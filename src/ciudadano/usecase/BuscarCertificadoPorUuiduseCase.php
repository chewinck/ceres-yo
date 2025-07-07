<?php

namespace Src\ciudadano\usecase;
use Src\ciudadano\dao\eloquent\EloquentCertificadoRepository;
use Src\ciudadano\infrastructure\service\GenerarCertificadoService;
use Src\ciudadano\view\dto\ResponseCertificateDto;


class BuscarCertificadoPorUuiduseCase
{
    private $eloquentCertificadoRepository;
    private $generarCertificadoService;

    public function __construct( EloquentCertificadoRepository $eloquentCertificadoRepository, GenerarCertificadoService $generarCertificadoService)
    {
        $this->generarCertificadoService = $generarCertificadoService;
        $this->eloquentCertificadoRepository = $eloquentCertificadoRepository;
    }

    public function execute(string $uuid): ResponseCertificateDto
    {
        $response = $this->eloquentCertificadoRepository->buscarPorUuid($uuid);
        return  $this->generarCertificadoService->GenerarPdf($response->certificadoDto);


    }
}