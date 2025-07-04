<?php
declare(strict_types=1);

namespace Src\ciudadano\domain;

use Src\Ciudadano\view\dto\CertificadoDto;
use Src\ciudadano\domain\CertificadoStrategy;
use Src\ciudadano\domain\CertificadoRepository;
use Src\ciudadano\domain\CertificadoTAPEPStrategy;
use Src\ciudadano\domain\CertificadoAutomaticoComunStrategy;
use Src\ciudadano\domain\CertificadoExcepcionalStrategy;



class CertificadoFactory
{
    /**
     * @param CertificadoDto $certificadoDto
     * @return CertificadoStrategy
     */
    public static function crear(CertificadoDto $certificadoDto): CertificadoStrategy
    {
        if (strtolower(str_replace(' ', '', $certificadoDto->categoria)) === 'automatica') {
            if (strtolower(str_replace(' ', '', $certificadoDto->tipo)) === 'tapep') {
                return new CertificadoTAPEPStrategy($certificadoDto);
            }
            return new CertificadoAutomaticoComunStrategy($certificadoDto);
        }

        if (strtolower(str_replace(' ', '', $certificadoDto->categoria)) === 'excepcional') {
            return new CertificadoExcepcionalStrategy($certificadoDto);
        }

        throw new \InvalidArgumentException('Categoría o tipo de certificado no soportado');
    }
}