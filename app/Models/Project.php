<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function customers()
    {
        return $this->belongsToMany(Customer::class, 'investments') 
                    ->withPivot('amount')
                    ->withTimestamps();
    }


    
    public function expenses()
    {
        return $this->hasMany(Expense::class);
    }
    public function income()
    {
        return $this->hasMany(Income::class);
    }
    public function realExpenses()
    {
        return $this->hasMany(ExpenseEntry::class);
    }

}
