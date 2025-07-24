<?php

namespace Src\ciudadano\usecase;

use Src\ciudadano\domain\CertificadoFactory;
use Src\ciudadano\view\dto\CertificadoDto;
use Src\shared\response\ResponseHttp;
use Src\ciudadano\infrastructure\service\GenerarCertificadoService;
use Src\ciudadano\view\dto\ConfigBaseCertificadoDto;
use Src\ciudadano\view\dto\CiudadanoDto;
use Src\ciudadano\dao\eloquent\EloquentCertificadoRepository;
use Src\admin\dao\eloquent\EloquentUserRepository;
use Carbon\Carbon;
use Src\ciudadano\infrastructure\service\GeneradorQrService;
use Src\ciudadano\infrastructure\service\UtilService;



final class GenerarCertificadoUseCase
{
    public function execute(CertificadoDto $certificadoDto): ResponseHttp
    {

        $eloquentUserRepository = new EloquentUserRepository();
        $user = $eloquentUserRepository->getAuthenticatedUserWithCiudadano();
        if (!$user) {
            return new ResponseHttp(404, 'Usuario no encontrado', null);
        }

        Carbon::setLocale('es');
        
        $ciudadanoDto = new CiudadanoDto(
            $user->getNombre(),
            $user->getCiudadano()->getId(),
            $user->getCiudadano()->getNumeroIdentificacion(),
            "pendiente",
            '9',
            '8',
            '15',
            $user->getCiudadano()->getDireccion(),
            $user->getCiudadano()->getBarrio()
        );

        $configBaseCertificadoDto = new ConfigBaseCertificadoDto(
            UtilService::generateUniqueId(),
            "XXXXX",
            "XXXXXX",
            "firmaSecretario",
            "Nombre Secretario",
            "Nombre Elaborador",
            "Cargo Elaborador",
            Carbon::now()->day,
            Carbon::now()->translatedFormat('F'),
            Carbon::now()->year,
        );
        


        $certificadoDto->ciudadano = $ciudadanoDto;
        $certificadoDto->configuracion = $configBaseCertificadoDto;


        $certificadoStrategy = CertificadoFactory::crear($certificadoDto);
        $respGuardarCertificado = $certificadoStrategy->guardar(new EloquentCertificadoRepository());
        if (!$respGuardarCertificado->exito) {
            return new ResponseHttp(500, 'Error al guardar el certificado', null);
        }

        $resp = $certificadoStrategy->generar(new GenerarCertificadoService());
        if(!$resp->esExitoso()) {
            return new ResponseHttp(500, 'Error al generar el certificado: ' . $resp->mensajeError, null);
        }

        return new ResponseHttp(200, 'Certificado generado exitosamente', $resp->contenidoPdf);
    }
}   