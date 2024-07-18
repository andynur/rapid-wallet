<?php

namespace App\Models;

use App\Constants\TransactionStatus;
use App\Constants\TransactionTypes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Transaction extends Model
{
    use HasFactory, SoftDeletes;

    protected $touches = ['user'];
    protected $fillable = [
        'user_id',
        'order_id',
        'amount',
        'timestamp',
        'type',
        'status',
    ];

    public function getStatusAttribute($value)
    {
        return [
            TransactionStatus::ON_PROGRESS => 'on progress',
            TransactionStatus::SUCCESS => 'success',
            TransactionStatus::FAILED => 'failed',
        ][$value];
    }

    public function getTypeAttribute($value)
    {
        return [
            TransactionTypes::DEPOSIT => 'deposit',
            TransactionTypes::WITHDRAWAL => 'withdrawal',
        ][$value];
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
