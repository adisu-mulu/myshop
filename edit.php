<?php
// Include the database connection file
include 'db.php';

// Handle updating a product
// if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['edit_product'])) {
//     $id = $_POST['id'];
//     $title = $_POST['title'];
//     $description = $_POST['description'];
//     $price = $_POST['price'];

//     // Check if a new image is uploaded
//     if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
//         $imageTmpName = $_FILES['image']['tmp_name'];
//         $imageName = $_FILES['image']['name'];
//         $imageExtension = strtolower(pathinfo($imageName, PATHINFO_EXTENSION));
//         $allowedExtensions = ['jpg', 'jpeg', 'png', 'gif'];

//         if (in_array($imageExtension, $allowedExtensions)) {
//             $uniqueImageName = uniqid("product_", true) . '.' . $imageExtension;
//             $uploadDirectory = 'uploads/';
//             if (!is_dir($uploadDirectory)) {
//                 mkdir($uploadDirectory, 0777, true);
//             }
//             $imageDestination = $uploadDirectory . $uniqueImageName;
//             move_uploaded_file($imageTmpName, $imageDestination);

//             // Update product with the new image
//             $query = "UPDATE products SET title = '$title', description = '$description', price = '$price', image = '$imageDestination' WHERE id = '$id'";
//         } else {
//             echo "Invalid file type. Only JPG, JPEG, PNG, and GIF are allowed.";
//         }
//     } else {
//         // Keep the old image if no new image is uploaded
//         $query = "UPDATE products SET title = '$title', description = '$description', price = '$price' WHERE id = '$id'";
//     }

//     $conn->query($query);
//     header("Location: admin.php"); // Redirect to the admin page after saving
//     exit;
// }

// // Fetch the product to edit
// if (isset($_GET['edit_id'])) {
//     $id = $_GET['edit_id'];
//     $result = $conn->query("SELECT * FROM products WHERE id = $id");
//     if ($result && $result->num_rows > 0) {
//         $productToEdit = $result->fetch_assoc();
//     } else {
//         die("Product not found.");
//     }
// } else {
//     die("No product ID provided.");
// }

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Product</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script>
    function previewImage(event) {
        const fileInput = event.target;
        const file = fileInput.files[0];

        if (file) {
            const reader = new FileReader();

            reader.onload = function(e) {
                // Replace the current image source with the selected image preview
                const currentImage = document.getElementById('currentImage');
                if (currentImage) {
                    currentImage.src = e.target.result;
                } else {
                    // If no current image exists, create an img tag
                    const imgPreview = document.createElement('img');
                    imgPreview.id = 'currentImage';
                    imgPreview.src = e.target.result;
                    imgPreview.className = 'img-thumbnail';
                    imgPreview.style.maxHeight = '200px';

                    fileInput.parentElement.insertBefore(imgPreview, fileInput);
                }
            };

            reader.readAsDataURL(file);
        }
    }
</script>
</head>

<body>
    <div class="container my-5">
        <h1>Edit Product</h1>

        <!-- Edit Product Form -->
        <form method="POST" class="my-4" enctype="multipart/form-data">
            <input type="hidden" name="id" value="<?= $productToEdit['id'] ?>">

            <div class="mb-3">
                <label for="title" class="form-label">Title</label>
                <input type="text" name="title" id="title" class="form-control"
                    value="<?= htmlspecialchars($productToEdit['title']) ?>" required>
            </div>

            <div class="mb-3">
                <label for="description" class="form-label">Description</label>
                <textarea name="description" id="description" class="form-control"
                    required><?= htmlspecialchars($productToEdit['description']) ?></textarea>
            </div>

            <div class="mb-3">
                <label for="price" class="form-label">Price</label>
                <input type="number" name="price" id="price" class="form-control" step="0.01"
                    value="<?= htmlspecialchars($productToEdit['price']) ?>" required>
            </div>
            <div class="mb-3">
                <label for="image" class="form-label">Product Image</label>
                <!-- Display Current Image -->
                <div class="mb-2">
                    <?php if (!empty($productToEdit['image'])): ?>
                    <img id="currentImage" src="<?= htmlspecialchars($productToEdit['image']) ?>"
                        alt="Current Product Image" class="img-thumbnail" style="max-height: 200px;">
                    <?php else: ?>
                    <p>No image available.</p>
                    <?php endif; ?>
                </div>
                <input type="file" name="image" id="image" class="form-control"
                    onchange="previewImage(event)">
            </div>
            <button type="submit" name="edit_product" class="btn btn-primary">Save Changes</button>
            <a href="admin.php" class="btn btn-secondary">Cancel</a>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>