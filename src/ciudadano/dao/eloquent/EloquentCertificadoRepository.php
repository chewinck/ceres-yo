<?php

namespace Src\Ciudadano\dao\eloquent;

use Src\ciudadano\domain\RepositoryCertificado;
use Src\ciudadano\view\dto\CertificadoDto;
use App\Models\SolicitudCertificado;
use Src\ciudadano\view\dto\CiudadanoDto;
use Src\ciudadano\view\dto\GuardarCertificadoResponseDto;
use Src\ciudadano\view\dto\ConfigBaseCertificadoDto;
use Src\ciudadano\view\dto\ResponseCertificateDto;
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

public function buscarPorUuid(string $uuid): ?ResponseCertificateDto
{
    // $registro = SolicitudCertificado::with('ciudadano.user')->where('uuid', $uuid)->first();
    $registro = SolicitudCertificado::where('uuid', $uuid)->first();

    if (!$registro) {
        Sentry::captureMessage('Certificado no encontrado para el UUID: ' . $uuid);
        return new ResponseCertificateDto(null, 'Certificado no encontrado', null);
    }

    $info = $registro->informacion_adicional ?? null;
    $ciudadano = $info['ciudadano'] ?? null;
    $configuracion = $info['configuracion'] ?? null;

    if (!$info || !$ciudadano || !$configuracion) {
        Sentry::captureMessage('Información incompleta para el certificado con UUID: ' . $uuid);
        return new ResponseCertificateDto(null, 'Información incompleta para el certificado', null);
    }

    $ciudadano = new CiudadanoDto(
        $ciudadano['nombreCiudadano'],
        $ciudadano['idCiudadano'],
        $ciudadano['numeroIdentificacion'],
        $ciudadano['lugarExpedicion'],
        $ciudadano['aniosResidencia'],
        $ciudadano['mesesResidencia'],
        $ciudadano['diasResidencia'],
        $ciudadano['direccionResidencia'],
        $ciudadano['barrioResidencia']
    );

    $configuracion = new ConfigBaseCertificadoDto(
        $configuracion['uuid'],
        $configuracion['codigoComunicacion'],
        $configuracion['numeroDecreto'],
        $configuracion['firmaSecretario'],
        $configuracion['nombreSecretario'],
        $configuracion['nombreElaborador'],
        $configuracion['cargoElaborador'],
        $configuracion['diaCertificado'],
        $configuracion['mesCertificado'],
        $configuracion['anioCertificado']
    );

    $certificadoDto = new CertificadoDto(
        $registro->tipo_certificado,
        $registro->tipo_solicitud,
        $registro->dominio ?? 'http://localhost:8081',
        // false,
        // $registro->plantilla_certificado,
        // null,s
        $configuracion,
        $ciudadano
    );

    return new ResponseCertificateDto(
        $certificadoDto,
        null,
        null
    );
}
}