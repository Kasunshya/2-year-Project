<?php
class M_SysAdminP {
    private $db;

    public function __construct() {
        $this->db = new Database;
    }

    public function getAllCategories() {
        $this->db->query('SELECT * FROM category ORDER BY name');
        return $this->db->resultSet();
    }

    public function addCategory($data) {
        $this->db->query('INSERT INTO category (name, description, image_path) 
                         VALUES (:name, :description, :image_path)');
        
        $this->db->bind(':name', $data['name']);
        $this->db->bind(':description', $data['description']);
        $this->db->bind(':image_path', $data['image_path'] ?? null);
        
        return $this->db->execute();
    }

    public function uploadCategoryImage($file) {
        $targetDir = "../public/img/categories/";
        if (!file_exists($targetDir)) {
            mkdir($targetDir, 0777, true);
        }
        
        // Generate unique filename
        $fileName = uniqid() . '_' . basename($file['name']);
        $targetFile = $targetDir . $fileName;
        
        // Check file type
        $imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));
        $allowedTypes = ['jpg', 'jpeg', 'png', 'gif'];
        
        if (!in_array($imageFileType, $allowedTypes)) {
            return false;
        }
        
        // Check if it's a valid image
        $check = getimagesize($file['tmp_name']);
        if ($check === false) {
            return false;
        }
        
        // Try to upload file
        if (move_uploaded_file($file['tmp_name'], $targetFile)) {
            // Set proper permissions
            chmod($targetFile, 0644);
            return $fileName;
        }
        
        return false;
    }

    public function updateCategory($data) {
        $sql = 'UPDATE category SET name = :name, description = :description';
        
        // Only update image if a new one is provided
        if (isset($data['image_path'])) {
            $sql .= ', image_path = :image_path';
        }
        
        $sql .= ' WHERE category_id = :category_id';
        
        $this->db->query($sql);
        
        $this->db->bind(':category_id', $data['category_id']);
        $this->db->bind(':name', $data['name']);
        $this->db->bind(':description', $data['description']);
        
        if (isset($data['image_path'])) {
            $this->db->bind(':image_path', $data['image_path']);
        }
        
        return $this->db->execute();
    }

    public function deleteCategory($id) {
        // Get category image before deleting
        $this->db->query('SELECT image_path FROM category WHERE category_id = :id');
        $this->db->bind(':id', $id);
        $category = $this->db->single();

        // Delete image file if exists
        if ($category && $category->image_path) {
            $imagePath = "../public/img/categories/" . $category->image_path;
            if (file_exists($imagePath)) {
                unlink($imagePath);
            }
        }

        // Delete the category
        $this->db->query('DELETE FROM category WHERE category_id = :id');
        $this->db->bind(':id', $id);
        
        return $this->db->execute();
    }

    public function getCategoryById($id) {
        $this->db->query('SELECT * FROM category WHERE category_id = :category_id');
        $this->db->bind(':category_id', $id);
        return $this->db->single();
    }

    public function getCategoryByName($name) {
        $this->db->query('SELECT * FROM category WHERE name = :name');
        $this->db->bind(':name', $name);
        return $this->db->single();
    }

    // Product Methods
    public function getAllProducts() {
        $this->db->query('SELECT p.*, c.name as category_name 
                         FROM product p 
                         LEFT JOIN category c ON p.category_id = c.category_id 
                         ORDER BY p.product_id DESC');
        return $this->db->resultSet();
    }

    public function addProduct($data, $image_path = null) {
        $this->db->query('INSERT INTO product (product_name, description, price, 
                         available_quantity, category_id, image_path, expiry_date) 
                         VALUES (:name, :description, :price, :quantity, :category_id, :image_path, :expiry_date)');
        
        $this->db->bind(':name', $data['product_name']);
        $this->db->bind(':description', $data['description']);
        $this->db->bind(':price', $data['price']);
        $this->db->bind(':quantity', $data['available_quantity']);
        $this->db->bind(':category_id', $data['category_id']);
        $this->db->bind(':image_path', $image_path);
        $this->db->bind(':expiry_date', $data['expiry_date']);

        return $this->db->execute();
    }

    public function updateProduct($data, $image_path = null) {
        $sql = 'UPDATE product SET 
                product_name = :name, 
                description = :description, 
                price = :price, 
                available_quantity = :quantity, 
                category_id = :category_id,
                expiry_date = :expiry_date';
        
        if ($image_path !== null) {
            $sql .= ', image_path = :image_path';
        }
        
        $sql .= ' WHERE product_id = :product_id';
        
        $this->db->query($sql);

        $this->db->bind(':product_id', $data['product_id']);
        $this->db->bind(':name', $data['product_name']);
        $this->db->bind(':description', $data['description']);
        $this->db->bind(':price', $data['price']);
        $this->db->bind(':quantity', $data['available_quantity']);
        $this->db->bind(':category_id', $data['category_id']);
        $this->db->bind(':expiry_date', $data['expiry_date']);
        
        if ($image_path !== null) {
            $this->db->bind(':image_path', $image_path);
        }

        return $this->db->execute();
    }

    public function deleteProduct($id) {
        $this->db->query('DELETE FROM product WHERE product_id = :product_id');
        $this->db->bind(':product_id', $id);
        return $this->db->execute();
    }

    public function getProductById($id) {
        $this->db->query('SELECT p.*, c.name as category_name 
                         FROM product p 
                         LEFT JOIN category c ON p.category_id = c.category_id 
                         WHERE p.product_id = :product_id');
        $this->db->bind(':product_id', $id);

        return $this->db->single();
    }

    public function searchProducts($term) {
        $this->db->query('SELECT p.*, c.name as category_name 
                          FROM product p 
                          LEFT JOIN category c ON p.category_id = c.category_id 
                          WHERE p.product_name LIKE :term 
                          OR p.description LIKE :term 
                          OR c.name LIKE :term 
                          ORDER BY p.product_id DESC');
        
        $searchTerm = "%{$term}%";
        $this->db->bind(':term', $searchTerm);
        
        return $this->db->resultSet();
    }

    public function updateExpiredProducts() {
        $this->db->query("UPDATE product 
                          SET status = 'inactive' 
                          WHERE status = 'active' 
                          AND expiry_date < CURRENT_DATE()");
        return $this->db->execute();
    }

    // Branch Management Methods
    public function getAllBranches() {
        $this->db->query('SELECT * FROM branch ORDER BY branch_id DESC');
        return $this->db->resultSet();
    }

    public function addBranch($data) {
        $this->db->query('INSERT INTO branch (branch_name, branch_address, branch_contact) 
                         VALUES (:branch_name, :branch_address, :branch_contact)');
        
        $this->db->bind(':branch_name', $data['branch_name']);
        $this->db->bind(':branch_address', $data['branch_address']);
        $this->db->bind(':branch_contact', $data['branch_contact']);

        return $this->db->execute();
    }

    public function updateBranch($data) {
        $this->db->query('UPDATE branch SET 
                         branch_name = :branch_name, 
                         branch_address = :branch_address, 
                         branch_contact = :branch_contact 
                         WHERE branch_id = :branch_id');
        
        $this->db->bind(':branch_id', $data['branch_id']);
        $this->db->bind(':branch_name', $data['branch_name']);
        $this->db->bind(':branch_address', $data['branch_address']);
        $this->db->bind(':branch_contact', $data['branch_contact']);

        return $this->db->execute();
    }

    public function deleteBranch($id) {
        $this->db->query('DELETE FROM branch WHERE branch_id = :branch_id');
        $this->db->bind(':branch_id', $id);
        return $this->db->execute();
    }

    public function getBranchById($id) {
        $this->db->query('SELECT * FROM branch WHERE branch_id = :branch_id');
        $this->db->bind(':branch_id', $id);
        return $this->db->single();
    }

    public function updateBranchStatus($branchId, $status) {
        $this->db->query('UPDATE branch SET status = :status WHERE branch_id = :branch_id');
        $this->db->bind(':status', $status);
        $this->db->bind(':branch_id', $branchId);
        
        return $this->db->execute();
    }

    public function getAllCustomers() {
        $this->db->query('SELECT c.*, u.email 
                          FROM customer c 
                          LEFT JOIN users u ON c.user_id = u.user_id 
                          ORDER BY c.customer_id DESC');
        return $this->db->resultSet();
    }

    // Promotion Management Methods
    public function getAllPromotions() {
        $this->db->query('SELECT * FROM promotions ORDER BY start_date DESC');
        return $this->db->resultSet();
    }

    public function addPromotion($data) {
        $this->db->query('INSERT INTO promotions (title, description, discount_percentage, start_date, end_date, image_path, is_active) 
                         VALUES (:title, :description, :discount_percentage, :start_date, :end_date, :image_path, :is_active)');
        
        $this->db->bind(':title', $data['title']);
        $this->db->bind(':description', $data['description']);
        $this->db->bind(':discount_percentage', $data['discount_percentage']);
        $this->db->bind(':start_date', $data['start_date']);
        $this->db->bind(':end_date', $data['end_date']);
        $this->db->bind(':image_path', $data['image_path']);
        $this->db->bind(':is_active', $data['is_active']);

        return $this->db->execute();
    }

    public function updatePromotion($data) {
        try {
            // Always update these fields
            $sql = 'UPDATE promotions SET 
                    title = :title, 
                    description = :description, 
                    discount_percentage = :discount_percentage, 
                    start_date = :start_date, 
                    end_date = :end_date';
            
            // Add image_path to update if it's changed
            if ($data['image_path']) {
                $sql .= ', image_path = :image_path';
            }
            
            $sql .= ' WHERE id = :id';
            
            $this->db->query($sql);
            
            // Bind all the regular parameters
            $this->db->bind(':id', $data['id']);
            $this->db->bind(':title', $data['title']);
            $this->db->bind(':description', $data['description']);
            $this->db->bind(':discount_percentage', $data['discount_percentage']);
            $this->db->bind(':start_date', $data['start_date']);
            $this->db->bind(':end_date', $data['end_date']);
            
            // Bind image path if it exists
            if ($data['image_path']) {
                $this->db->bind(':image_path', $data['image_path']);
            }
            
            return $this->db->execute();
        } catch (PDOException $e) {
            error_log('Update Promotion Error: ' . $e->getMessage());
            return false;
        }
    }

    public function deletePromotion($id) {
        $this->db->query('DELETE FROM promotions WHERE id = :id');
        $this->db->bind(':id', $id);
        return $this->db->execute();
    }

    public function getPromotionById($id) {
        $this->db->query('SELECT * FROM promotions WHERE id = :id');
        $this->db->bind(':id', $id);
        return $this->db->single();
    }

    public function updatePromotionStatus($id, $status) {
        try {
            $this->db->query('UPDATE promotions SET is_active = :is_active WHERE id = :id');
            $this->db->bind(':id', $id);
            $this->db->bind(':is_active', $status);
            return $this->db->execute();
        } catch (PDOException $e) {
            error_log('Update Promotion Status Error: ' . $e->getMessage());
            return false;
        }
    }

    public function getEmployeeById($id) {
        try {
            $this->db->query('SELECT * FROM employee WHERE employee_id = :id');
            $this->db->bind(':id', $id);
            
            $result = $this->db->single();
            
            if ($this->db->rowCount() > 0) {
                return $result;
            }
            return false;
        } catch (Exception $e) {
            error_log("Error in getEmployeeById: " . $e->getMessage());
            return false;
        }
    }

}
?>