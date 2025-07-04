<?php

namespace Src\ciudadano\domain;

use Src\ciudadano\view\dto\CertificadoDto;
use Src\ciudadano\view\dto\ResponseCertificateDto;
use Src\ciudadano\domain\GenerarCertificadoInterface;
use Src\ciudadano\view\dto\GuardarCertificadoResponseDto;
use Src\ciudadano\domain\RepositoryCertificado;

interface CertificadoStrategy
{
    /**
     * @param string $tipo
     * @param string $numero
     * @return string
     */

    public function __construct(CertificadoDto $certificadoDto);
    public function generar(GenerarCertificadoInterface $generarCertificado): ResponseCertificateDto;
    public function guardar(RepositoryCertificado $repositoryCertificado): GuardarCertificadoResponseDto;

}