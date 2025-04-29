<?php
include("Includes/header.php");
include("Connections/connect.php");
include("Connections/authorization.php");

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>All Users</title>
    <link href="../Styles/styles.css" rel="stylesheet">
    <link href="Styles/total-users.css" rel="stylesheet">
</head>
<body class="bg-gray-100">

<div class="container">
    <div class="sidebar">
        <?php include("Includes/side-bar.php"); ?>
    </div>

    <div class="content p-6">
        <h1 class="text-3xl font-bold text-center mb-6">User Details</h1>
        <table class="min-w-full bg-white border border-gray-300 shadow-md">
            <thead>
                <tr class="bg-gray-200">
                    <th class="px-4 py-2 border">Sl No</th>
                    <th class="px-4 py-2 border">Name</th>
                    <th class="px-4 py-2 border">Phone</th>
                    <th class="px-4 py-2 border">Email</th>
                    <th class="px-4 py-2 border">Pin Code</th>
                    <th class="px-4 py-2 border">Registered On</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $query = "SELECT username, phoneNumber, email, pinCode, creationDate FROM users ORDER BY creationDate DESC";
                $result = mysqli_query($conn, $query);
                $slno = 1;

                while ($row = mysqli_fetch_assoc($result)) {
                    echo "<tr>";
                    echo "<td class='px-4 py-2 border'>" . $slno++ . "</td>";
                    echo "<td class='px-4 py-2 border'>" . htmlspecialchars($row['username']) . "</td>";
                    echo "<td class='px-4 py-2 border'>" . htmlspecialchars($row['phoneNumber']) . "</td>";
                    echo "<td class='px-4 py-2 border'>" . htmlspecialchars($row['email']) . "</td>";
                    echo "<td class='px-4 py-2 border'>" . htmlspecialchars($row['pinCode']) . "</td>";
                    echo "<td class='px-4 py-2 border'>" . htmlspecialchars($row['creationDate']) . "</td>";
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
