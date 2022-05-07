<?php

namespace Test\Service;

use PHPUnit\Framework\TestCase;
use App\Service\ProductHandler;

/**
 * Class ProductHandlerTest
 */
class ProductHandlerTest extends TestCase
{
    private $products = [
        [
            'id' => 1,
            'name' => 'Coca-cola',
            'type' => 'Drinks',
            'price' => 10,
            'create_at' => '2021-04-20 10:00:00',
        ],
        [
            'id' => 2,
            'name' => 'Persi',
            'type' => 'Drinks',
            'price' => 5,
            'create_at' => '2021-04-21 09:00:00',
        ],
        [
            'id' => 3,
            'name' => 'Ham Sandwich',
            'type' => 'Sandwich',
            'price' => 45,
            'create_at' => '2021-04-20 19:00:00',
        ],
        [
            'id' => 4,
            'name' => 'Cup cake',
            'type' => 'Dessert',
            'price' => 35,
            'create_at' => '2021-04-18 08:45:00',
        ],
        [
            'id' => 5,
            'name' => 'New York Cheese Cake',
            'type' => 'Dessert',
            'price' => 40,
            'create_at' => '2021-04-19 14:38:00',
        ],
        [
            'id' => 6,
            'name' => 'Lemon Tea',
            'type' => 'Drinks',
            'price' => 8,
            'create_at' => '2021-04-04 19:23:00',
        ],
    ];

    public function testGetTotalPrice()
    {
        $totalPrice = 0;
        foreach ($this->products as $product) {
            $price = $product['price'] ?: 0;
            $totalPrice += $price;
        }

        $this->assertEquals(143, $totalPrice);
    }

    //计算商品总金额
    public function testGetProductTotalPrice()
    {
        $totalPrice = array_sum(array_column($this->products, 'price'));

        $this->assertEquals(143, $totalPrice);
    }

    //把商品以金額排序（由大至小），並篩選商品類種是 “dessert” 的商品
    public function testSortProductByPrice()
    {
        $expected = [
            [
                'id' => 5,
                'name' => 'New York Cheese Cake',
                'type' => 'Dessert',
                'price' => 40,
                'create_at' => '2021-04-19 14:38:00',
            ],
            [
                'id' => 4,
                'name' => 'Cup cake',
                'type' => 'Dessert',
                'price' => 35,
                'create_at' => '2021-04-18 08:45:00',
            ],
        ];

        $products = $this->products;

        array_multisort(array_column($products, 'price'), SORT_DESC, $products);

        $products = array_values(array_filter($products, function ($product)
        {
            return $product['type'] == 'Dessert';
        }));

        $this->assertEquals($expected, $products);
    }

    //把創建日期轉換為 unix timestamp
    public function testChangeCreateAtToTimeStamp()
    {
        $expected = [
            [
                'id' => 1,
                'name' => 'Coca-cola',
                'type' => 'Drinks',
                'price' => 10,
                'create_at' => 1618912800,
            ],
            [
                'id' => 2,
                'name' => 'Persi',
                'type' => 'Drinks',
                'price' => 5,
                'create_at' => 1618995600,
            ],
            [
                'id' => 3,
                'name' => 'Ham Sandwich',
                'type' => 'Sandwich',
                'price' => 45,
                'create_at' => 1618945200,
            ],
            [
                'id' => 4,
                'name' => 'Cup cake',
                'type' => 'Dessert',
                'price' => 35,
                'create_at' => 1618735500,
            ],
            [
                'id' => 5,
                'name' => 'New York Cheese Cake',
                'type' => 'Dessert',
                'price' => 40,
                'create_at' => 1618843080,
            ],
            [
                'id' => 6,
                'name' => 'Lemon Tea',
                'type' => 'Drinks',
                'price' => 8,
                'create_at' => 1617564180,
            ],
        ];

        $products = array_map(function ($item)
        {
            $item['create_at'] = strtotime($item['create_at']);
            return $item;
        }, $this->products);

        $this->assertEquals($expected, $products);
    }
}