<?php

use App\Models\Inventory;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;

class MigrateInitialData extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $users = $this->toAssociativeArray(storage_path('app/dumps/users.csv'));
        $products = $this->toAssociativeArray(storage_path('app/dumps/products.csv'));
        $inventories = $this->toAssociativeArray(storage_path('app/dumps/inventory.csv'));
        $orders = $this->toAssociativeArray(storage_path('app/dumps/orders.csv'));

        $users = array_map(function($user) {
            return array_merge(Arr::except($user, [
                'password_hash',
                'password_plain'
            ]), [
                'password' => $user['password_hash']
            ]);
        }, $users);
    try {
        DB::transaction(function () use ($users, $products, $inventories, $orders) {
            foreach(array_chunk($users, 500) as $chunk) {
                User::insert($chunk);
            }
            foreach (array_chunk($products, 500) as $chunk) {
                Product::insert($chunk);
            }
            foreach (array_chunk($inventories, 500) as $chunk) {
                Inventory::insert($chunk);
            }
            foreach (array_chunk($orders, 500) as $chunk) {
                Order::insert($chunk);
            }
        });
    }
        catch(\Exception $e) {
            dump($e->getMessage());
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::statement("SET foreign_key_checks=0");
        User::truncate();
        Product::truncate();
        Inventory::truncate();
        Order::truncate();
        DB::statement("SET foreign_key_checks=1");
    }

    private function toAssociativeArray($file): array {
        if(!file_exists($file)) {
            throw new \Exception("File $file does not exist!");
        }
        $rows = array_map('str_getcsv', file($file));
        $header = array_shift($rows);
        $csv = array();
        foreach($rows as $row) {
            foreach($row as $key=>$column) {
                if(strtolower($column) === 'null') {
                    $row[$key] = null;
                }
            }
            $csv[] = array_combine($header, $row);
        }
        return $csv;
    }
}
