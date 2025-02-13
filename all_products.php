<?php
    include 'db.php';
    $products = fetchAllProducts();
    $reviews = fetchReviews();
    ?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product Cards</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link href="style.css" rel="stylesheet">
</head>

<body>
    <div class="footer">
        <div class="footer-content">
            <div class="footer-column">
                <?php if ($announcementContent): ?>
                <img src="announcement.gif" alt="Announcement GIF" style="width: 50px; height: 50px;">
                <span><?= $announcementContent ?></span>
                <?php endif; ?>
            </div>
            <div class="footer-column">
                <p>Check out our store for more <a href="all_products.php"><button>Check store</button></a>
                </p>
            </div>

        </div>
    </div>


    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container-fluid">
            <a class="navbar-brand" href="/">Logo</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarScroll"
                aria-controls="navbarScroll" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="navbar-collapse" id="navbarScroll">
                <ul class="navbar-nav me-auto my-2 my-lg-0 navbar-nav-scroll" style="--bs-scroll-height: 100px;">
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="/">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#cmpInfo">Company Info</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#prReview" tabindex="-1">Product Review</a>
                    </li>
                </ul>
                <form class="d-flex" action="search_results.php" method="GET">
                    <input class="form-control me-2" type="search" placeholder="Looking for..." aria-label="Search" name="query" required>
                    <button class="btn btn-outline-success" type="submit" name="search_product">Search</button>
                </form>
            </div>
        </div>
    </nav>
    <br><br><br>
    <div class="container">
        <h1>Our Products</h1>
        <br><br>
        <div class="product-grid" id="productGrid">
            <?php if (count($products) > 0): ?>
            <?php foreach ($products as $product): ?>
            <div class="product-card">
                <a href="details.php?product_id=<?= $product['id'] ?>">
                    <img class="product-image" src="<?= htmlspecialchars($product['image']) ?>"
                        alt="<?= htmlspecialchars($product['title']) ?>">
                </a>
                <div class="product-details">
                    <h2 class="product-title"><?= htmlspecialchars($product['title']) ?></h2>
                    <p class="product-description"><?= htmlspecialchars($product['description']) ?></p>
                    <p class="product-price" style="text-align: center;">Birr <?= htmlspecialchars($product['price']) ?>
                    </p>
                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#buyNow"
                        style="float: center;">
                        Buy Now
                    </button>
                </div>
            </div>
            <?php endforeach; ?>
            <?php else: ?>
            <p>No products available.</p>
            <?php endif; ?>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="buyNow" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">Payment Information</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p style="text-align: center;">Payment Method</p>
                    <p>1. Commercial Bank of Ethiopia: 1000482417877 - Fisaha Mulu</p>
                    <p>2. Telebirr: +251962558992 - Fisaha Mulu</p>
                    <p>Call and order: +251962558992, +251937330216</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <!-- <button type="button" class="btn btn-primary">Submit</button> -->
                </div>
            </div>
        </div>
    </div>
    

    <br><br><br><br>
    <div class="footer">
        <div class="footer-content">
            <div class="footer-column">
                <h3>Moyale</h3>
                <p>Near Koket Borena Hotel</p>
                <p>50 meter down the road</p>
            </div>
            <div class="footer-column">
                <h3>Address</h3>
                <p>01, Moyale, Ethiopia</p>
                <p>Get directions</p>
            </div>
            <div class="footer-column">
                <h3>Contact Info</h3>
                <p>+251962558992</p>
                <p>fisahamulu78@gmail.com</p>
                <p>Social media</p>
            </div>
            <div class="footer-column" id="review_us">
                <h3>Review us</h3>
                <form  method="POST" >
                    <div class="mb-2">
                        <input type="text" class="form-control" id="name" name="username" placeholder="Enter your name"
                            required>
                    </div>
                    <div class="mb-2">
                        <textarea class="form-control" id="review" name="review" rows="3"
                            placeholder="Write your review here..." required></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary" name="submit_review">Submit</button>
                </form>
            </div>
        </div>
    </div>
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