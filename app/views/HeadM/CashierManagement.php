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
                <h1><i class="fas fa-cash-register icon-cashier"></i>&nbsp Cashiers</h1>
                
            </header>
            <div class="content">
                <div class="employee-list">
                    <div class="search-bar">
                        <form method="GET" action="<?php echo URLROOT; ?>/HeadM/cashierManagement" class="search-form">
                            <div class="search-field">
                                <input type="text" name="name_email" placeholder="Search by Name or Email" value="<?php echo isset($_GET['name_email']) ? htmlspecialchars($_GET['name_email']) : ''; ?>">
                            </div>
                            <div class="search-field">
                                <select name="branch_id">
                                    <option value="">All Branches</option>
                                    <?php foreach ($data['branches'] as $branch): ?>
                                        <option value="<?php echo $branch->branch_id; ?>" <?php echo (isset($_GET['branch_id']) && $_GET['branch_id'] == $branch->branch_id) ? 'selected' : ''; ?>>
                                            <?php echo $branch->branch_name; ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="search-field">
                                <button class="btn search-btn" type="submit"><i class="fas fa-search"></i> Search</button>
                            </div>
                        </form>
                    </div>
                    <div class="table-container" style="border-radius: 10px; overflow: hidden;">
                        <table style="border-collapse: separate; border-spacing: 0; border-radius: 10px;">
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
                                                    <a href="<?php echo URLROOT . '/headm/downloadCV/' . $cashier->employee_id; ?>" class="btn download-cv"><i class="fas fa-download"></i>Download CV</a>
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