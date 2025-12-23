<?php 
include "header.php";
include "products.php";

$query = strtolower(trim($_GET["q"] ?? ""));

$results = [];

if ($query !== "") {
    foreach ($products as $product) {
        if (strpos(strtolower($product["name"]), $query) !== false) {
            $results[] = $product;
        }
    }
}
?>

<div class="container mt-5">
    <h2>Search Results for: <strong><?= htmlspecialchars($query) ?></strong></h2>
    <p><?= count($results) ?> result(s) found</p>

    <div class="row mt-4">

        <?php if (count($results) == 0): ?>
            <div class="col-lg-12">
                <p>No products match your search.</p>
            </div>
        <?php endif; ?>

        <?php foreach ($results as $item): ?>
        <div class="col-lg-3 col-md-6 col-sm-6">
            <div class="product__item">
                <div class="product__item__pic set-bg" data-setbg="<?= $item['image'] ?>">
                    <ul class="product__hover">
                        <li><a href="#"><img src="img/icon/heart.png" alt=""></a></li>
                        <li><a href="#"><img src="img/icon/compare.png" alt=""></a></li>
                        <li><a href="#"><img src="img/icon/search.png" alt=""></a></li>
                    </ul>
                </div>

                <div class="product__item__text">
                    <h6><?= $item["name"] ?></h6>
                    <a href="#" class="add-cart">+ Add To Cart</a>
                    <h5>LKR<?= number_format($item["data-price"], 2) ?></h5>
                </div>
            </div>
        </div>
        <?php endforeach; ?>

    </div>
</div>

<?php include "footer.php"; ?>
