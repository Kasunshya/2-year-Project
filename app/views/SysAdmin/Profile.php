<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $data['title']; ?></title>
    <?php require APPROOT.'/views/SysAdmin/SideNavBar.php'?>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    
    <style>
        .profile-container {
            width: 90%;
            margin-left: 120px;
            margin-right: 30px;
            padding: 20px;
            background: white;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }

        header {
            background-color: #5d2e46;
            padding: 2rem;
            margin-left: 120px;
            margin-right: 20px;
            margin-bottom: 20px;
            border-radius: 5px;
            color: white;
            display: flex;
            align-items: center;
        }

        header i {
            margin-right: 10px;
            font-size: 2rem;
        }

        .detail-row {
            padding: 15px;
            border-bottom: 1px solid #eee;
            display: flex;
            align-items: center;
        }

        .label {
            font-weight: bold;
            width: 150px;
            color: #5d2e46;
        }

        .value {
            color: #666;
        }
    </style>
</head>
<body>
    <header>
        <i class="fas fa-user-shield"></i>
        <h1>My Profile</h1>
    </header>

    <div class="profile-container">
        <?php flash('profile_message'); ?>
        
        <?php if(isset($data['employee']) && $data['employee']): ?>
            <div class="detail-row">
                <span class="label">Name:</span>
                <span class="value"><?php echo htmlspecialchars($data['employee']->full_name ?? 'N/A'); ?></span>
            </div>
            <div class="detail-row">
                <span class="label">Email:</span>
                <span class="value"><?php echo htmlspecialchars($data['employee']->email ?? 'N/A'); ?></span>
            </div>
            <div class="detail-row">
                <span class="label">Role:</span>
                <span class="value">System Administrator</span>
            </div>
            <div class="detail-row">
                <span class="label">Join Date:</span>
                <span class="value">
                    <?php echo isset($data['employee']->join_date) ? date('F j, Y', strtotime($data['employee']->join_date)) : 'N/A'; ?>
                </span>
            </div>
        <?php else: ?>
            <div class="alert alert-warning">
                Profile information not available
            </div>
        <?php endif; ?>
    </div>
</body>
</html>
