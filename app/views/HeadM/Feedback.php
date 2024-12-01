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
        <?php require_once APPROOT.'/views/HeadM/inc/sidebar.php'; ?>

        <!-- Main Content -->
        <main>
            <header class="header">
                <h1><i class="fas fa-comments"></i>&nbsp FEEDBACK VIEW</h1>
                <div class="user-info">
                    <span><b>HEAD MANAGER</b></span>
                </div>
            </header>
            <div class="content">

            <!-- Delete Confirmation Modal -->
            <div id="deleteemployeeModal" class="modal">
                <div class="modal-content">
                    <span class="close">&times;</span>
                    <h2>Delete Feedback</h2>
                    <p>Are you sure you want to delete this feedback?</p>
                    <div class="buttons">
                        <button type="submit" id="confirmDelete" class="btn reset">Yes</button>
                        <button type="reset" class="btn submit">No</button>
                    </div>
                </div>
            </div>
            
            <div class="emplooyee-list">
                <div class="search-bar">
                    <form method="GET" action="">
                        <input type="text" placeholder="Search by Customer Name">
                        <button class="search-btn"><i class="fas fa-search"></i></button>
                    </form>
                </div>
                <div class="table-container">
                    <table>
                        <thead>
                            <tr>
                                <th>Feedback ID</th>
                                <th>Customer ID</th>
                                <th>Customer Name</th>
                                <th>Message</th>
                                <th>Rating</th>
                                <th>Date</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>F001</td>
                                <td>101</td>
                                <td>John Doe</td>
                                <td>The cake was amazing!</td>
                                <td><span class="rating">★★★★★</span></td>
                                <td>2024-11-20</td>
                                <td><button class="btn delete" onclick="deleteEmployee()">Delete</button></td>
                            </tr>
                            <tr>
                                <td>F002</td>
                                <td>102</td>
                                <td>Jane Smith</td>
                                <td>Delivery was on time and perfect.</td>
                                <td><span class="rating">★★★★★</span></td>
                                <td>2024-11-21</td>
                                <td><button class="btn delete"onclick="deleteEmployee()">Delete</button></td>
                            </tr>
                            <tr>
                                <td>F003</td>
                                <td>103</td>
                                <td>Michael Brown</td>
                                <td>Great customization options!</td>
                                <td><span class="rating">★★★★★</span></td>
                                <td>2024-11-22</td>
                                <td><button class="btn delete"onclick="deleteEmployee()">Delete</button></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                </div>
            </div>
        </main>
    </div>
    <script src="<?php echo URLROOT; ?>/public/js/HeadM/BranchManagers.js"></script>
</body>

</html>


