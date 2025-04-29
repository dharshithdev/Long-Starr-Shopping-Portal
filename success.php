<?php
include("Includes/simple-header.php");
include("Connection/connect.php");
include("Connections/authorization.php");
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Payment Success</title>
  <link rel="stylesheet" href="Styles/Success.php">
</head>
<body>
  <div class="container">
    <div class="checkmark-circle">
      <div class="checkmark"></div>
    </div>
    <h1>Payment Successful!</h1>
    <p>Thank you for your payment. Your transaction was successful.</p>
  </div>

  <script>
     setTimeout(() => {
       window.location.href = "view-orders.php";
     }, 4000);
  </script>
</body>
</html>
<?php include("Includes/footer.php"); ?>