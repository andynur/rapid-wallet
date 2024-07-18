<?php

namespace Database\Seeders;

use App\Constants\TransactionTypes;
use App\Models\Transaction;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TransactionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = User::get(['id']);

        $order_id = 1;
        $statuses = [0, 1, 2];
        $types = [TransactionTypes::DEPOSIT, TransactionTypes::WITHDRAWAL];
        $amounts = [25000, 50000, 100000, 150000, 200000, 250000];

        foreach ($users as $user) {
            for ($i = 0; $i < 4; $i++) {
                Transaction::create([
                    'user_id' => $user->id,
                    'order_id' => 'ORD' . str_pad($order_id, 5, '0', STR_PAD_LEFT),
                    'amount' => $amounts[array_rand([0, 5])],
                    'timestamp' => Carbon::now()->subDays(rand(0, 30))->format('Y-m-d H:i:s'),
                    'type' => $types[array_rand($types)],
                    'status' => $statuses[array_rand($statuses)],
                ]);

                $order_id++;
            }
        }
    }
}
