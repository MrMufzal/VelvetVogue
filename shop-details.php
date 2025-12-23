<?php 
session_start(); 
include 'products.php';

// Get product ID from URL
$product_id = isset($_GET['id']) ? intval($_GET['id']) : 0;

// Find the product
$product = null;
foreach ($products as $p) {
    if ($p['id'] == $product_id) {
        $product = $p;
        break;
    }
}

// If product not found, redirect to shop
if (!$product) {
    header("Location: shop.php");
    exit;
}

// Get related products (same type, exclude current product)
$related_products = array_filter($products, function($p) use ($product) {
    return $p['type'] == $product['type'] && $p['id'] != $product['id'];
});
$related_products = array_slice($related_products, 0, 4); // Limit to 4 products
?>

<!DOCTYPE html>
<html lang="zxx">

<?php include 'header.php'; ?>

    <!-- Shop Details Section Begin -->
    <section class="shop-details">
        <div class="product__details__pic">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="product__details__breadcrumb">
                            <a href="./index.php">Home</a>
                            <a href="./shop.php">Shop</a>
                            <span><?php echo htmlspecialchars($product['name']); ?></span>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-6 offset-lg-3">
                        <div class="product__details__pic__item">
                            <img src="<?php echo htmlspecialchars($product['image']); ?>" alt="<?php echo htmlspecialchars($product['name']); ?>" style="width: 100%; max-width: 500px; margin: 0 auto; display: block;">
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="product__details__content">
            <div class="container">
                <div class="row d-flex justify-content-center">
                    <div class="col-lg-8">
                        <div class="product__details__text">
                            <h4><?php echo htmlspecialchars($product['name']); ?></h4>
                            
                            <?php if (!empty($product['label'])): ?>
                                <span class="label" style="background: #ca1515; color: white; padding: 4px 12px; border-radius: 3px; font-size: 12px; display: inline-block; margin-bottom: 10px;">
                                    <?php echo htmlspecialchars($product['label']); ?>
                                </span>
                            <?php endif; ?>
                            
                            <div class="rating">
                                <i class="fa fa-star"></i>
                                <i class="fa fa-star"></i>
                                <i class="fa fa-star"></i>
                                <i class="fa fa-star"></i>
                                <i class="fa fa-star-o"></i>
                                <span> - 5 Reviews</span>
                            </div>
                            
                            <h3>LKR <?php echo number_format($product['data-price'], 2); ?></h3>
                            
                            <p><?php echo htmlspecialchars($product['description']); ?></p>
                            
                            <div class="product__details__option">
                                <div class="product__details__option__size">
                                    <span>Size:</span>
                                    <label class="active">
                                        <?php echo htmlspecialchars($product['size']); ?>
                                        <input type="radio" checked>
                                    </label>
                                </div>
                                
                                <div class="product__details__option__color">
                                    <span>Color:</span>
                                    <label class="active" style="background-color: <?php echo strtolower($product['color']); ?>; width: 20px; height: 20px; border-radius: 50%; display: inline-block; border: 2px solid #ddd;">
                                        <input type="radio" checked>
                                    </label>
                                    <span style="margin-left: 10px;"><?php echo htmlspecialchars($product['color']); ?></span>
                                </div>
                            </div>
                            
                            <div class="product__details__cart__option">
                                <div class="quantity">
                                    <div class="pro-qty">
                                        <input type="number" value="1" min="1" id="quantity">
                                    </div>
                                </div>
                                <a href="shopping-cart.php?id=<?php echo $product['id']; ?>" class="primary-btn">Add to cart</a>
                            </div>
                            
                            <div class="product__details__btns__option">
                                <a href="#"><i class="fa fa-heart"></i> Add to wishlist</a>
                                <a href="#"><i class="fa fa-exchange"></i> Add To Compare</a>
                            </div>
                            
                            <div class="product__details__last__option">
                                <h5><span>Product Information</span></h5>
                                <ul>
                                    <li><span>Product ID:</span> <?php echo $product['id']; ?></li>
                                    <li><span>Category:</span> <?php echo htmlspecialchars($product['type']); ?></li>
                                    <li><span>Brand:</span> <?php echo htmlspecialchars($product['brand']); ?></li>
                                    <li><span>Tag:</span> <?php echo htmlspecialchars($product['tag']); ?></li>
                                    <li><span>Available Size:</span> <?php echo htmlspecialchars($product['size']); ?></li>
                                    <li><span>Color:</span> <?php echo htmlspecialchars($product['color']); ?></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="row">
                    <div class="col-lg-12">
                        <div class="product__details__tab">
                            <ul class="nav nav-tabs" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link active" data-toggle="tab" href="#tabs-5" role="tab">Description</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" data-toggle="tab" href="#tabs-6" role="tab">Reviews</a>
                                </li>
                            </ul>
                            <div class="tab-content">
                                <div class="tab-pane active" id="tabs-5" role="tabpanel">
                                    <div class="product__details__tab__content">
                                        <div class="product__details__tab__content__item">
                                            <h5>Product Information</h5>
                                            <p><?php echo htmlspecialchars($product['description']); ?></p>
                                            <p>This premium <?php echo htmlspecialchars($product['name']); ?> from <?php echo htmlspecialchars($product['brand']); ?> 
                                            is crafted with attention to detail and quality. Perfect for those who appreciate fine craftsmanship and style.</p>
                                        </div>
                                        <div class="product__details__tab__content__item">
                                            <h5>Material & Care</h5>
                                            <p>Made from high-quality materials designed for durability and comfort. 
                                            Follow care instructions to maintain the product's quality and appearance for years to come.</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane" id="tabs-6" role="tabpanel">
                                    <div class="product__details__tab__content">
                                        <div class="product__details__tab__content__item">
                                            <h5>Customer Reviews</h5>
                                            <p>This product has received excellent reviews from our customers. 
                                            Average rating: 4.0 out of 5 stars based on customer feedback.</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Shop Details Section End -->

    <!-- Related Section Begin -->
    <?php if (count($related_products) > 0): ?>
    <section class="related spad">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <h3 class="related-title">Related Products</h3>
                </div>
            </div>
            <div class="row">
                <?php foreach ($related_products as $related): ?>
                <div class="col-lg-3 col-md-6 col-sm-6">
                    <div class="product__item">
                        <div class="product__item__pic set-bg" data-setbg="<?php echo htmlspecialchars($related['image']); ?>">
                            <?php if (!empty($related['label'])): ?>
                                <span class="label"><?php echo htmlspecialchars($related['label']); ?></span>
                            <?php endif; ?>
                            <ul class="product__hover">
                                <li><a href="#"><img src="img/icon/heart.png" alt=""></a></li>
                                <li><a href="#"><img src="img/icon/compare.png" alt=""> <span>Compare</span></a></li>
                                <li><a href="shop-details.php?id=<?php echo $related['id']; ?>"><img src="img/icon/search.png" alt=""></a></li>
                            </ul>
                        </div>
                        <div class="product__item__text">
                            <h6><a href="shop-details.php?id=<?php echo $related['id']; ?>"><?php echo htmlspecialchars($related['name']); ?></a></h6>
                            <a href="shopping-cart.php?id=<?php echo $related['id']; ?>" class="add-cart">+ Add To Cart</a>
                            <div class="rating">
                                <i class="fa fa-star"></i>
                                <i class="fa fa-star"></i>
                                <i class="fa fa-star"></i>
                                <i class="fa fa-star"></i>
                                <i class="fa fa-star-o"></i>
                            </div>
                            <h5>LKR <?php echo number_format($related['data-price'], 2); ?></h5>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>
    <?php endif; ?>
    <!-- Related Section End -->

    <?php include 'footer.php'; ?>
</body>

</html>