<?php
// declare(strict_types=1);

namespace App\Ciudadano\domain;

use App\Ciudadano\View\Dto\CertificadoDto;
use App\Ciudadano\Domain\CertificadoStrategy;
use App\Ciudadano\Domain\CertificadoRepository;
use App\Ciudadano\Domain\CertificadoFactory;
use App\Ciudadano\Domain\CertificadoTAPEPStrategy;
use App\Ciudadano\Domain\CertificadoAutomaticoComunStrategy;
use App\Ciudadano\Domain\CertificadoExcepcionalStrategy;


class CertificadoFactory
{
    /**
     * @param CertificadoDto $certificadoDto
     * @return CertificadoStrategy
     */
    public static function crear(CertificadoDto $certificadoDto): CertificadoStrategy
    {
        if ($certificadoDto->categoria === 'automatico') {
            if ($certificadoDto->tipo === 'TAPEP') {
                return new CertificadoTAPEPStrategy();
            }
            return new CertificadoAutomaticoComunStrategy();
        }

        if ($certificadoDto->categoria === 'excepcional') {
            return new CertificadoExcepcionalStrategy();
        }

        throw new \InvalidArgumentException('Categoría o tipo de certificado no soportado');
    }
}