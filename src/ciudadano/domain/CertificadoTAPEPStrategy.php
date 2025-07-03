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
    public function generar(GenerarCertificadoInterface $generarCertificado):string
    {
        Log::info("Esta es el certificado Automático TAPEP");     
        return $generarCertificado->generarPdf($this->certificadoDto->tipo); 
    }
}