<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Client extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'phone', 'address', 'user_id','city'];

    public function transactions(): HasMany
    {
        return $this->hasMany(Transaction::class);
    }

    public function repairs()
    {
        return $this->hasMany(Repair::class, 'id_cliente');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
