<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Laravel\Scout\Searchable;

class Mascota extends Model
{
    use Searchable;

    protected $fillable = [
        'dueno_id',
        'nombre',
        'especie',
        'raza',
        'fecha_nacimiento',
        'tipo_sangre',
        'comportamiento',
        'es_adoptado',
        'alergias',
        'lesiones',
        'patologicos',
        'historial_alimentacion',
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

    public function toSearchableArray()
    {
        return [
            'id' => $this->id,
            'nombre' => $this->nombre,
            'dueno_nombre' => $this->dueno ? $this->dueno->nombre_completo : '',
        ];
    }
}
