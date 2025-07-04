<?php
namespace Src\ciudadano\view\dto;

class GuardarCertificadoResponseDto {
    public function __construct(
        public bool $exito,
        public ?string $id = null,
        public ?string $error = null
    ) {}
}
