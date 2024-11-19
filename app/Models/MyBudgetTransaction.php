<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MyBudgetTransaction extends Model
{
    use HasFactory;

    protected $table = 'mybudget_transaction';
}
