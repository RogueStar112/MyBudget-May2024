<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

use App\Models\MyBudgetCategory;
use App\Models\MyBudgetSource;

class MyBudgetItem extends Model
{
    use HasFactory;
    use SoftDeletes;

    public function category()
    {
        return $this->belongsTo(MyBudgetCategory::class);
    }

    public function section()
    {
        return $this->belongsTo(MyBudgetSection::class);
    }

    public function source()
    {
        return $this->belongsTo(MyBudgetSource::class);
    }

    protected $table = "mybudget_item";
}
