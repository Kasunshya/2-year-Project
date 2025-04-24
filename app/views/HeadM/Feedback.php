<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Feedback View - Head Manager</title>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/public/css/HeadM/Customization.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <style>
        .rating {
            color: #FFD700;
            font-size: 18px;
        }
        
        /* Add styling for notification */
        .notification {
            position: fixed;
            top: 20px;
            right: 20px;
            padding: 15px 25px;
            border-radius: 4px;
            color: white;
            opacity: 0;
            transition: opacity 0.3s ease-in-out;
            z-index: 1000;
        }
        
        .notification.success {
            background-color: #4CAF50;
        }
        
        .notification.error {
            background-color: #F44336;
        }
        
        .notification.show {
            opacity: 1;
        }
    </style>
</head>

<body>
    <div class="container">
        <!-- Sidebar -->
        <?php require_once APPROOT . '/views/HeadM/inc/sidebar.php'; ?>

        <!-- Main Content -->
        <main>
            <header class="header">
                <h1><i class="fas fa-comments"></i>&nbsp FEEDBACK VIEW</h1>
                <div class="user-info">
                    <span><b>HEAD MANAGER</b></span>
                </div>
            </header>
            <div class="content">
                <div class="search-bar">
                    <form method="GET" action="<?php echo URLROOT; ?>/HeadM/feedback" class="search-form">
                        <div class="search-field">
                            <input type="text" name="product_name" placeholder="Search by Product Name" value="<?php echo isset($_GET['product_name']) ? htmlspecialchars($_GET['product_name']) : ''; ?>">
                        </div>
                        <div class="search-field">
                            <button class="btn search-btn" type="submit"><i class="fas fa-search"></i> Search</button>
                        </div>
                    </form>
                </div>
                <div class="table-container">
                    <table>
                        <thead>
                            <tr>
                                <th>Customer Name</th>
                                <th>Product Name</th>
                                <th>Feedback</th>
                                <th>Date</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (isset($data['feedbacks']) && is_array($data['feedbacks'])): ?>
                                <?php foreach ($data['feedbacks'] as $feedback): ?>
                                    <tr>
                                        <td><?php echo !is_null($feedback->customer_name) ? htmlspecialchars($feedback->customer_name) : 'N/A'; ?></td>
                                        <td><?php echo !is_null($feedback->product_name) ? htmlspecialchars($feedback->product_name) : 'N/A'; ?></td>
                                        <td><?php echo !is_null($feedback->feedback_text) ? htmlspecialchars($feedback->feedback_text) : 'No feedback'; ?></td>
                                        <td><?php echo !is_null($feedback->created_at) ? date('Y-m-d', strtotime($feedback->created_at)) : 'N/A'; ?></td>
                                        <td>
                                            <button class="btn post-btn" onclick="postFeedback(<?php echo $feedback->feedback_id; ?>)">
                                                <i class="fas fa-share"></i> Post
                                            </button>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="5" style="text-align: center;">No feedback found</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </main>
    </div>
    
    <!-- Add notification div -->
    <div id="notification" class="notification"></div>
    
    <!-- Add JavaScript for posting feedback -->
    <script>
        function postFeedback(feedbackId) {
            if (confirm('Are you sure you want to post this feedback to the homepage?')) {
                fetch('<?php echo URLROOT; ?>/HeadM/postFeedback', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify({ feedback_id: feedbackId })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        showNotification('Feedback posted to homepage successfully!', 'success');
                    } else {
                        showNotification('Error: ' + data.message, 'error');
                    }
                })
                .catch(error => {
                    showNotification('Error connecting to server', 'error');
                    console.error('Error:', error);
                });
            }
        }
        
        function showNotification(message, type) {
            const notification = document.getElementById('notification');
            notification.textContent = message;
            notification.className = `notification ${type}`;
            
            // Show notification
            setTimeout(() => notification.classList.add('show'), 100);
            
            // Hide notification after 3 seconds
            setTimeout(() => {
                notification.classList.remove('show');
            }, 3000);
        }
    </script>
</body>

</html>


