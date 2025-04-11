<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Branch Management</title>
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/public/css/HeadM/sidebar.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <style>
        body {
     
            margin: 0;
            font-family: Arial, sans-serif;
            background-color: #f2f1ec ;
            
        }

        .header {
            background-color: var(--primary-color);
            color: var(--white);
            padding: 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-radius: 10px;
            margin-left: 150px;
            margin-top: 10px;
            margin-bottom: 20px;
            font-size: 1.5rem;
            font-weight: bold;
        }

        .content {
            margin-left: 150px;
            padding: 20px;
            width: calc(100% - 250px);
            
        }

        .btn {
            padding: 10px 20px;
            font-size: 1rem;
            color: white;
            background-color: #c98d83;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            margin-bottom: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            
        }

        table th, table td {
            border: 1px solid #ddd;
            padding: 12px;
            text-align: left;
        }

        table th {
            background-color: #c98d83;
            color: white;
        }

        table td {
            background-color: #ffff;

        }

        .actions {
            display: flex;
            gap: 10px;
        }

        .modal {
            display: none;
            position: fixed;
            z-index: 1000;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            align-items: center;
            justify-content: center;
        }

        .modal-content {
            background-color: white;
            padding: 20px;
            border-radius: 8px;
            width: 40%;
            position: relative;
        }

        .modal-content h2 {
            margin-bottom: 20px;
            text-align: center;
        }

        .modal-content label {
            display: block;
            margin: 10px 0 5px;
        }

        .modal-content input {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 5px;
            margin-bottom: 15px;
        }

        .modal-content .close {
            position: absolute;
            top: 10px;
            right: 10px;
            font-size: 1.5rem;
            cursor: pointer;
        }

        .search-bar {
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .search-bar input {
            width: 70%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 1rem;
        }

        .search-bar button {
            padding: 10px 20px;
            font-size: 1rem;
            color: white;
            background-color: #c98d83;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        .search-bar button:hover {
            background-color: #783b31;
        } 
    </style>
</head>
<body>
<div class="container">
    <?php require_once APPROOT . '/views/SysAdmin/SideNavBar.php'; ?>

    <header class="header">
        <div class="header-left">
            <i class="fas fa-building"></i>
            <span>Branch Management</span>
        </div>
        <div class="header-role">
            <span>System Administrator</span>
        </div>
    </header>

    <div class="content">
        <div class="search-bar">
            <input type="text" id="searchBranchInput" placeholder="Search Branch by ID">
            <button onclick="searchBranch()">Search</button>
        </div>
        <button class="btn" onclick="openAddModal()">+ Add Branch</button>
        <table>
            <thead>
                <tr>
                    <th>Branch ID</th>
                    <th>Branch Name</th>
                    <th>Address</th>
                    <th>Contact No</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody id="branchTable">
                <tr>
                    <td>1</td>
                    <td>Main Branch</td>
                    <td>123 Street, Colombo</td>
                    <td>0771234567</td>
                    <td class="actions">
                        <button class="btn" onclick="openEditModal(1)">Edit</button>
                        <button class="btn delete-btn" onclick="deleteBranch(1)">Delete</button>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>

    <div class="modal" id="addBranchModal">
        <div class="modal-content">
            <span class="close" onclick="closeModal('addBranchModal')">&times;</span>
            <h2>Add Branch</h2>
            <form id="addBranchForm">
                <label for="branch_id">Branch ID:</label>
                <input type="text" id="branch_id" required>
                <label for="branch_name">Branch Name:</label>
                <input type="text" id="branch_name" required>
                <label for="address">Address:</label>
                <input type="text" id="address" required>
                <label for="contact_no">Contact No:</label>
                <input type="text" id="contact_no" required>
                <button type="submit" class="btn">Add Branch</button>
            </form>
        </div>
    </div>
</div>

<script>
    function openAddModal() {
        document.getElementById('addBranchModal').style.display = 'flex';
    }

    function closeModal(modalId) {
        document.getElementById(modalId).style.display = 'none';
    }

    document.getElementById("addBranchForm").addEventListener("submit", function(event) {
        event.preventDefault();
        const branchId = document.getElementById("branch_id").value;
        const branchName = document.getElementById("branch_name").value;
        const address = document.getElementById("address").value;
        const contactNo = document.getElementById("contact_no").value;
        
        const table = document.getElementById("branchTable");
        const row = table.insertRow();
        row.innerHTML = `<td>${branchId}</td><td>${branchName}</td><td>${address}</td><td>${contactNo}</td>
                         <td class='actions'><button class='btn' onclick='openEditModal(${branchId})'>Edit</button>
                         <button class='btn delete-btn' onclick='deleteBranch(${branchId})'>Delete</button></td>`;
        
        closeModal('addBranchModal');
    });
</script>

    <div class="modal" id="editBranchModal">
        <div class="modal-content">
            <span class="close" onclick="closeModal('editBranchModal')">&times;</span>
            <h2>Edit Branch</h2>
            <form id="editBranchForm">
                <label for="edit_branch_id">Branch ID:</label>
                <input type="text" id="edit_branch_id" required>
                <label for="edit_branch_name">Branch Name:</label>
                <input type="text" id="edit_branch_name" required>
                <label for="edit_address">Address:</label>
                <input type="text" id="edit_address" required>
                <label for="edit_contact_no">Contact No:</label>
                <input type="text" id="edit_contact_no" required>
                <button type="submit" class="btn">Update Branch</button>
            </form>
        </div>
    </div>
</div>

<script>
    function openAddModal() {
        document.getElementById('addBranchModal').style.display = 'flex';
    }

    function openEditModal(branchId) {
        document.getElementById('editBranchModal').style.display = 'flex';
    }

    function closeModal(modalId) {
        document.getElementById(modalId).style.display = 'none';
    }

    function deleteBranch(branchId) {
        if (confirm("Are you sure you want to delete this branch?")) {
            alert(`Branch ${branchId} deleted.`);
        }
    }
</script>
</body>
</html>
