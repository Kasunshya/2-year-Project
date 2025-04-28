<?php
class M_DailyBranchOrder {
    private $db;

    public function __construct() {
        $this->db = new Database;
    }

    public function getOrderById($orderId) {
        $this->db->query('SELECT * FROM dailybranchorder WHERE dailybranchorder_id = :order_id');
        $this->db->bind(':order_id', $orderId);
        return $this->db->single();
    }

    public function updateStatus($orderId, $status) {
        // Check if status is valid enum value
        if (!in_array($status, ['pending', 'approved', 'rejected'])) {
            return false;
        }

        $this->db->query('UPDATE dailybranchorder 
                         SET status = :status
                         WHERE dailybranchorder_id = :order_id');
        
        $this->db->bind(':status', $status);
        $this->db->bind(':order_id', $orderId);
        
        // Only create notification if status update is successful
        if($this->db->execute()) {
            $order = $this->getOrderById($orderId);
            if($order) {
                $notification = new M_Notification();
                $notification->createNotification(
                    $order->branch_id,
                    $orderId,
                    $status
                );
            }
            return true;
        }
        return false;
    }

    public function getAllOrders() {
        $this->db->query('SELECT dbo.*, b.branch_name 
                         FROM dailybranchorder dbo
                         JOIN branch b ON dbo.branch_id = b.branch_id
                         ORDER BY dbo.orderdate DESC');
        return $this->db->resultSet();
    }

    public function getOrdersByBranch($branchId) {
        $this->db->query('SELECT * FROM dailybranchorder 
                         WHERE branch_id = :branch_id 
                         ORDER BY created_at DESC');
        $this->db->bind(':branch_id', $branchId);
        return $this->db->resultSet();
    }
}