<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SolicitudCertificado extends Model
{
    //

    protected $table = 'solicitudes_certificado';
    protected $primaryKey = 'id';
    protected $fillable = [
        'uuid',
        'ciudadano_id',
        'tiempo_residencia',
        'fecha_emision_certificado',
        'tipo_solicitud',
        'tipo_certificado',
        'estado',
        'requisito',
        'plantilla_certificado',
        'informacion_adicional'
    ];
    protected $casts = [
        'informacion_adicional' => 'array',
    ];
    public function ciudadano()
    {
        return $this->belongsTo(Ciudadano::class, 'ciudadano_id');
    }
}
