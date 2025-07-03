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
        // $inputs = $request->validated();

        $configuracionCertificado = ConfigCertificadoService::obtenerConfiguracionCertificado(
            $request->categoriaCertificado,
            $request->tipoCertificado
        );

        $certificadoDto = new CertificadoDto(
            tipo: $request->tipoCertificado,
            categoria: $request->categoriaCertificado,
            requiereFormulario: $configuracionCertificado['requiere_formulario'],
            plantilla: $configuracionCertificado['plantilla'],
            documentos: $configuracionCertificado['documentos'],
        );

        $generarCertificadoUseCase = new GenerarCertificadoUseCase();
        $contenidoPdf= $generarCertificadoUseCase->execute($certificadoDto);

         return response($contenidoPdf)
        ->header('Content-Type', 'application/pdf')
        ->header('Content-Disposition', 'inline; filename="certificado.pdf"')
        ->header('Content-Length', strlen($contenidoPdf));
    }

    public function solicitar()
    {
        return view('certificate.solicitar');
    }

}