<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ExpenseEntry extends Model
{
    protected $guarded = [];

    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    public function expense()
    {
        return $this->belongsTo(Expense::class);
    }
}
