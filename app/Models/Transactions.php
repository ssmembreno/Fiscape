<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Categories;
use Illuminate\Database\Eloquent\SoftDeletes;

class Transactions extends Model
{
    const TYPE_INGRESO = 1;
    const TYPE_GASTO = 2;

    use HasFactory;
    use SoftDeletes;
    
    protected $fillable = [
        'user_id',
        'category_id',
        'type', // ingreso o gasto
        'amount',
        'date',
        'description'
    ];

    public function user()
        {
        return $this->belongsTo(User::class);
    }

    /**
     * Relación: una transacción pertenece a una categoría.
     */
    public function category()
    {
        return $this->belongsTo(Categories::class);
    }

}
