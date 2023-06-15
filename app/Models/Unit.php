<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Unit extends Model
{
    use HasFactory;

    public function department()
    {
        return $this->belongsTo(Department::class);
    }

    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }

    public function employees()
    {
        return $this->hasMany(Employee::class);
    }
}
