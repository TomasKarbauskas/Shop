
<section class="container single-product my-5 pt-5">
    <div class="row mt-5">
        <div class="col-lg-5 col-md-6 col-sm-12">
            <img class="rounded float-left w-100"
                 src="<?php echo imagesUrl(($products['image'] ?? ''));?>">
        </div>
        <div class="col-lg-6 col-md-12 col-sm-12">
            <?php if(isset($products)): ?>
            <h3 class="py-4">Mens fashion</h3>
            <h3><?= ($products['product_name'] ?? ''); ?></h3>
            <h2>€<?php echo ($products['price'] ?? '');?></h2>
            <div class="form-group checkout-btn-container">
            </div>
                <form action="<?= publicUrl("shop/toCart"); ?>" method="post" enctype="multipart/form-data">
                    <input type="hidden" name="image" value="<?= ($products['image'] ?? ''); ?>">
                    <input type="hidden" name="product_id" value="<?= ($products['id'] ?? ''); ?>">
                        <input type="hidden" name="product_name" value="<?= ($products['product_name'] ?? ''); ?>">
                        <input type="hidden" name="price" value="<?= ($products['price'] ?? ''); ?>">
                    <div id="single-product-quantity">
                        <label class="form-group pt-4 mr-2">quantity</label>
                        <input class="form-control mt-3 mx-2" type="number" name="quantity" value="1" required>
                    </div>
                        <input type="hidden" name="description" value="<?= ($products['description'] ?? ''); ?>">
                    <div class="form-group checkout-btn-container pt-3">
                        <button type="submit" class="buy-btn">add to cart</button>
                    </div>
                </form>
                    <div class="form-group checkout-btn-container pt-5">
                        <a href="/shop"><button class="buy-btn">back</button></a>
                    </div>
            <?php endif; ?>
            <h4 class="mt-5 mb-5">product details</h4>
            <span><?= ($products['description'] ?? ''); ?></span>
        </div>
    </div>
</section>





