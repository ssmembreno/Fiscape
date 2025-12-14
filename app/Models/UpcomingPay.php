<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Accounts;
use App\Models\Categories;

class UpcomingPay extends Model
{
    use HasFactory;

    const PENDIENTE = 1;
    const PAGADO = 0;

    protected $fillable = [
        'user_id',
        'account_id',
        'category_id',
        'name',
        'amount',
        'due_date',
        'status',
        'transaction_id',
    ];

    protected $casts = [
        'status' => 'integer',
    ];

    public function account()
    {
        return $this->belongsTo(Accounts::class);
    }

    public function category()
    {
        return $this->belongsTo(Categories::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
