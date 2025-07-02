<?php

namespace Src\ciudadano\domain;

use Src\ciudadano\view\dto\CertificadoDto;
use Src\ciudadano\domain\CertificadoStrategy;

use Illuminate\Support\Facades\Log;

final class CertificadoAutomaticoComunStrategy implements CertificadoStrategy
{

    private CertificadoDto $certificadoDto;
    /**
     * @param CertificadoDto $certificadoDto
     * @return string
     */

     public function __construct(CertificadoDto $certificadoDto){
        $this->certificadoDto = $certificadoDto;
    
    }


    public function generar(GenerarCertificadoInterface $generarCertificado):string
    {
         
        Log::info("Este es el certificado de categoría {$this->certificadoDto->categoria} y tipo {$this->certificadoDto->tipo}");        
        
       return $generarCertificado->generarPdf($this->certificadoDto->tipo); 
    }
}
