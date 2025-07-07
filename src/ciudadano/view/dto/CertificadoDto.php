<?php

namespace Src\ciudadano\view\dto;

class CertificadoDto
{
    public function __construct(
        public string $tipo,
        public string $categoria,
        public string $dominio,
        // public bool $requiereFormulario,
        // public ?string $plantilla = null,
        // public  $documentos = null,
        public ?ConfigBaseCertificadoDto $configuracion = null,
        public ?CiudadanoDto $ciudadano = null

    ) {}

    public function toArray(): array
{
    return [
        'tipo' => $this->tipo,
        'categoria' => $this->categoria,
        'dominio' => $this->dominio,
        // 'requiereFormulario' => $this->requiereFormulario,
        // 'plantilla' => $this->plantilla,
        // 'documentos' => $this->documentos,
        'configuracion' => $this->configuracion?->toArray(), // si tu dto hijo tiene toArray()
        'ciudadano' => $this->ciudadano?->toArray(), // igual aquí
    ];
}

}