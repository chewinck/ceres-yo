<?php

namespace Src\Ciudadano\Domain;
use Src\ciudadano\view\dto\ResponseCertificateDto;
use Src\ciudadano\view\dto\CertificadoDto;

interface GenerarCertificadoInterface
{
    /**
     * @return string
     */
    public function generarPdf(CertificadoDto $certificadoDto): ResponseCertificateDto;
}