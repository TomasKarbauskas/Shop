
<section id="home">
    <div class="container" id="background">
        <h5>New Arrivals</h5>
        <h1><span>Best Price</span></h1>
        <p>E-Shop Great Outdoors</p>
        <a href="#featured"><button class="buy-btn">Shop now</button></a>
    </div>
</section>
<section id="featured" class="my-5 pb-5">
    <div class="container text-center mt-5 py-5">
        <h3>The Winter is Coming</h3>
        <hr>
        <p>Our Best Deals</p>
    </div>
    <div class="row mx-auto container-fluid">
        <?php if(isset($products))
        foreach ($products as $product): ?>
        <div class="product text-center col-lg-3 col-md-6 col-sm-12">
            <a href="/shop/<?php echo $product['id']?>">
                <img class="img-fluid mb-2" id="home-img" src="<?php echo imagesUrl(($product['image'] ?? ''));?>">
            </a>
            <div class="star" id="star">
                <i class="fas fa-star" style="color: #ffb700"></i>
                <i class="fas fa-star" style="color: #ffb700"></i>
                <i class="fas fa-star" style="color: #ffb700"></i>
                <i class="fas fa-star" style="color: #ffb700"></i>
                <i class="fas fa-star" style="color: #ffb700"></i>
            </div>
            <h5 class="p-name"><?php echo $product['product_name']?></h5>
            <h4 class="p-price">€<?php echo $product['price']?></h4>
            <a href="/shop/<?php echo $product['id']?>"><button class="buy-btn">Buy Now</button></a>
        </div>
        <?php endforeach; ?>
    </div>
</section>
