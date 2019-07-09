<?php

return (Object)  [
    'invitationDaysExpiration' => 10,

    'config' => (Object) [
        'nullParam' => 'null',
        'sortAsc' => 'asc',
        'sortDesc' => 'desc',
        'sortAscImg' =>'glyphicon-sort-by-alphabet',
        'sortDescImg' => 'glyphicon-sort-by-alphabet-alt',
        'sortImg' => 'glyphicon-sort'
    ],

    'archivos' => (Object) [
        'descripcion' => (Object) [
            'dir' => 'descripcion_adjuntos'
        ]
    ],

    'sideMenu' => (Object) [
        'Reporte' => (Object) [
            'clickeable' => true,
            'selected' => true,
            'title' => 'Activo intangible',
            'img' => 'glyphicon-list-alt',
            'url' => 'activo',
            'name' => 'Activo'
        ],

        'steps' => (Object) [
            'clickeable' => false,
            'title' => 'Formulario',
            'selected' => false,
            'img' => 'glyphicon-th-list',
            'name' => 'Formulario',
            'percentage_complete' => 0,
            'url' => 'diligencia',
            'size' => 9,
            'submenus' => (Object) [
                '1' => (Object) [
                    'step' => 1,
                    'available' => true,
                    'component' => 'activos-descripcion',
                    'clickeable' => true,
                    'selected' => false,
                    'url' => 'descripcion',
                    'name' => 'Descripción',
                    'size' => 1,
                    'fields' => (Object) [
                        'descripcion' => (Object) [
                            'name' => 'descripcion',
                            'required' => true,
                            'textAlert' => false,
                            'finished' => false,
                            'type' => 'text',
                        ],

                        'descripcion_adjuntos' => (Object) [
                            'name' => 'descripcion_adjuntos',
                            'type' => 'adjunto',
                            'textAlert' => false,
                            'required' => false,
                            'finished' => false
                        ]
                    ],

                    'percentage_complete' => 0,
                ],

                '2' => (Object) [
                    'step' => 2,
                    'component' => 'activos-clasificacion',
                    'clickeable' => true,
                    'available' => false,
                    'selected' => false,
                    'url' => 'clasificacion',
                    'name' => 'Clasificación',
                    'percentage_complete' => 0,
                    'size' => 1,
                    'fields' => (Object) [
                        'clasificacion' => (Object) [
                            'name' => 'clasificacion',
                            'required' => true,
                            'textAlert' => false,
                            'finished' => false,
                            'type' => 'select-only',
                            'values' => (Object) [
                                'logos_signos_palabras' => 'Logos, signos, palabras o frases distintivas',
                                'publicacion' => 'Publicación',
                                'articulo' => 'Artículo',
                                'ensayo' => 'Ensayo',
                                'presentacion' => 'Presentación',
                                'poster' => 'Poster',
                                'diseño' => 'Diseños',
                                'planos_esquemas' => 'Planos, esquemas, representaciones gráficas, dibujos, posters, fotografías',
                                'lema' => 'Lema',
                                'resultadoID' => 'Resultado de I+D',
                                'audiovisual' => 'Obra Audiovisual',
                                'musical' => 'Obra musical',
                                'info' => 'Información confidencial',
                                'software' => 'Software',
                                'base_datos' => 'Base de datos',
                                'know_how' => 'Know-how',
                                'otro' => 'Otro' ,
                            ],

                            'descripciones' => (Object) [
                                'logos_signos_palabras' => (Object) [
                                    'nombre' => 'Logos, signos, palabras o frases distintivas',
                                    'descripcion' => 'Corrientemente están asociadas y sirven para identificar, individualizar o hacer distintivo un producto o un servicio. No es necesario que se hayan solicitado o registrado  como maca o lema comercial ante la autoridad competente (en Colombia la Superintendencia de Industria y Comercio).'
                                ],

                                'publicacion' => (Object) [
                                    'nombre' => 'Publicación',
                                    'descripcion' => 'Documento escrito que ha sido puesto a disposición del público en alguna revista nacional o internacional, indexada o no indexada, en algún portal, página web, blog, etc. y en lo posible identifique el medio en el que se hizo la publicación en la descripción que puede ser científico, técnico o artístico y resultado de las actividades académicas o de I+D+i+e.  Si esta publicación se trata de un libro, una tesis de grado u otra clase de publicación independientemente del medio (impreso, digital electrónico, etc.) se debe indicar esta clase de publicación de preferencia. '
                                ],
                                
                                'articulo' => (Object) [
                                    'nombre' => 'Artículo',
                                    'descripcion' => 'Documento escrito que no ha sido publicado o está en proceso de ser publicado y que puede ser científico, técnico o artístico y resultado de las actividades académicas o de I+D+i+e. ',
                                ],
                                'ensayo' => (Object) [
                                    'nombre' => 'Ensayo',
                                    'descripcion' => ' Documento escrito que puede ser científico, técnico o artístico. ',
                                ],
                                'presentacion' => (Object) [
                                    'nombre' => 'Presentación',
                                    'descripcion' => 'Documento escrito resultado de las actividades académicas o de I+D+i+e. ',
                                ],
                                'poster' => (Object) [
                                    'nombre' => 'Poster',
                                    'descripcion' => 'Imagen o representación gráfica con contenido científico técn+co o artístico, resultado de las actividades académicas o de I+D+i+e ',
                                ],
                                'diseño' => (Object) [
                                    'nombre' => 'Diseños',
                                    'descripcion' => 'Es el documento que contiene la apariencia particular de un producto que resulte de cualquier reunión de líneas o combinación de colores, o de cualquier forma externa bidimensional o tridimensional, línea, contorno, configuración, textura o material, sin que cambie el destino o finalidad de dicho producto.'
                                ],

                                'planos_esquemas' => (Object) [
                                    'nombre' => 'Planos, esquemas, representaciones gráficas, dibujos, posters, fotografías',
                                    'descripcion' => 'Documentos que hacen representaciones gráficas, esquemáticas, artísticas, técnicas o científicas.'
                                ],

                                'lema' => (Object) [
                                    'nombre' => 'Lema',
                                    'descripcion' => 'Son las frases que acompañan una marca que distinguen un producto o servicio en el mercado. Seleccionarlas en esta categoría sin importar si aún no se han solicitado ante la autoridad competente.'
                                ],

                                'resultadoID' => (Object) [
                                    'nombre' => 'Resultado de I+D',
                                    'descripcion' => 'Aquí se agrupa el conjunto de documentos, diseños, modelos, inventos, prototipos, productos, subproductos, metodologías o procesos que resulten de las actividades de investigación y desarrollo ya sea que se hayan desarrollado en un proyecto de la Universidad (o de un miembro de la comunidad universitaria), o de la Universidad con un tercero. Use esta opción cuando crea que no hay otra que identifique, describa o individualice mejor el activo intangible identificado.'
                                ],

                                'audiovisual' => (Object) [
                                    'nombre' => 'Obra Audiovisual',
                                    'descripcion' => 'Es una obra que puede tener contenido artístico, científico o técnico que pueden componerse de  varios activos intangibles que en individualmente también son activos intangibles y podrían protegerse individualmente.  Por favor tome en cuenta que cada uno debe identificarse e inventariarse de manera independiente, por ejemplo, música que se crea para su banda sonora, el guion, los dibujos animados, los signos distintivos que individualiza e identifica la obra,  entre otros.'
                                ],

                                'musical' => (Object) [
                                    'nombre' => 'Obra musical',
                                    'descripcion' => 'Las obras musicales, al igual que las obras audiovisuales, pueden estar conformados por muchos activos intangibles. Por ejemplo, un activo intangible es la letra de la canción y otro activo intangible es la pista instrumental. Y si es así, por favor identifíquelos e inventaríelos de manera independiente.'
                                ],

                                'info' => (Object) [
                                    'nombre' => 'Información confidecial',
                                    'descripcion' => 'Se refiere a toda la información que no es de carácter público y que por estrategia su acceso es limitado al personal autorizado. Por ejemplo. la información de un resultado de I+D puede ser confidencial antes de que se solicite una patente.'
                                ],

                                'software' => (Object) [
                                    'nombre' => 'Software',
                                    'descripcion' => 'Si el activo intangible identificado es un programa de ordenador o instrucciones o tareas para una computadora, deberá seleccionarse esta opción.'
                                ],

                                'base_datos' => (Object) [
                                    'nombre' => 'Base de datos',
                                    'descripcion' => 'Compilación de datos o información, independientemente que existan en forma impresa, en unidades de almacenamiento en computador o de cualquier otra forma, seleccionados y dispuestos original y sistemáticamente para su posterior uso.'
                                ],

                                'know_how' => (Object) [
                                    'nombre' => 'Know-how',
                                    'descripcion' => 'Conjunto estructurado o no estructurado de saber hacer o saber producir o saber creado, desarrollado, organizado u obtenido.'
                                ],

                                'otro' => (Object) [
                                    'nombre' => 'Otro',
                                    'descripcion' => 'Cuando el activo intangible identificado no se encuentre dentro de las opciones específicas deberá seleccionarse esta opción y hacerse precisión en cuál es la clasificación. '
                                ],
                                
                            ]
                        ],

                        'cual' => (Object) [
                            'name' => 'cual',
                            'required' => true,
                            'textAlert' => false,
                            'finished' => false,
                            'type' => 'text',
                            'reference_to_resp' => 'otro',
                            'reference_to'=> 'clasificacion'
                        ],

                        'clasificacion_adjuntos' => (Object) [
                            'name' => 'clasificacion_adjuntos',
                            'required' => false,
                            'textAlert' => false,
                            'finished' => false,
                            'type' => 'adjunto'
                        ]
                    ]
                ],

                '3' => (Object) [
                    'step' => 3,
                    'component' => 'activos-estado',
                    'clickeable' => true,
                    'available' => false,
                    'selected' => false,
                    'url' => 'estado',
                    'name' => 'Estado',
                    'percentage_complete' => 0,
                    'size' => 1,
                    'fields' => (Object) [
                        'estado' => (Object) [
                            'name' => 'estado',
                            'required' => true,
                            'textAlert' => false,
                            'finished' => false,
                            'type' => 'select-only',
                            'values' => (Object) [
                                'no_identificado' => 'No identificado',
                                'identificado_no_protegido' => 'Identificado y no protegido',
                                'identificado_protegido' => 'Identificado y protegido',
                            ],

                            'descripciones' => (Object) [
                                'no_identificado' => (Object) [
                                    'nombre' => 'No identificado',
                                    'descripcion' => 'Si el activo intangible no se había detectado, caracterizado o identificado como activo intangible hasta la fecha.'
                                ],
                                'identificado_no_protegido' => (Object) [
                                    'nombre' => 'Identificado y no protegido',
                                    'descripcion' => 'Si el activo intangible se había detectado, caracterizado o identificado  pero no se han protegido los derechos de propiedad intelectual asociados al mismo.',
                                ],

                                'identificado_protegido' => (Object) [
                                    'nombre' => 'Identificado y protegido',
                                    'descripcion' => 'Si se ha detectado, caracterizado o identificado  y se han protegido los derechos de propiedad intelectual asociados al mismo.'
                                ]
                            ]
                        ]
                    ]
                ],
                
                '4' => (Object) [
                    'step' => 4,
                    'component' => 'activos-dpi-asociado',
                    'clickeable' => true,
                    'available' => false,
                    'selected' => false,
                    'url' => 'dpiAsociado',
                    'name' => 'DPI asociados',
                    'percentage_complete' => 0,
                    'size' => 1,
                    'fields' => (Object) [
                        'dpi_asociado' => (Object) [
                            'name' => 'dpi_asociado',
                            'required' => true,
                            'textAlert' => false,
                            'finished' => false,
                            'industry' => false,
                            'type' => 'select-multi',
                            // 'values' => [
                            //     (Object) ['id' => 'derecho_autor', 'name' => 'Derecho de autor'],
                            //     (Object) ['id' => 'esquema_trazado', 'name' => 'Esquemas de trazado'],
                            //     (Object) ['id' => 'diseño_industrial', 'name' => 'Diseño industrial'],
                            //     (Object) ['id' => 'secreto_empresarial', 'name' => 'Secreto empresarial'],
                            //     (Object) ['id' => 'patente_invencion', 'name' => 'Patente de invencion'],
                            //     (Object) ['id' => 'variedades_vegetales', 'name' => 'Variedades vegetales'],
                            //     (Object) ['id' => 'signos_distintivos', 'name' => 'Signos distintivos']
                            // ]

                        ]
                    ]
                ],
                '5' => (Object) [
                    'step' => 5,
                    'component' => 'activos-estado-actual',
                    'clickeable' => true,
                    'available' => false,
                    'selected' => false,
                    'url' => 'estadoActual',
                    'name' => 'Estado Actual del AI',
                    'percentage_complete' => 0,
                    'size' => 6,
                    'fields' => (Object) [
                        'publicado_divulgado' => (Object) [
                            'name' => 'publicado_divulgado',
                            'required' => true,
                            'textAlert' => false,
                            'finished' => false,
                            'type' => 'select-only',
                            'values' => (Object) [
                                'si' => 'Si',
                                'no' => 'No',
                            ],
                        ],

                        'lugar_publicacion' => (Object) [
                            'name' => 'lugar_publicacion',
                            'required' => true,
                            'textAlert' => false,
                            'finished' => false,
                            'type' => 'text',
                            'reference_to_resp' => 'si',
                            'reference_to'=> 'publicado_divulgado'
                        ],

                        'fecha_publicacion' => (Object) [
                            'name' => 'fecha_publicacion',
                            'required' => true,
                            'textAlert' => false,
                            'finished' => false,
                            'type' => 'date',
                            'reference_to_resp' => 'si',
                            'reference_to'=> 'publicado_divulgado',
                        ],

                        'contrato_confidencialidad' => (Object) [
                            'name' => 'contrato_confidencialidad',
                            'required' => true,
                            'textAlert' => false,
                            'finished' => false,
                            'type' => 'select-only',
                            'values' => (Object) [
                                'si' => 'Si',
                                'no' => 'No'
                            ]
                        ],

                        'contrato_confidencialidad_adjunto' => (Object) [
                            'name' => 'contrato_confidencialidad_adjunto',
                            'required' => true,
                            'textAlert' => false,
                            'finished' => false,
                            'type' => 'adjunto',
                            'reference_to_resp' => 'si',
                            'reference_to'=> 'contrato_confidencialidad'
                        ],

                        // 'tiene_titular' => (Object) [
                        //     'name' => 'tiene_titular',
                        //     'required' => true,
                        //     'textAlert' => false,
                        //     'finished' => false,
                        //     'type' => 'select-only',
                        //     'values' => (Object) [
                        //         'si' => 'Si',
                        //         'no' => 'No',
                        //         'nose' => 'No se sabe'
                        //     ]
                        // ],

                        // 'nombre_titular' => (Object) [
                        //     'name' => 'nombre_titular',
                        //     'required' => true,
                        //     'textAlert' => false,
                        //     'finished' => false,
                        //     'type' => 'texto',
                        //     'reference_to_resp' => 'si',
                        //     'reference_to'=> 'tiene_titular'
                        // ],

                        'nombre_titular' => (Object) [
                            'name' => 'nombre_titular',
                            'required' => true,
                            'textAlert' => false,
                            'finished' => false,
                            'type' => 'texto'
                        ],


                        'contrato_cesion' => (Object) [
                            'name' => 'contrato_cesion',
                            'required' => true,
                            'textAlert' => false,
                            'finished' => false,
                            'type' => 'select-only',
                            'values' => (Object) [
                                'si' => 'Si',
                                'no' => 'No'
                            ]
                        ],

                        'contrato_cesion_adjunto' => (Object) [
                            'name' => 'contrato_cesion_adjunto',
                            'required' => true,
                            'textAlert' => false,
                            'finished' => false,
                            'type' => 'adjunto',
                            'reference_to_resp' => 'si',
                            'reference_to'=> 'contrato_cesion'
                        ],
                        
                        'ubicacion_ai' => (Object) [
                            'name' => 'ubicacion_ai',
                            'required' => true,
                            'textAlert' => false,
                            'finished' => false,
                            'type' => 'texto'
                        ],

                        'en_contabilidad' => (Object) [
                            'name' => 'en_contabilidad',
                            'required' => true,
                            'textAlert' => false,
                            'finished' => false,
                            'type' => 'select-only',
                            'values' => (Object) [
                                'si' => 'Si',
                                'no' => 'No'
                            ]
                        ],

                        'valor_de_ai' => (Object) [
                            'name' => 'valor_de_ai',
                            'required' => true,
                            'textAlert' => false,
                            'finished' => false,
                            'type' => 'number',
                            'reference_to_resp' => 'si',
                            'reference_to'=> 'en_contabilidad'
                        ],

                        'valor_de_ai_comentarios' => (Object) [
                            'name' => 'valor_de_ai_comentarios',
                            'required' => true,
                            'textAlert' => false,
                            'finished' => false,
                            'type' => 'text',
                            'reference_to_resp' => 'si',
                            'reference_to'=> 'en_contabilidad'
                        ],


                    ]
                ],

                '6' => (Object) [
                    'step' => 6,
                    'component' => 'activos-comentarios',
                    'clickeable' => true,
                    'available' => false,
                    'selected' => false,
                    'url' => 'comentarios',
                    'name' => 'Comentarios',
                    'percentage_complete' => 0,
                    'size' => 1,
                    'fields' => (Object) [
                        'comentarios' => (Object)[
                        'name' => 'comentarios',
                        'required' => false,
                        'textAlert' => false,
                        'finished' => false,
                        'type' => 'text'
                        ]
                    ],
                ],
                
                '7' => (Object) [
                    'step' => 7,
                    'component' => 'activos-plan-proteccion',
                    'clickeable' => true,
                    'available' => false,
                    'selected' => false,
                    'url' => 'proteccion',
                    'name' => 'Plan de acción y protección',
                    'percentage_complete' => 0,
                    'size' => 4,
                    'fields' => (Object) [
                        'deposito_da' => (Object) [
                            'name' => 'deposito_da',
                            'required' => true,
                            'textAlert' => false,
                            'finished' => false,
                            'type' => 'select-only',
                            'values' => (Object) [
                                'si' => 'Si',
                                'no' => 'No'
                            ],
                        ],

                        'registro_da' => (Object) [
                            'name' => 'registro_da',
                            'required' => true,
                            'textAlert' => false,
                            'finished' => false,
                            'type' => 'select-only',
                            'reference_to'=> 'deposito_da',
                            'reference_to_resp' => 'no',
                            'values' => (Object) [
                                'si' => 'Si',
                                'no' => 'No'
                            ],

                        ],
    
                        'numero_registro_da' => (Object) [
                            'name' => 'numero_registro_da',
                            'required' => true,
                            'textAlert' => false,
                            'finished' => false,
                            'type' => 'text',
                            'reference_to_resp' => 'si',
                            'reference_to'=> 'deposito_da'
                        ],

                        'medidas_proteccion' => (Object) [
                            'name' => 'medidas_proteccion',
                            'required' => true,
                            'textAlert' => false,
                            'finished' => false,
                            'type' => 'select-only',
                            'values' => (Object) [
                                'si' => 'Si',
                                'no' => 'No'
                            ],
                        ],
                        
                        'cuales_medidas' => (Object) [
                            'name' => 'cuales_medidas',
                            'required' => true,
                            'textAlert' => false,
                            'finished' => false,
                            'type' => 'number',
                            'reference_to_resp' => 'si',
                            'reference_to'=> 'medidas_proteccion'
                        ],

                        'propiedad_industrial' => (Object) [
                            'name' => 'propiedad_industrial',
                            'required' => true,
                            'textAlert' => false,
                            'finished' => false,
                            'type' => 'select-only',
                            'values' => (Object) [
                                'si' => 'Si',
                                'no' => 'No'
                            ],
                        ],

                        'propiedad_industria_deposito' => (Object) [
                            'name' => 'propiedad_industria_deposito',
                            'required' => true,
                            'textAlert' => false,
                            'finished' => false,
                            'type' => 'select-multi',
                            'reference_to' => 'propiedad_industrial',
                            'reference_to_resp' => 'si',
                            'industry' => true,
                        ],
                        
                        'propiedad_industria_registro' => (Object) [
                            'name' => 'propiedad_industria_registro',
                            'required' => false,
                            'textAlert' => false,
                            'finished' => false,
                            'subValues' => true,
                            'type' => 'select-multi',
                            'industry' => true,
                        ],

                        'contratos' => (Object) [
                            'name' => 'contratos',
                            'required' => true,
                            'textAlert' => false,
                            'finished' => false,
                            'type' => 'select-only',
                            'values' => (Object) [
                                'si' => 'Si',
                                'no' => 'No'
                            ],
                        ],

                        'cuales_contratos' => (Object) [
                            'name' => 'cuales_contratos',
                            'required' => true,
                            'textAlert' => false,
                            'finished' => false,
                            'type' => 'text',
                            'reference_to_resp' => 'si',
                            'reference_to' => 'contratos'
                        ]

                    ]
                ],

                '8' => (Object) [
                    'step' => 8,
                    'component' => 'activos-priorizacion',
                    'clickeable' => true,
                    'available' => false,
                    'selected' => false,
                    'url' => 'priorizacion',
                    'name' => 'Priorización y decisión',
                    'percentage_complete' => 0,
                    'size' => 2,
                    'fields' => (Object) [

                        'busqueda' => (Object) [
                            'name' => 'busqueda',
                            'required' => true,
                            'textAlert' => false,
                            'finished' => false,
                            'type' => 'select-only',
                            'values' => (Object) [
                                'si' => 'Si',
                                'no' => 'No'
                            ],
                        ],

                        'herramientas' => (Object) [
                            'name' => 'herramientas',
                            'required' => true,
                            'textAlert' => false,
                            'finished' => false,
                            'subValues' => true,
                            'type' => 'select-multi',
                            'reference_to' => 'busqueda',
                            'reference_to_resp' => 'si',
                            'industry' => true,
                        ],

                        'presupuesto_priorizacion' => (Object) [
                            'name' => 'presupuesto_priorizacion',
                            'required' => true,
                            'textAlert' => false,
                            'finished' => false,
                            'type' => 'select-only',
                            'values' => (Object) [
                                'si' => 'Si',
                                'no' => 'No'
                            ]
                        ],

                        'cantidad_presupuesto' => (Object) [
                            'name' => 'cantidad_presupuesto',
                            'required' => true,
                            'textAlert' => false,
                            'finished' => false,
                            'type' => 'number',
                            'reference_to_resp' => 'si',
                            'reference_to'=> 'presupuesto_priorizacion'
                        ]
                        

                    ]

                ],
                
                '9' => (Object) [
                    'step' => 9,
                    'component' => 'activos-uso-comercial',
                    'clickeable' => true,
                    'available' => false,
                    'selected' => false,
                    'url' => 'usoComercial',
                    'name' => 'Uso comercial',
                    'percentage_complete' => 0,
                    'size' => 1,
                    'fields' => (Object) [

                        'uso_comercial' => (Object) [
                            'name' => 'uso_comercial',
                            'required' => true,
                            'textAlert' => false,
                            'finished' => false,
                            'type' => 'select-only',
                            'values' => (Object) [
                                'si' => 'Si',
                                'no' => 'No'
                            ],
                        ],
                        'cual_uso_comercial' => (Object) [
                            'name' => 'cual_uso_comercial',
                            'required' => true,
                            'textAlert' => false,
                            'finished' => false,
                            'type' => 'text',
                            'reference_to_resp' => 'si',
                            'reference_to'=> 'uso_comercial'
                        ]
                    ]
                ],
                // '10' => (Object) [
                //     'step' => 10,
                //     'component' => 'activos-estrategias-gestion',
                //     'clickeable' => true,
                //     'available' => false,
                //     'selected' => false,
                //     'url' => 'estrategiasGestion',
                //     'name' => 'Estrategias de gestión',
                //     'percentage_complete' => 0,
                //     'size' => 1,
                //     'fields' => (Object) [

                //         'estrategias' => (Object) [
                //             'name' => 'estrategias',
                //             'required' => true,
                //             'textAlert' => false,
                //             'finished' => false,
                //             'type' => 'text'
                //         ]
                //     ]
                // ]
            ]
        ],

        // 'Historial' => (Object) [
        //     'clickeable' => true,
        //     'selected' => false,
        //     'img' => 'glyphicon-time',
        //     'url' => 'historial',
        //     'name' => 'Historial'
        // ],

        'Salir' => (Object) [
            'clickeable' => true,
            'title' => 'Salir del activo',
            'selected' => false,
            'img' => 'glyphicon-log-out',
            'url' => 'salir',
            'name' => 'Salir'
        ]
    ],

    'resources' => (Object) [

        'proyectos' => (Object) [
            'name' => 'proyectos',
            'basePath' => 'proyectos',
            'apiBasePath' => 'api-proyectos',
            'apiPath' => 'api-proyectos/{nombre?}/{users?}/{descripcion?}/{sortField?}/{dir?}',
            'apiController' => 'ProyectoController@apiIndex',
            'controller' => 'ProyectoController',
            'pagination' => 10,
            'fields' => (Object) [
                'nombre' => (Object) [
                    'name' => 'nombre',
                    'type' => 'text'
                ],

                'encargado' => (Object) [
                    'name' => 'encargado',
                    'type' => 'select',
                    'relation' => 'users',
                ],
                'descripcion' => (Object) [
                    'name' => 'descripcion',
                    'type' => 'text',
                ]
            ]
        ],

        'users' => (Object) [
            'name' => 'users',
            'basePath' => 'users',
            'apiBasePath' => 'api-users',
            'apiPath' => 'api-users/{nombre?}/{email?}/{roles?}/{sortField?}/{dir?}',
            'controller' => 'UserController',
            'apiController' => 'UserController@apiIndex',
            'pagination' => 10,

            'fields' => (Object) [
                'nombre' => (Object) [
                    'name' => 'nombre',
                    'type' => 'text'
                ],

                'email' => (Object) [
                    'name' => 'email',
                    'type' => 'text'
                ],

                'rol' => (Object) [
                    'name' => 'rol',
                    'type' => 'select',
                    'relation' => 'roles'
                ]
            ]
        ],
        
        'activos' => (Object) [
            'name' => 'activos',
            'basePath' => 'activos',
            'apiBasePath' => '/api-activos',
            'apiPath' => '/api-activos/{proyectos?}/{nombre_asociado?}/{estado_diligencia?}/{sortField?}/{dir?}',
            'controller' => 'ActivoController',
            'apiController' => 'ActivoController@apiIndex',
            'pagination' => 10,

            'fields' => (Object) [
                'proyecto' => (Object) [
                    'name' => 'proyecto',
                    'type' => 'select',
                    'relation' => 'proyectos'
                ],

                'nombre_asociado' => (Object) [
                    'name' => 'nombre_asociado',
                    'type' => 'text'
                ],

                'estado_diligencia' => (Object) [
                    'name' => 'estado_diligencia',
                    'type' => 'select'
                ],

                // 'deleted_at' => (Object) [
                //     'name' => 'borrado',
                //     'type' => 'select'
                // ]
            ]
        ]
    ]

];