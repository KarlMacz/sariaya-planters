<?php

use Illuminate\Database\Seeder;

use App\Product;
use App\User;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $products = collect([
            [
                'seller_id' => User::all()->random()->id,
                'name' => 'Product 1',
                'description' => null,
                'quantity' => 50,
                'price' => 10.00,
                'discount' => 10
            ],
            [
                'seller_id' => User::all()->random()->id,
                'name' => 'Product 2',
                'description' => null,
                'quantity' => 100,
                'price' => 11.00,
                'discount' => 0
            ],
            [
                'seller_id' => User::all()->random()->id,
                'name' => 'Product 3',
                'description' => null,
                'quantity' => 150,
                'price' => 12.00,
                'discount' => 0
            ],
            [
                'seller_id' => User::all()->random()->id,
                'name' => 'Product 4',
                'description' => null,
                'quantity' => 100,
                'price' => 13.00,
                'discount' => 0
            ],
            [
                'seller_id' => User::all()->random()->id,
                'name' => 'Product 5',
                'description' => null,
                'quantity' => 50,
                'price' => 14.00,
                'discount' => 50
            ]
        ]);

        if($products->count() > 0) {
            foreach($products as $product) {
                $new_product = new Product;

                foreach($product as $key => $value) {
                    $new_product[$key] = $value;
                }

                $new_product->save();
            }
        }
    }
}
