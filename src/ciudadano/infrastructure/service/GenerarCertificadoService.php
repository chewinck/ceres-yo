<?php

namespace Src\ciudadano\infrastructure\service;

use Illuminate\Support\Facades\Log;
use Src\ciudadano\view\dto\CertificadoDto;
use PhpOffice\PhpWord\TemplateProcessor;
use Barryvdh\Snappy\Facades\SnappyPdf;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;
use Src\ciudadano\domain\GenerarCertificadoInterface;
use Src\admin\infrastructure\EloquentUserRepository;

class GenerarCertificadoService implements GenerarCertificadoInterface
{

    private static function getNameTIpoCertificado(string $tipoCertificado): string
    {
        $arrayTipoCertificado = [
            'EVE' => 'Certificados de residencia para fines de Estudio, Vivienda, y Empleo',
            'PPL' => 'Certificado de residencia para personas Privadas de la libertad',
            'PEPA' => 'Certificado de residencia para permiso especial - porte y salvoconducto de armas',
            'TAPEP' => 'Certificado de residencia para trabajo en las áreas de influencia de los proyectos de exploración y explotación petrolera y minera',
        ];
        return $arrayTipoCertificado[$tipoCertificado] ?? 'Certificado Desconocido';
    }   

    public function generarPdf(string $tipoCertificado): string
{
    try {
        Carbon::setLocale('es');

        $templatePath = storage_path('app/public/EVE.docx');
        $tempDocPath = storage_path('app/public/temp.docx');
        $firmaPath = storage_path('app/public/firma-test.jpg');
        $imageEncabezado = storage_path('app/public/escudo-yopal-certificado.png');

        if (!file_exists($templatePath)) {
            $errorMessage = "Plantilla DOCX no encontrada: {$templatePath}";
            \Sentry\captureMessage($errorMessage, \Sentry\Severity::fatal());
            \Log::error($errorMessage);
            return "ha ocurrio un error al generar el certificado, por favor intente más tarde.";
        }

        if (!file_exists($firmaPath)) {
            $errorMessage = "Firma no encontrada: {$templatePath}";
            \Sentry\captureMessage($errorMessage, \Sentry\Severity::fatal());
            \Log::error($errorMessage);
            return "ha ocurrio un error al generar el certificado, por favor intente más tarde.";
        }
        $eloquentUserRepository = new EloquentUserRepository();
        $user = $eloquentUserRepository->getAuthenticatedUserWithCiudadano();

        $templateProcessor = new TemplateProcessor($templatePath);

        // Reemplazar variables
        $templateProcessor->setImageValue('imageEncabezado', [
            'path' => $imageEncabezado,
            'width' => 60,
            'ratio' => true
        ]);
        $templateProcessor->setValue('tipoCertificado', self::getNameTIpoCertificado($tipoCertificado));
        $templateProcessor->setValue('codigoComunicacion', '123456');
        $templateProcessor->setValue('numeroCertificado', UtilService::generateUniqueId());
        $templateProcessor->setValue('numeroDecreto', '2025-001');
        $templateProcessor->setValue('nombreCiudadano', $user->getNombre());
        $templateProcessor->setValue('numeroIdentificacion', $user->getCiudadano()->getNumeroIdentificacion());
        $templateProcessor->setValue('lugarExpedicion', 'pendiente');
        $templateProcessor->setValue('aniosResidencia', '9');
        $templateProcessor->setValue('mesesResidencia', '8');
        $templateProcessor->setValue('diasResidencia', '15');
        $templateProcessor->setValue('direccionResidencia', $user->getCiudadano()->getDireccion());
        $templateProcessor->setValue('barrioResidencia', $user->getCiudadano()->getBarrio());
        $templateProcessor->setValue('diaCertificado', Carbon::now()->day);
        $templateProcessor->setValue('mesCertificado', Carbon::now()->translatedFormat('F'));
        $templateProcessor->setValue('anioCertificado', Carbon::now()->year);
        $templateProcessor->setImageValue('firmaSecretario', [
            'path' => $firmaPath,
            'width' => 60,
            'ratio' => true
        ]);
        $templateProcessor->setValue('nombreSecretario', 'JORGE ANDRÉS RODRÍGUEZ GONZÁLEZ');
        $templateProcessor->setValue('nombreElaborador', 'Deisy Alfonso');
        $templateProcessor->setValue('cargoElaborador', 'Auxiliar Administrativo');

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

        return $pdf->output('certificado_residencia_Yopal.pdf');

    } catch (\Exception $e) {
        $errorMessage = "Ha ocurrido un error al generar el certificado. Por favor, intente más tarde. Detalles: " . $e->getMessage();
        \Sentry\captureMessage($errorMessage, \Sentry\Severity::fatal());
        \Log::error($errorMessage);
        return "Ha ocurrido un error al generar el certificado. Por favor, intente más tarde.";
    }
}

}
