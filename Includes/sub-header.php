<?php
include("Connections/connect.php");
include("Connections/verification.php");

$sql = "SELECT id, categoryName FROM category";
$result = $conn->query($sql);
?>

<section class="bg-gray-100 py-4 px-4 px-4">
  <div class="overflow-x-auto hide-scrollbar">
    <div class="flex gap-6 min-w-max mx-auto w-full max-w-screen-xl justify-center px-2">
    <a href="index.php" class="flex flex-col items-center min-w-[5rem] hover:scale-105 transition-transform duration-200">
            <img src="Assets/all.png" alt="All In Categories" class="w-20 h-20 rounded-full object-cover shadow" />
            <span class="text-center text-sm font-medium mt-2">All</span>
        </a>
      <?php
      
      if ($result->num_rows > 0) {
          while ($row = $result->fetch_assoc()) {
              $categoryId = $row['id'];
              $categoryName = $row['categoryName'];

              $imageDir = "Admin/CategoryImages/$categoryId";
              $imagePath = "";

              // Find the first image in the folder
              if (is_dir($imageDir)) {
                  $files = scandir($imageDir);
                  foreach ($files as $file) {
                      if ($file != "." && $file != "..") {
                          $imagePath = "$imageDir/$file";
                          break;
                      }
                  }
              }
              // Fallback image if none found
              if (!$imagePath) {
                  $imagePath = "Assets/categories/default.png";
              }
      ?>
          <a href="category.php?id=<?php echo $categoryId; ?>" class="flex flex-col items-center min-w-[5rem] hover:scale-105 transition-transform duration-200">
            <img src="<?php echo $imagePath; ?>" alt="<?php echo htmlspecialchars($categoryName); ?>" class="w-20 h-20 rounded-full object-cover shadow" />
            <span class="text-center text-sm font-medium mt-2"><?php echo htmlspecialchars($categoryName); ?></span>
        </a>
      <?php
          }
      } else {
          echo "<p class='text-center w-full'>No categories found</p>";
      }

      $conn->close();
      ?>

    </div>
  </div>
</section>

<style>
  .hide-scrollbar::-webkit-scrollbar {
    display: none;
  }
  .hide-scrollbar {
    -ms-overflow-style: none;
    scrollbar-width: none;
  }
</style>
