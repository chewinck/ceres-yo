<?php

namespace App\Ciudadano\Domain;

interface CertificadoStrategy
{
    /**
     * @param string $tipo
     * @param string $numero
     * @return string
     */
    public function generar(CertificadoDto $certificadoDto): bool;

}