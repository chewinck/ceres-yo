<?php

namespace Src\ciudadano\view\dto;

class CertificadoDto
{
    public function __construct(
        public string $tipo,
        public string $categoria,
        public bool $requiereFormulario,
        public ?string $plantilla = null,
        public  $documentos = null
    ) {}
}