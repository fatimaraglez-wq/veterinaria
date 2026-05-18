<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Dueno extends Model
{
    protected $fillable = [
        'nombre_completo',
        'telefono',
        'direccion',
        'email',
    ];

    public function mascotas()
    {
        return $this->hasMany(Mascota::class, 'dueno_id');
    }
}
