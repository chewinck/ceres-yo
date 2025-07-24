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
use Src\ciudadano\view\dto\PPLDto;

class GenerarCertificadoController extends Controller
{

    public function generar(GenerarCertificadoFormRequest $request)
    {
        // $inputs = $request->validated();

        $pplDto = null;

        if ($request->tipoCertificado == 'PPL'){
            $pplDto =  new PPLDto(
                nombrePPL: $request->nombrePPL ?? '',
                tipoDocumentoPPL: $request->tipoDocumentoPPL ?? '',
                numeroDocumentoPPL: $request->numeroDocumentoPPL ?? '',
                numeroExpedientePPL: $request->numeroExpedientePPL ?? '',
                nombreJuzgado: $request->nombreJuzgado ?? ''
            );
        }

        $certificadoDto = new CertificadoDto(
            tipo: $request->tipoCertificado,
            categoria: $request->categoriaCertificado,
            dominio: $request->dominio ?? $request->getHttpHost(),
            ppl: $pplDto,
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

    public function buscarPorUuid(Request $request , string $uuid)
    {
        $request->merge(['uuid' => $uuid]);
        $request->validate([
            'uuid' => ['required', 'string', 'regex:/^[a-zA-Z0-9\-]+$/'],
        ]);
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