<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

use App\Models\mybudget_category;
use App\Models\mybudget_item;
use App\Models\mybudget_source;

class mybudget_item extends Model
{
    use HasFactory;
    use SoftDeletes;

    public function category()
    {
        return $this->belongsTo(mybudget_category::class);
    }

    public function section()
    {
        return $this->belongsTo(mybudget_section::class);
    }

    public function source()
    {
        return $this->belongsTo(mybudget_source::class);
    }

    protected $table = "mybudget_item";
}
