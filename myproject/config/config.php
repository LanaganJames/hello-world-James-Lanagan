<?php
return [
    'db' => [
        'host' => '127.0.0.1',
        'port' => 3306,
        'name' => 'shopdb',
        'user' => 'root',
        'pass' => '',
        'charset' => 'utf8mb4',
    ],
    'tax_rate' => 0.05,  // 5%
    'ship_rate' => 0.10, // 10% of pre-tax subtotal
	'base_path' => '/PHP_Project/public', // <- add from the base
];