<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Expense extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    public function category()
    {
        return $this->belongsTo(ExpenseCategory::class, 'expense_category_id');
    }

    public function entry()
    {
        return $this->hasOne(ExpenseEntry::class);
    }


    public function expenseCategory()
    {
        return $this->belongsTo(ExpenseCategory::class, 'expense_category_id'); 
    }

}
