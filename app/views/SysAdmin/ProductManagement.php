<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Food Management</title>
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/public/css/HeadM/sidebar.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <style>
        body {
            display: flex;
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

        .modal-content input, .modal-content select, .modal-content textarea {
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
            <i class="fas fa-utensils"></i>
            <span>Product Management</span>
        </div>
        <div class="header-role">
            <span>System Administrator</span>
        </div>
    </header>
 
           
    <div class="content">
    <div class="search-bar">
                <input type="text" id="searchProductInput" placeholder="Search Product by ID">
                <button onclick="searchProduct()">Search</button>
                </div>
        <button class="btn" onclick="openAddFoodModal()">+ Add Food Item</button>
        <table>
            <thead>
                <tr>
                    <th>Product ID</th>
                    <th>Photo</th>
                    <th>Name</th>
                    <th>Category</th>
                    <th>Description</th>
                    <th>Price</th>
                    <th>Quantity</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody id="foodTable">
                <tr id="food-1">
                    <td>1</td>
                    <td><img src="../public/img/Customer/product-1.jpg" alt="Strawberry Pancake" width="50"></td>
                    <td>Strawberry Pancake</td>
                    <td>Pancakes</td>
                    <td>Delicious pancake with fresh strawberries.</td>
                    <td>LKR 1,250.00</td>
                    <td>10</td>
                    <td class="actions">
                        <button class="btn" onclick="openEditFoodModal(1)">Edit</button>
                        <button class="btn delete-btn" onclick="deleteFood(1)">Delete</button>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>

    <div class="modal" id="foodModal">
        <div class="modal-content">
            <span class="close" onclick="closeModal('foodModal')">&times;</span>
            <h2 id="foodModalTitle">Add Food Item</h2>
            <form id="foodForm">
                <input type="hidden" id="product_id">
                <label for="food_photo">Photo:</label>
                <input type="file" id="food_photo" accept="image/*">
                <label for="food_name">Name:</label>
                <input type="text" id="food_name" required>
                <label for="food_category">Category:</label>
                <select id="food_category" required>
                    <option value="Bread">Bread</option>
                    <option value="Waffles">Waffles</option>
                    <option value="Pancakes">Pancakes</option>
                    <option value="Drinks">Drinks</option>
                    <option value="Savoury Items">Savoury Items</option>
                </select>
                <label for="food_description">Description:</label>
                <textarea id="food_description" required></textarea>
                <label for="food_price">Price:</label>
                <input type="number" id="food_price" required>
                <label for="food_quantity">Quantity:</label>
                <input type="number" id="food_quantity" required>
                <button type="submit" class="btn">Save</button>
                <button type="button" class="btn" onclick="closeModal('foodModal')">Close</button>
            </form>
        </div>
    </div>
</div>

<script>
    function openAddFoodModal() {
        document.getElementById('foodModalTitle').textContent = "Add Food Item";
        document.getElementById('foodForm').reset();
        document.getElementById('foodModal').style.display = 'flex';
    }

    function openEditFoodModal(productId) {
        document.getElementById('foodModalTitle').textContent = "Update Food Item";

        let row = document.getElementById(`food-${productId}`);
        let cells = row.getElementsByTagName("td");

        document.getElementById("food_name").value = cells[2].textContent.trim();
        document.getElementById("food_category").value = cells[3].textContent.trim();
        document.getElementById("food_description").value = cells[4].textContent.trim();
        document.getElementById("food_price").value = parseFloat(cells[5].textContent.replace('LKR', '').trim());
        document.getElementById("food_quantity").value = cells[6].textContent.trim();

        document.getElementById('foodModal').style.display = 'flex';
    }

    function closeModal(modalId) {
        document.getElementById(modalId).style.display = 'none';
    }

    document.getElementById('foodForm').addEventListener('submit', function(e) {
        e.preventDefault();
        alert("Food item saved/updated successfully!");
        closeModal('foodModal');
    });
</script>

<script>
function deleteFood(fproductId) {
    if (confirm("Are you sure you want to delete this food item?")) {
        let row = document.getElementById(`food-${productId}`);
        if (row) {
            row.remove();
            alert(`Food item ${productId} deleted successfully!`);
        } else {
            alert("Food item not found!");
        }
    }
}
</script>


</body>
</html>