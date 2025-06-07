<?php

namespace App\Ciudadano\View\Dto;

class CertificadoDto
{
    public function __construct(
        public string $tipo,
        public string $categoria,
        public bool $requiereFormulario,
        public ?string $plantilla = null,
        public array $documentos = []
    ) {}
}