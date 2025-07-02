<?php

namespace Src\ciudadano\infrastructure\service;

use Illuminate\Support\Facades\Log;
use Src\ciudadano\view\dto\CertificadoDto;
use PhpOffice\PhpWord\TemplateProcessor;
use Barryvdh\Snappy\Facades\SnappyPdf;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;

class GenerarCertificadoService
{
    public static function generarPdf()
    {
        // 1. Cargar plantilla
        $templatePath = storage_path('app/public/EVE.docx');
        $tempDocPath = storage_path('app/public/temp.docx');

        $templateProcessor = new TemplateProcessor($templatePath);

        // 2. Reemplazar variables
        $templateProcessor->setValue('codigoComunicacion', '123456');
        $templateProcessor->setValue('numeroCertificado', UtilService::generateUniqueId());
        $templateProcessor->setValue('numeroDecreto', '2025-001');
        $templateProcessor->setValue('nombreCiudadano', 'Edwin Rodriguez Suarez');
        $templateProcessor->setValue('numeroIdentificacion', '1121872835');
        $templateProcessor->setValue('lugarExpedicion', 'Villavicencio - Meta');
        $templateProcessor->setValue('aniosResidencia', '9');
        $templateProcessor->setValue('mesesResidencia', '8');
        $templateProcessor->setValue('diasResidencia', '15');
        $templateProcessor->setValue('direccionResidencia', 'Calle 32 N 43 - 33');
        $templateProcessor->setValue('barrioResidencia', 'Bosques de Sirivana');
        $templateProcessor->setValue('diaCertificado', Carbon::now()->day);
        $templateProcessor->setValue('mesCertificado', Carbon::now()->month);
        $templateProcessor->setValue('anioCertificado', Carbon::now()->year);
        $templateProcessor->setImageValue('firmaSecretario', [
            'path' => storage_path('app/public/firma-test.jpg'),
            'width' => 60,
            'ratio' => true
        ]);
        $templateProcessor->setValue('nombreSecretario', 'JORGE ANDRÉS RODRÍGUEZ GONZÁLEZ');
        $templateProcessor->setValue('nombreElaborador', 'Deisy Alfonso');
        $templateProcessor->setValue('cargoElaborador', 'Auxiliar Administrativo');

        // 3. Guardar archivo temporal .docx
        $templateProcessor->saveAs($tempDocPath);

        // 4. Convertir a HTML (soporte limitado en estilos)
        $phpWord = \PhpOffice\PhpWord\IOFactory::load($tempDocPath);
        $htmlWriter = \PhpOffice\PhpWord\IOFactory::createWriter($phpWord, 'HTML');
        ob_start();
        $htmlWriter->save('php://output');
        $html = ob_get_clean();

        // 5. Opcional: envolver HTML con estilos base para mejor apariencia
      // 1. Inyectar clases manualmente en el HTML
      $html = str_replace('<p>', '<p class="body-text">', $html);
      $html = preg_replace('/<p>(.*?)CERTIFICA(.*?)<\/p>/', '<p class="header">$1CERTIFICA$2</p>', $html);
      $html = preg_replace('/<p class="body-text">(.*?)Cargo:(.*?)<\/p>/', '<p class="body-text no-indent">$1Cargo:$2</p>', $html);

      
      // 2. Añadir <style> con clases personalizadas y márgenes simulados (solo efecto visual, reales se configuran en Snappy)
      $style = '
          <style>
              body {
                  margin: 0;
                  padding: 0;
                  font-family: "Arial", sans-serif;
                  font-size: 14pt;
                  line-height: 1.0; /* Interlineado sencillo */
                  text-indent: 0;
              }
      
              .header {
                  font-size: 20pt;
                  font-weight: bold;
                  color: navy;
                  text-align: center;
                  margin-bottom: 20px;
              }
      
              .body-text {
                  font-size: 12pt;
                  text-align: justify;
                  line-height: 1.2;
                  margin: 0 3cm;
              }
      
              .signature {
                  font-size: 13pt;
                  margin-top: 40px;
                  text-align: center;
              }
          </style>
      ';
      
      // 3. Envolver HTML con head y body
      $html = '<html><head>' . $style . '</head><body>' . $html . '</body></html>';
      
      // 4. Generar PDF con Snappy y configurar tamaño carta y márgenes reales
      $pdf = SnappyPdf::loadHTML($html)
          ->setPaper('letter') // Tamaño carta (8.5" x 11")
          ->setOption('margin-top', '2.5cm')
          ->setOption('margin-bottom', '2.5cm')
          ->setOption('margin-left', '3cm')
          ->setOption('margin-right', '3cm')
          ->setOption('encoding', 'UTF-8');
      
      return $pdf->download('documento.pdf');
      
    }
}
