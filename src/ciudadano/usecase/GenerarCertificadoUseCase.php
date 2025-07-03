<?php

namespace Src\ciudadano\usecase;

use Src\ciudadano\domain\CertificadoFactory;
use Src\ciudadano\view\dto\CertificadoDto;
use Src\shared\response\ResponseHttp;
use Src\ciudadano\infrastructure\service\GenerarCertificadoService;



final class GenerarCertificadoUseCase
{
    public function execute(CertificadoDto $certificadoDto)
    {
        $certificadoStrategy = CertificadoFactory::crear($certificadoDto);
        return $certificadoStrategy->generar(new GenerarCertificadoService());
    }
}   