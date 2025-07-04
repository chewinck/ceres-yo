<?php

namespace Src\Ciudadano\Domain;
use Src\ciudadano\view\dto\CertificadoDto;
use Src\ciudadano\domain\CertificadoStrategy;
use Illuminate\Support\Facades\Log;
use Src\ciudadano\view\dto\ResponseCertificateDto;
use Src\ciudadano\view\dto\GuardarCertificadoResponseDto;
use Src\ciudadano\domain\RepositoryCertificado;

final class CertificadoExcepcionalStrategy implements CertificadoStrategy
{

    private CertificadoDto $certificadoDto;


    public function __construct(CertificadoDto $certificadoDto)
    {
        $this->certificadoDto = $certificadoDto;
    }

    /**
     * @param CertificadoDto $certificadoDto
     * @return string
     */
    public function generar():ResponseCertificateDto
    {
        Log::info("Generando certificado excepcional de tipo {$this->certificadoDto->tipo} y categoría {$this->certificadoDto->categoria}");
        
        // Aquí se implementa la lógica para generar el certificado excepcional.
        // Por ejemplo, podrías usar una plantilla y reemplazar los datos necesarios.
        $resultado = $this->generarCertificadoExcepcional();
        
        return new ResponseCertificateDto($resultado, null);
    }

    public function guardar(RepositoryCertificado $repositoryCertificado): GuardarCertificadoResponseDto
    {
        Log::info("Guardando certificado excepcional de tipo {$this->certificadoDto->tipo} y categoría {$this->certificadoDto->categoria}");
        
        // Aquí se implementa la lógica para guardar el certificado excepcional.
        $exito = $this->guardarCertificadoExcepcional();
        
        return new GuardarCertificadoResponseDto($exito, null);
    }
    {
        // Implementar la lógica para guardar el certificado si es necesario.
        // Por ejemplo, podrías guardar en una base de datos o en un sistema de archivos.
        Log::info("Guardando certificado excepcional de tipo {$this->certificadoDto->tipo} y categoría {$this->certificadoDto->categoria}");
        return true; // Retornar true si se guarda correctamente, false en caso contrario.
    }

}