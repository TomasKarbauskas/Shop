<?php
if(!($_SESSION['authenticated'] ?? '')) {
    redirect('/shop/login');
} ?>
<section class="my-5 py-5 col-lg-12 col-md-8">
    <div class="container text-center pt-5" style="padding-top: 5rem">
        <h2 class="form-weight-bold">administrator area</h2>
        <h2 class="form-weight-bold">add product</h2>
        <h4 class="form-weight-bold"><?= ($_SESSION['message'] ?? '') ?></h4>
    </div>
    <div class="mx-auto container pt-3" >
        <form id="checkout-form" action="<?= publicUrl('shop/store'); ?>"
              method="post" enctype="multipart/form-data">
                <label>product name</label>
                <input type="text" class="form-control"
                       id="checkout-name" name="product_name" placeholder="product name" required>
                <label>price</label>
                <input type="number" class="form-control"
                       id="checkout-email" name="price" placeholder="price" required>
                <label>description</label>
                <input type="text" class="form-control"
                       id="checkout-phone" name="description" placeholder="description" required>
                <label>quantity</label>
                <input type="number" class="form-control"
                       id="checkout-city" name="quantity" placeholder="quantity" required>
            <div class="form-group pt-4">
                <label>add image</label>
                <input name="image" multiple placeholder="image" type="file" required>
            </div>
            <div class="form-group checkout-btn-container">
                <a href="/shop/orders"><input type="button" class="btn" id="checkout-btn" value="orders"></a>
                <input type="submit" class="btn" id="checkout-btn" value="submit">
                <a href="/shop/logout"><input type="button" class="btn" id="checkout-btn" value="logout"></a>
            </div>
        </form>
    </div>
</section>
<section class="cart container my-5 pb-5">
    <div class="container mt-5">
        <h2 class="font-weight-bold">products in stock</h2>
        <hr>
    </div>
    <table class="mt-5 pt-5">
        <tr>
            <th>product</th>
            <th>quantity</th>
        </tr>
        <?php if(isset($products))
        foreach ($products as $product): ?>
        <tr>
            <td>
                <div class="product-info">
                    <img src="<?php echo imagesUrl(($product['image'] ?? ''));?>"/>
                    <div id="admin-create-product-section" style="display: flex">
                        <div>
                            <p><?php echo ($product['product_name'] ?? '');?></p>
                            <small><span>€</span><?php echo ($product['price'] ?? '');?></small>
                        </div>
                        <div class="form-group checkout-btn-container">
                            <form method="POST" action="<?= publicUrl("shop/{$product['id']}") ?>">
                                <input type="hidden" name="_method" value="DELETE">
                                <input class="btn" id="checkout-btn" type="submit" value="delete"
                                style="color: coral; text-underline: coral; cursor: pointer;">
                            </form>
                        </div>
                    </div>
                </div>
            </td>
            <td>
                <div>
                    <small><?= ($product['quantity'] ?? '');?></small>
                    <a href="<?= ($product['id'] ?? '');?>/edit" class="edit-btn">edit</a>
                </div>
            </td>
        </tr>
        <?php endforeach; ?>
    </table>
</section>


