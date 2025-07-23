<?php

namespace Src\ciudadano\view\dto;

class PPLDto
{
    public function __construct(
        public string $nombrePPL,
        public string $tipoDocumentoPPL,
        public string $numeroDocumentoPPL,
        public string $numeroExpedientePPL,
        public string $nombreJuzgado,
    ) {}

    public function toArray(): array
    {
        return [
            'nombrePPL' => $this->nombrePPL,
            'tipoDocumentoPPL' => $this->tipoDocumentoPPL,
            'numeroDocumentoPPL' => $this->numeroDocumentoPPL,
            'numeroExpedientePPL' => $this->numeroExpedientePPL,
            'nombreJuzgado' => $this->nombreJuzgado,
        ];
    }
}