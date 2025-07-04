<?php

namespace Src\Ciudadano\view\dto;

class ConfigBaseCertificadoDto
{
    public function __construct(
        public string $uuid,
        public string $codigoComunicacion,
        public string $numeroDecreto,
        public string $firmaSecretario,
        public string $nombreSecretario,
        public string $nombreElaborador,
        public string $cargoElaborador,
        public string $diaCertificado,
        public string $mesCertificado,
        public string $anioCertificado,
    ) {}

    public function toArray(): array
    {
        return [
            'uuid' => $this->uuid,
            'codigoComunicacion' => $this->codigoComunicacion,
            'numeroDecreto' => $this->numeroDecreto,
            'firmaSecretario' => $this->firmaSecretario,
            'nombreSecretario' => $this->nombreSecretario,
            'nombreElaborador' => $this->nombreElaborador,
            'cargoElaborador' => $this->cargoElaborador,
            'diaCertificado' => $this->diaCertificado,
            'mesCertificado' => $this->mesCertificado,
            'anioCertificado' => $this->anioCertificado,
        ];
    }
}


