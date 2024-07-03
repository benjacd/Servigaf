<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Repair extends Model
{
    use HasFactory;

    // Agregar los campos que se pueden llenar masivamente
    protected $fillable = [
        'client_id',
        'product',
        'category',
        'repair_detail',
        'repair_date',
        'repair_accepted',
    ];

    // Definir las relaciones si las tienes
    public function client()
    {
        return $this->belongsTo(Client::class);
    }
}

