<?php

class ProductRepository
{

    public PDO $productRepository;

    public function __construct()
    {

        $this->productRepository = new PDO(
            'mysql:host=localhost;dbname=theoPDO',
            'gab',
            "motdepasse"
        );
    }

    public function save(Product $product):void{

        // If product update If no product save
        if($product->id !== NULL){
            $productId = $product->id;
            $query = $this->productRepository->prepare("
                UPDATE products
                SET name = :name, description = :description, price = :price
                WHERE id = $productId
            ");
        } else {

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

        $data = $query->fetchAll(PDO::FETCH_ASSOC);
        // Fetch assoc pour n'avoir que les association et pas les index de col
        return array_map(array($this, 'transformRawDataToProduct'), $data);
    }

    public function getById(int $id): Product{
        $query = $this->productRepository->prepare("SELECT * FROM products WHERE products.id = :id");
        $query->execute([
            "id" => $id
        ]);

        return $this->transformRawDataToProduct($query->fetch());
    }

}