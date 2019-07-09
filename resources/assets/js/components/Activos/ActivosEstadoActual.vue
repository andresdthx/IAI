<template lang="html">
  <div v-if="dataReady">
        <div class='step-container'>

            <div>
                <div>
                    <div>
                        <h4 class="step-title">
                            <strong>Estado actual del AI</strong>         
                        </h4>
                    </div> 
                        <strong>Estado: </strong><span>{{constants.state(data.finished)}}</span>
                        <br>
                        <span v-if="data.finished">{{constants.stepFinished}} </span>
                </div>
            </div>
            <hr>

            <div>
                <form name="form">
                    <h5>
                        <strong class="step-title">¿El AI ha sido publicado o divulgado?
                            <span style="color:red">*
                                <span class="glyphicon glyphicon-question-sign" 
                                      v-tooltip.right="{
                                        content: constantsEstadoActual.tooltips[data.fields.publicado_divulgado.name],
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
                    </h5>

                    <select v-model="publicado_divulgado" :ref="data.fields.publicado_divulgado.name" >
                        <option selected disabled value=''>Selecciona una opción</option>
                        <option v-for="(value, key) in data.fields.publicado_divulgado.values" :value="key">
                                {{value}}
                        </option>
                    </select>

                    <template v-if="publicado_divulgado=='si'" >
                        <br><br>
                         <strong class="step-title">Medio de publicación o divulgación
                            <span style="color:red">*
                                <span class="glyphicon glyphicon-question-sign" 
                                      v-tooltip.right="{
                                        content: constantsEstadoActual.tooltips[data.fields.lugar_publicacion.name],
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
        
                        <input 
                            :ref="data.fields.lugar_publicacion.name"
                            v-model="lugar_publicacion"
                            type="text" 
                            class="input-text-step" 
                            name="nombre" 
                            placeholder="Ingresa el medio de publicación o divulgación">

                        <strong v-if="data.fields.lugar_publicacion.textAlert" 
                            style="color:red; display:block">{{constants.fieldRequired('lugar de publicación o divulgación', 'm')}}
                        </strong>

                        <br>

                        <strong class="step-title">Fecha de publicación o divulgación
                            <span style="color:red">*
                                <span class="glyphicon glyphicon-question-sign" 
                                      v-tooltip.right="{
                                        content: constantsEstadoActual.tooltips[data.fields.fecha_publicacion.name],
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
                        <br>

                        <date-picker :date="startTime" :option="option" :ref="data.fields.fecha_publicacion.name">''</date-picker>
                        
                        <strong v-if="data.fields.fecha_publicacion.textAlert" 
                            style="color:red; display:block">{{constants.fieldRequired('fecha de publicación o divulgación', 'f')}}
                        </strong>

                    </template>
                    <hr>
                    <h5>
                    <strong class="step-title">¿El AI tiene contrato de confidencialidad firmado?
                            <span style="color:red">*
                                <span class="glyphicon glyphicon-question-sign" 
                                      v-tooltip.right="{
                                        content: constantsEstadoActual.tooltips[data.fields.contrato_confidencialidad.name],
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
                    </h5>

                    <select v-model="contrato_confidencialidad" :ref="data.fields.contrato_confidencialidad.name" >
                        <option selected disabled value=''>Selecciona una opción</option>
                        <option v-for="(value, key) in data.fields.contrato_confidencialidad.values" :value="key">
                                {{value}}
                        </option>
                    </select>

                    <br><br>

                     <template v-if="contrato_confidencialidad=='si'" >
                        <h5>
                         <strong class="step-title">Adjuntar contrato de confidencialidad firmado
                            <span style="color:red">*
                                <span class="glyphicon glyphicon-question-sign" 
                                      v-tooltip.right="{
                                        content: constantsEstadoActual.tooltips[data.fields.contrato_confidencialidad_adjunto.name],
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
                        </h5>

                        <div class="fileContainer" style="Open Sans">
                            <i class="fa fa-cloud-upload" style="display: inline; margin-right: 5px"></i>
                            Adjuntar
                            <input type="file" name='file' @change="onFiles($event, data.fields.contrato_confidencialidad_adjunto.name)" multiple/>
                        </div>
                        <br><br>

                        <template v-if="files && files[data.fields.contrato_confidencialidad_adjunto.name].length > 0" >

                            <table class="table table-download" style="margin-top:20px;">

                                <thead>
                                    <tr>
                                        <th >
                                        <h5 style="display: inline" class="step-title">Archivos seleccionados </h5>
                                        <input style="margin-top: 9px; margin-left: 8px"
                                                @click="checkAllSelectedFiles(data.fields.contrato_confidencialidad_adjunto.name, $event)"
                                                type="checkbox"
                                        >
                                        </th>
                                    </tr>
                                </thead>

                                <tbody>
                                    <tr v-for="(file, index) in files[data.fields.contrato_confidencialidad_adjunto.name]">
                                        <td class="td-download">
                                            <span style="font-size: 14px;font-family: 'Open Sans'; color: #a09b9b">
                                                {{file.name}}
                                            </span>
                                        </td>


                                        <td class="td-download">
                                            <span style="margin-left: 20px;font-size: 14px;font-family: 'Open Sans'; color: #a09b9b">
                                                {{getFileSize(file.size)}}
                                            </span>
                                        </td>


                                        <td class="td-download"><span @click="abortUpload(data.fields.contrato_confidencialidad_adjunto.name, index)" class="fa fa-trash" style="color: red; padding-bottom: 8px; width: 20px; cursor: pointer"></span></td>

                                         <td class="td-download">
                                            <input  style="margin-top: 9px; margin-left: 8px" v-model="file.delete" type="checkbox">
                                        </td>
                                    </tr>
                                </tbody>
                            </table>

                            <button type="button"  @click="onDeleteSelectedFiles(data.fields.contrato_confidencialidad_adjunto.name)" class="btn btn-danger">Eliminar archivos</button>
                            <button type="button" @click="onSubmit(false)"  class="btn btn-guardar">Guardar archivos</button>
                         

                        </template>


                        <template v-if="data.fields.contrato_confidencialidad_adjunto.finished">
                        
                            <table class="table table-download" style="margin-top:20px;">
                
                                <thead>
                                    <tr>
                                        <th >
                                            <h5 style="display: inline" class="step-title"> Archivos ascociados</h5>
                                            <input style="margin-top: 9px; margin-left: 8px"
                                                @click="checkAllFiles(data.fields.contrato_confidencialidad_adjunto.name, data.fields.contrato_confidencialidad_adjunto.selectAll)"
                                                v-model="data.fields.contrato_confidencialidad_adjunto.selectAll" 
                                                type="checkbox"
                                        >
                                        </th>
                                    </tr>
                                </thead>

                                <tbody>
                                    <tr v-for="file in data.fields.contrato_confidencialidad_adjunto.data">
                                        <!-- <a :href="`/activos/donwloadFile/${replaceSlash(file.id)}`">{{file.nombre}} </a> -->
                                        <td class="td-download"><span style="font-size: 14px;font-family: 'Open Sans'; color: #a09b9b">{{file.nombre}} </span></td>

                                        <td class="td-download">
                                            <a :href="`/activos/donwloadFile/${replaceSlash(file.id)}`" 
                                                class="fa fa-cloud-download"
                                                style="color: #490E6F;cursor: pointer;display: inline; margin-right: 5px; text-decoration: none;">
                                            </a>
                                        </td>

                                        <td class="td-download"><span @click="deleteFile(activo_id, replaceSlash(file.id))" class="fa fa-trash" style="cursor: pointer; color: red; padding-bottom: 8px; width: 20px; padding-left: 0px"></span></td>

                                        <td class="td-download">
                                            <input  style="margin-top: 9px; margin-left: 8px" v-model="file.delete" type="checkbox">
                                        </td>

                                    </tr>

                                </tbody>
                            </table>
                            <button type="button"  @click="onDeleteFiles(activo_id, data.fields.contrato_confidencialidad_adjunto.name)" class="btn btn-danger">Eliminar archivos</button>
                            <!--<button type="button"  @click="onDownloadFiles(activo_id, data.fields.descripcion_adjuntos.name)" class="btn btn-info">Descargar</button>-->

                        </template>

                        
                        <br><br>

                    
                       <template v-if="data.fields.contrato_confidencialidad_adjunto.textAlert">
                            <strong 
                                style="color:red; display:block">{{constants.fieldRequired('contrato de confidencialidad', 'm')}}
                            </strong>
                        </template>


                    </template>

                    <!--<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>-->
                     <!-- <h5>
                        <strong class="step-title">¿El DPI tiene titular?
                                <span style="color:red">*
                                    <span class="glyphicon glyphicon-question-sign" 
                                        v-tooltip.right="{
                                            content: constantsEstadoActual.tooltips[data.fields.contrato_cesion.name],
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
                        </h5>

                         <select v-model="tiene_titular" :ref="data.fields.tiene_titular.name" >
                            <option selected disabled value=''>Selecciona una opción</option>
                            <option v-for="(value, key) in data.fields.tiene_titular.values" :value="key">
                                    {{value}}
                            </option>
                        </select>

                         <strong v-if="data.fields.tiene_titular.textAlert" 
                            style="color:red; display:block">Debe de indicar si existe o no el titular
                        </strong> -->
                    
                    <!--<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>-->
                    <template >

                        <h5>
                        <strong class="step-title">Nombre del titular de cada uno de los DPI asociados al AI
                                <span style="color:red">*
                                    <span class="glyphicon glyphicon-question-sign" 
                                        v-tooltip.right="{
                                            content: constantsEstadoActual.tooltips[data.fields.nombre_titular.name],
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
                            </h5>

                            <input 
                                :ref="data.fields.nombre_titular.name"
                                v-model="nombre_titular"
                                type="text" 
                                class="input-text-step" 
                                name="nombre" 
                                placeholder="Ingresa el nombre del titular de cada uno de los DPI asociados al AI">

                            <strong v-if="data.fields.nombre_titular.textAlert" 
                                style="color:red; display:block">{{constants.fieldRequired('nombre del titular', 'm')}}
                            </strong>
                        </template>
                        <hr>
                        <h5>
                        <strong class="step-title">¿Los DPI asociados al AI se han cedido a la Universidad y/o a un tercero? 
                                <span style="color:red">*
                                    <span class="glyphicon glyphicon-question-sign" 
                                        v-tooltip.right="{
                                            content: constantsEstadoActual.tooltips[data.fields.contrato_cesion.name],
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
                        </h5>

                         <select v-model="contrato_cesion" :ref="data.fields.contrato_cesion.name" >
                            <option selected disabled value=''>Selecciona una opción</option>
                            <option v-for="(value, key) in data.fields.contrato_cesion.values" :value="key">
                                    {{value}}
                            </option>
                        </select>

                         <template v-if="contrato_cesion == 'si'" >
                             <br><br>
                        <h5>
                         <strong class="step-title">Adjuntar contrato de cesión firmado
                            <span style="color:red">*
                                <span class="glyphicon glyphicon-question-sign" 
                                      v-tooltip.right="{
                                        content: constantsEstadoActual.tooltips[data.fields.contrato_cesion_adjunto.name],
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
                        </h5>


                        <div class="fileContainer" style="Open Sans">
                            <i class="fa fa-cloud-upload" style="display: inline; margin-right: 5px"></i>
                            Adjuntar
                            <input  type="file" name='file' @change="onFiles($event, data.fields.contrato_cesion_adjunto.name)" multiple/>
                        </div> 
                        <br><br>


                        <template v-if="files && files[data.fields.contrato_cesion_adjunto.name].length > 0">
                            <table  class="table table-download" style="margin-top:20px;">

                                <thead>
                                    <tr>
                                        <th >
                                        <h5 style="display: inline" class="step-title">Archivos seleccionados</h5>
                                        <input style="margin-top: 9px; margin-left: 8px"
                                                @click="checkAllSelectedFiles(data.fields.contrato_cesion_adjunto.name, $event)"
                                                type="checkbox"
                                        >
                                        </th>
                                    </tr>
                                </thead>

                                <tbody>
                                    <tr v-for="(file, index) in files[data.fields.contrato_cesion_adjunto.name]">
                                        <td class="td-download">
                                            <span style="font-size: 14px;font-family: 'Open Sans'; color: #a09b9b">
                                                {{file.name}}
                                            </span>
                                        </td>


                                        <td class="td-download">
                                            <span style="margin-left: 20px;font-size: 14px;font-family: 'Open Sans'; color: #a09b9b">
                                                {{getFileSize(file.size)}}
                                            </span>
                                        </td>


                                        <td class="td-download"><span @click="abortUpload(data.fields.contrato_cesion_adjunto.name, index)"  class="fa fa-trash" style="color: red; padding-bottom: 8px; width: 20px; cursor: pointer"></span></td>

                                        <td class="td-download">
                                            <input  style="margin-top: 9px; margin-left: 8px" v-model="file.delete" type="checkbox">
                                        </td>

                                    </tr>
                                </tbody>
                            </table>

                             <button type="button"  @click="onDeleteSelectedFiles(data.fields.contrato_cesion_adjunto.name)" class="btn btn-danger">Eliminar archivos</button>
                            <button type="button" @click="onSubmit(false)"  class="btn btn-guardar">Guardar archivos</button>
                        </template>

                        <template v-if="data.fields.contrato_cesion_adjunto.finished" >

                            <table class="table table-download" style="margin-top:20px;">
                
                                <thead>
                                    <tr>
                                        <th >
                                        <h5 style="display: inline" class="step-title">Archivos ascociados</h5>

                                        <input style="margin-top: 9px; margin-left: 8px"
                                                @click="checkAllFiles(data.fields.contrato_cesion_adjunto.name, data.fields.contrato_cesion_adjunto.selectAll)"
                                                v-model="data.fields.contrato_cesion_adjunto.selectAll" 
                                                type="checkbox">

                                        </th>
                                    </tr>
                                </thead>

                                <tbody>
                                    <tr v-for="file in data.fields.contrato_cesion_adjunto.data">
                                        <!-- <a :href="`/activos/donwloadFile/${replaceSlash(file.id)}`">{{file.nombre}} </a> -->
                                        <td class="td-download"><span style="font-size: 14px;font-family: 'Open Sans'; color: #a09b9b">{{file.nombre}} </span></td>
                                        
                                        <td class="td-download">
                                            <a :href="`/activos/donwloadFile/${replaceSlash(file.id)}`" 
                                                class="fa fa-cloud-download"
                                                style="color: #490E6F;cursor: pointer;display: inline; margin-right: 5px; text-decoration: none;">
                                            </a>
                                        </td>

                                        <td class="td-download"><span @click="deleteFile(activo_id, replaceSlash(file.id))" class="fa fa-trash" style="cursor: pointer; color: red; padding-bottom: 8px; width: 20px; padding-left: 0px"></span></td>

                                        <td class="td-download">
                                            <input  style="margin-top: 9px; margin-left: 8px" v-model="file.delete" type="checkbox">
                                        </td>
                                        
                                    </tr>

                                </tbody>
                            </table>
                            <button type="button"  @click="onDeleteFiles(activo_id, data.fields.contrato_cesion_adjunto.name)" class="btn btn-danger">Eliminar archivos</button>
                        </template>


                        <!--<button type="button"  @click="onDownloadFiles(activo_id, data.fields.descripcion_adjuntos.name)" class="btn btn-info">Descargar</button>-->

                       <template v-if="data.fields.contrato_cesion_adjunto.textAlert">
                            <br><br>
                            <strong 
                                style="color:red; display:block">{{constants.fieldRequired('contrato de cesión', 'm')}}
                            </strong>
                        </template>

                    </template>
                    <hr>

                     <h5>
                    <strong class="step-title">Ubicación actual del AI
                            <span style="color:red">*
                                <span class="glyphicon glyphicon-question-sign" 
                                      v-tooltip.right="{
                                        content: constantsEstadoActual.tooltips[data.fields.ubicacion_ai.name],
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
                        </h5>

                        <input 
                            :ref="data.fields.ubicacion_ai.name"
                            v-model="ubicacion_ai"
                            type="text" 
                            class="input-text-step" 
                            name="nombre" 
                            placeholder="Ingresa la ubicación actual del AI">

                        <strong v-if="data.fields.ubicacion_ai.textAlert" 
                            style="color:red; display:block">{{constants.fieldRequired('ubicacion actual del AI', 'f')}}
                        </strong>

                        <hr>

                        <h5>
                        <strong class="step-title">¿Se encuentra incorporado a la contabilidad como activo intangible? 
                                <span style="color:red">*
                                    <span class="glyphicon glyphicon-question-sign" 
                                        v-tooltip.right="{
                                            content: constantsEstadoActual.tooltips[data.fields.valor_de_ai.name],
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
                        </h5>

                         <select v-model="en_contabilidad" :ref="data.fields.en_contabilidad.name" >
                            <option selected disabled value=''>Selecciona una opción</option>
                            <option v-for="(value, key) in data.fields.contrato_cesion.values" :value="key"
                                    :selected='data.fields.contrato_cesion.data && key == data.fields.contrato_cesion.data'>
                                    {{value}}
                            </option>
                        </select>

                    <template v-if="en_contabilidad == 'si'">
                        <br><br>
                        <h5>
                            <strong class="step-title">Valor del AI
                                <span style="color:red">*
                                    
                                </span>
                            </strong>
                        </h5>

                        <input 
                            :ref="data.fields.valor_de_ai.name"
                            v-model ="valor_de_ai"
                            type="number" 
                            name="nombre" 
                            placeholder="Ingresa el valor en contabilidad del AI">

                        <strong v-if="data.fields.valor_de_ai.textAlert" 
                            style="color:red; display:block">El valor del AI es requerido
                        </strong>
                        <br>
                        <h5>
                            <strong class="step-title">Comentarios sobre el AI en contabilidad
                                <span style="color:red">*
                                    
                                </span>
                            </strong>
                        </h5>

                        <textarea   
                                name ='uso'
                                v-model="valor_de_ai_comentarios"
                                :ref="data.fields.valor_de_ai_comentarios.name" 
                                placeholder="Ingresa los comentarios sobre el AI en contabilidad"
                                rows="9"
                                cols="80">
                        </textarea>

                        <strong v-if="data.fields.valor_de_ai_comentarios.textAlert" 
                            style="color:red; display:block">Los comentarios sobre el AI en contabilidad son requeridos
                        </strong>


                    </template>
                    <br><br>
                    <div style="float: right">
                        <button type="button" style="margin-right: 15px;" @click="$emit('cerrar')" class="btn btn-cancelar">Cancelar</button>
                        <button type="button" @click="onSubmit"  class="btn btn-guardar">Guardar</button>
                    </div>
                    <br><br>



                </form>
            </div>

        </div>
    </div>
</template>

<script>
import VTooltip from "v-tooltip";
import { CONSTANTS as constants } from "../../constants";
import mixinStep from "./ActivosMixin";
import Multiselect from "vue-multiselect";
import myDatepicker from "vue-datepicker";

export default {
  mixins: [mixinStep],
  components: {
    "date-picker": myDatepicker
  },

  data() {
    return {
      step: "5",
      publicado_divulgado: '',
      contrato_confidencialidad: "",
      contrato_cesion: "",
      //tiene_titular: "",
      en_contabilidad: "",
      constantsEstadoActual: constants.estado_actual,
      constants: constants.stateMessages,
      startTime: {time: ''},
      option: constants.date_picker.style,
      lugar_publicacion: '',
      nombre_titular: '',
      ubicacion_ai: ''
    };
  },

  created() {
      if (this.data) {
        this.lugar_publicacion          = this.data.fields.lugar_publicacion.data;
        this.nombre_titular             = this.data.fields.nombre_titular.data;
        this.ubicacion_ai               = this.data.fields.ubicacion_ai.data;
        this.valor_de_ai                = this.data.fields.valor_de_ai.data;
        
        //this.tiene_titular              = this.data.fields.tiene_titular.data ? this.data.fields.tiene_titular.data : '';
        this.publicado_divulgado        = this.data.fields.publicado_divulgado.data ?  this.data.fields.publicado_divulgado.data : '';
        this.contrato_confidencialidad  = this.data.fields.contrato_confidencialidad.data ?  this.data.fields.contrato_confidencialidad.data : '';
        this.contrato_cesion            = this.data.fields.contrato_cesion.data ?  this.data.fields.contrato_cesion.data : '';
        this.en_contabilidad            = this.data.fields.en_contabilidad.data ?  this.data.fields.en_contabilidad.data : '';
        this.valor_de_ai_comentarios    = this.data.fields.valor_de_ai_comentarios.data ?  this.data.fields.valor_de_ai_comentarios.data : '';
        this.startTime.time             = this.data.fields.fecha_publicacion.data ?  this.data.fields.fecha_publicacion.data : '';
      }
  },

  watch: {

    "startTime.time": function(val) {
      this.$refs[this.data.fields.fecha_publicacion.name] = { value: val };
    },

    data: function(data) {
        this.lugar_publicacion          = this.data.fields.lugar_publicacion.data;
        this.nombre_titular             = this.data.fields.nombre_titular.data;
        this.ubicacion_ai               = this.data.fields.ubicacion_ai.data;
        this.valor_de_ai                = this.data.fields.valor_de_ai.data;

        //this.tiene_titular              = this.data.fields.tiene_titular.data ? this.data.fields.tiene_titular.data : '';
        this.publicado_divulgado        = this.data.fields.publicado_divulgado.data ?  data.fields.publicado_divulgado.data : '';
        this.contrato_confidencialidad  = this.data.fields.contrato_confidencialidad.data ?  data.fields.contrato_confidencialidad.data : '';
        this.contrato_cesion            = this.data.fields.contrato_cesion.data ?  data.fields.contrato_cesion.data : '';
        this.en_contabilidad            = this.data.fields.en_contabilidad.data ?  data.fields.en_contabilidad.data : '';
        this.startTime.time             = this.data.fields.fecha_publicacion.data ?  data.fields.fecha_publicacion.data : '';
    }
  }
};
</script>

