<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\User;

class MyBudgetSource extends Model
{
    use HasFactory;

    protected $table = "mybudget_source";
    
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
