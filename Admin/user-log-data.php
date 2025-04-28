<?php
include("Includes/header.php");
include("Connections/connect.php");
include("Connections/authorization.php");

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>User Logs</title>
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
        .content {
            margin-left: 22%;
            width: 75%;
        }
    </style>
</head>
<body class="bg-gray-100">

<div class="container">
    <div class="sidebar">
        <?php include("Includes/side-bar.php"); ?>
    </div>

    <div class="content p-6">
        <h1 class="text-3xl font-bold text-center mb-6">User Login Logs</h1>
        <table class="min-w-full bg-white border border-gray-300 shadow-md">
            <thead>
                <tr class="bg-gray-200">
                    <th class="px-4 py-2 border">Login ID</th>
                    <th class="px-4 py-2 border">User Name</th>
                    <th class="px-4 py-2 border">Logged In</th>
                    <th class="px-4 py-2 border">Logged Out</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $query = "SELECT userlogs.loginId, users.username, userlogs.loggedIn, userlogs.loggedOut 
                          FROM userlogs 
                          JOIN users ON userlogs.userId = users.id 
                          ORDER BY userlogs.loggedIn DESC";
                $result = mysqli_query($conn, $query);

                while ($row = mysqli_fetch_assoc($result)) {
                    echo "<tr>";
                    echo "<td class='px-4 py-2 border'>" . $row['loginId'] . "</td>";
                    echo "<td class='px-4 py-2 border'>" . htmlspecialchars($row['username']) . "</td>";
                    echo "<td class='px-4 py-2 border'>" . $row['loggedIn'] . "</td>";
                    echo "<td class='px-4 py-2 border'>" . (!empty($row['loggedOut']) ? $row['loggedOut'] : '<span class="text-red-500">Still Logged In</span>') . "</td>";
                    echo "</tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
</div>

</body>
</html>
<?php include("Includes/footer.php"); ?>
