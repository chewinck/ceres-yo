<?php

namespace Src\ciudadano\domain;

use Src\ciudadano\view\dto\CertificadoDto;
use Src\ciudadano\domain\CertificadoStrategy;
use Illuminate\Support\Facades\Log;

final class CertificadoTAPEPStrategy implements CertificadoStrategy
{

    private CertificadoDto $certificadoDto;


    public function __construct(CertificadoDto $certificadoDto)
    {
        $this->certificadoDto = $certificadoDto;
    }   

    /**
     * @param CertificadoDto $certificadoDto
     * @return string
     */
    public function generar():string
    {
        // Aquí se implementa la lógica para generar el certificado automático común.
        // Por ejemplo, podrías usar una plantilla y reemplazar los datos necesarios.
        
        $contenido = "Certificado de tipo: {$this->certificadoDto->tipo}\n";
        $contenido .= "Categoría: {$this->certificadoDto->categoria}\n";

        Log::info("Esta es el certificado Automático TAPEP");     
        
        if ($this->certificadoDto->requiereFormulario) {
            $contenido .= "Requiere formulario.\n";
        } else {
            $contenido .= "No requiere formulario.\n";
        }
        
        if ($this->certificadoDto->plantilla) {
            $contenido .= "Plantilla utilizada: {$this->certificadoDto->plantilla}\n";
        }
        
        return true;
    }
}