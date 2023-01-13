<section class="cart container my-5 py-5">
    <div class="container mt-5">
        <h2 class="font-weight-bold">your cart</h2>
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
                        <form method="POST" action="<?= publicUrl("shop/{$product['id']}/deleteCartItem") ?>">
                            <div class="checkout-container pt-4">
                                <input type="hidden" name="_method" value="DELETE">
                                <input  class="check-out" id="checkout-btn" type="submit" value="remove">
                            </div>
                        </form>
                    </div>
                </div>
            </td>
            <td>
                <form  id="cart-form" action="<?= publicUrl("shop/updateCartItem"); ?>"
                      method="post" enctype="multipart/form-data">
                    <input type="hidden" class="form-control" id="checkout-name" name="id"
                           value="<?= ($product['id'] ?? ''); ?>">
                    <input type="hidden" class="form-control" id="checkout-name" name="product_name"
                           value="<?= ($product['product_name'] ?? ''); ?>">
                    <input type="number" class="input" id="checkout-name" name="quantity"
                           value="<?= ($product['quantity'] ?? ''); ?>">
                    <div class="checkout-container">
                        <button type="submit" class="check-out" id="checkout-btn">update</button>
                    </div>
                </form>
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
    <?php if(!empty($products)): ?>
        <div class="checkout-container">
        <a href="/shop/checkout"><button type="submit" class="check-out">checkout</button></a>
    </div>
    <?php endif;?>
</section>






