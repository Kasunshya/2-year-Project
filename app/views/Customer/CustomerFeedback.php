<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Summary</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <style>
        :root {
            --primary-color: #c98d83;
            --secondary: #783b31;
            --bg: #f2f1ec;
            --white: #ffffff;
            --box-shadow: 0 .5rem 1rem rgba(0, 0, 0, 0.1);
        }

        * {
            font-family: 'Vidaloka', serif;
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            text-decoration: none;
        }
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

        body {
            background: var(--background-color) url('/images/banner-bg.jpg') no-repeat center center fixed;
            background-size: cover;
            color: var(--black);
        }

        /* Navigation Bar */
        /* Add these styles in the <style> tag after the existing navbar styles */
.navbar {
    background-color: var(--white);
    box-shadow: var(--box-shadow);
    position: sticky;
    top: 0;
    z-index: 1000;
    padding: 1rem 5%;
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.navbar .logo {
    color: var(--secondary);
    font-size: 1.8rem;
    font-weight: 600;
    text-decoration: none;
    letter-spacing: 2px;
}

.navbar ul {
    display: flex;
    list-style: none;
    gap: 2rem;
    margin: 0;
    padding: 0;
}

.navbar ul li {
    position: relative;
}

.navbar ul li a {
    color: var(--black);
    text-decoration: none;
    font-weight: 500;
    font-size: 1rem;
    transition: var(--transition);
    padding: 0.5rem 0;
}

.navbar ul li a:hover {
    color: var(--primary-color);
}

.navbar ul li a::after {
    content: '';
    position: absolute;
    bottom: -5px;
    left: 0;
    width: 0;
    height: 2px;
    background: var(--primary-color);
    transition: var(--transition);
}

.navbar ul li a:hover::after {
    width: 100%;
}

/* Add responsive navbar styles */
@media (max-width: 992px) {
    .navbar {
        padding: 1rem 2%;
    }

    .navbar .logo {
        font-size: 1.5rem;
    }

    .navbar ul {
        gap: 1.5rem;
    }
}

@media (max-width: 768px) {
    .navbar {
        flex-direction: column;
        padding: 1rem;
    }

    .navbar .logo {
        margin-bottom: 1rem;
    }

    .navbar ul {
        flex-wrap: wrap;
        justify-content: center;
        gap: 1rem;
    }

    .navbar ul li a {
        font-size: 0.9rem;
    }
}

        /* Order Summary Section */
        .container {
            max-width: 800px;
            margin: 80px auto 50px;
            background: var(--white);
            padding: 20px;
            border-radius: 8px;
            box-shadow: var(--box-shadow);
        }

        .container h1 {
            text-align: center;
            font-size: 28px;
            margin-bottom: 10px;
            color: var(--secondary-color);
        }

        .thank-you-message {
            text-align: center;
            font-size: 18px;
            margin-bottom: 20px;
            color: var(--black);
        }

        .order-summary {
            margin-bottom: 20px;
        }

        .order-summary table {
            width: 100%;
            border-collapse: collapse;
        }

        .order-summary th, .order-summary td {
            text-align: left;
            padding: 10px;
            border: 1px solid #ddd;
        }

        .order-summary th {
            background: var(--primary-color);
            color: var(--white);
        }

        .order-summary td {
            color: var(--black);
        }

        .order-info {
            margin-top: 20px;
            text-align: left;
        }

        .order-info p {
            font-size: 16px;
            margin: 8px 0;
            color: var(--black);
        }

        .buttons {
            display: flex;
            justify-content: space-between;
            margin-top: 20px;
        }

        .btn {
            padding: 10px 20px;
            background: var(--primary-color);
            color: var(--white);
            font-size: 16px;
            text-align: center;
            border: none;
            border-radius: 5px;
            text-decoration: none;
            cursor: pointer;
        }

        .btn:hover {
            background: #783b31;
        }

        /* Feedback Modal */
        .modal {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
            justify-content: center;
            align-items: center;
            z-index: 1000;
        }

        .modal-content {
            background: var(--white);
            padding: 20px;
            width: 400px;
            border-radius: 10px;
            box-shadow: var(--box-shadow);
            text-align: center;
        }

        .modal-content h2 {
            font-size: 24px;
            margin-bottom: 20px;
            color: var(--secondary-color);
        }

        .modal-content textarea {
            width: 100%;
            height: 100px;
            border: 1px solid #ddd;
            border-radius: 5px;
            padding: 10px;
            margin-bottom: 15px;
            font-size: 14px;
        }

        .modal-content .modal-buttons {
            display: flex;
            justify-content: space-between;
        }

        .close-btn {
            background: var(--secondary-color);
        }

        .close-btn:hover {
            background: var(--primary-color);
        }

        .delivery-info {
            background-color: #f9f9f9;
            padding: 15px;
            border-radius: 5px;
            margin-top: 20px;
        }

        .order-summary table {
            margin-bottom: 20px;
        }

        .order-summary tfoot tr:last-child {
            background-color: #f2f1ec;
            font-weight: bold;
        }

        .order-info p {
            margin: 10px 0;
        }

        .message-popup {
            display: none;
            position: fixed;
            top: 20px;
            right: 20px;
            background: var(--primary-color);
            color: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
            z-index: 2000;
            animation: slideIn 0.5s ease-out;
        }

        .message-content {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .message-content i {
            font-size: 24px;
        }

        .message-content p {
            margin: 0;
            font-size: 16px;
        }

        @keyframes slideIn {
            from {
                transform: translateX(100%);
                opacity: 0;
            }
            to {
                transform: translateX(0);
                opacity: 1;
            }
        }

        @keyframes fadeOut {
            from {
                transform: translateX(0);
                opacity: 1;
            }
            to {
                transform: translateX(100%);
                opacity: 0;
            }
        }

        .order-table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
            background-color: #fff;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }

        .order-table th,
        .order-table td {
            padding: 12px 15px;
            border-bottom: 1px solid #ddd;
        }

        .order-table th {
            background-color: var(--primary-color);
            color: white;
            font-weight: bold;
            text-align: left;
        }

        .text-center {
            text-align: center;
        }

        .text-right {
            text-align: right;
        }

        .total-row {
            background-color: #f8f9fa;
            font-size: 1.1em;
        }

        .section-title {
            color: var(--primary-color);
            margin-bottom: 20px;
            padding-bottom: 10px;
            border-bottom: 2px solid var(--primary-color);
        }
    </style>
</head>
<body>
<?php require_once APPROOT . '/views/customer/RegisteredCustomerNav.php'; ?>
    <!-- Cart Page -->
    <div class="profile-title">Thank you for your order!</div>

    <!-- Order Summary -->
   
    <div class="container">
        
        <p class="thank-you-message" style="color: #783b31;">Your order has been successfully placed. Below is your order summary.</p>

        <!-- Order Summary Table -->
        <div class="container">
            <h2 class="section-title">Order Confirmation</h2>
            <div class="order-summary">
                <table class="order-table">
                    <thead>
                        <tr>
                            <th>Product</th>
                            <th class="text-center">Quantity</th>
                            <th class="text-right">Unit Price (LKR)</th>
                            <th class="text-right">Total (LKR)</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                        $subtotal = 0;
                        if (!empty($data['orderDetails']['items'])):
                            foreach($data['orderDetails']['items'] as $item): 
                                $subtotal += $item['total'];
                        ?>
                            <tr>
                                <td><?php echo htmlspecialchars($item['name']); ?></td>
                                <td class="text-center"><?php echo $item['quantity']; ?></td>
                                <td class="text-right"><?php echo number_format($item['unit_price'], 2); ?></td>
                                <td class="text-right"><?php echo number_format($item['total'], 2); ?></td>
                            </tr>
                        <?php 
                            endforeach;
                        else:
                        ?>
                            <tr>
                                <td colspan="4" class="text-center">No items found in this order</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="3" class="text-right"><strong>Subtotal:</strong></td>
                            <td class="text-right"><?php echo number_format($subtotal, 2); ?></td>
                        </tr>
                        <?php if ($data['orderDetails']['delivery_charge'] > 0): ?>
                            <tr>
                                <td colspan="3" class="text-right"><strong>Delivery Charge:</strong></td>
                                <td class="text-right"><?php echo number_format($data['orderDetails']['delivery_charge'], 2); ?></td>
                            </tr>
                        <?php endif; ?>
                        <?php if ($data['orderDetails']['discount'] > 0): ?>
                            <tr>
                                <td colspan="3" class="text-right"><strong>Discount:</strong></td>
                                <td class="text-right">-<?php echo number_format($data['orderDetails']['discount'], 2); ?></td>
                            </tr>
                        <?php endif; ?>
                        <tr class="total-row">
                            <td colspan="3" class="text-right"><strong>Total:</strong></td>
                            <td class="text-right"><strong><?php echo number_format($data['orderDetails']['total'], 2); ?></strong></td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>

        <!-- Order Information -->
        <div class="order-info">
            <p><strong>Order ID:</strong> <?php echo htmlspecialchars($data['orderDetails']['order_id']); ?></p>
            <p><strong>Order Date:</strong> <?php echo date('F j, Y, g:i a', strtotime($data['orderDetails']['order_date'])); ?></p>
            <p><strong>Payment Status:</strong> <?php echo htmlspecialchars($data['orderDetails']['payment_status']); ?></p>
            <p><strong>Payment Method:</strong> <?php echo htmlspecialchars($data['orderDetails']['payment_method']); ?></p>
            
            <!-- Delivery Information -->
            <div class="delivery-info" style="margin-top: 20px;">
                <h3 style="color: #783b31; margin-bottom: 10px;">Delivery Information</h3>
                <p><strong>Delivery Type:</strong> <?php echo ucfirst(htmlspecialchars($data['orderDetails']['delivery_type'])); ?></p>
                <?php if ($data['orderDetails']['delivery_type'] === 'delivery'): ?>
                    <p><strong>Delivery Address:</strong> <?php echo htmlspecialchars($data['orderDetails']['delivery_address']); ?></p>
                    <p><strong>District:</strong> <?php echo ucfirst(htmlspecialchars($data['orderDetails']['district'])); ?></p>
                <?php endif; ?>
                <p><strong>Contact Number:</strong> <?php echo htmlspecialchars($data['orderDetails']['contact_number']); ?></p>
            </div>

            <!-- Buttons -->
            <div class="buttons" style="margin-top: 20px;">
                <a href="<?php echo URLROOT ?>/customer/customerhomepage" class="btn">Back to Home</a>
                <button class="btn" id="add-feedback-btn">Add Feedback</button>
            </div>

        </div> <!-- Close container div -->

        <!-- Feedback Modal -->
        <div id="feedbackModal" class="modal">
            <div class="modal-content">
                <h2>Leave Your Feedback</h2>
                <form id="feedbackForm" method="POST" action="<?php echo URLROOT; ?>/customer/submitFeedback">
                    <input type="hidden" name="order_id" value="<?php echo $data['orderDetails']['order_id']; ?>">
                    <input type="hidden" name="customer_id" value="<?php echo $_SESSION['customer_id']; ?>">
                    <textarea name="feedback_text" id="feedbackText" placeholder="Tell us about your experience..." required></textarea>
                    <div class="modal-buttons">
                        <button type="submit" class="btn" id="submit-feedback">Submit</button>
                        <button type="button" class="btn close-btn" id="close-modal">Close</button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Message Popup -->
        <div id="messagePopup" class="message-popup">
            <div class="message-content">
                <i class="fas fa-check-circle"></i>
                <p>Thank you for your feedback!</p>
            </div>
        </div>

        <script>
        document.getElementById('add-feedback-btn').addEventListener('click', function() {
            document.getElementById('feedbackModal').style.display = 'flex';
        });

        document.getElementById('close-modal').addEventListener('click', function() {
            document.getElementById('feedbackModal').style.display = 'none';
        });

        document.getElementById('feedbackForm').addEventListener('submit', function(e) {
            e.preventDefault();
            
            const formData = new FormData(this);
            const messagePopup = document.getElementById('messagePopup');
            
            fetch(this.action, {
                method: 'POST',
                body: formData
            })
            .then(response => response.text())
            .then(data => {
                try {
                    const result = JSON.parse(data);
                    if (result.success) {
                        // Hide the modal
                        document.getElementById('feedbackModal').style.display = 'none';
                        document.getElementById('add-feedback-btn').style.display = 'none';
                        
                        // Show success message
                        messagePopup.style.display = 'block';
                        
                        // Hide message after 3 seconds
                        setTimeout(() => {
                            messagePopup.style.animation = 'fadeOut 0.5s ease-out';
                            setTimeout(() => {
                                messagePopup.style.display = 'none';
                                messagePopup.style.animation = '';
                            }, 500);
                        }, 3000);
                    } else {
                        throw new Error(result.message || 'Error submitting feedback');
                    }
                } catch (e) {
                    messagePopup.querySelector('p').textContent = e.message;
                    messagePopup.style.background = '#dc3545';
                    messagePopup.style.display = 'block';
                    
                    setTimeout(() => {
                        messagePopup.style.animation = 'fadeOut 0.5s ease-out';
                        setTimeout(() => {
                            messagePopup.style.display = 'none';
                            messagePopup.style.animation = '';
                        }, 500);
                    }, 3000);
                }
            })
            .catch(error => {
                console.error('Error:', error);
                messagePopup.querySelector('p').textContent = 'Error submitting feedback';
                messagePopup.style.background = '#dc3545';
                messagePopup.style.display = 'block';
            });
        });
        </script>

    </body>
</html>
