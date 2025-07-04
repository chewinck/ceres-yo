<?php


namespace Src\ciudadano\view\dto;

class CiudadanoDto
{
    public function __construct(
        public string $nombreCiudadano,
        public int $idCiudadano,
        public string $numeroIdentificacion,
        public string $lugarExpedicion,
        public int $aniosResidencia,
        public int $mesesResidencia,
        public int $diasResidencia,
        public string $direccionResidencia,
        public string $barrioResidencia
    ) {}

    public function toArray(): array
    {
        return [
            'nombreCiudadano' => $this->nombreCiudadano,
            'idCiudadano' => $this->idCiudadano,
            'numeroIdentificacion' => $this->numeroIdentificacion,
            'lugarExpedicion' => $this->lugarExpedicion,
            'aniosResidencia' => $this->aniosResidencia,
            'mesesResidencia' => $this->mesesResidencia,
            'diasResidencia' => $this->diasResidencia,
            'direccionResidencia' => $this->direccionResidencia,
            'barrioResidencia' => $this->barrioResidencia,
        ];
    }

}
