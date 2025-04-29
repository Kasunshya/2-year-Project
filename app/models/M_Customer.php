<?php
class M_Customer {
    private $db;

    public function __construct() {
        $this->db = new Database;
    }

    public function getAllCustomers() {
        $this->db->query("SELECT * FROM customers");
        return $this->db->resultSet();
    }

    public function addCustomer($data) {
        $this->db->query("INSERT INTO customers (full_name, address, contact_no) VALUES (:full_name, :address, :contact_no)");
        $this->db->bind(':full_name', $data['full_name']);
        $this->db->bind(':address', $data['address']);
        $this->db->bind(':contact_no', $data['contact_no']);

        return $this->db->execute();
    }

    public function deleteCustomer($id) {
        $this->db->query("DELETE FROM customers WHERE customer_id = :customer_id");
        $this->db->bind(':customer_id', $id);

        return $this->db->execute();
    }

    public function getAllCategories() {
        $this->db->query("SELECT * FROM category");
        return $this->db->resultSet();
    }

    public function getActiveProducts() {
        $this->db->query('SELECT p.*, c.name as category_name 
                         FROM product p 
                         LEFT JOIN category c ON p.category_id = c.category_id 
                         WHERE p.status = 1 
                         AND p.available_quantity > 0 
                         AND (p.expiry_date IS NULL OR p.expiry_date > NOW()) 
                         ORDER BY p.created_at DESC 
                         LIMIT 6');
        return $this->db->resultSet();
    }

    public function getProductsByCategory($categoryIdentifier) {
        try {
            // Check if the identifier is numeric (ID) or string (name)
            $isId = is_numeric($categoryIdentifier);
            
            $this->db->query("SELECT p.*, c.name as category_name 
                             FROM product p 
                             LEFT JOIN category c ON p.category_id = c.category_id 
                             WHERE " . ($isId ? "p.category_id = :identifier" : "c.name = :identifier") . "
                             AND p.is_active = 1 
                             AND p.available_quantity > 0 
                             AND (p.expiry_date IS NULL OR p.expiry_date > NOW()) 
                             ORDER BY p.created_at DESC");
                             
            $this->db->bind(':identifier', $categoryIdentifier);
            $results = $this->db->resultSet();
            
            error_log("Found " . count($results) . " products for category " . 
                     ($isId ? "ID: " : "name: ") . $categoryIdentifier);
            return $results;
        } catch (Exception $e) {
            error_log("Error in getProductsByCategory: " . $e->getMessage());
            return [];
        }
    }

    public function getFilteredProducts($category = null, $minPrice = null, $maxPrice = null) {
        try {
            $sql = "SELECT p.*, c.name as category_name 
                    FROM product p 
                    LEFT JOIN category c ON p.category_id = c.category_id 
                    WHERE p.is_active = 1 
                    AND p.available_quantity > 0 
                    AND (p.expiry_date IS NULL OR p.expiry_date > NOW())";
            $params = [];

            if (!empty($category)) {
                $sql .= " AND p.category_id = :category";
                $params[':category'] = $category;
            }

            if (!empty($minPrice)) {
                $sql .= " AND p.price >= :minPrice";
                $params[':minPrice'] = $minPrice;
            }

            if (!empty($maxPrice)) {
                $sql .= " AND p.price <= :maxPrice";
                $params[':maxPrice'] = $maxPrice;
            }

            $sql .= " ORDER BY p.created_at DESC";

            $this->db->query($sql);

            foreach ($params as $param => $value) {
                $this->db->bind($param, $value);
            }

            $results = $this->db->resultSet();
            error_log("Filtered products query: " . $sql);
            error_log("Found " . count($results) . " products");
            
            return $results;
        } catch (Exception $e) {
            error_log("Error in getFilteredProducts: " . $e->getMessage());
            return [];
        }
    }

    public function getProductById($productId) {
        $this->db->query("SELECT p.*, c.name as category_name 
                         FROM product p 
                         LEFT JOIN category c ON p.category_id = c.category_id 
                         WHERE p.product_id = :product_id");
        $this->db->bind(':product_id', $productId);
        return $this->db->single();
    }

    public function createOrder($data) {
        $this->db->query('INSERT INTO orders (
            customer_id, 
            total, 
            order_date, 
            order_type, 
            payment_method, 
            payment_status, 
            discount, 
            employee_id,
            branch_id, 
            amount_tendered, 
            change_amount, 
            delivery_charge
        ) VALUES (
            :customer_id, 
            :total, 
            :order_date, 
            :order_type, 
            :payment_method, 
            :payment_status, 
            :discount, 
            :employee_id,
            :branch_id, 
            :amount_tendered, 
            :change_amount, 
            :delivery_charge
        )');
        
        try {
            $this->db->bind(':customer_id', $data['customer_id']);
            $this->db->bind(':total', $data['total']);
            $this->db->bind(':order_date', $data['order_date']);
            $this->db->bind(':order_type', $data['order_type']);
            $this->db->bind(':payment_method', $data['payment_method']);
            $this->db->bind(':payment_status', $data['payment_status']);
            $this->db->bind(':discount', $data['discount']);
            $this->db->bind(':employee_id', $data['employee_id']);
            $this->db->bind(':branch_id', $data['branch_id']);
            $this->db->bind(':amount_tendered', $data['amount_tendered']);
            $this->db->bind(':change_amount', $data['change_amount']);
            $this->db->bind(':delivery_charge', $data['delivery_charge']);
            
            if ($this->db->execute()) {
                return $this->db->lastInsertId();
            }
            return false;
        } catch (Exception $e) {
            error_log('Error creating order: ' . $e->getMessage());
            return false;
        }
    }

    public function createOrderDetail($data) {
        $this->db->query('INSERT INTO orderdetails (
            order_id, 
            product_id, 
            quantity, 
            price
        ) VALUES (
            :order_id, 
            :product_id, 
            :quantity, 
            :price
        )');
        
        try {
            $this->db->bind(':order_id', $data['order_id']);
            $this->db->bind(':product_id', $data['product_id']);
            $this->db->bind(':quantity', $data['quantity']);
            $this->db->bind(':price', $data['price']);
            
            return $this->db->execute();
        } catch (Exception $e) {
            error_log('Error creating order detail: ' . $e->getMessage());
            return false;
        }
    }

    public function createDeliveryDetail($data) {
        $this->db->query('INSERT INTO delivery_details (
            order_id,
            branch_id,
            delivery_type,
            delivery_address,
            delivery_date,
            district,
            contact_number
        ) VALUES (
            :order_id,
            :branch_id,
            :delivery_type,
            :delivery_address,
            :delivery_date,
            :district,
            :contact_number
        )');
        
        try {
            $this->db->bind(':order_id', $data['order_id']);
            $this->db->bind(':branch_id', $data['branch_id']);
            $this->db->bind(':delivery_type', $data['delivery_type']);
            $this->db->bind(':delivery_address', $data['delivery_address']);
            $this->db->bind(':delivery_date', $data['delivery_date']);
            $this->db->bind(':district', $data['district']);
            $this->db->bind(':contact_number', $data['contact_number']);
            
            return $this->db->execute();
        } catch (Exception $e) {
            error_log('Error creating delivery detail: ' . $e->getMessage());
            return false;
        }
    }

    public function addOrderDetail($data) {
        $this->db->query("INSERT INTO orderdetails (order_id, product_id, quantity, price) 
                          VALUES (:order_id, :product_id, :quantity, :price)");
        
        $this->db->bind(':order_id', $data['order_id']);
        $this->db->bind(':product_id', $data['product_id']);
        $this->db->bind(':quantity', $data['quantity']);
        $this->db->bind(':price', $data['price']);

        return $this->db->execute();
    }

    public function addDeliveryDetail($data) {
        $this->db->query("INSERT INTO delivery_details (order_id, delivery_type, 
                          street_address, city, postal_code, delivery_date) 
                          VALUES (:order_id, :delivery_type, :street_address, 
                          :city, :postal_code, :delivery_date)");

        $this->db->bind(':order_id', $data['order_id']);
        $this->db->bind(':delivery_type', $data['delivery_type']);
        $this->db->bind(':street_address', $data['street_address']);
        $this->db->bind(':city', $data['city']);
        $this->db->bind(':postal_code', $data['postal_code']);
        $this->db->bind(':delivery_date', $data['delivery_date']);

        return $this->db->execute();
    }

    public function getLatestProducts($limit = 6) {
        try {
            $this->db->query("SELECT p.*, c.name as category_name 
                         FROM product p 
                         LEFT JOIN category c ON p.category_id = c.category_id 
                         WHERE p.is_active = 1 
                         AND p.available_quantity > 0 
                         AND (p.expiry_date IS NULL OR p.expiry_date > NOW()) 
                         ORDER BY p.created_at DESC 
                         LIMIT :limit");
            
            $this->db->bind(':limit', $limit);
            $results = $this->db->resultSet();
            
            error_log("Latest products query executed with limit: " . $limit);
            error_log("Found " . count($results) . " products");
            
            return $results;
        } catch (Exception $e) {
            error_log("Error in getLatestProducts: " . $e->getMessage());
            return [];
        }
    }

    public function getActivePromotions() {
        try {
            $this->db->query("SELECT * FROM promotions 
                         WHERE is_active = 1 
                         AND start_date <= CURDATE() 
                         AND end_date >= CURDATE() 
                         ORDER BY discount_percentage DESC");
            return $this->db->resultSet();
        } catch (Exception $e) {
            error_log("Error getting active promotions: " . $e->getMessage());
            return [];
        }
    }

    public function createEnquiry($data) {
        $this->db->query('INSERT INTO enquiry (first_name, last_name, email_address, phone_number, message) 
                          VALUES (:first_name, :last_name, :email_address, :phone_number, :message)');
        
        $this->db->bind(':first_name', $data['first_name']);
        $this->db->bind(':last_name', $data['last_name']);
        $this->db->bind(':email_address', $data['email_address']);
        $this->db->bind(':phone_number', $data['phone_number']);
        $this->db->bind(':message', $data['message']);

        return $this->db->execute();
    }

    public function submitEnquiry($data) {
        try {
            $this->db->query("INSERT INTO enquiry 
                         (first_name, last_name, email_address, phone_number, message) 
                         VALUES 
                         (:first_name, :last_name, :email_address, :phone_number, :message)");

            $this->db->bind(':first_name', $data['first_name']);
            $this->db->bind(':last_name', $data['last_name']);
            $this->db->bind(':email_address', $data['email_address']);
            $this->db->bind(':phone_number', $data['phone_number']);
            $this->db->bind(':message', $data['message']);

            // Debug log
            error_log('Executing enquiry insert with data: ' . print_r($data, true));

            return $this->db->execute();
        } catch (Exception $e) {
            error_log('Error in submitEnquiry: ' . $e->getMessage());
            return false;
        }
    }

    public function getCustomerData($userId) {
        try {
            $this->db->query('SELECT * FROM customer WHERE user_id = :user_id AND customer_status = "Active"');
            $this->db->bind(':user_id', $userId);
            $result = $this->db->single();
            
            error_log('Customer data retrieved for user_id ' . $userId . ': ' . print_r($result, true));
            return $result;
        } catch (Exception $e) {
            error_log('Error getting customer data: ' . $e->getMessage());
            return null;
        }
    }

    public function getLastFiveOrders($userId) {
        $this->db->query('SELECT * FROM orders 
                          WHERE customer_id = :user_id 
                          ORDER BY order_date DESC LIMIT 5');
        $this->db->bind(':user_id', $userId);
        return $this->db->resultSet();
    }

    public function getCustomerNotifications($userId) {
        $this->db->query('SELECT * FROM customization_replies 
                          WHERE customer_id = :user_id 
                          ORDER BY created_at DESC');
        $this->db->bind(':user_id', $userId);
        return $this->db->resultSet();
    }

    public function updateCustomerData($data) {
        $this->db->query('UPDATE customers 
                          SET name = :name, contact = :contact, address = :address 
                          WHERE user_id = :user_id');
        
        $this->db->bind(':user_id', $data['user_id']);
        $this->db->bind(':name', $data['name']);
        $this->db->bind(':contact', $data['contact']);
        $this->db->bind(':address', $data['address']);
        
        return $this->db->execute();
    }

    public function updateCustomer($data) {
        try {
            $this->db->query('UPDATE customer 
                         SET customer_name = :name, 
                             customer_contact = :contact, 
                             customer_address = :address 
                         WHERE customer_id = :customer_id');

            $this->db->bind(':customer_id', $data['customer_id']);
            $this->db->bind(':name', $data['name']);
            $this->db->bind(':contact', $data['contact']);
            $this->db->bind(':address', $data['address']);

            // Debug logging
            error_log("Updating customer with data: " . print_r($data, true));
            
            $result = $this->db->execute();
            
            if ($result) {
                error_log("Customer update successful");
                return true;
            } else {
                error_log("Customer update failed");
                return false;
            }
        } catch (Exception $e) {
            error_log("Error in updateCustomer: " . $e->getMessage());
            return false;
        }
    }

    public function getCustomerIdByUserId($userId) {
        $this->db->query('SELECT customer_id FROM customer WHERE user_id = :user_id AND customer_status = "Active"');
        $this->db->bind(':user_id', $userId);
        $result = $this->db->single();
        return $result ? $result->customer_id : null;
    }

    // Add this method to create a customer record if it doesn't exist
    public function createCustomerForUser($userId) {
        // Get user email from users table
        $this->db->query('SELECT email FROM users WHERE user_id = :user_id');
        $this->db->bind(':user_id', $userId);
        $user = $this->db->single();
        
        if (!$user) {
            error_log("User not found for user_id: " . $userId);
            return false;
        }
        
        // Create customer record
        $this->db->query('INSERT INTO customer (user_id, customer_name) VALUES (:user_id, :name)');
        $this->db->bind(':user_id', $userId);
        $this->db->bind(':name', explode('@', $user->email)[0]); // Use part of email as name
        
        return $this->db->execute();
    }

    public function submitCakeCustomization($data) {
        $this->db->query('INSERT INTO cake_customization (
            customer_id,
            flavor, 
            size, 
            toppings, 
            premium_toppings, 
            message, 
            delivery_option, 
            delivery_address,
            branch_id,
            delivery_date, 
            total_price,
            order_status
        ) VALUES (
            :customer_id,
            :flavor, 
            :size, 
            :toppings, 
            :premium_toppings, 
            :message, 
            :delivery_option, 
            :delivery_address,
            :branch_id,
            :delivery_date, 
            :total_price,
            "Pending"
        )');

        $this->db->bind(':customer_id', $data['customer_id']);
        $this->db->bind(':flavor', $data['flavor']);
        $this->db->bind(':size', $data['size']);
        $this->db->bind(':toppings', $data['toppings']);
        $this->db->bind(':premium_toppings', $data['premium_toppings']);
        $this->db->bind(':message', $data['message']);
        $this->db->bind(':delivery_option', $data['delivery_option']);
        $this->db->bind(':delivery_address', $data['delivery_address']);
        $this->db->bind(':branch_id', $data['branch_id']);
        $this->db->bind(':delivery_date', $data['delivery_date']);
        $this->db->bind(':total_price', $data['total_price']);

        $result = $this->db->execute();
        error_log("Cake customization insert result: " . ($result ? "Success" : "Failed"));
        return $result;
    }

    public function createCakeCustomization($data) {
        try {
            $this->db->query("INSERT INTO cake_customization (
                customer_id, 
                flavor, 
                size, 
                toppings, 
                premium_toppings, 
                message, 
                delivery_option, 
                delivery_address, 
                delivery_date, 
                total_price,
                branch_id,
                order_status,
                created_at
            ) VALUES (
                :customer_id, 
                :flavor, 
                :size, 
                :toppings, 
                :premium_toppings, 
                :message, 
                :delivery_option, 
                :delivery_address, 
                :delivery_date, 
                :total_price, 
                :branch_id,
                :order_status,
                NOW()
            )");

            $this->db->bind(':customer_id', $data['customer_id']);
            $this->db->bind(':flavor', $data['flavor']);
            $this->db->bind(':size', $data['size']);
            $this->db->bind(':toppings', $data['toppings']);
            $this->db->bind(':premium_toppings', $data['premium_toppings']);
            $this->db->bind(':message', $data['message']);
            $this->db->bind(':delivery_option', $data['delivery_option']);
            $this->db->bind(':delivery_address', $data['delivery_address']);
            $this->db->bind(':delivery_date', $data['delivery_date']);
            $this->db->bind(':total_price', $data['total_price']);
            $this->db->bind(':branch_id', $data['delivery_option'] === 'pickup' ? $data['branch_id'] : null);
            $this->db->bind(':order_status', $data['order_status']);

            $result = $this->db->execute();
            error_log("Cake customization creation result: " . ($result ? "Success" : "Failed"));
            return $result;
        } catch (PDOException $e) {
            error_log("Database Error in createCakeCustomization: " . $e->getMessage());
            return false;
        }
    }

    public function getAllBranches() {
        try {
            // Update query to match actual table structure
            $this->db->query("SELECT branch_id, branch_name, branch_address 
                         FROM branch 
                         ORDER BY branch_id ASC");
            return $this->db->resultSet();
        } catch (Exception $e) {
            error_log("Error getting branches: " . $e->getMessage());
            return [];
        }
    }

    public function getUserIdByEmail($email) {
        $this->db->query('SELECT user_id FROM users WHERE email = :email');
        $this->db->bind(':email', $email);
        $result = $this->db->single();
        
        if ($result) {
            return $result->user_id;
        }
        return false;
    }

    public function getUserByEmail($email) {
        $this->db->query('SELECT * FROM users WHERE email = :email AND user_role = "customer"');
        $this->db->bind(':email', $email);
        return $this->db->single();
    }

    public function verifyAndGetUserData($email) {
        try {
            // Get user data
            $this->db->query('SELECT * FROM users WHERE email = :email AND user_role = "customer"');
            $this->db->bind(':email', $email);
            $user = $this->db->single();
            
            if (!$user) {
                error_log("No user found for email: " . $email);
                return null;
            }
            
            // Get customer data
            $this->db->query('SELECT * FROM customer WHERE user_id = :user_id AND customer_status = "Active"');
            $this->db->bind(':user_id', $user->user_id);
            $customer = $this->db->single();
            
            if (!$customer) {
                error_log("No customer record found for user_id: " . $user->user_id);
                return null;
            }
            
            return [
                'user' => $user,
                'customer' => $customer
            ];
        } catch (Exception $e) {
            error_log("Error in verifyAndGetUserData: " . $e->getMessage());
            return null;
        }
    }

    public function verifyUserAndGetCustomerData($userId) {
        try {
            // Get user data with role check
            $this->db->query('SELECT * FROM users WHERE user_id = :user_id AND user_role = "customer"');
            $this->db->bind(':user_id', $userId);
            $user = $this->db->single();
            
            if (!$user) {
                error_log("No valid customer user found for ID: " . $userId);
                return null;
            }
            
            // Get associated customer data
            $this->db->query('SELECT * FROM customer WHERE user_id = :user_id AND customer_status = "Active"');
            $this->db->bind(':user_id', $userId);
            $customer = $this->db->single();
            
            if (!$customer) {
                error_log("No active customer record found for user_id: " . $userId);
                return null;
            }
            
            return [
                'user' => $user,
                'customer' => $customer
            ];
        } catch (Exception $e) {
            error_log("Error verifying user data: " . $e->getMessage());
            return null;
        }
    }

    public function getActiveCustomerByUserId($userId) {
        $this->db->query('SELECT c.*, u.email, u.user_role 
                         FROM customer c 
                         JOIN users u ON c.user_id = u.user_id 
                         WHERE c.user_id = :user_id 
                         AND c.customer_status = "Active" 
                         AND u.user_role = "customer"');
                         
        $this->db->bind(':user_id', $userId);
        return $this->db->single();
    }

    public function getCustomerById($customerId) {
        $this->db->query('SELECT * FROM customer WHERE customer_id = :customer_id');
        $this->db->bind(':customer_id', $customerId);
        return $this->db->single();
    }

    public function getRecentOrders($customerId, $limit = 5) {
        $this->db->query('SELECT order_id, order_date, total, payment_status as status 
                          FROM orders 
                          WHERE customer_id = :customer_id 
                          ORDER BY order_date DESC 
                          LIMIT :limit');
        
        $this->db->bind(':customer_id', $customerId);
        $this->db->bind(':limit', $limit);
        
        return $this->db->resultSet();
    }

    
    

    public function getAllProducts() {
        try {
            $this->db->query("SELECT p.*, c.name as category_name 
                         FROM product p 
                         LEFT JOIN category c ON p.category_id = c.category_id 
                         WHERE p.is_active = 1 
                         AND p.available_quantity > 0 
                         AND (p.expiry_date IS NULL OR p.expiry_date > NOW()) 
                         ORDER BY p.created_at DESC");
            
            $results = $this->db->resultSet();
            error_log("Total products found: " . count($results));
            
            return $results;
        } catch (Exception $e) {
            error_log("Error in getAllProducts: " . $e->getMessage());
            return [];
        }
    }

    public function createCompleteOrder($orderData) {
        try {
            error_log("Creating order with data: " . print_r($orderData, true));
            
            // 1. Create the order record
            $this->db->query("INSERT INTO orders (
                customer_id,
                total,
                order_date,
                order_type,
                payment_method,
                payment_status,
                discount,
                delivery_charge
            ) VALUES (
                :customer_id,
                :total,
                NOW(),
                'Online',
                :payment_method,
                :payment_status,
                :discount,
                :delivery_charge
            )");

            // Calculate delivery charge based on delivery type
            $deliveryCharge = ($orderData['delivery_type'] === 'delivery') ? 500.00 : 0.00;

            $this->db->bind(':customer_id', $orderData['customer_id']);
            $this->db->bind(':total', $orderData['total']);
            $this->db->bind(':payment_method', $orderData['payment_method']);
            $this->db->bind(':payment_status', $orderData['payment_status']);
            $this->db->bind(':discount', $orderData['discount']);
            $this->db->bind(':delivery_charge', $deliveryCharge);

            if (!$this->db->execute()) {
                throw new Exception("Failed to create order record");
            }

            $orderId = $this->db->lastInsertId();
            error_log("Created order with ID: " . $orderId);

            // 2. Create order details for each item
            foreach ($orderData['cart_items'] as $item) {
                error_log("Processing cart item: " . print_r($item, true));
                
                if (!isset($item['product_id'])) {
                    throw new Exception("Missing product_id in cart item");
                }

                $this->db->query("INSERT INTO orderdetails (
                    order_id,
                    product_id,
                    quantity,
                    price
                ) VALUES (
                    :order_id,
                    :product_id,
                    :quantity,
                    :price
                )");

                $this->db->bind(':order_id', $orderId);
                $this->db->bind(':product_id', $item['product_id']);
                $this->db->bind(':quantity', $item['quantity']);
                $this->db->bind(':price', $item['price']);

                if (!$this->db->execute()) {
                    throw new Exception("Failed to create order detail");
                }
            }

            // 3. Create delivery details
            $this->db->query("INSERT INTO delivery_details (
                order_id,
                branch_id,
                delivery_type,
                delivery_address,
                delivery_date,
                district,
                contact_number
            ) VALUES (
                :order_id,
                :branch_id,
                :delivery_type,
                :delivery_address,
                NOW(),
                :district,
                :contact_number
            )");

            $this->db->bind(':order_id', $orderId);
            $this->db->bind(':branch_id', $orderData['branch_id']);
            $this->db->bind(':delivery_type', $orderData['delivery_type']);
            $this->db->bind(':delivery_address', $orderData['delivery_address']);
            $this->db->bind(':district', $orderData['district']);
            $this->db->bind(':contact_number', $orderData['contact_number']);

            if (!$this->db->execute()) {
                throw new Exception("Failed to create delivery detail");
            }

            return $orderId;
        } catch (Exception $e) {
            error_log("Error in createCompleteOrder: " . $e->getMessage());
            return false;
        }
    }

    public function getOrderDetails($orderId) {
        try {
            // Debug log
            error_log("Getting order details for order ID: " . $orderId);

            // First get the order basic info
            $this->db->query("
                SELECT 
                    o.*,
                    d.delivery_type,
                    d.delivery_address,
                    d.district,
                    d.contact_number,
                    d.branch_id
                FROM orders o
                LEFT JOIN delivery_details d ON o.order_id = d.order_id
                WHERE o.order_id = :order_id
            ");
            
            $this->db->bind(':order_id', $orderId);
            $orderInfo = $this->db->single();

            if (!$orderInfo) {
                error_log("No basic order info found for order ID: " . $orderId);
                return false;
            }

            // Then get the order items with product details
            $this->db->query("
                SELECT 
                    od.quantity,
                    od.price as unit_price,
                    p.product_name as name,
                    (od.quantity * od.price) as total
                FROM orderdetails od
                INNER JOIN product p ON od.product_id = p.product_id
                WHERE od.order_id = :order_id
            ");

            $this->db->bind(':order_id', $orderId);
            $items = $this->db->resultSet();

            // Debug log
            error_log("Found " . count($items) . " items for order ID: " . $orderId);
            error_log("Items data: " . print_r($items, true));

            // Format the complete order details
            $orderDetails = [
                'order_id' => $orderInfo->order_id,
                'order_date' => $orderInfo->order_date,
                'total' => $orderInfo->total,
                'delivery_charge' => $orderInfo->delivery_charge,
                'discount' => $orderInfo->discount,
                'payment_status' => $orderInfo->payment_status,
                'payment_method' => $orderInfo->payment_method,
                'delivery_type' => $orderInfo->delivery_type,
                'delivery_address' => $orderInfo->delivery_address,
                'district' => $orderInfo->district,
                'contact_number' => $orderInfo->contact_number,
                'items' => []
            ];

            // Add items to the order details
            foreach ($items as $item) {
                $orderDetails['items'][] = [
                    'name' => $item->name,
                    'quantity' => $item->quantity,
                    'unit_price' => $item->unit_price,
                    'total' => $item->total
                ];
            }

            return $orderDetails;

        } catch (Exception $e) {
            error_log("Error getting order details: " . $e->getMessage());
            error_log("Stack trace: " . $e->getTraceAsString());
            return false;
        }
    }

    public function saveFeedback($feedbackData) {
        try {
            $this->db->query("INSERT INTO feedback (order_id, customer_id, feedback_text) 
                             VALUES (:order_id, :customer_id, :feedback_text)");
            
            $this->db->bind(':order_id', $feedbackData['order_id']);
            $this->db->bind(':customer_id', $feedbackData['customer_id']);
            $this->db->bind(':feedback_text', $feedbackData['feedback_text']);

            // Debug logging
            error_log("Saving feedback with data: " . print_r($feedbackData, true));

            $result = $this->db->execute();
            if (!$result) {
                error_log("Failed to execute feedback insert");
                return false;
            }
            return true;
        } catch (Exception $e) {
            error_log("Error saving feedback: " . $e->getMessage());
            return false;
        }
    }

    public function checkFeedbackTable() {
        // Direct query to check what's in the feedback table
        $this->db->query('SELECT * FROM feedback WHERE is_posted = 1');
        $result = $this->db->resultSet();
        
        echo '<h4>Feedback with is_posted=1:</h4>';
        echo '<pre>';
        print_r($result);
        echo '</pre>';
        
        // Check if is_posted column exists
        $this->db->query('SHOW COLUMNS FROM feedback LIKE "is_posted"');
        $column = $this->db->single();
        
        echo '<h4>is_posted column check:</h4>';
        echo '<pre>';
        print_r($column);
        echo '</pre>';
    }

    public function getPostedFeedbacks() {
        $this->db->query("SELECT f.*, 
             CONCAT(c.customer_name, '') as customer_name 
             FROM feedback f 
             JOIN customer c ON f.customer_id = c.customer_id 
             WHERE f.is_posted = 1 
             ORDER BY f.created_at DESC 
             LIMIT 6");
        
        return $this->db->resultSet();
    }

    public function beginTransaction() {
        $this->db->beginTransaction();
    }

    public function commit() {
        return $this->db->commit();
    }

    public function rollBack() {
        return $this->db->rollBack();
    }
}
?>
