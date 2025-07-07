<?php

namespace Src\ciudadano\domain;

use Src\ciudadano\view\dto\CertificadoDto;
use Src\ciudadano\domain\CertificadoStrategy;
use Illuminate\Support\Facades\Log;
use Src\ciudadano\view\dto\ResponseCertificateDto;
use Src\ciudadano\domain\GenerarCertificadoInterface;
use Src\ciudadano\view\dto\GuardarCertificadoResponseDto;

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
    public function generar(GenerarCertificadoInterface $generarCertificado):ResponseCertificateDto
    {
        Log::info("Esta es el certificado Automático TAPEP");     
        return $generarCertificado->generarPdf($this->certificadoDto); 
    }

    public function guardar(RepositoryCertificado $repositoryCertificado): GuardarCertificadoResponseDto
    {
        return  $repositoryCertificado->guardarCertificado($this->certificadoDto);
    }
    }

