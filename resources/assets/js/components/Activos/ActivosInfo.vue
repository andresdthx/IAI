<template lang="html">
<div>
   <div v-if="dataReady">

    <activos-modal-step
        v-if="openModalHelp" 
        @close="onCloseModal()"
        :component="componentToOpen"
        >
    </activos-modal-step>

    <template v-for="(item, index) in hist">
        <activo-modal-historial
            :data="item"
            :previus="getPreviusHistorial(item.commit, index)"
            :clasificaciones="data.steps.submenus['2'].fields.clasificacion.values"
            :estados="data.steps.submenus['3'].fields.estado.values"
            :dpis="activo.dpis_opt"
            :herramientas="activo.herramientas"
            v-if="item.modal"
            @close="onCloseHistModal(item.id)">
        </activo-modal-historial>

    </template>
    
        <div style="margin-bottom: 100px;">

             <div>
                <span class="header-table" style="text-decoration: underline;font-size: 25px;">Nombre del activo</span>
                <span class="header-table" style="font-size: 25px;">: {{activo.nombre_asociado}}</span>
            </div>

            <div>
                <img style="float: left; margin-right: 10px; padding-top: 5px" src="/images/proyecto_pertenece.png" alt="" width="20">
                <span class="header-table" style="font-weight: bold; font-size: 20px; font-family: 'Open Sans'">Proyecto al que pertenece:</span>
                <span class="header-table" style=" font-size: 20px; font-family: 'Open Sans'"> {{data.steps.subproyecto.nombre}}</span>
            </div>


             <div v-if="data.steps.submenus['2'].finished && !openModalHelp">
                <img style="float: left; margin-right: 10px; padding-top: 5px" src="/images/clasificacion.png" alt="" width="15">
                <span class="header-table" style="font-weight: bold; font-size: 20px; font-family: 'Open Sans'">Clasificación:</span>
                <span class="header-table" style=" font-size: 20px; font-family: 'Open Sans'">{{data.steps.submenus['2'].fields.clasificacion.values[data.steps.submenus['2'].fields.clasificacion.data]}} </span>
            </div> 

            <br>

            <!-- <div v-if="data.steps.submenus['1'].finished && !openModalHelp">
                <h2>Descripción:</h2>
               <span class="description-style" >{{data.steps.submenus['1'].fields.descripcion.data}}</span>
            </div> -->
            
        </div>

        <div style="position: relative">

            <back-button 
                :text="'Volver al proyecto'"
                :url="`/subproyectos/${this.data.steps.subproyecto.id}`"
                positionStyle="right: 0px; bottom: 0px; top: -60px;"
            />

         <div class="info-content">


            <ul class="nav nav-tabs">
                <li role="presentation" class="active"><a data-toggle="tab" href="#progreso">Formulario</a></li>
                <li role="presentation"><a data-toggle="tab" href="#info">Reporte</a></li>
                <li role="presentation"><a data-toggle="tab" href="#estrategias">Estrategias de gestión</a></li>
                <li role="presentation"><a data-toggle="tab" href="#historial">Historial</a></li>
            </ul>

        <div class="tab-content">

            <div class="tab-pane fade in active" id="progreso">
                <div class="info-progreso tab-pane fade in active" id="progreso">

                    <div class="inside">
                        <h4 class="step-title" style="margin: 0">Progreso</h4>

                        <br>
                        <div class="progress">
                            <div :class="`progress-bar ${getColorProgressBar(round(data.steps.percentage_complete))} progress-bar-striped`" 
                                role="progressbar"
                                :aria-valuenow="round(data.steps.percentage_complete)"
                                aria-valuemin="0"
                                aria-valuemax="100"
                                :style="`width: ${round(data.steps.percentage_complete)}%`">
                                {{round(data.steps.percentage_complete)}}%
                            </div>
                        </div>

                        <ul class="form-list">

                            <li v-for="item in data.steps.submenus">     

                                <a v-if="item.finished"  @click.prevent="openComponent(item.component)" href="#">
                                    <span>
                                        <img v-if="item.finished" style="float: left; margin-right: 10px" src="/images/teminado.png" alt="" width="20">
                                        {{item.name}}
                                    </span>
                                </a>

                                <a v-if="item.available && !item.finished" @click.prevent="openComponent(available.component)" href="#">                            
                                    <span class="wait">{{available.name}}</span>
                                </a>

                                <template v-if="!item.available">
                                    <span class="block"> {{item.name}}</span>
                                </template>

                            </li> 
                        </ul>
                    </div>
                </div>
            </div>
            

            <div class="tab-pane" id="info">
                <div class="inside" style="border-color: #490e6f; padding: 25px; min-height: 450px;">
                <button @click="downloadReport" style="margin-right:50px; float: right" class="btn btn-info">Descargar reporte</button>
                
                <div id="x" style="text-align: justify">
                    <br><br><br>
                    
                    <div class="col-md-12">
                        <div class="col-md-6" v-if="isEstrategias" style="text-align: center;width: 350px; height: 400px; margin-bottom: 40px">
                            
                            <h4>Estrategia de gestión
                                <span class="glyphicon glyphicon-question-sign" 
                                        v-tooltip.right="{
                                        content: 'Esta gráfica muestra el porcentaje de pendientes y pendientes urgentes para tener en cuenta en la estrategia de gestión.',
                                        placement: 'bottom-center',
                                        classes: ['info'],
                                        targetClasses: ['it-has-a-tooltip'],
                                        offset: 5,
                                        delay: {
                                            show: 500,
                                            hide: 300,
                                        },
                                        }">
                                </span>  
                            </h4>

                            <hr style="margin: 0px; ">
                            <doughnut-chart :chart-data="doughnoutData"></doughnut-chart>
                        </div>

                        <div class="col-md-6" style="text-align: center;width: 350px; height: 400px; margin-left: 20px; margin-bottom: 40px">
                            <h4>Progreso del formulario

                            <span class="glyphicon glyphicon-question-sign" 
                                        v-tooltip.right="{
                                        content: 'Esta gráfica muestra el porcentaje relativo al progreso del formulario.',
                                        placement: 'bottom-center',
                                        classes: ['info'],
                                        targetClasses: ['it-has-a-tooltip'],
                                        offset: 5,
                                        delay: {
                                            show: 500,
                                            hide: 300,
                                        },
                                        }">
                                </span>  
                            </h4>

                            <hr style="margin: 0px; ">
                            <doughnut-chart :chart-data="doughnoutDiligencia" :options="donaDiligenciaOptions"></doughnut-chart>
                        </div>
                        
                    </div>
                
                    <template v-if="data.steps.submenus['1'].finished">
     
                        <h4><strong>Descripción del AI identificado: </strong></h4>

                        <p style="white-space: pre-wrap">{{data.steps.submenus['1'].fields.descripcion.data}}</p>
                        
                        <table v-if="data.steps.submenus['1'].fields.descripcion_adjuntos.finished" class="table" style="margin-top:20px;">
                
                            <thead>
                                <tr>
                                    <th >Documentos adjuntos</th>
                                </tr>
                            </thead>

                            <tbody>
                                <tr v-for="file in data.steps.submenus['1'].fields.descripcion_adjuntos.data">
                                    <a :href="`/activos/donwloadFile/${replaceSlash(file.id)}`">{{file.nombre}} </a>
                                </tr>

                            </tbody>
                        </table>
                        <hr>
                    </template>

                    <template v-if="data.steps.submenus['2'].finished">
                        <h4><strong>Clasificación del AI identificado: </strong></h4>
                        <span v-if ="Object.keys(data.steps.submenus['2'].fields.clasificacion.values).indexOf(data.steps.submenus['2'].fields.clasificacion.data) >= 0"><strong>Tipo: </strong>{{data.steps.submenus['2'].fields.clasificacion.values[data.steps.submenus['2'].fields.clasificacion.data]}}</span>
                        <span v-else> <strong>Tipo: </strong> {{data.steps.submenus['2'].fields.clasificacion.data}}</span>
                        
                        <table v-if="data.steps.submenus['2'].fields.clasificacion_adjuntos.finished" class="table" style="margin-top:20px;">

                            <thead>
                                <tr>
                                    <th >Documentos adjuntos</th>
                                </tr>
                            </thead>

                            <tbody>
                                <tr v-for="file in data.steps.submenus['2'].fields.clasificacion_adjuntos.data">
                                    <a :href="`/activos/donwloadFile/${replaceSlash(file.id)}`">{{file.nombre}} </a>
                                </tr>

                            </tbody>
                        </table>
                        <hr>
                    </template>

                    <template v-if="data.steps.submenus['3'].finished">
                        <h4><strong>Estado del AI identificado: </strong></h4>

                        <strong>Tipo: </strong><span :style="getEstrategia('estado') && getEstrategiaColor('estado')">{{data.steps.submenus['3'].fields.estado.values[data.steps.submenus['3'].fields.estado.data]}}</span>
                        <br>
                        <template v-if="getEstrategia('estado') && getEstrategia('estado').estrategia">
                            <strong>Estrategia de gestión para el estado del activo: </strong>
                            <span>{{getEstrategia('estado').estrategia}}</span>
                            <br>
                            <strong>Persona responsable de ejecutar la estrategia de gestión: </strong>
                            <span v-if="getEstrategia('estado').responsable != 'otro'">
                                {{encargadoValues[getEstrategia('estado').responsable]}}
                            </span>
                            <span v-else>{{getEstrategia('estado').otro}}</span>
                        </template>
                        <hr>
                    </template>

                    <template v-if="data.steps.submenus['4'].finished">
                        <h4><strong>DPI asociados: </strong></h4>
                        <ul>
                            <li v-for="item in data.steps.submenus['4'].fields.dpi_asociado.data">
                                {{item.nombre}}
                            </li>
                        </ul>
                        <hr>
                    </template>

                    <template v-if="data.steps.submenus['5'].finished">
                        <h4><strong>Estado actual del AI: </strong></h4>
                        <span><strong>¿El AI ha sido publicado o divulgado?:</strong> {{ getYesNo(data.steps.submenus['5'].fields.publicado_divulgado.data) }} </span>
                        <br>
                        <template v-if="data.steps.submenus['5'].fields.publicado_divulgado.data == 'si'">
                            <span><strong>Lugar de publicación o divulgación:</strong> {{ (data.steps.submenus['5'].fields.lugar_publicacion.data) }} </span>
                            <br>
                            <span><strong>Fecha de publicación o divulgación:</strong> {{ (data.steps.submenus['5'].fields.fecha_publicacion.data) }} </span>
                            <br>
                        </template>

                        <strong >¿El AI tiene contrato de confidencialidad firmado?:</strong> <span :style="getEstrategia('contrato_confidencialidad') && getEstrategiaColor('contrato_confidencialidad')"> {{ getYesNo(data.steps.submenus['5'].fields.contrato_confidencialidad.data) }} </span>
                        <br>

                        <template v-if="getEstrategia('contrato_confidencialidad') && getEstrategia('contrato_confidencialidad').estrategia">
                            <strong>Estrategia de gestión para el contrato de confidencialidad: </strong>
                            <span>{{getEstrategia('contrato_confidencialidad').estrategia}}</span>
                            <br>
                            <strong>Persona responsable de ejecutar la estrategia de gestión: </strong>

                            <span v-if="getEstrategia('contrato_confidencialidad').responsable != 'otro'">
                                {{encargadoValues[getEstrategia('contrato_confidencialidad').responsable]}}
                            </span>

                            <span v-else>{{getEstrategia('contrato_confidencialidad').otro}}</span>
                            <br>
                        </template>

                        <table v-if="data.steps.submenus['5'].fields.contrato_confidencialidad.data == 'si'" class="table" style="margin-top:20px;">
                
                            <thead>
                                <tr>
                                    <th >Contrato de confidencialidad firmado</th>
                                </tr>
                            </thead>

                            <tbody>
                                <tr v-for="file in data.steps.submenus['5'].fields.contrato_confidencialidad_adjunto.data">
                                    <a :href="`/activos/donwloadFile/${replaceSlash(file.id)}`">{{file.nombre}} </a>
                                </tr>

                            </tbody>
                        </table>


                        <span><strong v-if="data.steps.submenus['5'].fields.nombre_titular.data ">
                            Nombre del titular del DPI:</strong> {{ (data.steps.submenus['5'].fields.nombre_titular.data) }} 
                        </span>
                        <br>

                        <strong>¿Los DPI asociados al AI se han cedido a la Universidad y/o a un tercero?:</strong> <span :style="getEstrategia('contrato_cesion') && getEstrategiaColor('contrato_cesion')">{{ getYesNo(data.steps.submenus['5'].fields.contrato_cesion.data) }} </span>
                        <br>
                        <template v-if="getEstrategia('contrato_cesion') && getEstrategia('contrato_cesion').estrategia">

                            <strong>Estrategia de gestión para el contrato de cesión: </strong>{{getEstrategia('contrato_cesion').estrategia}}
                            <br>
                            <strong>Persona responsable de ejecutar la estrategia de gestión: </strong>

                            <span v-if="getEstrategia('contrato_cesion').responsable != 'otro'">
                                {{encargadoValues[getEstrategia('contrato_cesion').responsable]}}
                            </span>

                            <span v-else>{{getEstrategia('contrato_cesion').otro}}</span>
                            <br>

                        </template>

                        <template v-if="data.steps.submenus['5'].fields.contrato_cesion.data == 'si'" >

                            <table class="table" style="margin-top:20px;">
                    
                                <thead>
                                    <tr>
                                        <th>Contrato de cesión firmado</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    <tr v-for="file in data.steps.submenus['5'].fields.contrato_cesion_adjunto.data">
                                        <a :href="`/activos/donwloadFile/${replaceSlash(file.id)}`">{{file.nombre}} </a>
                                    </tr>
                                </tbody>
                            </table>
                        </template>

                       
                        <span><strong>Ubicación actual del AI :</strong> {{ (data.steps.submenus['5'].fields.ubicacion_ai.data) }} </span>
                        <br>
                        <strong>¿Se encuentra en contabilidad?:</strong> <span :style="getEstrategia('en_contabilidad') ? getEstrategiaColor('en_contabilidad'): ''" > {{ getYesNo(data.steps.submenus['5'].fields.en_contabilidad.data) }} </span>
                        <br>
                        <template v-if="getEstrategia('en_contabilidad') && getEstrategia('en_contabilidad').estrategia">
                            <strong>Estrategia de gestión para la contabilidad: </strong> {{getEstrategia('en_contabilidad').estrategia}}
                            <br>
                            <strong>Persona responsable de ejecutar la estrategia de gestión: </strong>

                            <span v-if="getEstrategia('en_contabilidad').responsable != 'otro'">
                                {{encargadoValues[getEstrategia('en_contabilidad').responsable]}}
                            </span>

                            <span v-else>{{getEstrategia('en_contabilidad').otro}}</span>
                            <br>
                        </template>

                        <span v-if="data.steps.submenus['5'].fields.en_contabilidad.data == 'si'">
                            <strong>Valor del AI:</strong>  ${{ (data.steps.submenus['5'].fields.valor_de_ai.data) }} 
                            <br>
                            <strong>Comentarios sobre el AI en contabilidad: </strong>{{ (data.steps.submenus['5'].fields.valor_de_ai_comentarios.data) }} 
                        </span>

                        <hr>
                    </template>

                    <template v-if="data.steps.submenus['6'].finished">

                        <h4><strong>Comentarios: </strong></h4>
                        <p style="white-space: pre-wrap">{{data.steps.submenus['6'].fields.comentarios.data[0].comentario}}</p>
        
                        <hr>
                    </template>

                    <template v-if="data.steps.submenus['7'].finished">
                        <h4><strong>Plan de acción y protección del AI: </strong></h4>
                        <span><strong>¿Existe un depósito ante la autoridad competente para el derecho de autor?:</strong> {{ getYesNo(data.steps.submenus['7'].fields.deposito_da.data) }} </span>
                        <br>
                        <span v-if="data.steps.submenus['7'].fields.deposito_da.data == 'si'">
                             <strong>Número de referencia del depósito para el derecho de autor:</strong>
                             {{ (data.steps.submenus['7'].fields.numero_registro_da.data) }}
                        </span>

                        <span v-else>
                             <strong>¿Se sugiere registro de derecho de autor?:</strong>
                             {{ getYesNo(data.steps.submenus['7'].fields.registro_da.data) }}
                        </span>

                        <br>
                        <span>
                            <strong>¿Se sugiere tomar medidas razonables para la protección de los secretos empresariales?:</strong> 
                            {{ getYesNo(data.steps.submenus['7'].fields.medidas_proteccion.data) }} 
                        </span>
                        <br>

                        <template v-if="data.steps.submenus['7'].fields.medidas_proteccion.data == 'si'">
                            <span>
                                <strong>¿Cuáles medidas?:</strong> {{ (data.steps.submenus['7'].fields.cuales_medidas.data) }} 
                            </span>
                            <br>
                        </template>

                        <span>
                             <strong>¿Se sugiere registro o depósito de algun derecho de propiedad industrial? :</strong>
                             {{ getYesNo(data.steps.submenus['7'].fields.propiedad_industrial.data) }}
                        </span>
                        <br>

                        <template v-if="data.steps.submenus['7'].fields.propiedad_industrial.data == 'si'">
                        <br>
                        <strong>Derechos de propiedad industrial a los que se les sugiere registro: </strong>
                        
                         <ul>
                            <li v-for="dpi in data.steps.submenus['7'].fields.propiedad_industria_deposito.data">
                                {{dpi.nombre}}
                            </li>
                        </ul>

                        </template>
                        
                        <template v-if="data.steps.submenus['7'].fields.propiedad_industria_registro.data.length > 0">
                            <span>
                                <strong>Derechos de propiedad industrial para los cuales ya existe un registro:</strong>
                            </span>
                            <table class="table" style="margin-top:20px;">
                
                            <thead>
                                <tr>
                                    <th >Derecho de propiedad industrial</th>
                                    <th >Número de referencia</th>
                                </tr>
                            </thead>

                            <tbody>
                                <tr v-for="dpi in data.steps.submenus['7'].fields.propiedad_industria_registro.data">
                                    <td>{{dpi.nombre}}</td>
                                    <td>{{dpi.pivot.numero_registro}}</td>
                                </tr>

                            </tbody>
                        </table>
                        </template>

                        <span>
                             <strong>¿Se sugiere suscribir contrato para la protección del AI?  :</strong>
                             {{ getYesNo(data.steps.submenus['7'].fields.contratos.data) }}
                        </span>
                        <br>
                        <span v-if="data.steps.submenus['7'].fields.contratos.data == 'si'">
                             <strong>Contrato sugerido para la protección del AI:</strong>
                             {{ (data.steps.submenus['7'].fields.cuales_contratos.data) }}
                        </span>
                        <hr>
                    </template>

                    <template v-if="data.steps.submenus['8'].finished">
                        <h4><strong>Herramientas para la priorización y decisión del AI: </strong></h4>

                        <span >
                             <strong>¿Se sugiere realizar una búsqueda relacionada con el AI?:</strong>
                             {{ getYesNo(data.steps.submenus['8'].fields.busqueda.data) }}
                        </span>
                        <br>

                        <template v-if="data.steps.submenus['8'].fields.busqueda.data == 'si'">
                            <br>
                            <template v-for="dpi in data.steps.submenus['8'].fields.herramientas.values.dpis">
                                <div v-if="(dpi.herramientas.length + dpi.herramientas_nuevas.length) > 0">
                                    <span>
                                        <strong>Herramientas de priorización para {{dpi.nombre.toLowerCase()}}</strong>
                                    </span>
                                    <ul>
                                        <li v-for="herramienta in dpi.herramientas.concat(dpi.herramientas_nuevas)">
                                            {{herramienta.nombre}}
                                        </li>
                                    </ul>
                                </div>
                            </template>
                        </template>

                        <strong>¿Existe presupuesto para el plan de priorización?:</strong>
                            <span :style="getEstrategia('presupuesto_priorizacion') ? getEstrategiaColor('presupuesto_priorizacion'): ''">
                                {{ getYesNo(data.steps.submenus['8'].fields.presupuesto_priorizacion.data) }}
                            </span>
                        <br>

                        <template v-if="getEstrategia('presupuesto_priorizacion') && getEstrategia('presupuesto_priorizacion').estrategia">
                            <strong>Estrategia de gestión para el presupuesto de priorización: </strong><span>{{getEstrategia('presupuesto_priorizacion').estrategia}}</span>
                            <br>
                            <strong>Persona responsable de ejecutar la estrategia de gestión: </strong>

                            <span v-if="getEstrategia('presupuesto_priorizacion').responsable != 'otro'">
                                {{encargadoValues[getEstrategia('presupuesto_priorizacion').responsable]}}
                            </span>

                            <span v-else>{{getEstrategia('presupuesto_priorizacion').otro}}</span>
                            <br>

                        </template>

                        <span v-if="data.steps.submenus['8'].fields.presupuesto_priorizacion.data == 'si'">
                             <strong>Cantidad de presupuesto para el plan de priorización:</strong>
                             ${{(data.steps.submenus['8'].fields.cantidad_presupuesto.data) }}
                        </span>
                        <hr>
                    </template>

                    <template v-if="data.steps.submenus['9'].finished">
                         <h4><strong>Uso comercial del AI: </strong></h4>
                        <span >
                             <strong>¿Hay uso comercial del AI?:</strong>
                             {{ getYesNo(data.steps.submenus['9'].fields.uso_comercial.data) }}
                        </span>
                        <br>

                        <span v-if="data.steps.submenus['9'].fields.uso_comercial.data == 'si'">
                             <strong>Uso comercial del AI:</strong>
                             {{ (data.steps.submenus['9'].fields.cual_uso_comercial.data) }}
                        </span>
                        <hr>
                    </template>

                    <template v-if="estrategiaGeneral.estrategia">
                        <h4><strong>Estrategias de gestión general: </strong></h4> 
                        <span style="text-align: justify; white-space: pre-wrap">{{estrategiaGeneral.estrategia}}</span>
                        <br>
                        <br>
                        <strong>Persona responsable de ejecutar la estrategia de gestión: </strong>

                            <span v-if="estrategiaGeneral.responsable != 'otro'">
                                {{encargadoValues[estrategiaGeneral.responsable]}}
                            </span>

                            <span v-else>{{estrategiaGeneral.otro}}</span>
                    </template>

                        <!--<template v-if="data.steps.submenus['10'].finished">
                            <h4><strong>Estrategias para la gestión del AI: </strong></h4>

                            <ul>
                                <li v-for="estrategia in data.steps.submenus['10'].fields.estrategias.data ">
                                    {{estrategia.estrategia}}
                                </li>
                            </ul>
                        </template>
                        -->
                    
                </div>
                </div>
            </div>

            <div class="info-progreso tab-pane" id="estrategias">

                <div class="inside" style="border-color: #7ab800; padding: 25px;">

                <div>

                    <h3><strong>Estrategias de gestión</strong>
                        <span class="glyphicon glyphicon-question-sign" 
                                      v-tooltip.right="{
                                        content: 'De acuerdo a la información recogida en el diligenciamiento, describa cuáles son las sugerencias y estrategias generales para la gestión, gerencia y administración del activo intangible y los derechos de propiedad intelectual asociados.',
                                        placement: 'bottom-center',
                                        classes: ['info'],
                                        targetClasses: ['it-has-a-tooltip'],
                                        offset: 5,
                                        delay: {
                                            show: 500,
                                            hide: 300,
                                        },
                                      }">
                                </span>   
                    </h3>

                    <p><strong>Nota: </strong>Da click al campo en el que desees para ingresar o modificar una estrategia de gestión.</p>
                    <br>

                    <template v-for="state in ['danger', 'warning']">
                        <p v-if="geEstrategiaByState(state).length > 0" :style="getStateStyle(state)" >{{getStateName(state)}}</p>
                        <template v-for=" estrategia in geEstrategiaByState(state)">

                            <h5 @click="onClickEstrategia(estrategia.id)" style="display: inline; cursor: pointer; color: #3097D1">
                                <strong >{{getEstrategiaName(estrategia.campo)}} <span id="up-down" style="font-size: 13px" class="glyphicon glyphicon-chevron-down"></span></strong>
                                <br>
                            </h5>

                            <template v-if="estrategia.click">

                                <form>
                                    <textarea   
                                        name ='descripcion'
                                        v-model ="estrategia.estrategia"
                                        placeholder="Ingresa las estrategias de gestión"
                                        rows="8"
                                        cols="110"
                                        required>
                                    </textarea>

                                    <strong v-if="estrategia.errors.estrategia" style="color:red; display:block">Este campo es requerido</strong> 
                                    <br><br>

                                     <strong class="step-title">Persona responsable de ejecutar la estrategia de gestión
                                        <span style="color:red">*
                                            <span class="glyphicon glyphicon-question-sign" 
                                                v-tooltip.right="{
                                                    content: 'descripcion',
                                                    placement: 'bottom-center',
                                                    classes: ['info'],
                                                    targetClasses: ['it-has-a-tooltip'],
                                                    offset: 5,
                                                    delay: {
                                                        show: 500,
                                                        hide: 300,
                                                    },
                                                }">
                                            </span>     
                                        </span>
                                    </strong>

                                    <div class="step-container">
                                            <select style="width: initial" v-model="estrategia.responsable" required >
                                                <option selected disabled :value="null">Selecciona un responsable</option>
                                                <option v-for="(value, key) in encargadoValues" :value="key"
                                                :selected='estrategia.responsable && key == estrategia.responsable'>
                                                        {{value}}
                                                </option>
                                            </select>

                                        <br><br>

                                        <div v-if="estrategia.responsable == 'otro'">

                                            <h5>
                                                <strong class="step-title">Cuál?</strong><span style="color:red">*</span>
                                            </h5>

                                            <input 
                                                v-model="estrategia.otro"
                                                type="text"
                                                name="nombre" 
                                                placeholder="Indica al responsable">

                                   
                                            <strong v-if="estrategia.errors.responsable" 
                                                style="color:red; display:block">Este campo es requerido
                                            </strong> 

                                        <br>
                                        <br>
                                    </div>

                                    </div>

                                    <button @click.prevent="onSaveEstrategia(estrategia.id)" class="btn btn-success">Guardar </button>

                                </form>

                            </template>
                            <hr>
                        </template>
                    </template>

                    <h3><strong>Estrategias generales</strong>
                        <span class="glyphicon glyphicon-question-sign" 
                                      v-tooltip.right="{
                                        content: 'De acuerdo a la información recogida en el diligenciamiento, describa cuáles son las sugerencias y estrategias generales para la gestión, gerencia y administración del activo intangible y los derechos de propiedad intelectual asociados.',
                                        placement: 'bottom-center',
                                        classes: ['info'],
                                        targetClasses: ['it-has-a-tooltip'],
                                        offset: 5,
                                        delay: {
                                            show: 500,
                                            hide: 300,
                                        },
                                      }">
                        </span>
                    </h3>

                    <form>

                        <textarea   
                            name ='descripcion'
                            v-model="estrategiaGeneral.estrategia"
                            placeholder="Ingresa las estrategias generales para el activo intangible"
                            rows="8"
                            cols="110">
                        </textarea>

                        <strong v-if="estrategiaGeneral.errors.estrategia " style="color:red; display:block">Este campo es requerido</strong>

                        <br><br>

                        <strong class="step-title">Persona responsable de ejecutar la estrategia de gestión
                            <span style="color:red">*
                                <span class="glyphicon glyphicon-question-sign" 
                                    v-tooltip.right="{
                                        content: 'En este espacio por favor indique la persona natural que será responsable de ejecutar la estrategia de gestión que se planteó anteriormente. En caso de seleccionar la opción `Otra` indique quién y cuál es su rol al interior de la Universidad.',
                                        placement: 'bottom-center',
                                        classes: ['info'],
                                        targetClasses: ['it-has-a-tooltip'],
                                        offset: 5,
                                        delay: {
                                            show: 500,
                                            hide: 300,
                                        },
                                    }">
                                </span>     
                            </span>
                        </strong>

                        <div class="step-container">
                            <select style="width: initial" v-model="estrategiaGeneral.responsable" required >
                                <option selected disabled :value="null">Selecciona un responsable</option>
                                <option v-for="(value, key) in encargadoValues" :value="key"
                                :selected='estrategiaGeneral.responsable && key == estrategiaGeneral.responsable'>
                                        {{value}}
                                </option>
                            </select>

                            <strong v-if="estrategiaGeneral.errors.responsable " style="color:red; display:block">Este campo es requerido</strong>

                            <br><br>

                            <div v-if=" estrategiaGeneral.responsable == 'otro'">

                                <h5>
                                    <strong class="step-title">Cuál?</strong><span style="color:red">*</span>
                                </h5>

                                <input 
                                    v-model="estrategiaGeneral.otro"
                                    type="text"
                                    name="nombre" 
                                    placeholder="Indica al responsable">

                                <br><br>

                            </div>

                        </div>

                        <button @click.prevent="onSaveEstrategiaGeneral(estrategiaGeneral)" class="btn btn-success">Guardar</button>
                    </form>

                </div>
                </div>
            </div>

            <div class="tab-pane" id="historial">
                <div class="inside" style="border-color: #a64586; padding: 25px; min-height: 450px;">
                     <h4 class="step-title" style="margin: 0px; margin-bottom: 30px;">Historial</h4>

                    <multiselect
                        v-model="selectedHistorial" 
                        :options="getHistoryOptions(hist)"
                        :multiple="true"
                        :close-on-select="false" 
                        :clear-on-select="false" 
                        :hide-selected="true" 
                        :preserve-search="true" 
                        select-label="Presiona enter para seleccionar"
                        placeholder="Buscar por tipo de modificación"
                        label="name"
                        track-by="id">
                    </multiselect>

                    <div style="margin-top: 40px">
                        <button class="btn btn-info" @click="onBuscarHistorial">Buscar</button>
                        <button class="btn btn-danger" @click="onDeleteHistorial">Borrar filtros</button>
                    </div>

                    <table class="table" style="margin-top:40px;">

                        <thead>
                            <tr>
                                <th>Modificación</th>
                                <th>Fecha de modificación</th>

                            </tr>
                        </thead>

                        <tbody>

                            <template v-for="itemHistory in histItems">
                                <tr @click.prevent="clickHistory(itemHistory.id)" class="td-historial" v-if="itemHistory.select">
                                    <td><span style="color: #3097D1;" >{{itemHistory.commit}}</span></td>
                                    <td style="text-align: left;">{{itemHistory.created_at}}</td>

                                </tr>
                            </template>

                        </tbody>

                    </table>

                    <div class="text-center">

                        <ul class="pagination">
                            <li>
                                <a @click.prevent="updatePage(updatePage(currentPage - 1))" href="#" aria-label="Previous">
                                    <span aria-hidden="true">&laquo;</span>
                                </a>
                            </li>

                            <li :class="((index + 1)  == currentPage ) ? 'active' : ''" v-for="(x, index) in Array(numberPages)">
                                <a @click.prevent=" currentPage = (index + 1)" href="#">{{ index + 1}}</a>
                            </li>

                            <li>
                                <a @click.prevent="updatePage(updatePage(currentPage - 1))" href="#" aria-label="Next">
                                    <span aria-hidden="true">&raquo;</span>
                                </a>
                            </li>
                        </ul>

                    </div>

                    <!-- <activo-historial
                    :historial="this.activo.historial">
                    </activo-historial> -->
            </div>

        </div>
        </div>
        </div>
        </div>
  </div>
 
        <div v-else style="text-align: center;">
            <div class="loader"></div>
            <h3>Cargando datos</h3>
        </div>
    
  </div>


  </div>

</template>

<style>

    .td-historial  {
        cursor: pointer;
    }

    .td-historial:hover {
        background-color: #F5F5F5;
    }

</style>

<script>
    import store from '../../store';
    import axios from 'axios';
    import swal from 'sweetalert2';
    import html2pdf from 'html2pdf.js';
    import Multiselect from 'vue-multiselect';

    export default {
        store,
        components: {Multiselect},
        data() {
            return {
                currentPage: 1,
                itemsPerPage: 5,
                encargadoValues: {
                    responsable: 'Responsable del grupo de investigación',
                    director: 'Coordinador de innovación y transferencia',
                    otro: 'Otro'
                },
                estrategiaErrors: '',


                selectedHistorial: '',
                showProgress: false,
                openModalHelp: false,
                componentToOpen: '',

                donaDiligenciaOptions: {
                    tooltips: {
                        callbacks: {
                            label: function(tooltipItem, data) {
                                return `${data.labels[tooltipItem.index]}: ${data.datasets[0].data[tooltipItem.index]}%`
                            }
                        }
                    }
                }

            }
        },



        computed: {

            hist: function() {
                let x = store.getters.historial;
                return x;
            },


            numberPages: function() {
                return Math.ceil( (_.filter(this.hist, item => item.select).length) /this.itemsPerPage);
            },

            histItems: function name() {
                let x = _.filter(this.hist, item => item.select);

                return x.slice( (this.currentPage - 1) * this.itemsPerPage, this.currentPage * this.itemsPerPage );
            },

            openNotification: function(){
                return true  
            },

            doughnoutData: _ => store.getters.doughnoutData,

            doughnoutDiligencia: function() {
                return store.getters.doughnoutDiligencia;
            },

            data: function() {
                return store.getters.data;
            },

            dataReady: _ => store.getters.dataReady,

            activo: function() {
                return store.getters.mainInfo;
            },

            available: function() {
                return _.filter(this.data.steps.submenus, item=> (item.available && !item.finished))[0]
            },

            isEstrategias: function() {
                return store.getters.isEstrategias
            },

            estrategiaGeneral: function() {
                let x  = store.getters.estrategiaGeneral;
                return x;
            }
        },

        methods: {

            updatePage: function(page) {
                if (page > 0 && page <= this.numberPages) {
                    this.currentPage = page;
                }
            },

            onDeleteHistorial: function(){
                this.selectedHistorial = '';
                let ids = _.map(this.getHistoryOptions(this.hist), item => item.id);
                store.commit("filterHistorial", ids);
            },

            onBuscarHistorial: function() {
                if (this.selectedHistorial && this.selectedHistorial.length > 0) {
                    let ids = _.map(this.selectedHistorial, item => item.id);
                    store.commit("filterHistorial", ids);
                } else {
                    let ids = _.map(this.getHistoryOptions(this.hist), item => item.id);
                    store.commit("filterHistorial", ids);
                }
            },

            getHistoryOptions: function(data) {

               let nameSteps = [
                       { id: '0', name: "Nombre"},
                       { id: '1', name: "Descripción"},
                       { id: '2', name: "Clasificación"},
                       { id: '3', name: "Estado"},
                       { id: '4', name: 'DPI asociados'},
                       { id: '5', name: 'Estado Actual del AI'},
                       { id: '6', name: 'Comentarios'},
                       { id: '7', name: 'Plan de acción y protección'},
                       { id: '8', name: 'Priorización y decisión'},
                       { id: '9', name: 'Uso comercial'},
                       {id: '10', name: 'Estrategias de gestión'}
               ]

                return nameSteps
            },

            getPreviusHistorial: function(commit, index) {

                let i = index + 1;
                while (i < this.hist.length && this.hist[i].commit != commit ) {
                    i = i + 1;
                }

                return (i >= this.hist.length ? null : this.hist[i])
            },

            onCloseHistModal: function(id) {
                store.commit("closeModalHist", id);
            },

            clickHistory: function(id) {
                store.commit("clickHistorial", id);
            },

            onSaveEstrategiaGeneral: function(estrategia) {

               let responsable = this.estrategiaGeneral.responsable == 'otro' ? this.estrategiaGeneral.otro : this.estrategiaGeneral.responsable;

               axios.post('/activos/addEstrategiaGeneral', { activo: estrategia.activo_id, estrategia: estrategia.estrategia,  responsable: responsable } ).then( response => {

                   store.commit("setActivo", response.data);
                        swal({
                            type: "success",
                            title: "Estrategia guardada",
                            showConfirmButton: false,
                            timer: 800
                        });
               }).catch( e => {
                   this.estrategiaGeneral.errors = e.response.data.errors;
               })
            },

            getColorProgressBar: function(percentage) {
                if (percentage == 100) {
                    return 'progress-bar-success'
                }

                if (percentage >20 && percentage < 100) {
                   return  'progress-bar-warning'
                }
                
                return 'progress-bar-danger'

            },

            downloadReport: function() {

                var opt = {
                    margin:       [0.6, 0.3, 1, 0.3],
                    filename:     `reporte_${this.activo.nombre_asociado}.pdf`,
                    image:        { type: 'jpeg', quality: 0.98 },
                    html2canvas:  { scale: 2 },
                    jsPDF:        { unit: 'in', format: 'letter', orientation: 'portrait' }
                };
                
                var element = document.querySelector('#x');
                html2pdf().from(element).set(opt).save();
             
            },

            getStateStyle: function(state) {
                let styles = {
                    'danger' : "color: red; font-size: 20px; font-weight: bold; margin-bottom: 30px",
                    'warning' : "color: orange; font-size: 20px; font-weight: bold; margin-bottom: 30px",
                }

                return styles[state];
            },

            getStateName: function(state) {
                let names = {
                    'danger': "Pendientes urgentes",
                    'warning': "Pendientes"
                }

                return names[state];
            },

            onClickEstrategia: function(id) {
                store.commit('onClickEstrategia', id);
            },  

            onSaveEstrategia: function(estrategiaId) {
                let estrategia = _.filter(this.data.steps.estrategias, estrategia => estrategia.id == estrategiaId)[0];

                let responsable = estrategia.responsable == 'otro' ? estrategia.otro : estrategia.responsable;

                axios.put(`/activos/addEstrategia`, 
                        {activo: estrategia.activo_id, estrategia_id: estrategia.id, estrategia: estrategia.estrategia, responsable: responsable}).then( response => {
                    store.commit("setActivo", response.data);
                    swal({
                        type: "success",
                        title: "Estrategia guardada",
                        showConfirmButton: false,
                        timer: 800
                    });
                }).catch( e => {

                    this.data.steps.estrategias = _.map(this.data.steps.estrategias, estrategia => {
                        if (estrategia.id == estrategiaId ) {
                            estrategia.errors = e.response.data.errors
                        }
                        return estrategia;
                    });
                })
                
            },

            getEstrategiaName: function(campo) {
                var names = {
                            tiene_titular : 'Estrategia de gestión para el titular del DPI',
                            contrato_cesion: 'Estrategia de gestión para el contrato de cesión',
                            contrato_confidencialidad: 'Estrategia de gestión para el contrato de confidencialidad',
                            en_contabilidad:  'Estrategia de gestión para la contabilidad',
                            estado: 'Estrategia de gestión para el estado',
                            presupuesto_priorizacion: 'Estrategia de gestión del presupuesto para el plan de priorización'
                            };
                return names[campo];
            },

            getEstrategia: function(campo) {
                let estrategias = this.data.steps.estrategias;
                return _.filter(estrategias, estrategia => estrategia.campo == campo)[0];
            },

            geEstrategiaByState: function(state) {
                let estrategias = _.filter(this.data.steps.estrategias, estrategia => estrategia.estado == state);
                return estrategias;
            },

            getEstrategiaColor: function(campo) {
                let estrategia = this.getEstrategia(campo);
                let mapStyle = 
                    {
                        good: "color: green",
                        warning: "color: #f58345",
                        danger: "color: red"
                    }
                return mapStyle[estrategia.estado]
            },

            openComponent: function(component) {
                this.componentToOpen = component;
                this.openModalHelp = true;

                $('body').css({
                    overflow: 'hidden'
                });

            },

            onCloseModal: function() {
                this.openModalHelp = false;
                $('body').css({
                    overflow: 'auto'
                });
            },

            replaceSlash: function(fileId) {
                return fileId.replace("/", "-");
            },
            goToRoute: function(routeName) {
                this.$router.push({ name: routeName });
            },
            onClickProgress: function() {
                this.showProgress = !this.showProgress;
            },
            
            round: function(number) {
                return number%1==0 ? number*100 : (number*100).toFixed(2)
            },

            getYesNo: function(val) {
                let opt = {si: 'Si', no: 'No', nose: 'No se sabe' }
                return opt[val];
            }
        }
    }
</script>

<style>

.description-style {
    text-align: justify;
    white-space: pre-wrap;
    color: #333333;
    font-family: 'Open Sans';
}
    .char-container {
        display: flex;
        flex-wrap: wrap;
    }

    .glyphicon.glyphicon-ok {
        font-size: 17px;
        color: green;
    }

    .current-step {
        text-align: center;
    }

    .info-progreso {
        display: grid;
        grid-template-columns: repeat(1, auto);
    }

    .info-progreso > div {
        padding-left: 25px;
        padding-right: 25px;
    }

    .info-content {
        display: grid;
        grid-template-columns: repeat(1, auto);
        margin-bottom: 200px;
    }

    .circle {
        margin-top: 30px;
    }

    .info-content > div {
        padding: 10px;
        background-color: white;
        box-shadow: 0 0 30px #888888;
        border:solid gray;
        border-width: 0.5px;
        border-radius: 10px;
    }

    .info {
        text-align: center;
        padding-top: 20px;
    }

    .loader {
        border: 10px solid white;
        border-radius: 50%;
        border-top: 10px solid #53c5cf;
        width: 90px;
        height: 90px;
        margin: auto;
        -webkit-animation: spin 1.2s linear infinite; /* Safari */
        animation: spin 1.2s linear infinite;
    }

        /* Safari */
    @-webkit-keyframes spin {
        0% { -webkit-transform: rotate(0deg); }
        100% { -webkit-transform: rotate(360deg); }
    }

    @keyframes spin {
        0% { transform: rotate(0deg); }
        100% { transform: rotate(360deg); }
    }

</style>
