<template lang="html">
    <div v-if="dataReady">
        <div class='step-container'>

            <div>
                <div>
                    <div>
                        <h4 class="step-title">
                            <strong>Clasificación del AI</strong>         
                        </h4>
                    </div> 
                        <strong>Estado: </strong><span>{{constants.state(data.finished)}}</span>
                        <br>
                        <span v-if="data.finished">{{constants.stepFinished}} </span>
                </div>
            </div>
            <hr>

            <div>
                
                <form name='form'>

                    <h5>
                        <strong class="step-title">Clasificación del AI identificado
                            <span style="color:red">*
                                <span class="glyphicon glyphicon-question-sign" 
                                      v-tooltip.right="{
                                        content: constantsClasificacion.tooltips[data.fields.clasificacion.name],
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

                    <select v-model="clasificacion" :ref="data.fields.clasificacion.name">
                        <option selected disabled value=''>Selecciona una clasificación</option>
                        <option v-for="(value, key) in data.fields.clasificacion.values" :value="key"
                                :selected='data.fields.clasificacion.data && key == data.fields.clasificacion.data'>
                                {{value}}
                        </option>
                    </select>

                    <template v-if="clasificacion == 'otro'">
                        <br><br>
                        <h5>
                            <strong class="step-title">Cuál?</strong><span style="color:red">*</span>
                        </h5>

                        <input 
                            :ref="data.fields.cual.name"
                            v-model="cual"
                            type="text"
                            name="nombre" 
                            placeholder="Ingresa la clasificación del activo intangible">
                        
                        <strong v-if="data.fields.cual.textAlert" 
                            style="color:red; display:block">Este campo es requerido
                        </strong>

                    </template>


                    <strong v-if="data.fields.clasificacion.textAlert" 
                            style="color:red; display:block">{{constants.fieldRequired(data.fields.clasificacion.name, 'f')}}
                    </strong>
                    
                    <br><br>
                    <div class="get-info">
                        <span  @click.preven="getInfo"><span class="glyphicon glyphicon-book"></span> <strong>Obtener información sobre los tipos de clasificación</strong></span>
                        
                        <template v-if="showInfo">
                            
                            <ul>
                               <li v-for="item in this.data.fields.clasificacion.descripciones">
                                   <strong>{{item.nombre}}: </strong>
                                   <span>{{item.descripcion}}</span>
                                   <br>
                               </li>
                            </ul>
                        </template>
                    </div>

                    <br><br>

                    <h5><strong class="step-title">Documentos adjuntos</strong>
                    <span class="glyphicon glyphicon-question-sign" v-tooltip.right="{
                                content: constantsClasificacion.tooltips[data.fields.clasificacion_adjuntos.name],
                                placement: 'bottom-center',
                                classes: ['info'],
                                targetClasses: ['it-has-a-tooltip'],
                                offset: 5,
                                delay: {
                                    show: 500,
                                    hide: 300,
                                },
                                }"></span> 
                    </h5>

                    <div class="fileContainer">
                        <i class="fa fa-cloud-upload" style="display: inline; margin-right: 5px"></i>
                        Adjuntar archivos
                        <input type="file" name='file' @change="onFiles($event, data.fields.clasificacion_adjuntos.name)" multiple />
                    </div> 

                    <br><br>

                    <template v-if="files && files[data.fields.clasificacion_adjuntos.name].length > 0">

                        <table class="table table-download" style="margin-top:20px;">
                
                            <thead>
                                <tr>
                                    <th >
                                        <h5 style="display: inline" class="step-title">Archivos seleccionados</h5>

                                        <input style="margin-top: 9px; margin-left: 8px"
                                                @click="checkAllSelectedFiles(data.fields.clasificacion_adjuntos.name, $event)"
                                                type="checkbox"
                                        >
                                    
                                    </th>
                                </tr>
                            </thead>

                            <tbody>
                                <tr v-for="(file, index)  in files[data.fields.clasificacion_adjuntos.name]">
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


                                    <td class="td-download"><span @click="abortUpload(data.fields.clasificacion_adjuntos.name, index)" class="fa fa-trash" style="color: red; padding-bottom: 8px; width: 20px; cursor: pointer"></span></td>

                                    <td class="td-download">
                                        <input  style="margin-top: 9px; margin-left: 8px" v-model="file.delete" type="checkbox">
                                    </td>

                                  
                                </tr>
                            </tbody>
                        </table>


                        <button type="button"  @click="onDeleteSelectedFiles(data.fields.clasificacion_adjuntos.name)" class="btn btn-danger">Eliminar archivos</button>
                        <button type="button" @click="onSubmit(false)"  class="btn btn-guardar">Guardar archivos</button>
                       
                    </template>

                    <template v-if="data.fields.clasificacion_adjuntos.finished">

                        <table class="table table-download" style="margin-top:20px;">
                
                            <thead>
                                <tr>
                                    <th >
                                    <h5 style="display: inline" class="step-title">Archivos ascociados</h5>

                                        <input style="margin-top: 9px; margin-left: 8px"
                                                    @click="checkAllFiles(data.fields.clasificacion_adjuntos.name, data.fields.clasificacion_adjuntos.selectAll)"
                                                    v-model="data.fields.clasificacion_adjuntos.selectAll" 
                                                    type="checkbox">
                                    </th>
                                </tr>
                            </thead>

                            <tbody >
                                <tr v-for="file in data.fields.clasificacion_adjuntos.data">

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

                         <button type="button"
                                @click="onDeleteFiles(activo_id, data.fields.clasificacion_adjuntos.name)" 
                                class="btn btn-danger">Eliminar archivos
                        </button>

                        <!--<button type="button"  @click="onDownloadFiles(activo_id, data.fields.descripcion_adjuntos.name)" class="btn btn-info">Descargar</button>-->
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

export default {
  mixins: [mixinStep],
  data() {
    return {
      step: "2",
      constants: constants.stateMessages,
      showInfo: false,
      clasificacion: "",
      cual: "",
      constantsClasificacion: constants.clasificacion
    };
  },

  created() {
    if (this.data) {
      this.clasificacion = this.data.fields.clasificacion.data || "";
      if (Object.keys(this.data.fields.clasificacion.values).indexOf(this.clasificacion) < 0 && this.clasificacion != "") {
          this.cual = this.clasificacion;
          this.clasificacion = 'otro';
      } else {
      this.cual = this.data.fields.cual.data || "";
      }
    }
  },

  watch: {

    data: function(data) {
      this.clasificacion = data.fields.clasificacion.data || "";
      if (Object.keys(data.fields.clasificacion.values).indexOf(this.clasificacion) < 0 && this.clasificacion != "") {
          this.cual = this.clasificacion;
          this.clasificacion = 'otro';
      } else {
      this.cual = data.fields.cual.data || "";
      }
    }
  },

  methods: {
    getInfo: function() {
      console.log("getInfo"), (this.showInfo = !this.showInfo);
    }

  }
};
</script>

