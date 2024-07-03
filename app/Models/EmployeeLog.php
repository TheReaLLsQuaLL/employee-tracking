<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;
class EmployeeLog extends Model
{
    use HasFactory;

    // Set fillables
    protected $fillable = [
        'start',
        'end',
        'projects_id',
        'users_id'
    ];

    // set "end" as nullable in model
    protected $attributes = [
        'end' => null,
    ];

    public function users(){
        return $this->belongsTo(User::class);
    }
    public function projects(){
        return $this->belongsTo(Project::class);
    }

}
