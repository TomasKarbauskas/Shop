<?php
if(!($_SESSION['authenticated'] ?? '')) {
    redirect('/shop/login');
} ?>
<section class="cart container my-5 py-5">
    <div class="container mt-5">
        <h2 class="font-weight-bold">edit product</h2>
        <hr>
    </div>
    <table class="mt-5 pt-5">
        <tr>
            <th>product</th>
            <th>quantity</th>
            <th>price</th>
        </tr>
        <?php if(isset($product))?>
        <tr>
            <td>
                <div class="product-info">
                    <img src="<?php echo imagesUrl(($product['image'] ?? ''));?>"/>
                    <div id="single-product-quantity">
                        <p class="checkout-container mt-2 pt-4 mx-2"><?= ($product['product_name'] ?? '');?></p>
                        <form method="POST" class="unsetCss" action="<?= publicUrl("shop/{$product['id']}") ?>">
                            <div class="checkout-container pt-4">
                                <input type="hidden" name="_method" value="DELETE">
                                <input  class="check-out" id="checkout-btn" type="submit" value="remove">
                            </div>
                        </form>
                    </div>
                </div>
            </td>
            <td>
                <small><?php echo ($product['quantity'] ?? '');?></small>
            </td>
            <td>
                <span>€</span>
                <span class="product-price"><?php echo ($product['price'] ?? '');?></span>
            </td>
        </tr>
    </table>
</section>
<section class="my-5 py-5 col-lg-12 col-md-8">
    <div class="container text-center pt-3">
        <h2 class="form-weight-bold ">administrator area</h2>
        <h2 class="form-weight-bold">edit product</h2>
        <h4 class="form-weight-bold"><?= ($_SESSION['message'] ?? '') ?></h4>
        <hr class="mx-auto">
    </div>
    <div class="mx-auto container pt-3" >
        <form id="checkout-form" action="<?= publicUrl('shop/update'); ?>" method="post" enctype="multipart/form-data">
            <div class="form-group checkout-small-element">
                <input type="hidden" name="id" value="<?= ($product['id'] ?? ''); ?>">
                <label>product name</label>
                <input type="text" class="form-control" id="checkout-name" name="product_name"
                       value="<?= ($product['product_name'] ?? ''); ?>" placeholder="product name" required>
            </div>
            <div class="form-group checkout-small-element">
                <label>price</label>
                <input type="text" class="form-control" id="checkout-email" name="price"
                       value="<?= ($product['price '] ?? ''); ?>" placeholder="price" required>
            </div>
            <div class="form-group checkout-small-element">
                <label>description</label>
                <input type="text" class="form-control" id="checkout-phone" name="description"
                       value="<?= ($product['description'] ?? ''); ?>" placeholder="description" required>
            </div>
            <div class="form-group checkout-small-element">
                <label>quantity</label>
                <input type="number" class="form-control" id="checkout-city" name="quantity"
                       value="<?= ($product['quantity'] ?? ''); ?>" placeholder="quantity" required>
            </div>
            <div class="form-group checkout-large-element pt-2">
                <label>add image</label>
                <input name="image" multiple placeholder="image" type="file" value="<?= ($product['image'] ?? ''); ?>">
            </div>
            <div class="form-group checkout-btn-container">
                <input type="submit" class="btn" id="checkout-btn" value="update">
            </div>
        </form>
    </div>
</section>
