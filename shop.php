
<?php
include 'products.php';
?>

<!DOCTYPE html>
<html lang="zxx">

<?php include 'header.php'; ?>

    <!-- Breadcrumb Section Begin -->
    <section class="breadcrumb-option">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="breadcrumb__text">
                        <h4>Shop</h4>
                        <div class="breadcrumb__links">
                            <a href="./index.php">Home</a>
                            <span>Shop</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Breadcrumb Section End -->

    <!-- Shop Section Begin -->
    <section class="shop spad">
        <div class="container">
            <div class="row">
                <div class="col-lg-3">
                    <div class="shop__sidebar">
                        <div class="shop__sidebar__search">
                            <form action="/VelvetVogue/search.php" method="GET">
                                <input type="text" id="search-input" name="q" placeholder="Search here.....">
                                <button type="submit"><span class="icon_search"></span></button>
                            </form>
                        </div>
                        <div class="shop__sidebar__accordion">
                            <div class="accordion" id="accordionExample">
                                <div class="card">
                                    <div class="card-heading">
                                        <a data-toggle="collapse" data-target="#collapseOne">Categories</a>
                                    </div>
                                    <div id="collapseOne" class="collapse show" data-parent="#accordionExample">
                                        <div class="card-body">
                                            <div class="shop__sidebar__categories">
                                                    <ul class="nice-scroll">
                                                    <li><a href="shop.php?type=Men">Men</a></li>
                                                    <li><a href="shop.php?type=Women">Women</a></li>
                                                    <li><a href="shop.php?type=Kids">Kids</a></li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="card">
                                    <div class="card-heading">
                                        <a data-toggle="collapse" data-target="#collapseTwo">Branding</a>
                                    </div>
                                    <div id="collapseTwo" class="collapse show" data-parent="#accordionExample">
                                        <div class="card-body">
                                            <div class="shop__sidebar__brand">
                                                <ul>
                                                <li><a href="shop.php?brand=Louis Vuitton">Louis Vuitton</a></li>
                                                <li><a href="shop.php?brand=Chanel">Chanel</a></li>
                                                <li><a href="shop.php?brand=Hermes">Hermes</a></li>
                                                <li><a href="shop.php?brand=Gucci">Gucci</a></li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="card">
                                    <div class="card-heading">
                                        <a data-toggle="collapse" data-target="#collapseThree">Filter Price</a>
                                    </div>
                                    <div id="collapseThree" class="collapse show" data-parent="#accordionExample">
                                        <div class="card-body">
                                            <div class="shop__sidebar__price">
                                                <ul>
                                                <li><a href="shop.php?price=0-1000">LKR 0 - 1000</a></li>
                                                <li><a href="shop.php?price=1000-2000">LKR 1000 - 2000</a></li>
                                                <li><a href="shop.php?price=2000-3000">LKR 2000 - 3000</a></li>
                                                <li><a href="shop.php?price=3000-5000">LKR 3000 - 5000</a></li>
                                                <li><a href="shop.php?price=5000-10000">LKR 5000 - 10000</a></li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="card">
                                    <div class="card-heading">
                                        <a data-toggle="collapse" data-target="#collapseFour">Size</a>
                                    </div>
                                    <div id="collapseFour" class="collapse show" data-parent="#accordionExample">
                                        <div class="card-body">
                                            <div class="shop__sidebar__size">
                                            <form id="sizeFilterForm" action="shop.php" method="GET">                                     
                                                        <form method="GET" action="shop.php" id="filterForm">
                                                <div class="shop__sidebar__size">
                                                    <label><input type="radio" name="size" value="S" onchange="autoSubmit()"> S</label>
                                                    <label><input type="radio" name="size" value="M" onchange="autoSubmit()"> M</label>
                                                    <label><input type="radio" name="size" value="L" onchange="autoSubmit()"> L</label>
                                                    <label><input type="radio" name="size" value="XL" onchange="autoSubmit()"> XL</label>
                                                    <label><input type="radio" name="size" value="XXL" onchange="autoSubmit()"> XXL</label>
                                                    <label><input type="radio" name="size" value="3XL" onchange="autoSubmit()"> 3XL</label>
                                                </div>
                                            </form>
                                        </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="card">
                                    <div class="card-heading">
                                        <a data-toggle="collapse" data-target="#collapseFive">Colors</a>
                                    </div>
                                    <div id="collapseFive" class="collapse show" data-parent="#accordionExample">
                                        <div class="card-body">
                                            <div class="shop__sidebar__color">
                                            <form method="GET" action="shop.php" id="colorForm">

                                                <label class="c-8">
                                                    <input type="radio" name="color" value="brown"
                                                        onchange="document.getElementById('colorForm').submit();"
                                                        <?php if(isset($_GET['color']) && $_GET['color']=='brown') echo 'checked'; ?>>
                                                </label>

                                                <label class="c-2">
                                                    <input type="radio" name="color" value="blue"
                                                        onchange="document.getElementById('colorForm').submit();"
                                                        <?php if(isset($_GET['color']) && $_GET['color']=='blue') echo 'checked'; ?>>
                                                </label>

                                                <label class="c-10" >
                                                    <input type="radio" name="color" value="green"
                                                        onchange="document.getElementById('colorForm').submit();"
                                                        <?php if(isset($_GET['color']) && $_GET['color']=='green') echo 'checked'; ?>>
                                                </label>

                                                <label class="c-1">
                                                    <input type="radio" name="color" value="black"
                                                        onchange="document.getElementById('colorForm').submit();"
                                                        <?php if(isset($_GET['color']) && $_GET['color']=='black') echo 'checked'; ?>>
                                                </label>

                                                <label class="c-9">
                                                    <input type="radio" name="color" value="white"
                                                        onchange="document.getElementById('colorForm').submit();"
                                                        <?php if(isset($_GET['color']) && $_GET['color']=='white') echo 'checked'; ?>>
                                                </label>

                                            </form>
                                        </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="card">
                                    <div class="card-heading">
                                        <a data-toggle="collapse" data-target="#collapseSix">Tags</a>
                                    </div>
                                    <div id="collapseSix" class="collapse show" data-parent="#accordionExample">
                                        <div class="card-body">
                                            <div class="shop__sidebar__tags">
                                                <a href="shop.php?tag=Product">Product</a>
                                                <a href="shop.php?tag=Bags">Bags</a>
                                                <a href="shop.php?tag=Shoes">Shoes</a>
                                                <a href="shop.php?tag=Fashion">Fashion</a>
                                                <a href="shop.php?tag=Clothing">Clothing</a>
                                                <a href="shop.php?tag=Hats">Hats</a>
                                                <a href="shop.php?tag=Accessories">Accessories</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-9">
                    <div class="shop__product__option">
                        <div class="row">
                            <div class="col-lg-6 col-md-6 col-sm-6">
                                <div class="shop__product__option__left">
                                    <p>Showing 1-12 of 126 results</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php include 'products.php'; ?>
<?php
// FILTER PRODUCTS BASED ON GET PARAMETERS
$filtered = $products;

// CATEGORY / TYPE
if (!empty($_GET['type'])) {
    $type = strtolower($_GET['type']);
    $filtered = array_filter($filtered, function($p) use ($type) {
        return strtolower($p['type']) == $type;
    });
}

// BRAND
if (!empty($_GET['brand'])) {
    $brand = strtolower($_GET['brand']);
    $filtered = array_filter($filtered, function($p) use ($brand) {
        return strtolower($p['brand']) == $brand;
    });
}

// PRICE FILTER
if (!empty($_GET['price'])) {

    list($min, $max) = explode('-', $_GET['price']);
    $min = (int)$min;
    $max = (int)$max;

    $filtered = array_filter($filtered, function($p) use ($min, $max) {
        return $p['data-price'] >= $min && $p['data-price'] <= $max;
    });
}

// SIZE
if (!empty($_GET['size'])) {
    $size = strtolower($_GET['size']);
    $filtered = array_filter($filtered, function($p) use ($size) {
        return strtolower($p['size']) == $size;
    });
}

// COLOR
if (!empty($_GET['color'])) {
    $color = strtolower($_GET['color']);
    $filtered = array_filter($filtered, function($p) use ($color) {
        return strtolower($p['color']) == $color;
    });
}
// TAG
if (!empty($_GET['tag'])) {
    $tag = strtolower($_GET['tag']);
    $filtered = [];

    foreach ($products as $p) {
        if (strtolower($p['tag']) == $tag) {
            $filtered[] = $p;
        }
    }
    $products = $filtered;
}

?>
<div class="row">
<?php foreach ($filtered as $p): ?>
    <div class="col-lg-4 col-md-6 col-sm-6">
        <div class="product__item <?php echo strtolower($p['label']); ?>">
            <div class="product__item__pic set-bg" data-setbg="<?php echo $p['image']; ?>">
                <?php if ($p['label'] != ""): ?>
                    <span class="label"><?php echo $p['label']; ?></span>
                <?php endif; ?>
                <ul class="product__hover">
                    <li><a href="#"><img src="img/icon/heart.png" alt=""></a></li>
                    <li><a href="#"><img src="img/icon/compare.png" alt=""> <span>Compare</span></a></li>
                    <li><a href="shop-details.php?id=<?php echo $p['id']; ?>"><img src="img/icon/search.png" alt=""></a></li>
                </ul>
            </div>
            <div class="product__item__text">
                <h6><?php echo $p['name']; ?></h6>
                <a href="shopping-cart.php?action=add&id=<?php echo $p['id']; ?>" class="add-cart">+ Add To Cart</a>
                <h5 class="price" data-price="<?php echo $p['data-price']; ?>">LKR <?php echo $p['data-price']; ?></h5>
            </div>
        </div>
    </div>
<?php endforeach; ?>
</div>

    </section>
    <!-- Shop Section End -->

<script>
    document.querySelectorAll('.shop__sidebar__size input[type="radio"]').forEach(function (radio) {
    radio.addEventListener('change', function () {
        document.getElementById('sizeFilterForm').submit();
        });
        });
</script>

   <?php include 'footer.php'; ?>
</body>

</html>