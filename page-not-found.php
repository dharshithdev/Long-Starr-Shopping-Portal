<?php 
    http_response_code(404);
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>404 Not Found</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="Styles/Styles.css">
</head>
<body class="bg-gray-100 flex items-center justify-center min-h-screen">

  <div class="bg-white shadow-lg rounded-xl p-10 max-w-md w-full text-center">
    <h1 class="text-6xl font-bold text-gray-800 mb-4">404</h1>
    <h2 class="text-xl font-semibold text-gray-700 mb-2">Page Not Found</h2>
    <p class="text-gray-600 mb-6">
      Sorry, the page you’re looking for doesn’t exist or has been moved.
    </p>

    <a href="index.php" class="inline-block bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-md text-sm font-medium transition duration-200">
      ← Back to Home
    </a>

    <div class="mt-8">
      <img src="https://media.giphy.com/media/14uQ3cOFteDaU/giphy.gif" alt="404 Not Found" class="w-52 mx-auto rounded-md shadow">
    </div>
  </div>

</body>
</html>
