<?php

namespace App\Models;

use App\Models\Account;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Cashback extends Model
{
    protected $fillable = ['page', 'cashback', 'payment_delay', 'sale_date', 'sale_amount', 'cashback_rate', 'payment_status','first_item','row_id'];

    use HasFactory;

    /**
     * Get the account that owns the cashbacks.
     */
    public function account()
    {
        return $this->belongsTo(Account::class);
    }
}
