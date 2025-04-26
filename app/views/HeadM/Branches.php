<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <title>Frostine Branches</title>
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/public/css/HeadM/Dashboard.css">
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
                <h1><i class="fas fa-building"></i>&nbsp Branches</h1>

            </header>
            <section class="dashboard-content">
                <div class="overview">
                    <?php foreach ($data['branches'] as $branch): ?>
                        <div class="card">
                            <h2><?php echo htmlspecialchars($branch->branch_name); ?></h2>
                            <p><?php echo htmlspecialchars($branch->branch_address); ?></p>
                            
                            <a href="<?php echo URLROOT; ?>/HeadM/branch/<?php echo $branch->branch_id; ?>" class="btn">View Branch</a>                        </div>
                    <?php endforeach; ?>
                </div>
            </section>
        </main>
    </div>
</body>

</html>