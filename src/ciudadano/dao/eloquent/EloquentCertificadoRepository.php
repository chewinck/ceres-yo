<?php

namespace Src\Ciudadano\dao\eloquent;

use Src\ciudadano\domain\RepositoryCertificado;
use Src\ciudadano\view\dto\CertificadoDto;
use App\Models\SolicitudCertificado;
use Src\ciudadano\view\dto\GuardarCertificadoResponseDto;
use Sentry;
use Illuminate\Support\Facades\Log;

class EloquentCertificadoRepository implements RepositoryCertificado
{
    /**
     * @param string $tipo
     * @param string $numero
     * @return bool
     */
    public function guardarCertificado(CertificadoDto $certificadoDto): GuardarCertificadoResponseDto
    {

        try {
        $registro = SolicitudCertificado::create([
        'uuid' => $certificadoDto->configuracion->uuid, 
        'ciudadano_id' => $certificadoDto->ciudadano->idCiudadano,
        'tiempo_residencia' => $certificadoDto->ciudadano->aniosResidencia . ' años, ' .
            $certificadoDto->ciudadano->mesesResidencia . ' meses, ' .
            $certificadoDto->ciudadano->diasResidencia . ' días',
        'fecha_emision_certificado' => now(),
        'tipo_solicitud' => $certificadoDto->categoria,
        'tipo_certificado' => $certificadoDto->tipo,
        'estado' => 'exitosa',
        'requisito' => $certificadoDto->requisito ?? null,
        'plantilla_certificado' => $certificadoDto->tipo,
        'informacion_adicional' => $certificadoDto->toArray()
        ]);


        if (!$registro->id) {
            return new GuardarCertificadoResponseDto(false, null, 'Error al guardar el certificado, intente mas tarde.');
        }

        return new GuardarCertificadoResponseDto(true, $registro->id, null);

    } catch (\Exception $e) {
        Sentry ::captureException($e);
        \Log::error('Error al guardar el certificado: ' . $e->getMessage());
        return new GuardarCertificadoResponseDto(false, null, 'Error al guardar el certificado: ' . $e->getMessage());
    }
    }
}