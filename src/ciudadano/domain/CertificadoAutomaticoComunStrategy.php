<?php

namespace App\Ciudadano\domain;

use App\Ciudadano\View\Dto\CertificadoDto;
use App\Ciudadano\Domain\CertificadoStrategy;

final class CertificadoAutomaticoComunStrategy implements CertificadoStrategy
{
    /**
     * @param CertificadoDto $certificadoDto
     * @return string
     */
    public function generar(CertificadoDto $certificadoDto): bool
    {
        // Aquí se implementa la lógica para generar el certificado automático común.
        // Por ejemplo, podrías usar una plantilla y reemplazar los datos necesarios.
        
        $contenido = "Certificado de tipo: {$certificadoDto->tipo}\n";
        $contenido .= "Categoría: {$certificadoDto->categoria}\n";
        
        if ($certificadoDto->requiereFormulario) {
            $contenido .= "Requiere formulario.\n";
        } else {
            $contenido .= "No requiere formulario.\n";
        }
        
        if ($certificadoDto->plantilla) {
            $contenido .= "Plantilla utilizada: {$certificadoDto->plantilla}\n";
        }
        
        return true;
    }
}
