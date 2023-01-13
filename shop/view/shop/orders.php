<?php
if(!($_SESSION['authenticated'] ?? '')) {
    redirect('/shop/login');
} ?>
<section class="cart container my-5 py-5">
    <div class="container mt-5">
        <h2 class="font-weight-bold">orders</h2>
    </div>
    <div>
        <?php if(isset($products))?>
        <?php if($products['total_cost'] ?? '') {$total = $products['total_cost'];}
        unset($products['total_cost']); ?>
        <?php  foreach ($products as $key => $product): ?>
        <table>
            <tr>
                <th>Customer name</th>
                <th>email</th>
                <th>phone</th>
                <th>address</th>
            </tr>
            <tr>
                <td><?= ($product['customer_name'] ?? '');?></td>
                <td><?= ($product['email'] ?? '');?></td>
                <td><?= ($product['phone'] ?? '');?></td>
                <td><?= ($product['address'] ?? '');?></td>
            </tr>
        </table>
    </div>
    <table class="mt-5 pt-5">
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
                        <form method="POST" action="<?= publicUrl("shop/{$product['id']}/deleteOrderItem") ?>">
                            <div class="checkout-container pt-4">
                                <input type="hidden" name="_method" value="DELETE">
                                <input  class="check-out" id="checkout-btn" type="submit" value="posted">
                            </div>
                        </form>
                    </div>
                </td>
                <td>
                    <h5><p>quantity: <?php echo ($product['quantity'] ?? '');?></h5>
                </td>
                <td>
                    <h5>product id: <?= ($product['product_id'] ?? ''); ?></h5>
                </td>
            </tr>
        <?php endforeach; ?>
    </table>
    <hr>
    <?php if(!empty($products)): ?>
        <div class="checkout-container">
            <a href="/shop/logout"><button type="submit" class="check-out">logout</button></a>
            <?php endif;?>
            <div class="checkout-container mx-2">
                <a href="/shop/create"><button type="submit" class="check-out">back</button></a>
            </div>
        </div>

</section>
