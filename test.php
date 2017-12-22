<?php

use Lexty\Robokassa\Receipt;
use Lexty\Robokassa\ReceiptItem;

require_once __DIR__ . '/vendor/autoload.php';

$receipt = new Receipt(Receipt::SNO_OSN);

// $receiptItem = new ReceiptItem([
//     'name' => 'Подписка ozla на 6 месяцев.',
//     'quantity' => 5,
//     'sum' => 11970,
//     'tax' => ReceiptItem::TAX_VAT10,
// ]);

$receipt->addItem(new ReceiptItem([
    'name' => 'Подписка ozla на 6 месяцев.',
    'quantity' => 5,
    'sum' => 11970,
    'tax' => ReceiptItem::TAX_VAT18,
]))->addItem(new ReceiptItem([
    'name' => 'Подписка ozla на 3 месяця.',
    'quantity' => 15,
    'sum' => 17955,
    'tax' => ReceiptItem::TAX_VAT10,
]));

// echo $receiptItem;
// var_dump($receiptItem);


echo $receipt;