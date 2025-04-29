<?php
class UnregisteredCustomerModel {
    private $db;

    public function __construct() {
        $this->db = new Database;
    }

    public function getProducts() {
        $this->db->query('SELECT p.* FROM product p 
                         WHERE p.status = :status 
                         ORDER BY p.product_id DESC');  // Changed from date_added to product_id
        $this->db->bind(':status', '1');
        return $this->db->resultSet();
    }

    public function getPromotions() {
        $this->db->query('SELECT id, title, description, discount_percentage, image_path, 
                          start_date, end_date 
                          FROM promotions 
                          WHERE is_active = :status 
                          AND start_date <= CURRENT_DATE 
                          AND end_date >= CURRENT_DATE');
        $this->db->bind(':status', 'active');
        return $this->db->resultSet();
    }

    public function getCategories() {
        $this->db->query('SELECT category_id, name, description, image_path 
                         FROM category 
                         ORDER BY category_id DESC');  // Changed from date_added to category_id
        return $this->db->resultSet();
    }

    public function getAllProducts($filters) {
        $sql = 'SELECT p.* FROM product p 
                INNER JOIN category c ON p.category_id = c.category_id 
                WHERE 1=1';
        
        $params = [];
        
        // Add status condition
        $sql .= ' AND p.status = :status';
        $params[':status'] = 'active';
        
        // Add category filter
        if (!empty($filters['category'])) {
            $sql .= ' AND c.name = :category';
            $params[':category'] = $filters['category'];
        }
        
        // Add price filters
        if (!empty($filters['min_price'])) {
            $sql .= ' AND p.price >= :min_price';
            $params[':min_price'] = $filters['min_price'];
        }
        
        if (!empty($filters['max_price'])) {
            $sql .= ' AND p.price <= :max_price';
            $params[':max_price'] = $filters['max_price'];
        }
        
        $sql .= ' ORDER BY p.product_id DESC';
        
        $this->db->query($sql);
        
        // Bind all parameters
        foreach ($params as $param => $value) {
            $this->db->bind($param, $value);
        }
        
        return $this->db->resultSet();
    }

    public function submitEnquiry($data) {
        $this->db->query('INSERT INTO enquiry (first_name, last_name, email_address, phone_number, message) 
                         VALUES (:first_name, :last_name, :email_address, :phone_number, :message)');
        
        $this->db->bind(':first_name', $data['first_name']);
        $this->db->bind(':last_name', $data['last_name']);
        $this->db->bind(':email_address', $data['email_address']);
        $this->db->bind(':phone_number', $data['phone_number']);
        $this->db->bind(':message', $data['message']);
        
        return $this->db->execute();
    }

    public function getPostedReviews() {
        $this->db->query('SELECT f.feedback_id, f.feedback_text, f.created_at,
                      c.customer_name 
                      FROM feedback f 
                      INNER JOIN customer c ON f.customer_id = c.customer_id 
                      WHERE f.is_posted = 1 
                      ORDER BY f.created_at DESC 
                      LIMIT 3');
        return $this->db->resultSet();
    }
}