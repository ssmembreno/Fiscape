<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Accounts extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'name',
        'user_id',
        'type',
        'balance',
        'initial_balance',
        'currency',
        'description',
        'status',
    ];

    public function Users(){
        return $this->hasMany(User::class);
    }

}
