<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Feedback View - Head Manager</title>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/public/css/HeadM/Customization.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
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
                    <form method="GET" action="">
                        <input type="text" name="search" placeholder="Search by Product Name" value="<?php echo isset($_GET['search']) ? htmlspecialchars($_GET['search']) : ''; ?>">
                        <button class="search-btn"><i class="fas fa-search"></i></button>
                    </form>
                </div>
                <div class="table-container">
                    <table>
                        <thead>
                            <tr>
                                <th>Product Name</th>
                                <th>Star Rating</th>
                                <th>Feedback Comment</th>
                                <th>Created Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!empty($data['feedbacks'])): ?>
                                <?php foreach ($data['feedbacks'] as $feedback): ?>
                                    <tr>
                                        <td><?php echo htmlspecialchars($feedback->product_name); ?></td>
                                        <td>
                                            <?php for ($i = 0; $i < floor($feedback->star_rating); $i++): ?>
                                                <span class="rating">★</span>
                                            <?php endfor; ?>
                                            <?php for ($i = floor($feedback->star_rating); $i < 5; $i++): ?>
                                                <span class="rating">☆</span>
                                            <?php endfor; ?>
                                        </td>
                                        <td><?php echo htmlspecialchars($feedback->feedback_comment); ?></td>
                                        <td><?php echo htmlspecialchars($feedback->created_at); ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="4" style="text-align: center;">No feedback found.</td>
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


