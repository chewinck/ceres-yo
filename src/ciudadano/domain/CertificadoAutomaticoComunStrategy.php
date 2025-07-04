<?php

namespace Src\ciudadano\domain;

use Src\ciudadano\view\dto\CertificadoDto;
use Src\ciudadano\domain\CertificadoStrategy;
use Src\ciudadano\view\dto\ResponseCertificateDto;
use Src\ciudadano\domain\GenerarCertificadoInterface;
use Src\ciudadano\domain\RepositoryCertificado;
use Src\ciudadano\view\dto\GuardarCertificadoResponseDto;

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


    public function generar(GenerarCertificadoInterface $generarCertificado):ResponseCertificateDto
    {
        Log::info("Este es el certificado de categoría {$this->certificadoDto->categoria} y tipo {$this->certificadoDto->tipo}");        
        
       return $generarCertificado->generarPdf($this->certificadoDto); 
    }

    public function guardar(RepositoryCertificado $repositoryCertificado): GuardarCertificadoResponseDto
    {
       return  $repositoryCertificado->guardarCertificado($this->certificadoDto);
    }
}
