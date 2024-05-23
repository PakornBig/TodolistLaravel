<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;

    protected $table = 'tasks'; // Specify the correct table name
    protected $fillable = [
        'TASK',
        'CREATED_AT',
        'UPDATED_AT'
    ];
    protected $primaryKey = 'ID';
    public $timestamps = false;
}
