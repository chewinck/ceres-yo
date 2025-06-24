<?php

Namespace App\Http\Controllers\Ciudadano;


use App\Http\Controllers\Controller;
use Src\ciudadano\infrastructure\service\ConfigCertificadoService;
use Src\ciudadano\view\dto\CertificadoDto;
use Src\ciudadano\usecase\GenerarCertificadoUseCase;
use App\Http\Requests\GenerarCertificadoFormRequest;

class GenerarCertificadoController extends Controller
{


    public function generar(GenerarCertificadoFormRequest $request)
    {
        $certificadoDto = new CertificadoDto(
            tipo: $request->tipo,
            categoria: $request->categoria,
            requiereFormulario: ConfigCertificadoService::obtenerRequiereFormulario($request->tipo, $request->categoria),
            plantilla: ConfigCertificadoService::obtenerPlantillaCertificado($request->tipo, $request->categoria),
            documentos: ConfigCertificadoService::obtenerDocumentos($request->tipo, $request->categoria)
        );

        $generarCertificadoUseCase = new GenerarCertificadoUseCase( $certificadoDto);

        $resp = $generarCertificadoUseCase->execute();

        return response()->json([
            "response" => [
                "code" => $resp->getCode(),
                "message" => $resp->getMessage(),
                "data" => $resp->getData()
            ]
        ], $resp->getCode());

    }
}