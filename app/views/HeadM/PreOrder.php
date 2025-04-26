<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Frostine Head Manager - View Enquiries</title>
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/public/css/HeadM/Customization.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
</head>
<body>
    <div class="container">
        <!-- Sidebar -->
        <?php require_once APPROOT.'/views/HeadM/inc/sidebar.php'; ?>

        <!-- Main Content -->
        <main>
            <header class="header">
                <h1><i class="fas fa-question-circle"></i>&nbsp View Enquiries</h1>
                <div class="user-info">
                    <span><b>HEAD MANAGER</b></span>
                </div>
            </header>

            <div class="content">
                <div class="preorder-list">
                    <div class="search-bar">
                        <form method="GET" action="<?php echo URLROOT; ?>/HeadM/preOrder" class="search-form">
                            <div class="search-field">
                                <input type="text" name="search" placeholder="Search by Name or Email" value="<?php echo isset($_GET['search']) ? htmlspecialchars($_GET['search']) : ''; ?>">
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
                                    <th>Enquiry ID</th>
                                    <th>First Name</th>
                                    <th>Last Name</th>
                                    <th>Email</th>
                                    <th>Phone Number</th>
                                    <th>Message</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (!empty($data['preOrders'])): ?>
                                    <?php foreach ($data['preOrders'] as $enquiry): ?>
                                        <tr>
                                            <td><?php echo htmlspecialchars($enquiry->enquiry_id); ?></td>
                                            <td><?php echo htmlspecialchars($enquiry->first_name); ?></td>
                                            <td><?php echo htmlspecialchars($enquiry->last_name); ?></td>
                                            <td><?php echo htmlspecialchars($enquiry->email); ?></td>
                                            <td><?php echo htmlspecialchars($enquiry->phone_number); ?></td>
                                            <td><?php echo htmlspecialchars($enquiry->description); ?></td>
                                            <td>
                                                <button class="btn btn-primary btn-sm" 
                                                        onclick="showReplyModal(
                                                            '<?php echo $enquiry->enquiry_id; ?>', 
                                                            '<?php echo htmlspecialchars($enquiry->first_name . ' ' . $enquiry->last_name); ?>', 
                                                            '<?php echo htmlspecialchars($enquiry->email); ?>'
                                                        )">
                                                    Reply
                                                </button>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <tr>
                                        <td colspan="7">No enquiries found.</td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </main>
    </div>

    <!-- Add this modal HTML at the bottom of your PreOrder view -->
    <div class="modal fade" id="replyModal" tabindex="-1" role="dialog" aria-labelledby="replyModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="replyModalLabel">Reply to Enquiry</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="replyForm">
                    <div class="modal-body">
                        <input type="hidden" id="enquiry_id" name="enquiry_id">
                        <div class="customer-info">
                            <p><i class="fas fa-user"></i><span id="customer_name"></span></p>
                            <p><i class="fas fa-envelope"></i><span id="customer_email"></span></p>
                        </div>
                        <div class="form-group">
                            <label for="reply_message">Your Reply:</label>
                            <textarea class="form-control" id="reply_message" name="reply_message" rows="5" required placeholder="Type your response here..."></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">Send Reply</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Add jQuery and Bootstrap JS if not already included -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    
    <!-- Your custom JavaScript file -->
    <script src="<?php echo URLROOT; ?>/public/assets/js/headm/preorder.js"></script>
</body>
</html>