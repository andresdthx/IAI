<template lang='html'>
       <transition id="modal" name="modal">
            <div class="modal-mask">
            <div class="modal-wrapper">
                <div class="modal-container" style="font-family: 'Open Sans';width: 800px; padding-bottom: 20px">
                    <span class="glyphicon glyphicon-remove close-modal" @click="$emit('close')" ></span>

                     <h3 class="step-title"><strong>{{data.commit}}</strong></h3>

                        <strong>Fecha de la modificación: </strong> <span>{{data.created_at}}</span>

                        <h4><strong>Responsable de la modificación: </strong></h4>
                            <strong>Nombre: </strong> <span>{{data.responsable_modificacion_nombre}}</span>
                            <br>
                            <strong>Correo electrónico: </strong> <span>{{data.responsable_modificacion_email}}</span>

                        <h4><strong>Cambios realizados: </strong></h4>


                        <template v-for="(field, index) in currentlyData">
                            <div v-if="field.info && ( (field.info.length > 0) || (typeof field.info == 'object') )">

                                <span> <strong>{{field.pregunta}}: </strong></span>


                                <template v-if="field.type == 'list'">
                                    <ul v-if="previusData && previusData[index].info">
                                        <li v-for="item in intersectList( field.info, previusData[index].info )">{{item}}</li>
                                        <li v-for="item in diffListDel( field.info, previusData[index].info  )"><del>{{item}}</del></li>
                                        <li v-for="item in diffListIns( field.info, previusData[index].info )"><ins>{{item}}</ins></li>
                                    </ul>

                                    <ul v-else>
                                        <li v-for="item in field.info"><ins>{{item}}</ins></li>
                                    </ul>
                                </template>

                                <template v-else-if="field.type == 'nested-list'">
                                    <ul v-if="previusData && previusData[index].info">

                                        <li v-for="item in intersectListFullData( field.info, previusData[index].info, field.fullinfo, previusData[index].fullinfo )">{{item.intersection}}
                                            <ul>
                                                <li><strong>Número de registro: </strong><span v-html="item.html"></span></li>
                                            </ul>
                                        </li>

                                        <li v-for="item in diffListDel( field.info, previusData[index].info )"><del>{{item}}</del></li>


                                        <li v-for="item in diffListIns( field.info, previusData[index].info )"><ins>{{item}}</ins>
                                            <ul>
                                                <li><strong>Número de registro: </strong> <ins>{{getVal( item, field.fullinfo )}}</ins> </li>
                                            </ul>
                                        </li>
                                    </ul>

                                    <ul v-else>
                                        <li v-for="(item, index) in field.info"><ins>{{item}}</ins>
                                            <ul>
                                                <li> <strong>Número de registro: </strong> <ins>{{field.fullinfo[index].pivot.numero_registro}}</ins></li>
                                            </ul>
                                        </li>
                                    </ul>
                                </template>


                                <template v-else-if="field.type == 'yesno'">
                                    <span v-if="previusData && previusData[index].info">
                                        <span v-if="diffYesNo(field.info, previusData[index].info)">{{field.info}}</span>
                                        <span v-else><del>{{previusData[index].info}}</del><ins>{{field.info}}</ins></span>
                                    </span>

                                    <span v-else>
                                        <span><ins>{{field.info}}</ins></span>
                                    </span>
                                </template>

                                <template v-else-if="field.type == 'herramientas'">

                                    <span v-if="previusData && previusData[index].info">
                                        <div v-for="(dpi, key) in field.info">
                                            <span> <strong >Herramientas de priorización para {{key.toLowerCase()}}:</strong>
                                                <ul>

                                                    <li v-for="herramienta in getHerramientasIns(dpi, previusData[index].info[key], 'intersectList')">{{herramienta}}</li>
                                                    <li v-for="herramienta in getHerramientasIns(dpi, previusData[index].info[key], 'diffListDel')"><del>{{herramienta}}</del></li>
                                                    <li v-for="herramienta in getHerramientasIns(dpi, previusData[index].info[key], 'diffListIns')"><ins>{{herramienta}}</ins></li>

                                                </ul>
                                            </span>
                                        </div>
                                     </span>

                                     <span v-else>
                                         <div v-for="(dpi, key) in field.info">
                                            <span> <strong >Herramientas de priorización para {{key.toLowerCase()}}:</strong>
                                                <ul>
                                                    <li v-for="herramienta in dpi"><ins>{{herramienta.herramienta}}</ins></li>
                                                </ul>
                                            </span>
                                        </div>
                                     </span>

                                </template>

                                <template v-else>
                                        <span v-if="previusData && previusData[index].info" v-html="test(field.info, previusData[index].info)" ></span>
                                        <span v-else v-html="test(field.info, '')"> </span>
                                </template>
                            </div>

                            <hr v-if="field.newLine">

                        </template>

                 </div>
            </div>
            </div>
        </transition>
</template>


<script>

import diffString from '../../diffString';

export default {
    props: ['data', 'previus', 'clasificaciones', 'estados', 'yesno', 'dpis', 'herramientas'],
    data(){
        return {
            currentlyData: this.getDataStep(this.data),
            previusData: (this.previus ? this.getDataStep(this.previus) : null)
        }
    },
    methods: {

        getHerramientasIns: function(new_, old, method) {
            let newName = _.map(new_, item => item.herramienta);
            let oldName = _.map(old, item => item.herramienta);


            if (method == 'intersectList'){
                return this.intersectList(newName, oldName);
            } else if (method == 'diffListIns') {
                return this.diffListIns(newName, oldName);
            } else if (method == 'diffListDel') {
                return this.diffListDel(newName, oldName);
            }
        },

        getVal: function(name, data) {
            return _.find(data, item => item.nombre == name).pivot.numero_registro;
        },

        getYesNo: function(val) {
            let opt = {si: 'Si', no: 'No', nose: 'No se sabe' }
            return opt[val];
        },

        test: function( new_, old ) {
            return diffString(old,new_);
        },

        diffYesNo: function(new_, old) {
            return (new_ == old)
        },

        diffListIns: function(new_, old) {
            return _.difference(new_, old)
        },

        diffListDel: function(new_, old) {
            return _.difference(old, new_)
        },

        intersectList: function(new_, old) {
            let intersection =_.intersection(new_, old);
            return intersection;
        },

        intersectListFullData: function(new_, old, newFullData, oldFullData) {
            let intersection =_.intersection(new_, old);

            let x =_.map(intersection, nombre => {
                let newDpi = _.find(newFullData, data => data.nombre == nombre);
                let oldDpi = _.find(oldFullData, data => data.nombre == nombre);
                return {intersection: nombre, html: this.test(newDpi.pivot.numero_registro, oldDpi.pivot.numero_registro)}
            })

            return x;
        },

        getDataStep: function(data) {
            switch (data.commit_field) {

                case '0': 
                    return [
                        {
                            info: data.nombre_asociado,
                            pregunta: 'nombre'
                        }
                    ]

                case "1":   
                    return [
                        {
                            info: data.descripcion,
                            pregunta: 'Descripción del AI identificado'
                        },

                        {
                            info: _.map(_.filter(data.archivos, archivo => archivo.tipo == 'descripcion_adjuntos'), item => item.nombre),
                            type: 'list',
                            pregunta: 'Archivos adjuntos'
                        },

                    ]
                case "2": 
                    return [
                        {
                            info: Object.keys(this.clasificaciones).indexOf(data.clasificacion) >= 0 ? this.clasificaciones[data.clasificacion] : data.clasificacion ,
                            type: 'yesno',
                            pregunta: 'Clasificación del AI identificado'
                        },

                        {
                            info: _.map(_.filter(data.archivos, archivo => archivo.tipo == 'clasificacion_adjuntos'), item => item.nombre),
                            type: 'list',
                            pregunta: 'Archivos adjuntos'
                        }
                    ]

                case "3": 
                    return [
                        {
                            info: this.estados[data.estado],
                            type: "yesno",
                            pregunta: 'Estado del AI'
                        }
                    ]

                case "4": 
                    return [
                        {
                            info: _.map(_.filter(data.dpis, dpi => dpi.pivot.tipo_asociacion == 'dpi_asociado'), item => item.nombre),
                            type: 'list',
                            pregunta: 'DPI asociados'
                        }
                    ]

                case "5": 
                    return [
                        {
                            info: this.getYesNo(data.publicado_divulgado),
                            type: 'yesno',
                            pregunta: '¿El AI ha sido publicado o divulgado?'
                        },

                        {
                            info: data.lugar_publicacion,
                            pregunta: 'Lugar de publicación o divulgación'
                        },

                        {
                            info: data.fecha_publicacion,
                            pregunta: 'Fecha de publicación o divulgación'
                        },

                        {
                            info: this.getYesNo(data.contrato_confidencialidad),
                            type: 'yesno',
                            pregunta: '¿El AI tiene contrato de confidencialidad firmado?'
                        },


                        {
                            info: _.map(_.filter(data.archivos, archivo => archivo.tipo == 'contrato_confidencialidad_adjunto'), item => item.nombre),
                            type: 'list',
                            pregunta: 'Archivos adjuntos'
                        },

                        {
                            info: data.nombre_titular,
                            pregunta: 'Nombre del titular del DPI'
                        },

                        {
                            info: this.getYesNo(data.contrato_cesion),
                            type: 'yesno',
                            pregunta: '¿El AI tiene contrato de cesión?'
                        },


                        {
                            info: _.map(_.filter(data.archivos, archivo => archivo.tipo == 'contrato_cesion_adjunto'), item => item.nombre),
                            type: 'list',
                            pregunta: 'Archivos adjuntos'
                        },

                        {
                            info: data.ubicacion_ai,
                            pregunta: 'Ubicación actual del AI '
                        },

                        {
                            info: this.getYesNo(data.en_contabilidad),
                            type: 'yesno',
                            pregunta: '¿Se encuentra en contabilidad?'
                        },

                        {
                            info: data.valor_de_ai,
                            pregunta: 'Valor del AI'
                        },

                        {
                            info: data.valor_de_ai_comentarios,
                            pregunta: 'Comentarios sobre el AI en contabilidad'
                        }
                    ]
                    
                case "6":
                    return [
                        {
                            info: _.last(data.comentarios).comentario,
                            pregunta: 'Comentarios'
                        }
                    ]

                case "7":
                    return [
                        {
                            info: this.getYesNo(data.deposito_da),
                            type: 'yesno',
                            pregunta: 'Existe un depósito ante la autoridad competente para el derecho de autor?'
                        },

                        {
                            info: data.numero_registro_da,
                            pregunta: 'Número de referencia del depósito para el derecho de autor'
                        },

                        {
                            info: this.getYesNo(data.registro_da),
                            type: 'yesno',
                            pregunta: '¿Se sugiere un depósito para el derecho de autor?'
                        },

                        {
                            info: this.getYesNo(data.medidas_proteccion),
                            type: 'yesno',
                            pregunta: '¿Se sugiere tomar medidas razonables para la protección de los secretos empresariales?'
                        },

                        {
                            info: data.cuales_medidas,
                            pregunta: '¿Cuáles medidas?'
                        },

                        {
                            info: _.map(_.filter(data.dpis, dpi => dpi.pivot.tipo_asociacion == 'propiedad_industria_deposito'), item => item.nombre),
                            type: 'list',
                            pregunta: 'Derechos de propiedad industrial a los que se les sugiere registro'
                        },

                        {
                            info: _.map(_.filter(data.dpis, dpi => dpi.pivot.tipo_asociacion == 'propiedad_industria_registro'), item => item.nombre),
                            fullinfo: _.filter(data.dpis, dpi => dpi.pivot.tipo_asociacion == 'propiedad_industria_registro'),
                            type: 'nested-list',
                            pregunta: 'Derechos de propiedad industrial para los cuales ya existe un registro'
                        },

                        {
                            info: this.getYesNo(data.contratos),
                            type:'yesno',
                            pregunta: '¿Se sugiere suscribir contrato para la protección del AI?'
                        },

                        {
                            info: data.cuales_contratos,
                            pregunta: 'Contrato sugerido para la protección del AI'
                        }
                    ]


                case '8': 
                    return [
                        {
                            info: this.getYesNo(data.busqueda),
                            type: 'yesno',
                            pregunta: '¿Se sugiere realizar una búsqueda relacionada con el AI?'
                        },

                        {
                            info: this.getHerramientas(data.dpi_herramientas),
                            type: 'herramientas',
                            pregunta: 'Herramientas'
                        },

                        {
                            info: this.getYesNo(data.presupuesto_priorizacion),
                            type: 'yesno',
                            pregunta: '¿Existe presupuesto para el plan de priorización?'
                        },

                        {
                            info: data.cantidad_presupuesto,
                            pregunta: 'Cantidad de presupuesto para el plan de priorización'
                        },
                    ]

                case '9': 
                    return [

                        {
                            info: this.getYesNo(data.uso_comercial),
                            type: 'yesno',
                            pregunta:  '¿Hay uso comercial del AI?'
                        },

                        {
                            info: data.cual_uso_comercial,
                            pregunta:  'Uso comercial del AI'
                        }

                    ]

                case '10': 
                    return [

                        {
                            info: this.getEstrategia('estrategia_general', data),
                            pregunta: 'Estrategia general'
                        },

                        {
                            info: this.getResponsableEstrategia('estrategia_general', data),
                            type: "yesno",
                            newLine: true,
                            pregunta: 'Persona responsable de ejecutar la estrategia de gestión'
                        },
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
                        {
                            info:  this.getEstrategia('estado', data),
                            pregunta: 'Estrategia de gestión para el estado'
                        },

                        {
                            info: this.getResponsableEstrategia('estado', data),
                            type: "yesno",
                            newLine: true,
                            pregunta: 'Persona responsable de ejecutar la estrategia de gestión'
                        },
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
                        {
                            info: this.getEstrategia('en_contabilidad', data),
                            pregunta: 'Estrategia de gestión para la contabilidad'
                        },

                        {
                            info: this.getResponsableEstrategia('en_contabilidad', data),
                            type: "yesno",
                            newLine: true,
                            pregunta: 'Persona responsable de ejecutar la estrategia de gestión'
                        },
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
                        {
                            info: this.getEstrategia('contrato_confidencialidad', data), 
                            pregunta: 'Estrategia de gestión para el contrato de confidencialidad'
                        },

                        {
                            info: this.getResponsableEstrategia('contrato_confidencialidad', data),
                            type: "yesno",
                            newLine: true,
                            pregunta: 'Persona responsable de ejecutar la estrategia de gestión'
                        },
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
                        {
                            info: this.getEstrategia('contrato_cesion', data), 
                            pregunta: 'Estrategia de gestión para el contrato de cesión'
                        },

                        {
                            info: this.getResponsableEstrategia('contrato_cesion', data),
                            type: "yesno",
                            newLine: true,
                            pregunta: 'Persona responsable de ejecutar la estrategia de gestión'
                        },
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
                        {
                            info: this.getEstrategia('presupuesto_priorizacion', data), 
                            pregunta: 'Estrategia de gestión del presupuesto para el plan de priorización'
                        },

                        {
                            info: this.getResponsableEstrategia('presupuesto_priorizacion', data),
                            type: "yesno",
                            newLine: true,
                            pregunta: 'Persona responsable de ejecutar la estrategia de gestión'
                        },

                    ]
                    
                default: 
                    return null;
            }
        },

        getEstrategia(campo, data) {
            let estrategia = _.find(data.estrategias, estrategia => estrategia.campo == campo)
            return estrategia ? estrategia.estrategia : null
        },

        getResponsableEstrategia(campo, data) {

            let responsable = {
                responsable: 'Responsable del grupo de investigación',
                director: 'Director de Transferencia de Conocimiento y Propiedad Intelectual',
            }

            let estrategia = _.find(data.estrategias, estrategia => estrategia.campo == campo);
            return estrategia ? (responsable[estrategia.responsable] || estrategia.responsable) : null

        },


        getHerramientas: function(data){
            let x = _.map(data, herramienta => {
                herramienta.herramienta = _.find(this.herramientas, herr => herr.id == herramienta.herramienta_id).nombre;
                herramienta.dpi = _.find(this.dpis, dpi => dpi.id == herramienta.dpi_id).nombre;
                return herramienta;
            });
            let s= _.groupBy(x, item => item.dpi);
            return s;
        },
   
        handleClick: function(event) {
            if (event.target.className == 'modal-wrapper') {
                this.$emit('close')
            }
        }
    },

    mounted() {
        window.addEventListener('click', this.handleClick)
    },

    beforeDestroy: function () {
        window.removeEventListener('click', this.handleClick)
    },
}
</script>