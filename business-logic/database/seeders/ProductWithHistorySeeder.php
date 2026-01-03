<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Carbon\Carbon;

class ProductWithHistorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. Define Products
        $productsData = [
            ['id' => 1, 'name' => 'Kopi Robusta Premium', 'price' => 45000],
            ['id' => 2, 'name' => 'Kopi Arabika Gayo', 'price' => 55000],
            ['id' => 3, 'name' => 'Teh Hijau Pekoe', 'price' => 30000],
            ['id' => 4, 'name' => 'Coklat Bubuk Dark', 'price' => 35000],
            ['id' => 5, 'name' => 'Sirup 20 Caramel', 'price' => 85000],
            ['id' => 6, 'name' => 'Susu UHT Full Cream', 'price' => 18000],
            ['id' => 7, 'name' => 'Gula Aren Cair', 'price' => 25000],
            ['id' => 8, 'name' => 'Creamer Powder', 'price' => 40000],
            ['id' => 9, 'name' => 'Cup Plastik 14oz', 'price' => 500],
            ['id' => 10, 'name' => 'Sedotan Steril', 'price' => 200],
        ];

        // 2. Clear Tables
        // Move outside transaction to avoid implicit commit issues with TRUNCATE
        Schema::disableForeignKeyConstraints();
        DB::table('sales_items')->truncate();
        DB::table('sales')->truncate();
        Schema::enableForeignKeyConstraints();

        DB::transaction(function () use ($productsData) {

            $productIds = [];
            foreach ($productsData as $prod) {
                DB::table('products')->updateOrInsert(
                    ['id' => $prod['id']],
                    [
                        'name'       => $prod['name'],
                        'price'      => $prod['price'],
                        'stock'      => rand(100, 500),
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]
                );
                $productIds[] = $prod['id'];
            }

            // 3. Generate History (Transaction-based)
            // Loop 30 Days
            $days = 30;
            for ($i = $days; $i >= 1; $i--) {
                $date = Carbon::now()->subDays($i)->startOfDay()->addHours(rand(8, 20)); // Random hour (8am-8pm)
                
                // Transactions per Day (e.g. 3 to 8 transactions)
                $transactionCount = rand(3, 8); 

                for ($t = 0; $t < $transactionCount; $t++) {
                    // Time adjustment for each transaction
                    $txDate = $date->copy()->addMinutes(rand(10, 300));

                    // Basket Size: 1 to 3 distinct items
                    $basketSize = rand(1, 3);
                    
                    // Pick random products for this basket
                    $pickedKeys = array_rand($productsData, $basketSize);
                    if (!is_array($pickedKeys)) $pickedKeys = [$pickedKeys];
                    
                    $totalAmount = 0;
                    $saleItems = [];

                    foreach ($pickedKeys as $key) {
                        $prod = $productsData[$key];
                        // Quantity per item: 1 to 5 (Realistic order)
                        $qty = rand(1, 5); 
                        $lineTotal = $prod['price'] * $qty;
                        $totalAmount += $lineTotal;

                        $saleItems[] = [
                            'product_id' => $prod['id'],
                            'quantity'   => $qty,
                            'price'      => $prod['price'],
                            'total'      => $lineTotal,
                        ];
                    }

                    // Insert Header
                    $saleId = DB::table('sales')->insertGetId([
                        'user_id'      => 1,
                        'sale_date'    => $txDate,
                        'total_amount' => $totalAmount,
                        'created_at'   => $txDate,
                        'updated_at'   => $txDate,
                    ]);

                    // Insert Items
                    foreach ($saleItems as $item) {
                        DB::table('sales_items')->insert([
                            'sale_id'    => $saleId,
                            'product_id' => $item['product_id'],
                            'quantity'   => $item['quantity'],
                            'price'      => $item['price'],
                            'total'      => $item['total'],
                            'created_at' => $txDate, 
                            'updated_at' => $txDate,
                        ]);
                    }
                }
            }
        });
    }
}
