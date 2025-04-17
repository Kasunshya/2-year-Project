<?php
class M_Product {
    private $db;

    public function __construct() {
        $this->db = new Database;
    }

    // Get all products with their category names
    public function getAllProducts() {
        $this->db->query('SELECT p.*, c.name as category_name 
                         FROM product p 
                         LEFT JOIN category c ON p.category_id = c.category_id 
                         ORDER BY p.product_id DESC');
        return $this->db->resultSet();
    }

    // Add new product
    public function addProduct($data) {
        $this->db->query('INSERT INTO product (product_name, description, price, 
                         available_quantity, category_id, status) 
                         VALUES (:name, :description, :price, :quantity, 
                         :category_id, :status)');

        // Bind values
        $this->db->bind(':name', $data['product_name']);
        $this->db->bind(':description', $data['description']);
        $this->db->bind(':price', $data['price']);
        $this->db->bind(':quantity', $data['available_quantity']);
        $this->db->bind(':category_id', $data['category_id']);
        $this->db->bind(':status', isset($data['status']) ? 1 : 0);

        return $this->db->execute();
    }

    // Update product
    public function updateProduct($data) {
        $this->db->query('UPDATE product 
                         SET product_name = :name, description = :description, 
                         price = :price, available_quantity = :quantity, 
                         category_id = :category_id, status = :status 
                         WHERE product_id = :id');

        // Bind values
        $this->db->bind(':id', $data['product_id']);
        $this->db->bind(':name', $data['product_name']);
        $this->db->bind(':description', $data['description']);
        $this->db->bind(':price', $data['price']);
        $this->db->bind(':quantity', $data['available_quantity']);
        $this->db->bind(':category_id', $data['category_id']);
        $this->db->bind(':status', isset($data['status']) ? 1 : 0);

        return $this->db->execute();
    }

    // Delete product
    public function deleteProduct($id) {
        $this->db->query('DELETE FROM product WHERE product_id = :id');
        $this->db->bind(':id', $id);
        return $this->db->execute();
    }

    // Search products
    public function searchProducts($searchTerm) {
        $this->db->query('SELECT p.*, c.name as category_name 
                         FROM product p 
                         LEFT JOIN category c ON p.category_id = c.category_id 
                         WHERE p.product_name LIKE :search 
                         OR p.product_id LIKE :search 
                         ORDER BY p.product_id DESC');
        $this->db->bind(':search', '%' . $searchTerm . '%');
        return $this->db->resultSet();
    }
}