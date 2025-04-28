<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Notifications</title>
    <?php require APPROOT.'/views/inc/components/verticalnavbar.php'; ?>
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/public/css/components/BranchManager/branchmdashboard.css">
    <style>

        /* Match header styling */
        header {
            background-color: #5d2e46;
            padding: 2rem;
            color: white;
            font-size: 2.5rem;
            text-transform: uppercase;
            margin-left: 30px;
            margin-right: 30px; /* Keep this value */
            border-radius: 5px;
            margin-top: 10px;
            z-index: 1;
            text-align: left;
        }

        header h7 {
            padding-left: 15px; /* Add some padding to the left of the text */
            display: inline-block;
            text-align: left;
            margin: 0;
        }

        header i {
            margin-right: 10px;
            text-align: left;
            display: inline-block;
            vertical-align: middle; /* Vertically align the icon with the text */
        }
        .notifications-wrapper {
            margin-left: 100px; /* Adjust based on your navbar width */
            padding: 20px;
        }
        
        .notifications-container {
            background: white;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            padding: 20px;
            margin: 20px;
        }

        .notification-item {
            padding: 15px;
            border-bottom: 1px solid #eee;
            margin-bottom: 10px;
            transition: background-color 0.3s;
        }

        .notification-item.unread {
            background-color: #f0e6ef;
        }

        .notification-item:hover {
            background-color: #f8f9fa;
        }

        .notification-message {
            font-size: 1.1em;
            margin-bottom: 5px;
        }

        .notification-time {
            font-size: 0.9em;
            color: #666;
        }

        .no-notifications {
            text-align: center;
            padding: 20px;
            color: #666;
        }
    </style>
</head>
<body>
    <div class="notifications-wrapper">
        <header>
            <h7><i class="fas fa-bell"></i> Notifications</h7>
        </header>

        <div class="notifications-container">
            <?php if(!empty($data['notifications'])): ?>
                <?php foreach($data['notifications'] as $notification): ?>
                    <div class="notification-item <?php echo !$notification->is_read ? 'unread' : ''; ?>"
                         data-id="<?php echo $notification->notification_id; ?>">
                        <div class="notification-message">
                            <?php echo htmlspecialchars($notification->message); ?>
                        </div>
                        <div class="notification-time">
                            <?php echo date('F j, Y, g:i a', strtotime($notification->created_at)); ?>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <div class="no-notifications">
                    <i class="fas fa-bell-slash"></i>
                    <p>No notifications at this time</p>
                </div>
            <?php endif; ?>
        </div>
    </div>

   
</body>
</html>