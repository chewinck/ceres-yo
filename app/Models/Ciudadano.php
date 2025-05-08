<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ciudadano extends Model
{
    //

    protected $table = 'ciudadanos';
    protected $primaryKey = 'id';


    protected $fillable = [
        'nacionalidad',
        'tipo_identificacion',
        'numero_identificacion',
        'fecha_expedicion',
        'telefono',
        'tipo_direccion',
        'barrio',
        'direccion'
    ];

    public function solicitudes()
    {
        return $this->hasMany(SolicitudCertificado::class, 'ciudadano_id');
    }
    public function user()
    {
        return $this->belongsTo(User::class, 'id');
    }
}
