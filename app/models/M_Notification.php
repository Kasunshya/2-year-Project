<?php
class M_Notification {
    private $db;

    public function __construct() {
        $this->db = new Database;
    }

    public function createNotification($branchId, $dailybranchorderId, $status) {
        try {
            // Create appropriate message based on status
            $message = $this->getNotificationMessage($dailybranchorderId, $status);
            
            $this->db->query('INSERT INTO notifications (branch_id, dailybranchorder_id, message, status) 
                             VALUES (:branch_id, :dailybranchorder_id, :message, :status)');
            
            $this->db->bind(':branch_id', $branchId);
            $this->db->bind(':dailybranchorder_id', $dailybranchorderId);
            $this->db->bind(':message', $message);
            $this->db->bind(':status', $status);
            
            return $this->db->execute();
        } catch (Exception $e) {
            error_log("Error creating notification: " . $e->getMessage());
            return false;
        }
    }

    private function getNotificationMessage($orderId, $status) {
        switch ($status) {
            case 'approved':
                return "Your daily order #{$orderId} has been APPROVED by the head manager";
            case 'rejected':
                return "Your daily order #{$orderId} has been REJECTED by the head manager. Please review and submit again.";
            case 'pending':
                return "New daily order #{$orderId} has been submitted and is pending approval";
            default:
                return "Status update for daily order #{$orderId}";
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
        $this->db->query('UPDATE notifications 
                         SET is_read = 1 
                         WHERE notification_id = :id');
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
        return $result->count;
    }
}