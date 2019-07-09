export const CONSTANTS = {
    img: {
        unsort: 'glyphicon glyphicon-sort',
        sort_abc_asc: 'glyphicon glyphicon-sort-by-alphabet',
        sort_abc_desc: 'glyphicon glyphicon-sort-by-alphabet-alt'
    },

    stateMessages: {
        stepFinished: 'Nota: Este paso ya ha sido finalizado, al editarse todos los campos obligatorios deben ser diigenciados.',
        state: (isFinished) => `${isFinished ? 'Finalizado' : 'En proceso'}.`,
        fieldRequired: (name, gender) => `${gender == 'm' ? 'El' : 'La'} ${name} es ${gender == 'm' ? 'requerido' : 'requerida'}.`
    },

    date_picker: {
        style: {
            type: 'day',
            week: ['Lun', 'Mar', 'Mie', 'Jue', 'Vie', 'Sab', 'Dom'],
            month: ['Enero', 'Febero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octobre', 'Noviembre', 'Diciembre'],
            format: 'YYYY-MM-DD',
            placeholder: 'aaaa/mm/dd',
            inputStyle: {
                'display': 'block',
                'padding': '0px 12px',
                'width': '100%',
                'height': '36px',
                'font-size': '14px',
                'font-family': 'Open Sans',
                'line-height': '1.6',
                'color': '#555555',
                'background-color': '#fff',
                'background-image': 'none',
                'border': '1px solid #ccd0d2',
                'border-radius': '4px',
                'box-shadow': 'inset 0 1px 1px rgba(0, 0, 0, 0.075)'

            },
            color: {
                header: '#0095da',
                headerText: '#ffffff'
                
            },
            buttons: {
                ok: 'Aceptar',
                cancel: 'Cancelar'
            },
            overlayOpacity: 0.5,
            dismissible: true
        }

    },

    descripcion: {
        tooltips: {
            main: '',
            descripcion: 'En este espacio por favor describa detalladamente en qué consiste el activo intangible que se está incluyendo en el inventario. Por ejemplo, si el activo intangibles es una publicación, poster, o cualquier otro documento resultado de actividades de investigación y desarrollo, describa el activo intangible de tal forma que cualquier persona pueda saber en qué consiste:  por ejemplo que es una publicación, escriba el título de la misma, en que revista o publicación se encuentra, en donde se encuentra depositado (biblioteca, repositorio, etc.), nombre del proyecto de investigación del cual es un resultado, quiénes son las autores, etc.',
            descripcion_adjuntos: 'Adjunte por favor todos los documentos que soporten la descripción que se hizo del activo intangible. Por ejemplo, si el activo intangible es una publicación, adjunte de ser posible una copia de la publicación, la fotografía, etc.'
        }
    },

    clasificacion: {
        tooltips: {
            main: '',
            clasificacion: 'Seleccione de las siguientes opciones la que mejor describa o caracterice al activo intangible que se está inventariando. Por ejemplo, si el activo intangible que se está inventariando es un artículo de investigación puede seleccionarse la opción “ Publicación” o “Artículo” (cuando no ha sido publicado), pero si por el contrario el activo intangible es por ejemplo una metodología, un proceso, o un método puede seleccionarse entre las opciones “Resultado de I+D”; “Tesis”; “Información confidencial”; “Otro”, dependiendo de la naturaleza misma del activo no del derecho de propiedad que lo podría proteger (puede haber más de un DPI aplicable).',
            clasificacion_adjuntos: 'En este espacio adjunte cualquier archivo que se relacione con la opción seleccionada si es el caso. Por ejemplo, la obra musical, el guion, el documento publicado (o la referencia o link donde se puede obtener), el diseño, el plano, etc.'
        }
    },

    estado: {
        tooltips: {
            main: '',
            estado: 'En esta opción seleccione si previamente se había identificado el activo pero no se había protegido, o si por el contrario se había identificado y se protegió debidamente o nunca se había identificado.'
        }
    },

    dpi_asociado: {
        tooltips: {
            main: '',
            dpi_asociado: 'Cada activo intangible puede tener uno o más derechos de propiedad intelectual asociados para su protección. Por ejemplo, un software puede protegerse a través del Derecho de Autor, pero también a través de una patente si cumple con los requisitos y soluciona un problema técnico, este software puede tener una marca asociada y también un diseño industrial para proteger su interfaz, y muchos otros. En esta opción seleccione todos los DPI que se le puedan asociar según su conocimiento.'
        }
    },
    

    estado_actual: {
        tooltips: {
            main: '',
            publicado_divulgado: 'Indique si el activo intangible ha sido divulgado de cualquier forma.',
            lugar_publicacion: 'indique el nombre del medio y de ser posible el lugar donde se realizó la publicación sea en medio impreso, digital. electrónico (Por ejemplo: revista “XX” publicada en la fecha “YY” y está disponible en la biblioteca o en la página web “ZZZ”) o el foro, seminario, congreso, conferencia, etc., mecanismo, medio o forma de divulgación y en donde se encuentra depositado o accesible al público.',
            fecha_publicacion: 'Indique el año, mes y día de la publicación.',
            contrato_confidencialidad: 'Indique si en relación al activo intangible existen contratos de confidencialidad con las personas que tienen relación con el mismo, bien para cuestiones laborales, comerciales o de investigación, o que han participado en su desarrollo, uso, manejo, archivo, conservación, explotación económica, etc. particularmente si no son servidores públicos o contratistas de la Universidad con quienes pueda existir ya una obligación previa de confidencialidad (en sus respectivos contratos).',
            contrato_confidencialidad_adjunto: 'Adjuntar contrato de confidencialidad firmado.',
            nombre_titular: 'Indique el nombre de la persona, natural o jurídica, que es titular de los derechos que se asocian el activo intangible. El titular originario es siempre la persona natural que es el autor, desarrollador, diseñador, creador o inventor, pero esta calidad puede transferirse a un tercero persona natural o jurídica. Esta transferencia debe hacer a través de un contrato de cesión de derecho el cual debe constar por escrito, debe indicar que se hace la cesión de manera permanente (no por un tiempo limitado) y para todo el mundo (no restringida a un territorio en específico), a menos se acuerde algo en contrario y este acuerdo este firmado por el representante legal de la Universidad.',
            contrato_cesion: 'El contrato de cesión es un contrato por medio del cual se cede la titularidad de todo o parte de los DPI asociados al AI a otra persona (en este caso, usualmente a la Universidad por los autores o inventores sobre las obras protegidas por el derecho de autor o una patente, por ejemplo).  Recuerde por favor que puede haber más de un DPI asociado y por esa razón puede ser necesario incluir uno o más contratos de cesión. Igualmente recuerde que puede ser necesario registrar esos contratos de cesión ante la autoridad nacional competente del país donde se desean hacer oponibles a terceros.',
            contrato_cesion_adjunto: 'Adjuntar contrato de cesión firmado.',
            ubicacion_ai: 'Indique en esta opción el lugar (o lugares) físico, digital o virtual donde se encuentra ubicado el activo intangible.',
            en_contabilidad: 'en contabilidad', 
            valor_de_ai: 'Indique si el AI se encuentra incorporado en la contabilidad de la Universidad. En caso de que la respuesta sea sí, por favor indique a continuación el valor por el cual se incorporó a la contabilidad y comentarios adicionales como por ejemplo la fecha de inclusión en la contabilidad.'
        }
    },

    comentarios: {
        tooltips: {
            main: '',
            comentarios: 'En este espacio indique todos los comentarios que tenga adicional sobre la información que se ha diligenciado y que sea importante para la evaluación del activo intangible. Por ejemplo, comentarios sobre la firma de los contratos de cesión, comentarios sobre la clasificación del activo intangible o sobre su estado de identificación y protección. En este espacio puede hacer todas las anotaciones que sean necesarias y que considere pertinente.'
        }
    },

    proteccion: {
        tooltips: {
            main: 'Esta etapa es para la formulación del plan de acción que permita superar o corregir los riesgos o debilidades detectadas en relación a los AI o a sus DPI asociados y  asegurar o proteger el AI o o el DPI identificado.  Esta etapa y la información aquí incluida permitirá no solo proteger el AI y sus DPI, sino poder usarlos, administrarlos, comercializarlos, licenciarlos, defenderlos o transferirlos.  Igualmente permitirá planear los recursos económicos que se requerirán para la protección, incorporación a la contabilidad, licenciarlos o defenderlos frente a posibles infractores.',
            deposito_da:'En esta sección si el Derecho de Autor no es un DPI asociado al activo intangible, marque la opcion “No”.',
            registro_da: 'En esta sección si el Derecho de Autor no es un DPI asociado al activo intangible, marque las opciones “No”.',
            numero_registro_da: 'Indique el número de referencia',
            medidas_proteccion: 'Se sugiere tomar medidas razonables para la protección de los secretos empresariales?',
            cuales_medidas: ' Indique cuáles medidas razonables se deben tomar para mantener la información confidencial y secreto. Por ejemplo, medidas físicas como marcas de agua en los documentos, carpetas especiales, lugares dispuestos con acceso restringido; o medidas virtuales como documentos encriptados, contraseñas, entre otros.',
            
            propiedad_industrial: 'Se sugiere registro/depósito de algún derecho de propiedad industrial?',
            propiedad_industria_deposito: 'Seleccione todos los derechos de propiedad industrial que apliquen',

            propiedad_industria_registro: 'Seleccione todos los DPI que apliquen y posteriormente indique el número de referencia del registro/depósito.',
            
            contratos: 'Indique si se sugiere la suscripción de algún tipo de contrato que se requiere para la debida protección y gestión del activo intangible.',
            cuales_contratos: 'Cuál contrato se sugiere?'
        }
    },

    priorizacion: {
        tooltips: {
            main: 'Herramientas evaluación de registrabilidad y/o priorización para tomar decisiones sobre la protección, gestión, uso, comercialización, transferencia, monetización o defensa del DPI asociado al AI.',
            busqueda: 'indique si se necesita o requiere el uso de alguna de las herramientas de evaluación de registrabilidad o de priorización como vigilancias tecnológicas, libertades de operación, estudios de mercado, patent landscaping u otros.',
            presupuesto_priorizacion: 'Si la respuesta es SI, por favor indique el presupuesto aproximado anual o semestral para poder invertir en Protección de los DPI y si el mismo cubre lo incorporado en el Plan de Acción o que actividades de priorización va a usar.',
            cantidad_presupuesto: 'Indique cuanto presupuesto existe'

        }
    },

    usoComercial: {
        tooltips: {
            main: '',
            uso_comercial: 'Describa el uso comercial del DPI (o DPI´s) asociados al AI y provea detalles de ese uso o si se tiene pensado hacerlo, y a continuación descríbalo.'
        }
    },

    estrategiasGestion: {
        tooltips: {
            main: '',
            estrategias: 'De acuerdo a la información recogida en el diligenciamiento, describa cuáles son las sugerencias y estrategias generales para la gestión, gerencia y administración del activo intangible y los derechos de propiedad intelectual asociados.'
        }
    }

}
