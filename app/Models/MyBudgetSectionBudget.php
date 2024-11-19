<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MyBudgetSectionBudget extends Model
{
    use HasFactory;

    protected $table = 'mybudget_sectionbudget';

    public $timestamps = false;

    protected $fillable = ['date_start', 'date_end', 'budget', 'category_id', 'section_id'];
}
