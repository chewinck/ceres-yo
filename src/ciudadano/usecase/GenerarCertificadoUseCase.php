<?php

namespace Src\ciudadano\usecase;

use Src\ciudadano\domain\CertificadoFactory;
use Src\ciudadano\view\dto\CertificadoDto;
use Src\shared\response\ResponseHttp;
use Src\ciudadano\infrastructure\service\GenerarCertificadoService;



final class GenerarCertificadoUseCase
{
    private  CertificadoDto  $certificadoDto;

    public function __construct( CertificadoDto $certificadoDto)
    {
        $this->certificadoDto =  $certificadoDto;
    }

    public function execute()
    {
        $certificadoStrategy = CertificadoFactory::crear($this->certificadoDto);
        return $certificadoStrategy->generar(new GenerarCertificadoService());
    }
}   