<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Income extends Model
{
    protected $guarded = [];
    public function category()
    {
        return $this->belongsTo(IncomeCategory::class, 'income_category_id');
    }

    public function project()
    {
        return $this->belongsTo(Project::class);
    }
}
