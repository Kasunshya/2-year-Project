<?php
class UnregisteredCustomerModel {
    private $db;

    public function __construct() {
        $this->db = new Database;
    }

    public function getLatestProducts() {
        $this->db->query("SELECT product_id, product_name, description, price, image_path 
                         FROM product 
                         WHERE is_active = 1 
                         AND status = 'active' 
                         ORDER BY created_at DESC 
                         LIMIT 6");
        
        return $this->db->resultSet();
    }

    public function getActivePromotions() {
        $this->db->query("SELECT id, title, description, discount_percentage, image_path 
                         FROM promotions 
                         WHERE is_active = 1 
                         AND CURDATE() BETWEEN start_date AND end_date 
                         ORDER BY created_at DESC");
        
        return $this->db->resultSet();
    }

    public function submitEnquiry($data) {
        $this->db->query("INSERT INTO enquiry (first_name, last_name, email_address, phone_number, message) 
                          VALUES (:first_name, :last_name, :email_address, :phone_number, :message)");
        
        // Bind values
        $this->db->bind(':first_name', $data['first_name']);
        $this->db->bind(':last_name', $data['last_name']);
        $this->db->bind(':email_address', $data['email_address']);
        $this->db->bind(':phone_number', $data['phone_number']);
        $this->db->bind(':message', $data['message']);
        
        // Execute
        return $this->db->execute();
    }

    public function getAllProducts($filters = []) {
        $sql = "SELECT p.*, c.name as category_name 
                FROM product p 
                LEFT JOIN category c ON p.category_id = c.category_id 
                WHERE p.is_active = 1 
                AND p.status = 'active'";
        
        $params = [];
        
        // Add category filter
        if (!empty($filters['category'])) {
            $sql .= " AND c.name = :category";
            $params[':category'] = $filters['category'];
        }
        
        // Add price range filter
        if (!empty($filters['min_price'])) {
            $sql .= " AND p.price >= :min_price";
            $params[':min_price'] = $filters['min_price'];
        }
        
        if (!empty($filters['max_price'])) {
            $sql .= " AND p.price <= :max_price";
            $params[':max_price'] = $filters['max_price'];
        }
        
        $sql .= " ORDER BY p.created_at DESC";
        
        $this->db->query($sql);
        
        // Bind all parameters
        foreach ($params as $key => $value) {
            $this->db->bind($key, $value);
        }
        
        return $this->db->resultSet();
    }

    public function getProductsByCategory($categoryId) {
        $this->db->query("SELECT p.*, c.category_name 
                          FROM product p 
                          LEFT JOIN category c ON p.category_id = c.category_id 
                          WHERE p.category_id = :category_id 
                          AND p.is_active = 1 
                          AND p.status = 'active'");
        
        $this->db->bind(':category_id', $categoryId);
        return $this->db->resultSet();
    }

    public function getCategories() {
        // Simple query to get all categories, since there's no is_active column
        $this->db->query("SELECT category_id, name FROM category ORDER BY name");
        return $this->db->resultSet();
    }
}