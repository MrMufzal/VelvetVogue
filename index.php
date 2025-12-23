
<!DOCTYPE html>
<html lang="zxx">

<?php include 'header.php'; ?>

    <!-- Hero Section Begin -->
    <section class="hero">
        <div class="hero__slider owl-carousel">
            <div class="hero__items set-bg" data-setbg="img/hero/hero-1.jpg">
                <div class="container">
                    <div class="row">
                        <div class="col-xl-5 col-lg-7 col-md-8">
                            <div class="hero__text">
                                <h6>Winter Collection</h6>
                                <h2>Autumn - Winter Collections 2025</h2>
                                <p>A distinguished fashion label redefining modern luxury.
                                Thoughtfully designed and meticulously crafted with a steadfast dedication to timeless elegance and superior quality.</p>
                                <a href="shop.php" class="primary-btn">Shop Here <span class="arrow_right"></span></a>
                                <div class="hero__social">
                                    <a href="https://web.facebook.com/hashtag/velvetvogue"><i class="fa fa-facebook"></i></a>
                                    <a href="https://x.com/hashtag/VelvetVogue?src=hashtag_click"><i class="fa fa-twitter"></i></a>
                                    <a href="https://za.pinterest.com/search/pins/?q=%23velvetvogue&rs=typed"><i class="fa fa-pinterest"></i></a>
                                    <a href="https://www.instagram.com/explore/search/keyword/?q=%23velvetvogue"><i class="fa fa-instagram"></i></a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="hero__items set-bg" data-setbg="img/hero/hero-2.jpg">
                <div class="container">
                    <div class="row">
                        <div class="col-xl-5 col-lg-7 col-md-8">
                            <div class="hero__text">
                                <h6>Summer Collection</h6>
                                <h2>Spring - Summer Collections 2025</h2>
                                <p>A contemporary fashion house creating refined essentials. Consciously made with an uncompromising focus on craftsmanship, sustainability, and sophistication.</p>
                                <a href="shop.php" class="primary-btn">Shop Here <span class="arrow_right"></span></a>
                                <div class="hero__social">
                                    <a href="https://web.facebook.com/hashtag/velvetvogue"><i class="fa fa-facebook"></i></a>
                                    <a href="https://x.com/hashtag/VelvetVogue?src=hashtag_click"><i class="fa fa-twitter"></i></a>
                                    <a href="https://za.pinterest.com/search/pins/?q=%23velvetvogue&rs=typed"><i class="fa fa-pinterest"></i></a>
                                    <a href="https://www.instagram.com/explore/search/keyword/?q=%23velvetvogue"><i class="fa fa-instagram"></i></a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Hero Section End -->

    <!-- Banner Section Begin -->
    <section class="banner spad">
        <div class="container">
            <div class="row">
                <div class="col-lg-7 offset-lg-4">
                    <div class="banner__item">
                        <div class="banner__item__pic">
                            <img src="img/banner/banner-1.jpg" alt="" width="400px">
                        </div>
                        <div class="banner__item__text">
                            <h2>Clothing Collections 2025</h2>
                            <a href="shop.php">Shop now</a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-5">
                    <div class="banner__item banner__item--middle">
                        <div class="banner__item__pic">
                            <img src="img/banner/banner-2.jpg" alt="" length="400px">
                        </div>
                        <div class="banner__item__text">
                            <h2>Accessories</h2>
                            <a href="shop.php">Shop now</a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-7">
                    <div class="banner__item banner__item--last">
                        <div class="banner__item__pic">
                            <img src="img/banner/banner-3.jpg" alt="">
                        </div>
                        <div class="banner__item__text">
                            <h2>Shoes Spring 2025</h2>
                            <a href="shop.php">Shop now</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Banner Section End -->

    <!-- Product Section Begin -->
    <?php include 'products.php'; ?>

<section class="product spad">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <ul class="filter__controls">
                    <li  data-filter=".best-sellers">Best Sellers</li>
                    <li data-filter=".new-arrivals">New Arrivals</li>
                    <li data-filter=".hot-sales">Hot Sales</li>
                </ul>
            </div>
        </div>

        <div class="row product__filter">

            <?php foreach ($products as $p): ?>

                <div class="col-lg-3 col-md-6 col-sm-6 mix <?php echo $p['category']; ?>">
                    <div class="product__item <?php echo ($p['label'] ? 'sale' : ''); ?>">
                        <div class="product__item__pic set-bg" data-setbg="<?php echo $p['image']; ?>">

                            <?php if ($p['label']): ?>
                                <span class="label"><?php echo $p['label']; ?></span>
                            <?php endif; ?>

                            <ul class="product__hover">
                                <li><a href="#"><img src="img/icon/heart.png" alt=""></a></li>
                                <li><a href="#"><img src="img/icon/compare.png" alt=""> <span>Compare</span></a></li>
                                <li><a href="product.php?id=<?php echo $p['id']; ?>"><img src="img/icon/search.png" alt=""></a></li>
                            </ul>

                        </div>

                        <div class="product__item__text">
                            <h6><?php echo $p['name']; ?></h6>
                            <a href="shopping-cart.php?id=<?php echo $p['id']; ?>" class="add-cart">+ Add To Cart</a>

                            <h5>LKR <?php echo number_format($p['data-price'], 2); ?></h5>
                        </div>
                    </div>
                </div>

            <?php endforeach; ?>

        </div>
    </div>
</section>
    <!-- Product Section End -->

    <!-- Categories Section Begin -->
    <section class="categories spad">
        <div class="container">
            <div class="row">
                <div class="col-lg-3">
                    <div class="categories__text">
                        <h2>Clothings Hot <br /> <span>Accessories</span> <br /> Shoe Collection</h2>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="categories__hot__deal">
                        <img src="img/product-sale.png" alt="">
                        <div class="hot__deal__sticker">
                            <span>Sale Of</span>
                            <h5>LKR 2999</h5>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 offset-lg-1">
                    <div class="categories__deal__countdown">
                        <span>Deal Of The Week</span>
                        <h2>Mini Tote Bag</h2>
                        <div class="categories__deal__countdown__timer" id="countdown">
                            <div class="cd-item">
                                <span>3</span>
                                <p>Days</p>
                            </div>
                            <div class="cd-item">
                                <span>1</span>
                                <p>Hours</p>
                            </div>
                            <div class="cd-item">
                                <span>50</span>
                                <p>Minutes</p>
                            </div>
                            <div class="cd-item">
                                <span>18</span>
                                <p>Seconds</p>
                            </div>
                        </div>
                        <a href="#" class="primary-btn">Shop now</a>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Categories Section End -->

    <!-- Instagram Section Begin -->
    <section class="instagram spad">
        <div class="container">
            <div class="row">
                <div class="col-lg-8">
                    <div class="instagram__pic">
                        <div class="instagram__pic__item set-bg" data-setbg="img/instagram/instagram-1.jpg"></div>
                        <div class="instagram__pic__item set-bg" data-setbg="img/instagram/instagram-2.jpg"></div>
                        <div class="instagram__pic__item set-bg" data-setbg="img/instagram/instagram-3.jpg"></div>
                        <div class="instagram__pic__item set-bg" data-setbg="img/instagram/instagram-4.jpg"></div>
                        <div class="instagram__pic__item set-bg" data-setbg="img/instagram/instagram-5.jpg"></div>
                        <div class="instagram__pic__item set-bg" data-setbg="img/instagram/instagram-6.jpg"></div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="instagram__text">
                        <h2>Instagram</h2>
                        <p>Visit Our Instagram page to find about the latest deals that we are offering.</p>
                        <h3>#VelvetVouge</h3>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Instagram Section End -->

    <!-- Latest Blog Section Begin -->
    <section class="latest spad">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="section-title">
                        <span>Latest News</span>
                        <h2>Fashion New Trends</h2>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-4 col-md-6 col-sm-6">
                    <div class="blog__item">
                        <div class="blog__item__pic set-bg" data-setbg="img/blog/blog-1.jpg"></div>
                        <div class="blog__item__text">
                            <span><img src="img/icon/calendar.png" alt=""> 16 February 2020</span>
                            <h5>What Curling Irons Are The Best Ones</h5>
                            <a href="#">Read More</a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 col-sm-6">
                    <div class="blog__item">
                        <div class="blog__item__pic set-bg" data-setbg="img/blog/blog-2.jpg"></div>
                        <div class="blog__item__text">
                            <span><img src="img/icon/calendar.png" alt=""> 21 February 2020</span>
                            <h5>Eternity Bands Do Last Forever</h5>
                            <a href="#">Read More</a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 col-sm-6">
                    <div class="blog__item">
                        <div class="blog__item__pic set-bg" data-setbg="img/blog/blog-3.jpg"></div>
                        <div class="blog__item__text">
                            <span><img src="img/icon/calendar.png" alt=""> 28 February 2020</span>
                            <h5>The Health Benefits Of Sunglasses</h5>
                            <a href="#">Read More</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Latest Blog Section End -->

    <!-- Footer Section Begin -->
    <?php include 'footer.php'; ?>
</body>

</html>