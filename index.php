<?php
    include 'db.php';
    $products = fetchProducts();
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
                <p>Check out our store for more <button>Check store</button>
                </p>
            </div>

        </div>
    </div>


    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">Navbar scroll</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarScroll"
                aria-controls="navbarScroll" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarScroll">
                <ul class="navbar-nav me-auto my-2 my-lg-0 navbar-nav-scroll" style="--bs-scroll-height: 100px;">
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="#">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#cmpInfo">Company Info</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#prReview" tabindex="-1">Product Review</a>
                    </li>
                </ul>
                <form class="d-flex">
                    <input class="form-control me-2" type="search" placeholder="Looking for..." aria-label="Search">
                    <button class="btn btn-outline-success" type="submit">Search</button>
                </form>
            </div>
        </div>
    </nav>

    <div class="container">
        <h1>Our Products</h1>
        <h2>New in Store</h2>
        <div class="product-grid" id="productGrid">
            <?php if (count($products) > 0): ?>
            <?php foreach ($products as $product): ?>
            <div class="product-card">
                <a href="details.html">
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
                    <button type="button" class="btn btn-primary">Submit</button>
                </div>
            </div>
        </div>
    </div>

    <h1>Speed is our satisfaction</h1>
    <div class="container">
        <div class="row">
            <div class="col-12 col-md-6">
                Welcome to Ethio-Amazone Moyale Brand (EAMB), your one-stop destination for quality products and
                unbeatable
                convenience! Discover a curated selection of premium items ranging from electronics, apparel, health and
                beauty products, to home essentials and more. At EAMB, With free delivery, we prioritize your shopping
                experience with easy navigation, secure payment options, and fast delivery. Whether you’re upgrading
                your tech, refreshing your wardrobe, or searching for the perfect gift, we’ve got you covered. Shop
                smart, save time, and enjoy exclusive deals every day. Join our growing community of satisfied customers
                today!"
            </div>
            <div class="col-12 col-md-6">
                ETHIO-AMAZONE MOYALE BRAND
            </div>

        </div>
    </div>


    <div id="cmpInfo">
        <h1>Company Info</h1>
        <div class="container">
            <div class="row">
                <div class="col">
                    <p>Ethio-Amazone Moyale Brand (EAMB) is a forward-thinking company that specializes in designing
                        and
                        manufacturing a diverse range of products while also sourcing high-quality items from around the
                        world.
                        Our mission is to make essential and innovative products accessible to everyone by offering them
                        at
                        competitive prices and ensuring efficient delivery systems.
                    </p>
                    <p>
                        In addition to our own product lines, EAMB actively seeks out unique and high-demand products
                        from
                        international markets. By leveraging our extensive network of global suppliers, we can offer a
                        curated selection of items that may not be readily available domestically. Our commitment to
                        quality
                        ensures that every product we source meets our rigorous standards
                    </p>
                    <p>
                        One of the core tenets of EAMB is to provide affordability without compromising on quality. By
                        strategically sourcing products from various regions, we can take advantage of cost efficiencies
                        and
                        pass those savings on to our customers. This approach enables us to offer competitive pricing,
                        making it easier for consumers to access a wide range of products without breaking the bank.
                    </p>
                </div>


            </div>
        </div>
    </div>

    <div id="prReview">
        <h1>Customer product review</h1>

        <div class="container">
            <div class="row">
                <div class="col-12 col-md-6">
                    <p>
                        Yohanis getachew
                    </p>
                </div>
                <div class="col-12 col-md-6">
                    The best shop
                </div>
            </div>
        </div>
    </div>

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
            <div class="footer-column">
                <h3>Review us</h3>
                <textarea></textarea>
                <button>Submit</button>
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