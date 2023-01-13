CREATE TABLE customer_product(
    id INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    customer_name VARCHAR(100) NOT NULL,
    product_id INT NOT NULL
);

ALTER TABLE customer_product ADD FOREIGN KEY (id) REFERENCES products(id);
ALTER TABLE customer_product ADD FOREIGN KEY (id) REFERENCES customerOrders(id);