<?php
include("Includes/header.php");
include('Connections/connect.php');
include("Connections/authorization.php");

// These lines are NOT needed for infinite scroll:
$limit = 10;
$offset = isset($_GET['offset']) ? intval($_GET['offset']) : 0;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Total Orders</title>
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <link href="../Styles/styles.css" rel="stylesheet">
    <style>
        .container {
            display: flex;
            flex-direction: row;
        }
        .sidebar {
            width: 20%;
            position: fixed;
            left: 0;
            top: 0;
            height: 100%;
            background: #f4f4f4;
        }
        .table-container {
            margin-left: 22%; /* leave space for sidebar */
            width: 75%;
        }
    </style>
</head>
<body class="bg-gray-100">

<div class="flex">
<div class="container">
    <div class="sidebar">
        <?php include("Includes/side-bar.php"); ?>
    </div>

    <div class="table-container p-6">
        <h1 class="text-3xl font-bold text-center mb-6">Today's Orders</h1>
        <table class="min-w-full bg-white border border-gray-300 shadow-md">
            <thead>
                <tr class="bg-gray-200">
                    <th class="px-4 py-2 border">Sl No</th>
                    <th class="px-4 py-2 border">Order ID</th>
                    <th class="px-4 py-2 border">Username</th>
                    <th class="px-4 py-2 border">Address</th>
                    <th class="px-4 py-2 border">Order Item</th>
                    <th class="px-4 py-2 border">Quantity</th>
                    <th class="px-4 py-2 border">Price</th>
                    <th class="px-4 py-2 border">Action</th>
                </tr>
            </thead>
            <tbody id="orders-table-body"></tbody>
        </table>
        <div id="loading" class="text-center py-4 hidden">Loading...</div>
    </div>
</div>
</div>

<script>
    let offset = 0;
    const limit = 10;
    let loading = false;

    function loadOrders() {
        if (loading) return;
        loading = true;
        document.getElementById('loading').classList.remove('hidden');

        axios.get(`Logics/fetch-today.php?offset=${offset}`)
            .then(response => {
                const orders = response.data;
                const tableBody = document.getElementById('orders-table-body');

                orders.forEach((order, index) => {
                    const row = document.createElement('tr');
                    row.innerHTML = `
                        <td class="px-4 py-2 border">${offset + index + 1}</td>
                        <td class="px-4 py-2 border">${order.order_id}</td>
                        <td class="px-4 py-2 border">${order.username}</td>
                        <td class="px-4 py-2 border">${order.address}</td>
                        <td class="px-4 py-2 border">${order.productName}</td>
                        <td class="px-4 py-2 border">${order.quantity}</td>
                        <td class="px-4 py-2 border">${order.price}</td>
                        <td class="px-4 py-2 border">
                            <a href="update-order.php?id=${order.order_id}" class="text-blue-500">Details</a>
                        </td>
                    `;
                    tableBody.appendChild(row);
                });

                offset += limit;
                loading = false;
                document.getElementById('loading').classList.add('hidden');
            })
            .catch(error => {
                console.error('Error loading orders:', error);
                document.getElementById('loading').textContent = 'Error loading orders.';
                loading = false;
            });
    }

    // Load initial orders
    loadOrders();

    // Infinite Scroll
    window.addEventListener('scroll', () => {
        if ((window.innerHeight + window.scrollY) >= document.body.offsetHeight - 100) {
            loadOrders();
        }
    });

    // Refresh orders every 15 seconds (optional real-time update)
    setInterval(() => {
        offset = 0;
        document.getElementById('orders-table-body').innerHTML = '';
        loadOrders();
    }, 15000); // 15 seconds
</script>

</body>
</html>
<?php include("Includes/footer.php"); ?>
