<?php

namespace Src\ciudadano\infrastructure\service;

class ConfigCertificadoService
{
    public static function obtenerConfiguracionCertificado(string $categoria, string $tipo): array
{
    $config = self::getConfigCertificados();
    $datos = $config['categorias'][$categoria]['tipos'][$tipo] ?? [];

    return [
        'name' => $datos['name'] ?? 'Certificado Desconocido',
        'plantilla' => $datos['plantilla'] ?? null,
        'documentos' => $datos['documentos'] ?? null,
        'requiere_formulario' => $datos['requiere_formulario'] ?? false,
    ];
}

    private static function getConfigCertificados(): array
    {
        return [
            'categorias' => [
                'automatica' => [
                    'tipos' => [
                        'EVE' => [
                            'name' => 'CERTIFICADO DE RESIDENCIA PARA FINES DE ESTUDIO, VIVIENDA Y EMPLEO',
                            'requiere_formulario' => false,
                            'plantilla' => storage_path('app/public/EVE-Automatico.docx'),
                            'documentos'=> null,
                        ],
                        'PPL' => [
                            'name' => 'CERTIFICADO DE RESIDENCIA PARA PERSONAS PRIVADAS DE LA LIBERTAD',
                            'requiere_formulario' => true,
                            'plantilla' => storage_path('app/public/PPL-Automatico.docx'),
                            'documentos'=> ['documento PPL'],

                        ],
                        'PEPA' => [
                            'name' => 'CERTIFICADO DE RESIDENCIA PARA PERMISO ESPECIAL - PORTE Y SALVOCONDUCTO DE ARMAS',
                            'requiere_formulario' => false,
                            'plantilla' => storage_path('app/public/PEPA-Automatico.docx'),
                            'documentos'=> null,

                        ],
                        'TAPEP' => [
                            'name' => 'CERTIFICADO DE RESIDENCIA PARA TRABAJO EN LAS ÁREAS DE INFLUENCIA DE LOS PROYECTOS DE EXPLORACIÓN Y EXPLOTACIÓN PETROLERA Y MINERA',
                            'requiere_formulario' => false,
                            'plantilla' => storage_path('app/public/TAPEP-Automatico.docx'),
                            'documentos'=> null,

                        ],
                    ],
                ],
                'excepcional' => [
                    'tipos' => [
                        'EVE' => [
                            'name' => 'Certificado de residencia para fines de Estudio, Vivienda, y Empleo',                            'requiere_formulario' => false,
                            'plantilla' => storage_path('app/public/EVE-Excepcional.docx'),
                            'documentos'=> ['Certificado de la junta de acción comunal',
                            'Certificado de estudio', 'Certificado de afiliación a EPS',
                            'Certificado Laboral'],

                        ],
                        'PPL' => [
                            'name' => 'Certificado de residencia para personas Privadas de la Libertad',
                            'requiere_formulario' => true,
                            'plantilla' => storage_path('app/public/pplExcepcional.docx'),
                            'documentos'=> ['Certificado de la junta de acción comunal',
                            'Certificado de estudio', 'Certificado de afiliación a EPS',
                            'Certificado Laboral'],
                        ],
                        'PEPA' => [
                            'name' => 'Certificado de residencia para permiso especial - porte y salvoconducto de armas',
                            'requiere_formulario' => false,
                            'plantilla' => storage_path('app/public/comunExcepcional.docx'),
                            'documentos'=> ['Certificado de la junta de acción comunal',
                            'Certificado de estudio', 'Certificado de afiliación a EPS',
                            'Certificado Laboral'],
                        ],
                        'TAPEP' => [
                            'name' => 'Certificado de residencia para trabajo en las áreas de influencia de los proyectos de exploración y explotación petrolera y minera',
                            'requiere_formulario' => false,
                            'plantilla' => storage_path('app/public/comunExcepcional.docx'),
                            'documentos'=> ['Certificado de afiliación a la junta de acción comunal'],
                        ],
                    ],
                ],
            ],
        ];
    }
}
