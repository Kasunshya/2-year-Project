<?php
class M_Category
{
    private $db;

    public function __construct()
    {
        $this->db = new Database;
    }

    // Fetch all categories
    public function getAllCategories()
    {
        $this->db->query('SELECT * FROM category ORDER BY name ASC'); // Fetch all categories ordered by name
        return $this->db->resultSet(); // Return the result set
    }

    // Fetch a single category by ID
    public function getCategoryById($id)
    {
        $this->db->query('SELECT * FROM category WHERE category_id = :id');
        $this->db->bind(':id', $id);
        return $this->db->single();
    }

    // Add a new category
    public function addCategory($data)
    {
        $this->db->query('INSERT INTO category (name, description) VALUES (:name, :description)');
        $this->db->bind(':name', $data['category_name']);
        $this->db->bind(':description', $data['description']);

        return $this->db->execute();
    }

    // Update an existing category
    public function updateCategory($data)
    {
        $this->db->query('UPDATE category SET name = :name, description = :description WHERE category_id = :id');
        $this->db->bind(':id', $data['category_id']);
        $this->db->bind(':name', $data['category_name']);
        $this->db->bind(':description', $data['description']);

        return $this->db->execute();
    }

    // Delete a category
    public function deleteCategory($id) {
        try {
            // First check if category is being used in products
            $this->db->query('SELECT COUNT(*) as count FROM product WHERE category_id = :id');
            $this->db->bind(':id', $id);
            $result = $this->db->single();
            
            if ($result->count > 0) {
                error_log('Cannot delete category: It is being used by products');
                return false;
            }
            
            // If not being used, proceed with deletion
            $this->db->query('DELETE FROM category WHERE category_id = :id');
            $this->db->bind(':id', $id);
            
            return $this->db->execute();
            
        } catch (Exception $e) {
            error_log('Error deleting category: ' . $e->getMessage());
            return false;
        }
    }
}
?>