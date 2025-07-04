<?php

namespace Src\ciudadano\view\dto;



class ResponseCertificateDto
{
    public function __construct(
        public ?string $contenidoPdf, // null si falló
        public ?string $mensajeError  // null si fue exitoso
    ) {}
    
    public function esExitoso(): bool
    {
        return $this->contenidoPdf !== null;
    }
}