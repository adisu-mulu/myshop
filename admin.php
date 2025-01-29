<?php
// Include the database connection file
include 'db.php';

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Page</title>
    <!-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet"> -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link href="style.css" rel="stylesheet">
</head>

<body>
    <div class="container my-5">
        <h1>Admin Panel</h1>

        <!-- Add Product Form -->
        <form method="POST" class="my-4" enctype="multipart/form-data">
            <h3>Add New Product</h3>
            <div class="mb-3">
                <label for="title" class="form-label">Title</label>
                <input type="text" name="title" id="title" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="description" class="form-label">Description</label>
                <textarea name="description" id="description" class="form-control" required></textarea>
            </div>
            <div class="mb-3">
                <label for="price" class="form-label">Price</label>
                <input type="number" name="price" id="price" class="form-control" step="0.01" required>
            </div>
            <div class="mb-3">
                <label for="image" class="form-label">Product Image</label>
                <input type="file" name="image" id="image" class="form-control" required>
            </div>
            <button type="submit" name="add_product" class="btn btn-success">Add Product</button>
        </form>

        <!-- Products Table -->
        <h3>Manage Products</h3>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Title</th>
                    <th>Description</th>
                    <th>Price</th>
                    <th>Image</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $products->fetch_assoc()): ?>
                <tr>
                    <td><?= $row['id'] ?></td>
                    <td><?= htmlspecialchars($row['title']) ?></td>
                    <td><?= htmlspecialchars($row['description']) ?></td>
                    <td><?= htmlspecialchars($row['price']) ?></td>
                    <td> <?php if (!empty($row['image'])): ?>
                        <img id="currentImg" src="<?= htmlspecialchars($row['image']) ?>" alt="Current Product Image"
                            class="img-thumbnail" style="max-height: 50px;">
                        <?php else: ?>
                        <p>No image available.</p>
                        <?php endif; ?>
                    </td>
                    <td>
                        <!-- Edit Button -->
                        <!-- <button class="btn btn-primary btn-sm" data-toggle="modal" data-target="#editModal<?= $row['id'] ?>">Edit</button> -->
                        <a href="edit.php?edit_id=<?= $row['id'] ?>" class="btn btn-primary btn-sm">Edit</a>
                        <!-- Delete Button -->
                        <a href="?delete_id=<?= $row['id'] ?>" class="btn btn-danger btn-sm"
                            onclick="return confirm('Are you sure you want to delete this product?');">Delete</a>
                    </td>
                </tr>


                <div class="modal fade" id="editModal<?= $row['id'] ?>" tabindex="-1"
                    aria-labelledby="editModalLabel<?= $row['id'] ?>" aria-hidden="true">
                    <div class="modal-dialog">
                        <form method="POST" class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="editModalLabel<?= $row['id'] ?>">Edit Product</h5>
                                <button type="button" class="btn-close" data-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <input type="hidden" name="id" value="<?= $row['id'] ?>">
                                <div class="mb-3">
                                    <label for="title<?= $row['id'] ?>" class="form-label">Title</label>
                                    <input type="text" name="title" id="title<?= $row['id'] ?>" class="form-control"
                                        value="<?= htmlspecialchars($row['title']) ?>" required>
                                </div>
                                <div class="mb-3">
                                    <label for="description<?= $row['id'] ?>" class="form-label">Description</label>
                                    <textarea name="description" id="description<?= $row['id'] ?>" class="form-control"
                                        required><?= htmlspecialchars($row['description']) ?></textarea>
                                </div>
                                <div class="mb-3">
                                    <label for="price<?= $row['id'] ?>" class="form-label">Price</label>
                                    <input type="number" name="price" id="price<?= $row['id'] ?>" class="form-control"
                                        step="0.01" value="<?= htmlspecialchars($row['price']) ?>" required>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                                <button type="submit" name="edit_product" class="btn btn-primary">Save Changes</button>
                            </div>
                        </form>
                    </div>
                </div>
                <?php endwhile; ?>
            </tbody>
        </table>

        <h3>Manage Announcement</h3>
        <form method="POST" class="my-4">
            <input type="hidden" name="id" value="<?= $announcement['id'] ?>">

            <div class="mb-3">
                <?php if (!empty($announcement['content'])): ?>
                <textarea name="content" id="content" class="form-control" rows="3"
                    required><?= htmlspecialchars($announcement['content']) ?></textarea>
                <?php else: ?>
                <textarea name="content" id="content" class="form-control" rows="3"
                    placeholder="Enter announcement"></textarea>
                <?php endif; ?>
            </div>

            <?php if (!empty($announcement['content'])): ?>
                <button type="submit" name="save_announcement" class="btn btn-primary">Save Changes</button>
                <?php else :?>
                    <button type="submit" name="add_announcement" class="btn btn-primary">Add Announcement</button>
                    <?php endif; ?>
            <button type="submit" name="delete_announcement" class="btn btn-danger"
                onclick="return confirm('Are you sure you want to delete this announcement?');">Delete</button>

        </form>

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