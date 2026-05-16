<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'rol',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function veterinario()
    {
        return $this->hasOne(Veterinario::class, 'usuario_id');
    }

    /**
     * Verifica si el usuario tiene datos vinculados que impidan su eliminación
     */
    public function hasRestrictedDependencies(): bool
    {
        // Aquí puedes agregar futuras relaciones. Ejemplo:
        // return $this->citas()->exists() || $this->mascotas()->exists();
        
        // La tabla veterinarios se elimina en cascada automáticamente en BD,
        // por lo que actualmente no hay dependencias restrictivas.
        return false;
    }
}
