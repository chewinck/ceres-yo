<?php

namespace Src\ciudadano\infrastructure\service;

use Illuminate\Support\Facades\Log;
use Src\ciudadano\view\dto\CertificadoDto;
use PhpOffice\PhpWord\TemplateProcessor;
use Barryvdh\Snappy\Facades\SnappyPdf;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;
use Src\ciudadano\domain\GenerarCertificadoInterface;
use Src\admin\dao\eloquent\EloquentUserRepository;
use Src\ciudadano\view\dto\ResponseCertificateDto;
use Src\ciudadano\infrastructure\service\ConfigCertificadoService;
use Src\ciudadano\infrastructure\service\GeneradorQrService;

class GenerarCertificadoService implements GenerarCertificadoInterface
{

    public function generarPdf(CertificadoDto $certificadoDto): ResponseCertificateDto
{
    try {
        Carbon::setLocale('es');

        $configuracionCertificado = ConfigCertificadoService::obtenerConfiguracionCertificado(
            $certificadoDto->categoria,
            $certificadoDto->tipo
        );

        if (is_null($configuracionCertificado) || empty($configuracionCertificado)) {
            $errorMessage = "Configuración del certificado no encontrada para categoría: {$certificadoDto->categoria}, tipo: {$certificadoDto->tipo}";
            \Sentry\captureMessage($errorMessage, \Sentry\Severity::fatal());
            Log::error($errorMessage);
            return new ResponseCertificateDto(null, $errorMessage, null);
        }

        // dd($configuracionCertificado);


        $templatePath = $configuracionCertificado['plantilla'] ?? null;
        $tempDocPath = storage_path('app/public/temp.docx');
        $firmaPath = storage_path('app/public/firma-test.jpg');
        $imageEncabezado = storage_path('app/public/escudo-yopal-certificado.png');

        if (!file_exists($templatePath)) {
            $errorMessage = "Plantilla DOCX no encontrada: {$templatePath}";
            \Sentry\captureMessage($errorMessage, \Sentry\Severity::fatal());
            Log::error($errorMessage);
            return new ResponseCertificateDto(null, $errorMessage, null);        }

        if (!file_exists($firmaPath)) {
            $errorMessage = "Firma no encontrada: {$templatePath}";
            \Sentry\captureMessage($errorMessage, \Sentry\Severity::fatal());
            Log::error($errorMessage);
            return new ResponseCertificateDto(null, $errorMessage, null);        }

        $templateProcessor = new TemplateProcessor($templatePath);

        // Reemplazar variables
        $templateProcessor->setImageValue('imageEncabezado', [
            'path' => $imageEncabezado,
            'width' => 60,
            'ratio' => true
        ]);
        $templateProcessor->setValue('tipoCertificado', $configuracionCertificado['name']);
        $templateProcessor->setValue('codigoComunicacion', $certificadoDto->configuracion->codigoComunicacion);
        $templateProcessor->setValue('numeroCertificado', $certificadoDto->configuracion->uuid);
        $templateProcessor->setValue('numeroDecreto', $certificadoDto->configuracion->numeroDecreto);
        $templateProcessor->setValue('nombreCiudadano', $certificadoDto->ciudadano->nombreCiudadano);
        $templateProcessor->setValue('numeroIdentificacion', $certificadoDto->ciudadano->numeroIdentificacion);
        $templateProcessor->setValue('lugarExpedicion', $certificadoDto->ciudadano->lugarExpedicion);
        $templateProcessor->setValue('aniosResidencia', $certificadoDto->ciudadano->aniosResidencia);
        $templateProcessor->setValue('mesesResidencia', $certificadoDto->ciudadano->mesesResidencia);
        $templateProcessor->setValue('diasResidencia', $certificadoDto->ciudadano->diasResidencia);
        $templateProcessor->setValue('direccionResidencia', $certificadoDto->ciudadano->direccionResidencia);
        $templateProcessor->setValue('barrioResidencia', $certificadoDto->ciudadano->barrioResidencia);
        $templateProcessor->setValue('diaCertificado', $certificadoDto->configuracion->diaCertificado);
        $templateProcessor->setValue('mesCertificado', $certificadoDto->configuracion->mesCertificado);
        $templateProcessor->setValue('anioCertificado', $certificadoDto->configuracion->anioCertificado);
        $templateProcessor->setImageValue('firmaSecretario', [
            'path' => $firmaPath,
            'width' => 60,
            'ratio' => true
        ]);
        $templateProcessor->setValue('nombreSecretario', 'JORGE ANDRÉS RODRÍGUEZ GONZÁLEZ');
        $templateProcessor->setValue('nombreElaborador', 'Deisy Alfonso');
        $templateProcessor->setValue('cargoElaborador', 'Auxiliar Administrativo');
        $templateProcessor->setImageValue('qr', [
            'path' => GeneradorQrService::generarQR(
                $certificadoDto->dominio,
                $certificadoDto->configuracion->uuid
            ),
            'width' => 60,
            'height' => 60,
            'ratio' => true,
        ]);
        $templateProcessor->saveAs($tempDocPath);

        // Convertir a HTML
        $phpWord = \PhpOffice\PhpWord\IOFactory::load($tempDocPath);
        $htmlWriter = \PhpOffice\PhpWord\IOFactory::createWriter($phpWord, 'HTML');
        ob_start();
        $htmlWriter->save('php://output');
        $html = ob_get_clean();

        // Limpieza y estilos
        $html = preg_replace('/margin-left:\s?[^;"]+;?/', '', $html);
        $html = str_replace('<p>', '<p class="body-text">', $html);
        $html = preg_replace('/<p>(.*?)CERTIFICA(.*?)<\/p>/', '<p class="header">$1CERTIFICA$2</p>', $html);

        $style = '
            <style>
                p {
                    margin: 0;
                    padding: 0;
                    font-family: "Times New Roman", sans-serif;
                    font-size: 12pt;
                    line-height: 1.5;
                    text-indent: 0;
                }
                .body-text {
                    font-size: 12pt;
                    text-align: justify;
                    line-height: 1.2;
                    margin: 0 3cm;
                }
            </style>
        ';

        $html = '<html><head>' . $style . '</head><body>' . $html . '</body></html>';

        file_put_contents(storage_path('app/debug.html'), $html);

        $pdf = SnappyPdf::loadHTML($html)
            ->setPaper('letter')
            ->setOption('margin-top', '1.5cm')
            ->setOption('margin-bottom', '2.5cm')
            ->setOption('margin-left', '3cm')
            ->setOption('margin-right', '3cm')
            ->setOption('encoding', 'UTF-8');

      return  new ResponseCertificateDto(null,$pdf->output('certificado_residencia_Yopal.pdf'), null);

    } catch (\Exception $e) {
        $errorMessage = "Ha ocurrido un error al generar el certificado. Por favor, intente más tarde. Detalles: " . $e;
        \Sentry\captureMessage($errorMessage, \Sentry\Severity::fatal());
        Log::error($errorMessage);
        return  new ResponseCertificateDto(null,null, $errorMessage);
    }
}

}
