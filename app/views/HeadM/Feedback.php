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
        
        

        .status-badge {
            padding: 8px 15px;  /* Increased padding */
            border-radius: 15px; /* Increased border radius */
            font-size: 1.1em;   /* Increased font size */
            font-weight: 600;    /* Made font slightly bolder */
            display: inline-block;
            min-width: 100px;    /* Set minimum width */
            text-align: center;  /* Center the text */
            text-transform: uppercase; /* Make text uppercase */
            letter-spacing: 0.5px; /* Add letter spacing */
        }

        .status-badge.posted {
            background-color: #28a745;
            color: white;
            box-shadow: 0 2px 4px rgba(40, 167, 69, 0.2); /* Added subtle shadow */
        }

        .status-badge.unposted {
            background-color: #6c757d;
            color: white;
            box-shadow: 0 2px 4px rgba(108, 117, 125, 0.2); /* Added subtle shadow */
        }

        .unpost-btn {
            background-color: #dc3545;
            color: white;
            border: none;
            padding: 5px 10px;
            border-radius: 4px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .unpost-btn:hover {
            background-color: #c82333;
        }

        .unpost-btn i {
            margin-right: 5px;
        }

        .post-btn {
            background-color: #28a745;
            color: white;
        }

        .post-btn:hover {
            background-color: #218838;
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
                <h1><i class="fas fa-comments"></i>&nbsp Feedback View</h1>
                <div class="user-info">
                    <span><b>HEAD MANAGER</b></span>
                </div>
            </header>
            <div class="content">
                <div class="search-bar">
                    <form method="GET" action="<?php echo URLROOT; ?>/HeadM/feedback" class="search-form">
                        <div class="search-field">
                            <input type="text" name="order_id" placeholder="Search by Order ID" 
                                   value="<?php echo isset($_GET['order_id']) ? htmlspecialchars($_GET['order_id']) : ''; ?>">
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
                                <th>Order ID</th>
                                <th>Feedback</th>
                                <th>Date</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (isset($data['feedbacks']) && is_array($data['feedbacks'])): ?>
                                <?php foreach ($data['feedbacks'] as $feedback): ?>
                                    <tr>
                                        <td><?php echo htmlspecialchars($feedback->customer_name ?? 'N/A'); ?></td>
                                        <td><?php echo htmlspecialchars($feedback->order_id ?? 'N/A'); ?></td>
                                        <td><?php echo htmlspecialchars($feedback->feedback_text ?? 'No feedback'); ?></td>
                                        <td><?php echo date('Y-m-d', strtotime($feedback->created_at)); ?></td>
                                        <td>
                                            <span class="status-badge <?php echo $feedback->is_posted ? 'posted' : 'unposted'; ?>">
                                                <?php echo $feedback->is_posted ? 'Posted' : 'Unposted'; ?>
                                            </span>
                                        </td>
                                        <td>
                                            <?php if ($feedback->is_posted == 0): ?>
                                                <button class="btn post-btn" onclick="postFeedback(<?php echo $feedback->feedback_id; ?>)">
                                                    <i class="fas fa-share"></i> Post
                                                </button>
                                            <?php else: ?>
                                                <button class="btn unpost-btn" onclick="unpostFeedback(<?php echo $feedback->feedback_id; ?>)">
                                                    <i class="fas fa-times"></i> Remove
                                                </button>
                                            <?php endif; ?>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="6" style="text-align: center;">No feedback found</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </main>
    </div>
    
    
    <!-- Add JavaScript for posting feedback -->
    <script>
        function postFeedback(feedbackId) {
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
                    location.reload();
                }
            })
            .catch(error => {
                console.error('Error:', error);
            });
        }

        function unpostFeedback(feedbackId) {
            fetch('<?php echo URLROOT; ?>/HeadM/unpostFeedback', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: 'feedback_id=' + feedbackId
            })
            .then(response => response.json())
            .then(data => {
                if (data.status === 'success') {
                    location.reload();
                }
            })
            .catch(error => {
                console.error('Error:', error);
            });
        }
    </script>
</body>

</html>


