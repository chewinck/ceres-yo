<?php

namespace Src\ciudadano\infrastructure\service;

class ConfigCertificadoService
{
    public static function obtenerConfiguracionCertificado(string $categoria, string $tipo): array
{
    $config = self::getConfigCertificados();
    $datos = $config['categorias'][$categoria]['tipos'][$tipo] ?? [];

    return [
        'plantilla' => $datos['plantilla'] ?? null,
        'documentos' => $datos['documentos'] ?? null,
        'requiere_formulario' => $datos['requiere_formulario'] ?? false,
    ];
}


    private static function getConfigCertificados(): array
    {
        return [
            'categorias' => [
                'automatico' => [
                    'tipos' => [
                        'EVE' => [
                            'name' => 'Evento',
                            'requiere_formulario' => false,
                            'plantilla' => 'certificados.automatico.eve',
                            'documentos'=> null,
                        ],
                        'PPL' => [
                            'name' => 'PPL',
                            'requiere_formulario' => true,
                            'plantilla' => 'certificados.automatico.ppl',
                            'documentos'=> ['documento PPL'],

                        ],
                        'PEPA' => [
                            'name' => 'PEPA',
                            'requiere_formulario' => false,
                            'plantilla' => 'certificados.automatico.pepa',
                            'documentos'=> null,

                        ],
                        'TAPEP' => [
                            'name' => 'TAPEP',
                            'requiere_formulario' => false,
                            'plantilla' => 'certificados.automatico.tapep',
                            'documentos'=> null,

                        ],
                    ],
                ],
                'excepcional' => [
                    'tipos' => [
                        'EVE' => [
                            'name' => 'Evento Excepcional',
                            'requiere_formulario' => false,
                            'plantilla' => 'certificados.excepcional.eve',
                            'documentos'=> ['Certificado de la junta de acción comunal',
                            'Certificado de estudio', 'Certificado de afiliación a EPS',
                            'Certificado Laboral'],

                        ],
                        'PPL' => [
                            'name' => 'PPL Excepcional',
                            'requiere_formulario' => true,
                            'plantilla' => 'certificados.excepcional.ppl',
                            'documentos'=> ['Certificado de la junta de acción comunal',
                            'Certificado de estudio', 'Certificado de afiliación a EPS',
                            'Certificado Laboral'],
                        ],
                        'PEPA' => [
                            'name' => 'PEPA Excepcional',
                            'requiere_formulario' => false,
                            'plantilla' => 'certificados.excepcional.pepa',
                            'documentos'=> ['Certificado de la junta de acción comunal',
                            'Certificado de estudio', 'Certificado de afiliación a EPS',
                            'Certificado Laboral'],
                        ],
                        'TAPEP' => [
                            'name' => 'TAPEP Excepcional',
                            'requiere_formulario' => false,
                            'plantilla' => 'certificados.excepcional.tapep',
                            'documentos'=> ['Certificado de afiliación a la junta de acción comunal'],
                        ],
                    ],
                ],
            ],
        ];
    }
}
