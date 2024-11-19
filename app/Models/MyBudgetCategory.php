<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\MyBudgetSection;
use App\Models\User;



class MyBudgetCategory extends Model
{
    use HasFactory;

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function sections()  {
        return $this->hasMany(MyBudgetSection::class);
    }

    protected $table = 'mybudget_category';
}

