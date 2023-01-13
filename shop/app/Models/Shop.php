<?php
declare(strict_types = 1);

require_once __DIR__.'/../../core/Connections.php';
require_once __DIR__.'/../../app/Traits/UploadFiles.php';
require_once __DIR__.'/../../app/Interfaces/ShopInterface.php';

class Shop extends Connections implements ShopInterface
{
    public string $products = 'products';
    public string $orders = 'orders';
    public string $users = 'users';

    public function getAll(): bool|array
    {
        return $this->connection->query("SELECT * FROM {$this->products}")
            ->fetchAll(PDO::FETCH_ASSOC);
    }

    public function get($id): array|bool
    {
        $sql = "SELECT * FROM {$this->products} WHERE id = ?";
        $statement = $this->connection->prepare($sql);
        $statement->execute([$id]);
        return $statement->fetch(PDO::FETCH_ASSOC);
    }

    public function create(array $data): void
    {
        $sql = "INSERT INTO {$this->products} (
                     product_name,
                     price,
                     description,
                     quantity,
                     image
                     )
                VALUES (
                     :product_name,
                     :price,
                     :description,
                     :quantity,
                     :image)";

        $statement = $this->connection->prepare($sql);
        $statement->execute($data);
    }

    public function update(array $data = []): void
    {
        $sql = "UPDATE
                    {$this->products}
                SET
                   product_name = :product_name,
                   price = :price,
                   description = :description,
                   quantity = :quantity,
                   image = :image
               WHERE id = :id";

        $statement = $this->connection->prepare($sql);
        $statement->execute($data);
    }

    public function delete($id): void
    {
        $sql = "
        DELETE FROM {$this->products}
        WHERE id = ?";

        $statement = $this->connection->prepare($sql);
        $statement->execute([$id]);
    }

    public function deleteCartItem($id): void
    {
        $sql = "
        DELETE FROM {$this->orders}
        WHERE id = ?";

        $statement = $this->connection->prepare($sql);
        $statement->execute([$id]);
    }

    public function subtractFromStock(array $customerOrders): void
    {
        $stock = $this->getAll();
        foreach ($stock as $key => $stockValue) {
            foreach ($customerOrders as $subKey => $value) {
                if($value['product_id'] === $stockValue['id']){
                    $stock[$key]['quantity'] = $stockValue['quantity'] - $value['quantity'];
                    unset($stock[$key]['created_at']);
                    unset($stock[$key]['updated_at']);
                    unset($stock[$key]['deleted_at']);
                }
            }
        }

        $sql = "UPDATE
                    {$this->products}
                SET
                   product_name = :product_name,
                   price = :price,
                   description = :description,
                   quantity = :quantity,
                   image = :image
               WHERE id = :id";

        $statement = $this->connection->prepare($sql);
        foreach ($stock as $key => $value) {
            if(!isset($value['created_at'])){
                $statement->execute($value);
            }
        }
    }
}