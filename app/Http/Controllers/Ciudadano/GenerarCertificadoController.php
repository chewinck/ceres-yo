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

        var_dump($request->all());
        die();
        $certificadoDto = new CertificadoDto(
            tipo: $request->tipoCertificado,
            categoria: $request->categoriaCertificado,
            requiereFormulario: ConfigCertificadoService::obtenerRequiereFormulario($request->tipo, $request->categoria),
            plantilla: ConfigCertificadoService::obtenerPlantillaCertificado($request->tipo, $request->categoria),
            documentos: ConfigCertificadoService::obtenerDocumentos($request->tipo, $request->categoria)
        );

        $generarCertificadoUseCase = new GenerarCertificadoUseCase( $certificadoDto);

        $resp = $generarCertificadoUseCase->execute();

        return $resp;

    }

    public function solicitar()
    {
        return view('certificate.solicitar');
    }

}