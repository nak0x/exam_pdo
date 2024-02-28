<?php

function psr4_autoloader($class): void{
    // On retire le Rpg\ par défaut
    $prefix = 'Rpg\\';

    if(str_starts_with($class, $prefix)){
        $classPath = str_replace($prefix, '', $class);
        // On remplace les \ par des /
        $classPath = str_replace('\\', '/', $classPath);

        // Transformation de la classe en chemin relatif
        $file = __DIR__ . '/' . $classPath . '.php';

        if(file_exists($file)){
            require $file;
        }
    }

}

spl_autoload_register('psr4_autoloader');

// TEST

$productRepo = new \Model\ProductRepository();

$pain = new \Model\Product("Pain", "C'est chaud est bon", 1.5);

$productRepo->save($pain);

$products = $productRepo->getAll();

var_dump($products);

$products[0]->name = "Pain au levin";

$productRepo ->save($products[0]);

var_dump($productRepo->getAll());