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
        $firmaPath = storage_path('app/public/firma-test.png');
        $imageEncabezado = storage_path('app/public/escudo-yopal-certificado-small.png');
        $banderaPath = storage_path('app/public/linea-bandera-amy.png');
        $lineaVertical = storage_path('app/public/linea-vertical-amy.png');
        $empresaCertificada = storage_path('app/public/empresa-certificada-amy.png');

        if (!file_exists($templatePath)) {
            $errorMessage = "Plantilla DOCX no encontrada: {$templatePath}";
            \Sentry\captureMessage($errorMessage, \Sentry\Severity::fatal());
            Log::error($errorMessage);
            return new ResponseCertificateDto(null, "Plantilla no encontrada", null);        }

        if (!file_exists($firmaPath)) {
            $errorMessage = "Firma no encontrada: {$templatePath}";
            \Sentry\captureMessage($errorMessage, \Sentry\Severity::fatal());
            Log::error($errorMessage);
            return new ResponseCertificateDto(null, "Firma no encontrada", null);        }

        $templateProcessor = new TemplateProcessor($templatePath);

        // Reemplazar variables
        $templateProcessor->setImageValue('imageEncabezado', [
            'path' => $imageEncabezado,
            'width' => 10,
            'ratio' => true
        ]);
        $templateProcessor->setValue('tipoCertificado', $configuracionCertificado['name']);
        $templateProcessor->setValue('codigoComunicacion', $certificadoDto->configuracion->codigoComunicacion);
        $templateProcessor->setValue('numeroCertificado', $certificadoDto->configuracion->codigoComunicacion);
        $templateProcessor->setImageValue('qr', [
            'path' => GeneradorQrService::generarQR(
                $certificadoDto->dominio,
                $certificadoDto->configuracion->uuid
            ),
            'width' => 30,
            'height' => 30,
            'ratio' => true,
        ]);
        $templateProcessor->setImageValue('lineaVertical', [
            'path' => $lineaVertical,
            'width' => 30,
            'ratio' => true
        ]);
        $templateProcessor->setValue('numeroDecreto', $certificadoDto->configuracion->numeroDecreto);
        $templateProcessor->setValue('nombreCiudadano', $certificadoDto->ciudadano->nombreCiudadano);
        $templateProcessor->setValue('numeroIdentificacion', $certificadoDto->ciudadano->numeroIdentificacion);
        $templateProcessor->setValue('lugarExpedicion', $certificadoDto->ciudadano->lugarExpedicion);
        $templateProcessor->setValue('aniosResidencia', $certificadoDto->ciudadano->aniosResidencia);
        $templateProcessor->setValue('mesesResidencia', $certificadoDto->ciudadano->mesesResidencia);
        $templateProcessor->setValue('diasResidencia', $certificadoDto->ciudadano->diasResidencia);
        $templateProcessor->setValue('direccionResidencia', $certificadoDto->ciudadano->direccionResidencia);
        $templateProcessor->setValue('barrioResidencia', $certificadoDto->ciudadano->barrioResidencia);
        
        if ($certificadoDto->tipo == 'PPL'){

            $templateProcessor->setValue('NombrePPL', $certificadoDto->ppl->nombrePPL);
            $templateProcessor->setValue('tipoDocumentoPPL', $certificadoDto->ppl->tipoDocumentoPPL);
            $templateProcessor->setValue('numeroDocumentoPPL', $certificadoDto->ppl->numeroDocumentoPPL);
            $templateProcessor->setValue('numeroExpediente', $certificadoDto->ppl->numeroExpedientePPL);
            $templateProcessor->setValue('nombreJuzgado', $certificadoDto->ppl->nombreJuzgado);      
        }
        
        $templateProcessor->setValue('diaCertificado', $certificadoDto->configuracion->diaCertificado);
        $templateProcessor->setValue('mesCertificado', $certificadoDto->configuracion->mesCertificado);
        $templateProcessor->setValue('anioCertificado', $certificadoDto->configuracion->anioCertificado);
        $templateProcessor->setImageValue('firmaSecretario', [
            'path' => $firmaPath,
            'width' => 40,
            'ratio' => true
        ]);
        $templateProcessor->setValue('nombreSecretario', 'JORGE ANDRÉS RODRÍGUEZ GONZÁLEZ');
        $templateProcessor->setValue('nombreElaborador', 'Deisy Alfonso');
        $templateProcessor->setValue('cargoElaborador', 'Auxiliar Administrativo');
        $templateProcessor->setImageValue('empresaCertificada', [
            'path' => $empresaCertificada,
            'width' => 10,
            'ratio' => true
        ]);
        
        $templateProcessor->setImageValue('bandera', [
            'path' => $banderaPath,
            'width' => 600,
            'ratio' => true,
            'customStyle' => 'class="bandera-final-img"'
        ]);

        $templateProcessor->saveAs($tempDocPath);

        // Convertir a HTML
        $phpWord = \PhpOffice\PhpWord\IOFactory::load($tempDocPath);
        $htmlWriter = \PhpOffice\PhpWord\IOFactory::createWriter($phpWord, 'HTML');
        ob_start();
        $htmlWriter->save('php://output');
        $html = ob_get_clean();

        $html = preg_replace('/border[^:]*:\s?[^;"]+;?/', '', $html);

        //Elimina solo font-size
        // $html = preg_replace('/font-size:\s?[^;"]+;?/', '', $html);}

        $html= utilService::eliminarParrafosConSoloImagen($html);
        $html = preg_replace_callback('/<table.*?>.*?<\/table>/is', function ($match) {
            // Limpia solo <p> vacíos dentro de esta tabla
            return preg_replace('/<p[^>]*>\s*(&nbsp;| )*\s*<\/p>/i', '', $match[0]);
        }, $html);
        

        // También puedes limpiar margin si viene embebido
        $html = preg_replace('/margin[^:]*:\s?[^;"]+;?/', '', $html);

        $html = preg_replace('/padding:\s?[^;"]+;?/', '', $html);
        $html = preg_replace('/margin(-\w+)?:\s?[^;"]+;?/', '', $html);

        // // Limpieza y estilos
        $html = preg_replace('/margin-left:\s?[^;"]+;?/', '', $html);
        $html = preg_replace('/<span style="font-family:\s*\'?Arial\'?;?">/', '<span>', $html);

        
        

        $style = '
            <style>

                 p span {
                    font-size: 11pt !important;
                    line-height: 1.5 !important;
                }

                p {
                    line-height: 1.5 !important;
                    font-size: 11pt !important;
                }

                td {
                    padding: 0;
                    margin: 0;
                    vertical-align: top;
                    }
                    
                table:last-of-type td,
                table:last-of-type p,
                table:last-of-type span {
                    font-size: 8pt !important;
                }

                img {
                    display: block;
                    margin: 0 auto;
                    line-height: 0.06 !important;
                    }

               .bandera-final img {
                    width: 100% !important;
                    height: auto !important;
                    display: block;
                }

                p > img {
                    line-height: o !important;
                    vertical-align: middle !important;
                    display: block !important;
                    margin-bottom: 0 !important;
                }

                p:has(img:only-child) {
                    line-height: 1 !important;
                    margin: 0 !important;
                    padding: 0 !important;
                }


            </style>
        ';


        $html = '<html><head>' . $style . '</head><body>' . $html . '</body></html>';

        file_put_contents(storage_path('app/debug.html'), $html);

        $pdf = SnappyPdf::loadHTML($html)
            ->setPaper('letter')
            ->setOption('margin-top', '0.5cm')
            ->setOption('margin-bottom', '2cm')
            ->setOption('margin-left', '2.5cm')
            ->setOption('margin-right', '3cm')
            ->setOption('encoding', 'UTF-8');

      return  new ResponseCertificateDto(null,$pdf->output('certificado_residencia_Yopal.pdf'), null);

    } catch (\Exception $e) {
        $errorMessage = "Ha ocurrido un error al generar el certificado. Por favor, intente más tarde. Detalles: " . $e;
        \Sentry\captureMessage($errorMessage, \Sentry\Severity::fatal());
        Log::error($errorMessage);
        return  new ResponseCertificateDto(null,null, "Ha ocurrido un error al generar el certificado. Por favor, intente más tarde. Detalles:");
    }
}

}
