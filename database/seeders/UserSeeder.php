<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Wallet;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = [
            [
                'name' => 'Test User',
                'email' => 'test@example.com',
                'password' => Hash::make('password123'),
            ],
            [
                'name' => 'Jane Smith',
                'email' => 'jane@example.com',
                'password' => Hash::make('password123'),
            ],
            [
                'name' => 'Alice Johnson',
                'email' => 'alice@example.com',
                'password' => Hash::make('password123'),
            ]
        ];

        $balances = [10000000, 5000000, 2500000];
        foreach ($users as $index => $userData) {
            $user = User::create($userData);
            if ($user->id === 1) {
                $user->assignRole('admin');
            } else {
                $user->assignRole('user');
            }

            $user->wallet()->create([
                'balance' => $balances[$index]
            ]);
        }
    }
}
