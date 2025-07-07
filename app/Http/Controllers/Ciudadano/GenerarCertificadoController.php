<?php

Namespace App\Http\Controllers\Ciudadano;


use App\Http\Controllers\Controller;
use Src\ciudadano\infrastructure\service\ConfigCertificadoService;
use Src\ciudadano\view\dto\CertificadoDto;
use Src\ciudadano\usecase\GenerarCertificadoUseCase;
use App\Http\Requests\GenerarCertificadoFormRequest;
use Src\ciudadano\usecase\BuscarCertificadoPorUuiduseCase;
use Src\ciudadano\dao\eloquent\EloquentCertificadoRepository;
use Src\ciudadano\infrastructure\service\GenerarCertificadoService;
use Illuminate\Http\Request;

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
            dominio: $request->dominio ?? $request->getHttpHost(),
            // requiereFormulario: $configuracionCertificado['requiere_formulario'],
            // plantilla: $configuracionCertificado['plantilla'],
            // documentos: $configuracionCertificado['documentos'],
        );

        $generarCertificadoUseCase = new GenerarCertificadoUseCase();
        $contenidoPdf= $generarCertificadoUseCase->execute($certificadoDto);

        if ($contenidoPdf->getCode() != 200) {
            return redirect()->back()->withErrors(['tipoCertificado' => $contenidoPdf->getMessage()])->withInput();
        }


         return response($contenidoPdf->getData())
        ->header('Content-Type', 'application/pdf')
        ->header('Content-Disposition', 'inline; filename="certificado.pdf"')
        ->header('Content-Length', strlen($contenidoPdf->getData()));
    }

    public function solicitar()
    {
        return view('certificate.solicitar');
    }

    public function buscarPorUuid(string $uuid)
    {
        $buscarCertificadoPorUuidUseCase = new BuscarCertificadoPorUuiduseCase(
            new EloquentCertificadoRepository(), new GenerarCertificadoService()
        );

        $response = $buscarCertificadoPorUuidUseCase->execute($uuid);

        if (!$response->esExitoso()) {
            return redirect()->back()->withErrors(['uuid' => $response->mensajeError])->withInput();
        }

        return response($response->contenidoPdf)
            ->header('Content-Type', 'application/pdf')
            ->header('Content-Disposition', 'inline; filename="certificado.pdf"');
    }

}