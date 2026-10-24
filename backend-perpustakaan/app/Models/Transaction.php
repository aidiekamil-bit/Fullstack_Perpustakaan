<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    // Tambahkan baris ini untuk mengizinkan mass assignment
    protected $fillable = [
        'borrower_name',
        'phone_number',
        'due_date',
    ];

    public function details()
    {
        return $this->hasMany(TransactionDetail::class);
    }
}