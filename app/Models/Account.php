<?php

namespace App\Models;

use App\Models\Cashback;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Account extends Model
{
    protected $fillable = ['name', 'token'];
    use HasFactory;

    /**
     * Get the cashbacks for the account.
     */
    public function cashbacks()
    {
        return $this->hasMany(Cashback::class);
    }
}
