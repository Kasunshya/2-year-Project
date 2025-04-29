<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <title>Frostine Head Manager - View Enquiries</title>
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/public/css/HeadM/Customization.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        /* SweetAlert2 Customization */
        .swal2-popup {
            font-size: 1.2rem;
        }
        
        .swal2-title {
            color: #333;
        }
        
        .swal2-confirm {
            background-color: #28a745 !important;
        }
        
        .swal2-cancel {
            background-color: #dc3545 !important;
        }

        .modal {
            display: none;
            position: fixed;
            z-index: 1000;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0,0,0,0.4);
        }

        .modal-content {
            background-color: #fefefe;
            margin: 15% auto;
            padding: 20px;
            border: 1px solid #888;
            width: 50%;
            border-radius: 8px;
            position: relative;
        }

        .close {
            color: #aaa;
            float: right;
            font-size: 28px;
            font-weight: bold;
            cursor: pointer;
        }

        .close:hover {
            color: black;
        }

        .customer-info {
            margin: 15px 0;
            padding: 10px;
            background: #f8f9fa;
            border-radius: 4px;
        }

        .form-group {
            margin-bottom: 15px;
        }

        .form-group label {
            display: block;
            margin-bottom: 5px;
        }

        .form-group textarea {
            width: 100%;
            min-height: 100px;
            padding: 8px;
            border: 1px solid #ddd;
            border-radius: 4px;
        }

        .modal-buttons {
            text-align: right;
            margin-top: 15px;
        }

        .modal-buttons button {
            margin-left: 10px;
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- Sidebar -->
        <?php require_once APPROOT.'/views/HeadM/inc/sidebar.php'; ?>

        <!-- Main Content -->
        <main>
            <header class="header">
                <h1><i class="fas fa-question-circle"></i>&nbsp View Enquiries</h1>
                
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
                                                <button class="btn btn-primary" 
                                                        onclick="showReplyModal(
                                                            '<?php echo $enquiry->enquiry_id; ?>', 
                                                            '<?php echo htmlspecialchars($enquiry->first_name . ' ' . $enquiry->last_name); ?>', 
                                                            '<?php echo htmlspecialchars($enquiry->email); ?>'
                                                        )">
                                                    <i class="fas fa-reply"></i> Reply
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

    <div class="modal" id="replyModal">
        <div class="modal-content">
            <span class="close">&times;</span>
            <h2>Reply to Enquiry</h2>
            <form id="replyForm">
                <input type="hidden" id="enquiry_id" name="enquiry_id">
                <div class="customer-info">
                    <p><strong>Customer:</strong> <span id="customer_name"></span></p>
                    <p><strong>Email:</strong> <span id="customer_email"></span></p>
                </div>
                <div class="form-group">
                    <label for="reply_message">Your Reply:</label>
                    <textarea id="reply_message" name="reply_message" required></textarea>
                </div>
                <div class="modal-buttons">
                    <button type="submit" class="btn btn-primary">Send Reply</button>
                    <button type="button" class="btn btn-secondary close-modal">Cancel</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Add jQuery and Bootstrap JS if not already included -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    
    <!-- Your custom JavaScript file -->
    <script src="<?php echo URLROOT; ?>/public/assets/js/headm/preorder.js"></script>

    <script>
        function showReplyModal(enquiryId, customerName, customerEmail) {
            const modal = document.getElementById('replyModal');
            document.getElementById('enquiry_id').value = enquiryId;
            document.getElementById('customer_name').textContent = customerName;
            document.getElementById('customer_email').textContent = customerEmail;
            modal.style.display = 'block';
        }

        // Close modal when clicking the close button or outside
        document.querySelector('.close').onclick = function() {
            document.getElementById('replyModal').style.display = 'none';
        }

        document.querySelector('.close-modal').onclick = function() {
            document.getElementById('replyModal').style.display = 'none';
        }

        window.onclick = function(event) {
            const modal = document.getElementById('replyModal');
            if (event.target == modal) {
                modal.style.display = 'none';
            }
        }

        // Handle form submission
        document.getElementById('replyForm').addEventListener('submit', function(e) {
            e.preventDefault();
            
            const formData = new FormData();
            formData.append('enquiry_id', document.getElementById('enquiry_id').value);
            formData.append('reply_message', document.getElementById('reply_message').value);

            fetch('<?php echo URLROOT; ?>/HeadM/sendEnquiryReply', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.status === 'success') {
                    Swal.fire({
                        icon: 'success',
                        title: 'Success!',
                        text: 'Reply sent successfully',
                        confirmButtonColor: '#a26b98'
                    }).then(() => {
                        document.getElementById('replyModal').style.display = 'none';
                        document.getElementById('replyForm').reset();
                        location.reload();
                    });
                } else {
                    throw new Error(data.message || 'Failed to send reply');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                Swal.fire({
                    icon: 'error',
                    title: 'Error!',
                    text: error.message || 'Failed to send reply',
                    confirmButtonColor: '#a26b98'
                });
            });
        });
    </script>
</body>
</html>