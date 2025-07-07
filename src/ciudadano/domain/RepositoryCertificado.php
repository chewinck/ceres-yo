<?php

namespace Src\ciudadano\domain;

use Src\ciudadano\view\dto\CertificadoDto;
use Src\ciudadano\view\dto\GuardarCertificadoResponseDto;
use Src\ciudadano\view\dto\ResponseCertificateDto;

interface RepositoryCertificado
{
    /**
     * @param string $tipo
     * @param string $numero
     * @return string
     */
    // public function generarCertificado(string $tipo, string $numero): string;

    /**
     * @param string $tipo
     * @param string $numero
     * @return bool
     */
    public function guardarCertificado(CertificadoDto $certificadoDto): GuardarCertificadoResponseDto;
    public function buscarPorUuid(string $uuid): ?ResponseCertificateDto;
}