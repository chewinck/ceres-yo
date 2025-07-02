<?php

namespace Src\Ciudadano\Domain;

interface GenerarCertificadoInterface
{
    /**
     * @return string
     */
    public function generarPdf(string $tipoCertificado): string;
}