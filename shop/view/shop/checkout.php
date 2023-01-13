<section class="cart container my-5 py-5">
    <div class="container mt-5">
        <h2 class="font-weight-bold">your items</h2>
        <hr>
    </div>
    <table class="mt-5 pt-5">
        <tr>
            <th>product</th>
            <th>quantity</th>
            <th>total</th>
        </tr>
        <?php if(isset($products))?>
            <?php
        $total = '';
        if($products['total_cost'] ?? '') {$total = $products['total_cost'];}
        unset($products['total_cost']); ?>
        <?php  foreach ($products as $key => $product): ?>
            <tr>
                <td>
                    <div class="product-info mx-3">
                        <img src="<?php echo imagesUrl(($product['image'] ?? ''));?>"/>
                        <div id="cart-form">
                            <div id="cart-small-item"><p><?php echo ($product['product_name'] ?? '');?></p>
                                <span>€</span>
                                <span class="product-price"><?php echo ($product['price'] ?? '');?></span>
                            </div>
                        </div>
                    </div>
                    <td>
                        <p><?= ($product['quantity'] ?? ''); ?></p>
                    </td>
                <td>
                    <span>€</span>
                    <span class="product-price"><?php echo ($product['price_total']?? '');?></span>
                </td>
            </tr>
        <?php endforeach; ?>
    </table>
    <div class="cart-total">
        <table>
            <tr>
                <td>total</td>
                <td><span>€ </span><?=  $total; ?></td>
            </tr>
        </table>
    </div>
    <div class="checkout-container mt-2">
        <a href="/shop/cart"><button type="submit" class="check-out">back</button></a>
    </div>
</section>

<section class="mb-5 pb-1">
    <div class="container text-center mt-3 pt-5">
        <h2 class="form-weight-bold">enter delivery address</h2>
                <hr class="mx-auto">
    </div>
    <div class="mx-auto container">
            <form id="checkout-form" method="post" action="<?= publicUrl('shop/payments'); ?>" >
            <div class="form-group checkout-small-element">
                <label>name</label>
                <input type="text" class="form-control" id="checkout-name"
                       name="name" placeholder="enter name"  required>
            </div>

            <div class="form-group checkout-small-element">
                <label>email</label>
                <input type="text" class="form-control" id="checkout-name"
                       name="email" placeholder="enter email"  required>
            </div>

            <div class="form-group checkout-small-element">
                <label>phone</label>
                <input type="tel" class="form-control" id="checkout-name"
                       name="phone" placeholder="enter phone number"  required>
            </div>

            <div class="form-group checkout-small-element">
                <label>city</label>
                <input type="text" class="form-control" id="checkout-name"
                       name="city" placeholder="city"  required>
            </div>

            <div class="form-group checkout-small-element">
                <label>address</label>
                <input type="text" class="form-control" id="checkout-name"
                       name="address" placeholder="enter address" required>
            </div>
            <div class="checkout-container mt-4">
                <input type="submit" class="check-out" id="checkout-btn" value="submit">
            </div>
        </form>
    </div>
</section>