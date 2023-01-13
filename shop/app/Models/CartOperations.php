<?php
declare(strict_types = 1);

use JetBrains\PhpStorm\NoReturn;

require_once __DIR__.'/../../core/Connections.php';
require_once __DIR__.'/../../app/Interfaces/CartOperationsInterface.php';

class CartOperations extends Connections implements CartOperationsInterface
{

    public string $orders = 'orders';
    public string $users = 'users';
    public string $customerOrders = 'customerOrders';

    public function getCartContent(): bool|array
    {
        return $this->connection->query("SELECT * FROM {$this->orders}")
            ->fetchAll(PDO::FETCH_ASSOC);
    }

    public function createOrder(array $data): int|string
    {
        $sql = "INSERT INTO {$this->orders} (
                     product_id,
                     product_name,
                     price,
                     description,
                     quantity,
                     image
                     )
                VALUES (
                     :product_id,
                     :product_name,
                     :price,
                     :description,
                     :quantity,
                     :image)";

        $statement = $this->connection->prepare($sql);
        $statement->execute($data);
        $id = $this->connection->lastInsertId();

        return $id;
    }

    public function customerOrders(array $data): int|string
    {
        $sql = "INSERT INTO {$this->customerOrders} (
                    email,
                    phone,
                    city,
                    address,
                    product_id,
                    product_name,
                    price,
                    description,
                    quantity,
                    image,
                    total_cost,
                    customer_name)
                VALUES (
                    :email,
                    :phone,
                    :city,
                    :address,
                    :product_id,
                    :product_name,
                    :price,
                    :description,
                    :quantity,
                    :image,
                    :total_cost,
                    :customer_name)";

        $statement = $this->connection->prepare($sql);
        $statement->execute($data);
        $id = $this->connection->lastInsertId();

        return $id;
    }

    public function ordersPayed(): bool|array
    {
        return $this->connection->query("SELECT * FROM {$this->customerOrders}")
            ->fetchAll(PDO::FETCH_ASSOC);
    }

    public function updateQuantity(array $data = []): void
    {
        $sql = "UPDATE
                    {$this->orders}
                SET
                   id = :id,
                   product_id = :product_id,
                   product_name = :product_name,
                   price = :price,
                   description = :description,
                   quantity = :quantity,
                   image = :image
               WHERE id = :id";

        $statement = $this->connection->prepare($sql);
        $statement->execute($data);
    }

    public function getOrderIds(): bool|array
    {
        return $this->connection->query("SELECT * FROM {$this->orders}")
            ->fetchAll(PDO::FETCH_ASSOC);
    }

    public function cartContentCount(): int
    {
        $total = [];
        $cartContent = $this->getOrderIds();
        foreach ($cartContent as $key => $value) {
            $total[] = $value['quantity'];
        }
        $itemsTotal = array_sum($total);

        return $itemsTotal;
    }

    public function costumerBagTotal(bool|array $cartContent): bool|array
    {
        foreach($cartContent as $key => $value) {
            $costPerItemTotal = $value['price'] * $value['quantity'];
            $costTotal[] =+ $costPerItemTotal;
            $total = array_sum($costTotal);
            $cartContent['total_cost'] = $total;
            $cartContent[$key]['price_total'] = $costPerItemTotal;
        }

        return $cartContent;
    }
    public function updateCart(array $data): void
    {
        $sql = "UPDATE
                    {$this->orders}
                SET
                   id = :id,
                   product_name = :product_name,
                   quantity = :quantity
               WHERE id = :id";

        $statement = $this->connection->prepare($sql);
        $statement->execute($data);
    }

    public function updateCartItem(array $data): void
    {
        $sql = "UPDATE
                    {$this->orders}
                SET
                   id = :id,
                   product_name = :product_name,
                   quantity = :quantity  
               WHERE id = :id";

        $statement = $this->connection->prepare($sql);
        $statement->execute($data);
    }

    public function customerOrderDetails(array $customerDetails, array $customerOrders): array
    {
        $customerOrderDetails = [];
        foreach ($customerOrders as $key => $value) {
            $value['total_cost'] = $value['price'] * $value['quantity'];
            $value['customer_name'] = $customerDetails['name'];
            unset($value['id']);
            unset($value['created_at']);
            unset($value['updated_at']);
            unset($value['deleted_at']);
            $customerOrderDetails[] = array_merge($customerDetails, $value);
        }

        foreach ($customerOrderDetails as $key => $value) {
            unset($customerOrderDetails[$key]['name']);
        }

        return $customerOrderDetails;
    }

    public function removeFromCart(): void
    {
        $cartContent = $this->getCartContent();
        foreach ($cartContent as $key => $value) {
            $this->deleteCartContent($value['product_id']);
        }
    }

    public function deleteCartContent(mixed $productId): void
    {
        $sql = "
        DELETE FROM {$this->orders}
        WHERE product_id = ?";

        $statement = $this->connection->prepare($sql);
        $statement->execute([$productId]);
    }

    public function deleteOrderItem(mixed $id): void
    {
        $sql = "
        DELETE FROM {$this->customerOrders}
        WHERE id = ?";

        $statement = $this->connection->prepare($sql);
        $statement->execute([$id]);
    }

    public function customerOrdersToDatabase(array $customerOrders): void
    {
        foreach ($customerOrders as $key => $value) {
            $orders = new CartOperations();
            $orders->customerOrders($value);
        }
    }
}