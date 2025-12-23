
<?php
    @session_start();
    if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}
?>
<head>
    <meta charset="UTF-8">
    <meta name="description" content="Velvet Vouge">
    <meta name="keywords" content="Velvet Vouge, Fashion Brand, ecommerce, male fashion, female fashion, accessories">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Velvet Vouge</title>

    <!-- Google Font -->
    <link href="https://fonts.googleapis.com/css2?family=Nunito+Sans:wght@300;400;600;700;800;900&display=swap"
    rel="stylesheet">

    <!-- Css Styles -->
    <link rel="stylesheet" href="css/bootstrap.min.css" type="text/css">
    <link rel="stylesheet" href="css/font-awesome.min.css" type="text/css">
    <link rel="stylesheet" href="css/elegant-icons.css" type="text/css">
    <link rel="stylesheet" href="css/magnific-popup.css" type="text/css">
    <link rel="stylesheet" href="css/nice-select.css" type="text/css">
    <link rel="stylesheet" href="css/owl.carousel.min.css" type="text/css">
    <link rel="stylesheet" href="css/slicknav.min.css" type="text/css">
    <link rel="stylesheet" href="css/style.css" type="text/css">
</head>

<body>
    <!-- Page Preloder -->
    <div id="preloder">
        <div class="loader"></div>
    </div>

    <!-- Offcanvas Menu Begin -->
    <div class="offcanvas-menu-overlay"></div>
    <div class="offcanvas-menu-wrapper">
        <div class="offcanvas__option">
            <div class="offcanvas__links">
                <?php if (isset($_SESSION['user'])): ?>
                            <div class="header__top__links">
                                <span>Welcome, <?php echo htmlspecialchars($_SESSION['user_name']); ?>!</span>
                                <a href="logout.php">Logout</a>
                            </div>
                        <?php else: ?>
                            <div class="header__top__links">
                                <a href="login.php">Login</a>  <a href="register.php">Register</a>
                            </div>
                        <?php endif; ?>
            </div>
            
        </div>
        <div class="offcanvas__nav__option">
            <a href="#" class="search-switch"><img src="img/icon/search.png" alt=""></a>
            <a href="#"><img src="img/icon/heart.png" alt=""></a>
            <a href="shopping-cart.php">
                            <img src="img/icon/cart.png" alt="">
                            <span>
                                <?php echo isset($_SESSION['cart']) ? array_sum(array_column($_SESSION['cart'], 'qty')) : 0; ?>
                            </span>
                        </a>
                        <?php
                    $total = array_sum(array_column($_SESSION['cart'], 'price'));
                    ?>
                    <div class="price">LKR <?php echo number_format($total, 2); ?></div>
        </div>
        <div id="mobile-menu-wrap"></div>
        <div class="offcanvas__text">
            <p>Free shipping, 30-day return or refund guarantee.</p>
        </div>
    </div>
    <!-- Offcanvas Menu End -->

    <!-- Header Section Begin -->
    <header class="header">
        <div class="header__top">
            <div class="container">
                <div class="row">
                    <div class="col-lg-6 col-md-7">
                        <div class="header__top__left">
                            <p>Free shipping, 30-day return or refund guarantee.</p>
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-5">
                        <div class="header__top__right">
                            <?php if (isset($_SESSION['user'])): ?>
                            <div class="header__top__links">
                                <span>Welcome, <?php echo htmlspecialchars($_SESSION['user_name']); ?>!</span>
                                <a href="logout.php">Logout</a>
                            </div>
                        <?php else: ?>
                            <div class="header__top__links">
                                <a href="login.php">Login</a>  <a href="register.php">Register</a>
                            </div>
                        <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="container">
            <div class="row">
                <div class="col-lg-3 col-md-3">
                    <div class="header__logo">
                        <a href="./index.php"><img src="img/logo.png" alt=""></a>
                    </div>
                </div>
                <div class="col-lg-6 col-md-6">
                    <nav class="header__menu mobile-menu">
                        <ul>
                            <li><a href="./index.php">Home</a></li>
                            <li><a href="./shop.php">Shop</a></li>
                            <li><a href="about.php">About Us</a> </li> 
                            <li><a href="./blog.php">Blog</a></li>
                            <li><a href="./contact.php">Contacts</a></li>
                        </ul> 
                    </nav>
                </div>
                <div class="col-lg-3 col-md-3">
                    <div class="header__nav__option">
                        <a href="#" class="search-switch"><img src="img/icon/search.png" alt=""></a>
                        <a href="#"><img src="img/icon/heart.png" alt=""></a>
                        <a href="shopping-cart.php">
                            <img src="img/icon/cart.png" alt="">
                            <span>
                                <?php echo isset($_SESSION['cart']) ? array_sum(array_column($_SESSION['cart'], 'qty')) : 0; ?>
                            </span>
                        </a>
                        <?php
                    $total = array_sum(array_column($_SESSION['cart'], 'price'));
                    ?>
                    <div class="price">LKR <?php echo number_format($total, 2); ?></div>
                </div>
            </div>
            <div class="canvas__open"><i class="fa fa-bars"></i></div>
        </div>
    </header>
    <!-- Header Section End -->
