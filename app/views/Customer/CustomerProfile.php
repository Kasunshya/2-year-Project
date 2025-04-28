<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Customer Profile</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">
    <style>
        /*
        :root {
            --primary-color: #c98d83;
            --secondary: #783b31;
            --bg: #f2f1ec;
            --white: #ffffff;
            --black: #333333;
            --gray: #666666;
            --light-gray: #f5f5f5;
            --box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            --transition: all 0.3s ease;
        }
*
        * {
            font-family: 'Vidaloka', serif;
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            background: var(--light-gray);
            color: var(--black);
            line-height: 1.6;
        }

        /* Header Styles */
        .profile-title {
            background-color: #c98d83;
            padding: 1.5rem;
            text-align: center;
            color: #ffffff;
            font-size: 2rem;
            font-weight: 500;
            text-transform: uppercase;
            letter-spacing: 2px;
            margin-bottom: 2rem;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            font-family: 'Poppins', sans-serif;
            max-width: 1200px;
            margin-left: auto;
            margin-right: auto;
            margin-top: 2rem;
        }

        @media (max-width: 768px) {
            header {
                font-size: 1.5rem;
                padding: 1.2rem;
                margin-top: 1rem;
                margin-bottom: 1rem;
            }
        }

        /* Profile Container */
        .container {
            max-width: 1200px;
            margin: 2rem auto;
            padding: 0 20px;
        }

        /* Profile Info Section */
        .profile-info {
            background: var(--white);
            border-radius: 10px;
            box-shadow: var(--box-shadow);
            padding: 2rem;
            margin-bottom: 2rem;
        }

        .form-group {
            margin-bottom: 1.5rem;
        }

        .form-group label {
            display: block;
            margin-bottom: 0.5rem;
            color: var(--gray);
            font-weight: 500;
        }

        .form-group input, 
        .form-group textarea {
            width: 100%;
            padding: 0.8rem;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 1rem;
            transition: var(--transition);
        }

        .form-group input:focus, 
        .form-group textarea:focus {
            border-color: var(--primary-color);
            outline: none;
            box-shadow: 0 0 0 2px rgba(201, 141, 131, 0.1);
        }

        /* Recent Orders Section */
        .recent-orders {
            background: var(--white);
            border-radius: 10px;
            box-shadow: var(--box-shadow);
            padding: 2rem;
            margin-bottom: 2rem;
        }

        .recent-orders h2 {
            color: var(--secondary);
            margin-bottom: 1.5rem;
            font-size: 1.5rem;
        }

        .order-history {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0;
            border-radius: 8px;
            overflow: hidden;
        }

        .order-history th {
            background: var(--primary-color);
            color: var(--white);
            padding: 1rem;
            text-align: left;
            font-weight: 500;
        }

        .order-history td {
            padding: 1rem;
            border-bottom: 1px solid #eee;
        }

        .order-history tr:last-child td {
            border-bottom: none;
        }

        .order-history tr:hover {
            background-color: var(--light-gray);
        }

        /* Button Styles */
        .btn {
            background: var(--primary-color);
            color: var(--white);
            padding: 0.8rem 1.5rem;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 1rem;
            font-weight: 500;
            transition: var(--transition);
        }

        .btn:hover {
            background: var(--secondary);
            transform: translateY(-2px);
        }

        /* Flash Messages */
        .alert {
            padding: 1rem;
            border-radius: 5px;
            margin-bottom: 1rem;
        }

        .alert-success {
            background-color: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }

        .alert-error {
            background-color: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .navbar ul {
                gap: 1rem;
            }

            .profile-info,
            .recent-orders {
                padding: 1rem;
            }

            .order-history th,
            .order-history td {
                padding: 0.8rem;
                font-size: 0.9rem;
            }
        }
    </style>
</head>
<body>
<?php require_once APPROOT . '/views/customer/RegisteredCustomerNav.php'; ?>

    
    

    <!-- Customer Profile Page -->
    <div class="profile-title">Customer Profile</div>

    <!-- Profile Info Section -->
    <div class="profile-info">
        <?php flash('profile_success'); ?>
        <?php flash('profile_error'); ?>
        
        <form action="<?php echo URLROOT; ?>/customer/updateProfile" method="POST">
            <div class="form-group">
                <label for="name">Name</label>
                <input type="text" id="name" name="name" 
                       value="<?php echo $data['customerData']->customer_name; ?>" required>
            </div>

            <div class="form-group">
                <label for="contact">Contact</label>
                <input type="tel" id="contact" name="contact" 
                       value="<?php echo $data['customerData']->customer_contact; ?>" required>
            </div>

            <div class="form-group">
                <label for="address">Address</label>
                <textarea id="address" name="address" required><?php echo $data['customerData']->customer_address; ?></textarea>
            </div>

            <button type="submit" class="btn">Update Profile</button>
        </form>
    </div>

    <div class="recent-orders">
        <h2>Recent Orders</h2>
        <table class="order-history">
            <thead>
                <tr>
                    <th>Order ID</th>
                    <th>Date</th>
                    <th>Total</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($data['orderHistory'] as $order): ?>
                    <tr>
                        <td><?php echo $order->order_id; ?></td>
                        <td><?php echo date('Y-m-d', strtotime($order->order_date)); ?></td>
                        <td>LKR <?php echo number_format($order->total, 2); ?></td>
                        <td><?php echo $order->status; ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>


<!-- Chat Widget -->
<?php require_once APPROOT . '/views/chat/index.php'; ?>
    
</body>
</html>
