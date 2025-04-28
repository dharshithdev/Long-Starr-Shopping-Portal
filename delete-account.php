<?php
session_start();
include("Connections/connect.php");
include("Connections/authorization.php");

$_SESSION['user_id'] = $userId;

$message = $_SESSION['message'] ?? "";
$error = $_SESSION['error'] ?? "";
unset($_SESSION['message'], $_SESSION['error']);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Delete Account</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="Styles/styles.css" rel="stylesheet">
    <style>
        .modal-bg {
            background-color: rgba(0, 0, 0, 0.6);
        }
    </style>
</head>
<body class="bg-gray-100 min-h-screen">

<?php include("Includes/simple-header.php"); ?>

<div class="flex items-center justify-center p-4">
    <div class="w-full max-w-md bg-white shadow-md rounded-xl p-6 mt-10">
        <h2 class="text-2xl font-bold mb-6 text-center text-red-600">⚠️ Delete Account</h2>
        
        <p class="text-center text-gray-600 mb-4">
            Deleting your account is permanent and cannot be undone. All your data will be lost forever.
        </p>

        <?php if (!empty($message)): ?>
            <div class="mb-4 text-center text-green-600 font-semibold"><?= htmlspecialchars($message) ?></div>
        <?php endif; ?>

        <?php if (!empty($error)): ?>
            <div class="mb-4 text-center text-red-600 font-semibold"><?= htmlspecialchars($error) ?></div>
        <?php endif; ?>

        <form id="deleteForm" method="POST" action="Logics/drop-account.php" class="space-y-4">
            <div>
                <label class="block text-gray-700 font-medium mb-1">Enter Password to Confirm</label>
                <input type="password" name="password" class="w-full px-4 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-red-500" required>
            </div>
            <div class="text-center mt-6">
                <button type="button" onclick="showConfirmation()" class="bg-red-600 text-white px-6 py-2 rounded-md hover:bg-red-700 transition">
                    Permanently Delete My Account
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Custom Confirmation Modal -->
<div id="confirmationModal" class="fixed inset-0 flex items-center justify-center modal-bg hidden">
    <div class="bg-white rounded-xl p-6 max-w-sm w-full shadow-lg text-center">
        <h3 class="text-xl font-semibold text-gray-800 mb-4">Are you sure?</h3>
        <p class="text-gray-600 mb-6">
            This action will permanently delete your account. This cannot be undone.
        </p>
        <div class="flex justify-center gap-4">
            <button onclick="submitForm()" class="bg-red-600 text-white px-4 py-2 rounded hover:bg-red-700">Yes, Delete</button>
            <button onclick="hideConfirmation()" class="bg-gray-300 text-gray-800 px-4 py-2 rounded hover:bg-gray-400">Cancel</button>
        </div>
    </div>
</div>

<?php include("Includes/footer.php"); ?>

<script src="/longstarr/Scripts/delete-account.js"></script>

</body>
</html>
