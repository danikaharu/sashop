<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Customer;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        \App\Models\User::factory()->create([
            'name' => 'admin',
            'email' => 'admin@example.com',
            'password' => bcrypt('12345'),
            'isAdmin' => true,
            'isOwner' => false
        ]);
        User::create([
            'name' => 'owner',
            'email' => 'owner@example.com',
            'password' => bcrypt('12345'),
            'isAdmin' => false,
            'isOwner' => true
        ]);
        $customer = User::create([
            'name' => 'user',
            'email' => 'user@example.com',
            'password' => bcrypt('12345'),
            'isAdmin' => false,
            'isOwner' => false
        ]);

        Customer::create([
            'user_id' => $customer->id,
            'phone' => '0808080',
            'address' => 'jln inini',
        ]);
    }
}
