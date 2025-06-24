<?php

namespace Src\ciudadano\domain;

use Src\ciudadano\view\dto\CertificadoDto;

interface CertificadoStrategy
{
    /**
     * @param string $tipo
     * @param string $numero
     * @return string
     */

    public function __construct(CertificadoDto $certificadoDto);
    public function generar(): bool;

}