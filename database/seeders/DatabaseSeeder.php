<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Contact;
use App\Models\Warehouse;
use Illuminate\Database\Seeder;
use Database\Seeders\AccountSeeder;
use Database\Seeders\ChartOfAccountSeeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();
        $this->call([
            AccountSeeder::class,
            ChartOfAccountSeeder::class
        ]);

        Warehouse::create([
            'code' => 'HQT',
            'name' => 'HEADQUARTER',
            'address' => 'Bandung, Jawa Barat, ID, 40375',
            'chart_of_account_id' => 1
        ]);

        Contact::create([
            'name' => 'General',
            'type' => 'Customer',
            'Description' => 'General Customer',
        ]);

        User::create([
            'name' => 'Admin',
            'email' => 'admin@jour.com',
            'password' => bcrypt('admin123'),
            'role' => 'Administrator',
            'warehouse_id' => 1
        ]);

        User::create([
            'name' => 'fend',
            'email' => 'fend@jour.com',
            'password' => bcrypt('user123'),
            'role' => 'Administrator',
            'warehouse_id' => 1
        ]);
    }
}
