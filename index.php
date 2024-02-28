<?php

require './Model/Product.php';
require './Model/ProductRepository.php';

// TEST

$productRepo = new ProductRepository();

$pain = new Product("Pain", "C'est chaud est bon", 1.5);

$productRepo->save($pain);

$products = $productRepo->getAll();

?>
<pre><?php var_dump($products); ?></pre>

<?php
$products[0]->name = "Pain au levin";

$productRepo ->save($products[0]);

?>
<pre><?php var_dump($productRepo->getAll()); ?></pre>