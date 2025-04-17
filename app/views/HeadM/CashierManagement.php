<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Frostine Cashier Management</title>
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
                <h1><i class="fas fa-cash-register icon-cashier"></i>&nbsp CASHIERS</h1>
                <div class="user-info">
                    <span><b>HEAD MANAGER</b></span>
                </div>
            </header>
            <div class="content">
                <div class="employee-list">
                    <div class="search-bar">
                        <form method="GET" action="">
                            <input type="text" name="search" placeholder="Search by Name or Email" value="<?php echo isset($_GET['search']) ? $_GET['search'] : ''; ?>">
                            <button class="search-btn">🔍</button>
                        </form>
                    </div>
                    <div class="table-container">
                        <table>
                            <thead>
                                <tr>
                                    <th>Cashier ID</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Contact No</th>
                                    <th>NIC</th>
                                    <th>Address</th>
                                    <th>Branch</th>
                                    <th>CV</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (!empty($data['cashiers'])): ?>
                                    <?php foreach ($data['cashiers'] as $cashier): ?>
                                        <tr>
                                            <td><?php echo $cashier->employee_id; ?></td>
                                            <td><?php echo $cashier->full_name; ?></td>
                                            <td><?php echo $cashier->email; ?></td>
                                            <td><?php echo $cashier->contact_no; ?></td>
                                            <td><?php echo $cashier->nic; ?></td>
                                            <td><?php echo $cashier->address; ?></td>
                                            <td><?php echo $cashier->branch; ?></td>
                                            <td>
                                                <?php if (!empty($cashier->cv_upload)): ?>
                                                    <a href="<?php echo URLROOT . '/headm/downloadCV/' . $cashier->employee_id; ?>">Download CV</a>
                                                <?php else: ?>
                                                    No CV Uploaded
                                                <?php endif; ?>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <tr>
                                        <td colspan="8">No cashiers found.</td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </main>
    </div>
</body>

</html>

<?php
// Ensure this function is part of a class, e.g., HeadManagerController
class HeadManagerController
{
    public function downloadCV($employee_id)
    {
        $cashier = $this->headManagerModel->getCashierById($employee_id);

        if ($cashier && !empty($cashier->cv_file)) {
            header('Content-Type: application/octet-stream');
            header('Content-Disposition: attachment; filename="' . $cashier->cv_upload . '"');
            echo $cashier->cv_file;
            exit;
        } else {
            flash('cashier_message', 'CV not found', 'alert alert-danger');
            redirect('HeadM/cashierManagement');
        }
    }
}