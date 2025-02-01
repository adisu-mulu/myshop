<?php
// Database configuration
$servername = "localhost";
$username = "root";
$password = "ki.amor";
$dbname = "shop";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

/**
 * Fetch products from the database
 * @return array
 */
function fetchProducts() {
    global $conn;
    $products = [];
    $sql = "SELECT id, title, description, price, image FROM products ORDER BY id DESC";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $products[] = $row;
        }
    }
    return $products;
}
function fetchAllProducts() {
    global $conn;
    $products = [];
    $sql = "SELECT id, title, description, price, image FROM products";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $products[] = $row;
        }
    }
    return $products;
}

function searchProducts() {
    global $conn;
    $products = [];
    
    $searchQuery = $conn->real_escape_string($_GET['query']);
    $sql = "SELECT title, description, price, image FROM products where title LIKE '%$searchQuery%'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $products[] = $row;
        }
    }
    return $products;
}


if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_product'])) {
    $title = $_POST['title'];
    $description = $_POST['description'];
    $price = $_POST['price'];
    
    // Handle the image upload
    if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
        $imageTmpName = $_FILES['image']['tmp_name'];
        $imageName = $_FILES['image']['name'];
        $imageSize = $_FILES['image']['size'];
        $imageError = $_FILES['image']['error'];
        $imageType = $_FILES['image']['type'];
      
        // Validate the file type (accept only images)
        $allowedExtensions = ['jpg', 'jpeg', 'png', 'gif'];
        $imageExtension = strtolower(pathinfo($imageName, PATHINFO_EXTENSION));

        if (in_array($imageExtension, $allowedExtensions)) {
            // Generate a unique name for the image to avoid overwriting
            $uniqueImageName = uniqid("product_", true) . '.' . $imageExtension;

            // Set the upload directory
            $uploadDirectory = 'uploads/';
            if (!is_dir($uploadDirectory)) {
                mkdir($uploadDirectory, 0777, true); // Create the directory if it doesn't exist
            }

            // Move the uploaded file to the server directory
            $imageDestination = $uploadDirectory . $uniqueImageName;
            if (move_uploaded_file($imageTmpName, $imageDestination)) {
                // Insert product details into the database
                $query = "INSERT INTO products (title, description, price, image) 
                          VALUES ('$title', '$description', '$price', '$imageDestination')";
                if ($conn->query($query)) {
                    echo "Product added successfully!";
                } else {
                    echo "Error: " . $conn->error;
                }
            } else {
                echo "Failed to move the uploaded image.";
            }
        } else {
            echo "Invalid file type. Only JPG, JPEG, PNG, and GIF are allowed.";
        }
    } else {
        echo "Please upload a valid image.";
    }
}

if (isset($_GET['edit_id']) || isset($_GET['product_id'])) {
    $editMode = true;
    if (isset($_GET['edit_id'])){
        $id = $_GET['edit_id'];
    }
    if (isset($_GET['product_id'])){
        $id = $_GET['product_id'];
    }
    $result = $conn->query("SELECT * FROM products WHERE id = $id");
    if ($result && $result->num_rows > 0) {
        $productToEdit = $result->fetch_assoc();
    } else {
        die("Product not found.");
    }
}

// Handle deleting a product
if (isset($_GET['delete_id'])) {
    $id = $_GET['delete_id'];
    $query = "DELETE FROM products WHERE id = $id";
    $conn->query($query);
    header("Location: admin.php"); // Redirect to refresh the page
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['edit_product'])) {
    $id = $_POST['id'];
    $title = $_POST['title'];
    $description = $_POST['description'];
    $price = $_POST['price'];

    // Check if a new image is uploaded
    if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
        $imageTmpName = $_FILES['image']['tmp_name'];
        $imageName = $_FILES['image']['name'];
        $imageExtension = strtolower(pathinfo($imageName, PATHINFO_EXTENSION));
        $allowedExtensions = ['jpg', 'jpeg', 'png', 'gif'];

        if (in_array($imageExtension, $allowedExtensions)) {
            $uniqueImageName = uniqid("product_", true) . '.' . $imageExtension;
            $uploadDirectory = 'uploads/';
            if (!is_dir($uploadDirectory)) {
                mkdir($uploadDirectory, 0777, true);
            }
            $imageDestination = $uploadDirectory . $uniqueImageName;
            move_uploaded_file($imageTmpName, $imageDestination);

            // Update product with the new image
            $query = "UPDATE products SET title = '$title', description = '$description', price = '$price', image = '$imageDestination' WHERE id = '$id'";
        } else {
            echo "Invalid file type. Only JPG, JPEG, PNG, and GIF are allowed.";
        }
    } else {
        // Keep the old image if no new image is uploaded
        $query = "UPDATE products SET title = '$title', description = '$description', price = '$price' WHERE id = '$id'";
    }

    $conn->query($query);
    header("Location: admin.php"); // Redirect to the admin page after saving
    exit;
}


// Fetch all products
$products = $conn->query("SELECT * FROM products");
$ann = $conn->query("SELECT * FROM announcements");

    if ($ann && $ann->num_rows > 0) {
        $announcement = $ann->fetch_assoc();
    } else {
        $announcement ="No announcemnts";
    }

//saving announcemnts
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['save_announcement'])) {
    $id = $_POST['id'];
    $content = $_POST['content'];

    // Sanitize the content to prevent SQL injection
    $content = $conn->real_escape_string($content);

    // Update the announcement in the database
    $query = "UPDATE announcements SET content = '$content' WHERE id = $id";
    if ($conn->query($query)) {
        echo "Announcement updated successfully!";
        
        exit;
    } else {
        echo "Error: " . $conn->error;
    }
}

//adding announcemnts
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_announcement'])) {
    $id = $_POST['id'];
    $content = $_POST['content'];

    // Sanitize the content to prevent SQL injection
    $content = $conn->real_escape_string($content);

    // Update the announcement in the database
    $query = "insert into announcements (content) values('$content' )";
    if ($conn->query($query)) {
        echo "Announcement added successfully!";
        
        exit;
    } else {
        echo "Error: " . $conn->error;
    }
}
//delete announcement
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_announcement'])) {
    $id = $_POST['id'];

    // Delete the announcement from the database
    $query = "DELETE FROM announcements WHERE id = $id";
    if ($conn->query($query)) {
        echo "Announcement deleted successfully!";
        //header("Location: manage_announcements.php"); // Redirect to the announcements page
        exit;
    } else {
        echo "Error: " . $conn->error;
    }
}


//checking if announcemnet exists to be displayed on home page
$announcementQuery = $conn->query("SELECT * FROM announcements ORDER BY id DESC LIMIT 1");

if ($announcementQuery && $announcementQuery->num_rows > 0) {
    $announcement = $announcementQuery->fetch_assoc();
    $announcementContent = htmlspecialchars($announcement['content']);
    } else {
    $announcementContent = null; // No announcement found
    }

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit_review'])) {
    $username = htmlspecialchars($_POST['username']);
    $review = htmlspecialchars($_POST['review']);
    
     // Insert product details into the database
     $query = "INSERT INTO review (username, comment) 
     VALUES ('$username', '$review')";
    if ($conn->query($query)) {
        header("Location: index.php");
    } else {
    echo "Error: " . $conn->error;
    }
    // // Example: Save the review to the database or display it
    // echo "Thank you, $name, for your review: <br>";
    // echo "<blockquote>$review</blockquote>";
    }


    function fetchReviews() {
        global $conn;
        $reviews = [];
        $sql = "SELECT username, comment, created_at FROM review ORDER BY id DESC";
        $result = $conn->query($sql);
    
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $reviews[] = $row;
            }
        }
        return $reviews;
    }


//upload multiple photos
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['uploadMultiple'])) {
    // Ensure the product ID is provided
    if (!isset($_POST['product_id'])) {
        die('Product ID is required.');
    }

    $productId = intval($_POST['product_id']);
    $uploadedPhotos = [];

    // Folder to store uploaded files
    $uploadDir = 'uploads/';

    // Loop through uploaded files
    foreach ($_FILES['photos']['tmp_name'] as $key => $tmpName) {
        if ($_FILES['photos']['error'][$key] === UPLOAD_ERR_OK) {
            $fileName = basename($_FILES['photos']['name'][$key]);
            $targetPath = $uploadDir . $fileName;

            // Move the file to the uploads folder
            if (move_uploaded_file($tmpName, $targetPath)) {
                // Store file name for database insertion
                $uploadedPhotos[] = $targetPath;
            } else {
                echo "Failed to upload file: " . htmlspecialchars($fileName) . "<br>";
            }
        }
    }

    // Insert uploaded photos into the morePhotos table
    if (!empty($uploadedPhotos)) {
        $stmt = $conn->prepare("INSERT INTO morePhotos (photoId, photos) VALUES (?, ?)");
        foreach ($uploadedPhotos as $photo) {
            $stmt->bind_param('is', $productId, $photo);
            $stmt->execute();
        }
        $stmt->close();
        echo "Photos uploaded and saved successfully!";
    } else {
        echo "No photos were uploaded.";
    }
}

//fetch existing photos
function fetchExistingPhotos() {
    global $conn;
    $photos = [];
    if (isset($_GET['edit_id'])){
        $id = $_GET["edit_id"];

    }
    if (isset($_GET['product_id'])){
        $id = $_GET["product_id"];

    }
    
    $sql = "SELECT *FROM morePhotos WHERE photoId = '$id'";
    $result = $conn->query($sql);
   
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
           
            $photos[] = $row;
        }
    }
    return $photos;
}

// Handle deleting a photo
if (isset($_GET['photo_id'])) {
    $id = $_GET['photo_id'];
    $pr_id = $_GET['pr_id'];
    $query = "DELETE FROM morePhotos WHERE id = $id";
    if ($conn->query($query)){
        $image_path = $_GET['path'];
         // Delete the image file from the server
        if (file_exists($image_path)) {
            unlink($image_path); // Deletes the file
            header("Location: edit.php?edit_id=$pr_id"); // Redirect to refresh the page
        } 
        else {
        // Optional: Log or handle the case where the file does not exist
        echo "Something went wrong";
    }
    }
   
    
}


//save company info
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['save_comp_info'])) {
    
    $content = $_POST['company_description'];
    $colA = $_POST['colA'];
    $colB = $_POST['colB'];

    // Sanitize the content to prevent SQL injection
    $content = $conn->real_escape_string($content);
    $colA = $conn->real_escape_string($colA);
    $colB = $conn->real_escape_string($colB);
    // Update the announcement in the database
    $query = "UPDATE company SET description = '$content', colA = '$colA', colB = '$colB'";
    if ($conn->query($query)) {
        echo "update successfull!";
        
        exit;
    } else {
        echo "Error: " . $conn->error;
    }
}

function fetchCompInfo() {
    global $conn;
    
    $sql = "SELECT * from company";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
       return $result->fetch_assoc();
    }
    return null;
}



?>