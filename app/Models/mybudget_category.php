<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\mybudget_section;
use App\Models\User;



class mybudget_category extends Model
{
    use HasFactory;

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function sections()  {
        return $this->hasMany(mybudget_section::class);
    }

    protected $table = 'mybudget_category';
}

