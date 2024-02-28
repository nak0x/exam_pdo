<?php

namespace Model;

use PDO;

class ProductRepository
{

    public PDO $productRepository;

    public function __construct()
    {

        $this->productRepository = new PDO(
            'mysql:host=localhost;dbname=examenpdo',
            'root',
            ""
        );
    }

    public function save(Product $product):void{

        // If product update If no product save
        if(array_key_exists('id', $product)){
            $productId = $fetchProduct['id'];
            $query = $this->productRepository->prepare("
                UPDATE products
                SET name = \":name\", description = \":description\", price = \":price\"
                WHERE id = $productId");
        }else{

            $query = $this->productRepository->prepare("
             
             INSERT INTO products (name, description, price)
             VALUES (:name, :description, :price)
            ");

        }

        $query->execute([
            "name" => $product->name,
            "description" => $product->description,
            "price" => $product->price
        ]);

    }

    private function transformRawDataToProduct(array $data): Product{
        return new Product($data["name"], $data["description"], $data["price"], $data["id"]);
    }

    public function getAll(): array
    {
        $query = $this->productRepository->prepare("SELECT * FROM products");
        $query->execute();

        // Fetch assoc pour n'avoir que les association et pas les index de col
        return array_map(call_user_func(array($this, 'transformRawDataToProduct')), $query->fetchAll(PDO::FETCH_ASSOC));
    }

    public function getById(int $id): Product{
        $query = $this->productRepository->prepare("SELECT * FROM products WHERE products.id = :id");
        $query->execute([
            "id" => $id
        ]);

        return $this->transformRawDataToProduct($query->fetch());
    }

}