<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Mascota extends Model
{
    protected $fillable = [
        'dueno_id',
        'nombre',
        'especie',
        'raza',
        'fecha_nacimiento',
        'tipo_sangre',
        'comportamiento',
        'es_adoptado',
    ];

    protected $casts = [
        'es_adoptado' => 'boolean',
        'fecha_nacimiento' => 'date',
    ];

    public function dueno()
    {
        return $this->belongsTo(Dueno::class, 'dueno_id');
    }

    public function consultas()
    {
        return $this->hasMany(Consulta::class);
    }
}
