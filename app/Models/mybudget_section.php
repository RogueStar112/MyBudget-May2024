<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\User;
use App\Models\mybudget_category;

class mybudget_section extends Model
{
    use HasFactory;

    protected $table = "mybudget_section";
    
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function category()
    {
        return $this->belongsTo(mybudget_category::class);
    }
}
