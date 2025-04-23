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
                                <th>Rating</th>
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
                                        <td>
                                            <?php 
                                            $rating = isset($feedback->rating) ? (int)$feedback->rating : 0;
                                            for ($i = 0; $i < $rating; $i++): ?>
                                                <span class="rating">★</span>
                                            <?php endfor; 
                                            for ($i = $rating; $i < 5; $i++): ?>
                                                <span class="rating">☆</span>
                                            <?php endfor; ?>
                                        </td>
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
                                    <td colspan="6" style="text-align: center;">No feedback found</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </main>
    </div>
</body>

</html>


