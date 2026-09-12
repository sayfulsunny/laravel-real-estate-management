<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Customer extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function projects()
    {
        return $this->belongsToMany(Project::class, 'investments') 
                    ->withPivot('amount')                           
                    ->withTimestamps();                             
    }
    
    public function investments()
    {
        return $this->hasMany(Investment::class);
    }
    
    public function installments()
    {
        return $this->hasMany(Installment::class);
    }


    
}
