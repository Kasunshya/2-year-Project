<?php
class M_Notification {
    private $db;

    public function __construct() {
        $this->db = new Database;
    }

    public function createNotification($branchId, $orderId, $status) {
        try {
            // First check if a notification already exists for this order and status
            $this->db->query('SELECT notification_id FROM notifications 
                            WHERE branch_id = :branch_id 
                            AND dailybranchorder_id = :order_id 
                            AND status = :status
                            AND created_at >= DATE_SUB(NOW(), INTERVAL 1 MINUTE)');
            
            $this->db->bind(':branch_id', $branchId);
            $this->db->bind(':order_id', $orderId);
            $this->db->bind(':status', $status);
            
            $existing = $this->db->single();
            
            // If a recent notification exists, don't create a new one
            if ($existing) {
                error_log("Duplicate notification prevented for order #$orderId with status $status");
                return true;
            }
            
            // Create message based on status
            $message = match($status) {
                'approved' => "Your daily order #$orderId has been APPROVED by the head manager",
                'rejected' => "Your daily order #$orderId has been REJECTED by the head manager. Please review and submit again.",
                default => "Your daily order #$orderId status has been updated to " . strtoupper($status)
            };
            
            // Insert new notification
            $this->db->query('INSERT INTO notifications (
                branch_id, 
                dailybranchorder_id, 
                message, 
                status,
                created_at
            ) VALUES (
                :branch_id, 
                :order_id, 
                :message, 
                :status,
                NOW()
            )');
            
            $this->db->bind(':branch_id', $branchId);
            $this->db->bind(':order_id', $orderId);
            $this->db->bind(':message', $message);
            $this->db->bind(':status', $status);

            return $this->db->execute();
            
        } catch (Exception $e) {
            error_log("Error creating notification: " . $e->getMessage());
            return false;
        }
    }

    public function getNotifications($branchId) {
        $this->db->query('SELECT * FROM notifications 
                          WHERE branch_id = :branch_id 
                          ORDER BY created_at DESC');
        $this->db->bind(':branch_id', $branchId);
        return $this->db->resultSet();
    }

    public function markAsRead($notificationId) {
        $this->db->query('UPDATE notifications SET is_read = TRUE WHERE notification_id = :id');
        $this->db->bind(':id', $notificationId);
        return $this->db->execute();
    }

    public function getUnreadCount($branchId) {
        $this->db->query('SELECT COUNT(*) as count 
                          FROM notifications 
                          WHERE branch_id = :branch_id 
                          AND is_read = 0');
        $this->db->bind(':branch_id', $branchId);
        $result = $this->db->single();
        return $result ? $result->count : 0;
    }
}