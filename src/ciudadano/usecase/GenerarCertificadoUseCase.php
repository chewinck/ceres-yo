<?php


namespace Src\ciudadano\usecase;

use Src\ciudadano\domain\CertificadoFactory;
use Src\ciudadano\view\dto\CertificadoDto;
use Src\shared\response\ResponseHttp;



final class GenerarCertificadoUseCase
{
    private  CertificadoDto  $certificadoDto;

    public function __construct( CertificadoDto $certificadoDto)
    {
        $this->certificadoDto =  $certificadoDto;
    }

    public function execute(): ResponseHttp  
    {
        $certificadoStrategy = CertificadoFactory::crear($this->certificadoDto);
        $resultado = $certificadoStrategy->generar($this->certificadoDto);

        if (!$resultado) {
            return new ResponseHttp(500, "Error al generar el certificado", null);

        } 

        return new ResponseHttp(200, "Certificado generado exitosamente", null);

    }
}   