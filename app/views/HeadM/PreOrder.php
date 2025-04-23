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
                <h1><i class="fas fa-question-circle"></i>&nbsp VIEW ENQUIRIES</h1>
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
                                                <button class="btn reply" onclick="replyToEnquiry('<?php echo htmlspecialchars($enquiry->email); ?>', '<?php echo htmlspecialchars($enquiry->enquiry_id); ?>')">
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

    <script>
    function replyToEnquiry(email, enquiryId) {
        window.location.href = `mailto:${email}?subject=Re: Enquiry #${enquiryId}`;
    }
    </script>
</body>
</html>