<?php

namespace Src\ciudadano\view\dto;

class CertificadoDto
{
    public function __construct(
        public string $tipo,
        public string $categoria,
        public string $dominio,
        public ?PPLDto $ppl = null, // opcional, solo si es PPL
        public ?ConfigBaseCertificadoDto $configuracion = null,
        public ?CiudadanoDto $ciudadano = null

    ) {}

    public function toArray(): array
{
    return [
        'tipo' => $this->tipo,
        'categoria' => $this->categoria,
        'dominio' => $this->dominio,
        'configuracion' => $this->configuracion?->toArray(), // si tu dto hijo tiene toArray()
        'ciudadano' => $this->ciudadano?->toArray(), // igual aquí
    ];
}

}