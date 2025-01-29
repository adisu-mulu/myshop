<?php
// Include the database connection file
include 'db.php';
$photos = fetchExistingPhotos();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Product</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="style.css" rel="stylesheet">
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
                <input type="file" name="image" id="image" class="form-control" onchange="previewImage(event)">
            </div>
            <button type="submit" name="edit_product" class="btn btn-primary">Save Changes</button>
            <a href="admin.php" class="btn btn-secondary">Cancel</a>
        </form>
        <br><br>

        <h1>Add more photos of the product</h1>
        <form method="POST" enctype="multipart/form-data">
            <div class="mb-3">
                <input type="hidden" name="product_id" value="<?= $_GET['edit_id'] ?>">
                <label for="photos" class="form-label">Choose Photos</label>
                <div id="photoPreview" class="row mt-4"></div>
                <input type="file" name="photos[]" id="photos" class="form-control" multiple accept="image/*" required>
                <small class="text-muted">You can select multiple photos (JPEG, PNG, GIF).</small>
            </div>
            <button type="submit" class="btn btn-primary" name="uploadMultiple">Upload</button>
        </form>

        <br><br><br>
        <h1>Manage existing photos</h1>
        <div class="product-grid" id="productGrid">
            <?php if (count($photos) > 0): ?>
            <?php foreach ($photos as $photos): ?>
            <div class="product-card">
                <a href="details.html">
                    <img class="product-image" src="<?= htmlspecialchars($photos['photos']) ?>"
                        alt="<?= htmlspecialchars($photos['photos']) ?>">
                </a>
                <div class="product-details">

                    <a href="?photo_id=<?= $photos['id'] ?>&&pr_id=<?= $photos['photoId']?>&&path=<?=$photos['photos']?>" class="btn btn-danger btn-sm"
                        onclick="return confirm('Are you sure you want to delete this product?');">Delete</a>
                </div>
            </div>
            <?php endforeach; ?>
            <?php else: ?>
            <p>No products available.</p>
            <?php endif; ?>
        </div>
    </div>

    <script>
    document.getElementById('photos').addEventListener('change', function(event) {
        const photoPreview = document.getElementById('photoPreview');
        photoPreview.innerHTML = ''; // Clear previous previews

        const files = event.target.files;
        if (files.length > 0) {
            for (const file of files) {
                if (file.type.startsWith('image/')) { // Ensure it's an image
                    const reader = new FileReader();

                    reader.onload = function(e) {
                        const col = document.createElement('div');
                        col.className = 'col-md-3 mb-3';
                        col.innerHTML =
                            `<img src="${e.target.result}" class="img-fluid rounded shadow" alt="Preview" style="max-height: 150px;">`;
                        photoPreview.appendChild(col);
                    };

                    reader.readAsDataURL(file); // Convert file to data URL for preview
                }
            }
        }
    });
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"
        integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js"
        integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js"
        integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous">
    </script>
</body>

</html>