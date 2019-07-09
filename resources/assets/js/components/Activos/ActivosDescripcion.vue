<template lang="html">
    <div v-if="dataReady">
        
        <div class='step-container'>
            <div>
                <div>
                    <div>
                        <h4 class="step-title">
                            <strong>Descripción del AI</strong>
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
                        <strong class="step-title">Descripción del AI identificado
                            <span style="color:red">*
                                <span class="glyphicon glyphicon-question-sign" 
                                      v-tooltip.right="{
                                        content: constantsDescripcion.tooltips[data.fields.descripcion.name],
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

                    <textarea name ='descripcion'
                              v-model="data.fields.descripcion.data"
                              :ref="data.fields.descripcion.name" 
                              placeholder="Ingresa aquí la descripción"
                              rows="9"
                              cols="80">
                    </textarea>

                    <strong v-if="data.fields.descripcion.textAlert" 
                            style="color:red; display:block">La descripción es requerida.
                    </strong>

                    <br><br>

                    <h5><strong class="step-title">Documentos adjuntos</strong>
                    <span class="glyphicon glyphicon-question-sign" v-tooltip.right="{
                                content: constantsDescripcion.tooltips[data.fields.descripcion_adjuntos.name],
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

                    <div class="fileContainer" style="Open Sans">
                        <i class="fa fa-cloud-upload" style="display: inline; margin-right: 5px"></i>
                        Adjuntar archivos
                        <input type="file" name='file' @change="onFiles($event, data.fields.descripcion_adjuntos.name)" multiple />
                    </div>
                    
                    <br><br>

                    <!--///////////////////////////////////nuevo///////////////////////////////////////////-->
                    <template v-if="files && files[data.fields.descripcion_adjuntos.name].length > 0">

                        <table class="table table-download" style="margin-top:20px;">

                            <thead>
                                <tr>
                                    <th >
                                    <h5 class="step-title" style="display: inline">Archivos seleccionados </h5>

                                    <!--///////////////////////nuevo//////////////////////////-->
                                    <input style="margin-top: 9px; margin-left: 8px"
                                                @click="checkAllSelectedFiles(data.fields.descripcion_adjuntos.name, $event)"
                                                type="checkbox"
                                        >
                                    </th>
                                </tr>
                            </thead>

                            <tbody>
                                <!--///////////////////////////////////nuevo///////////////////////////////////////////-->
                                <tr v-for="(file, index) in files[data.fields.descripcion_adjuntos.name]">

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

                                    <!--///////////////////////////////////nuevo index///////////////////////////////////////////-->
                                    <td class="td-download"><span @click="abortUpload(data.fields.descripcion_adjuntos.name, index)" class="fa fa-trash" style="color: red; padding-bottom: 8px; width: 20px; cursor: pointer"></span></td>

                                    <!--///////////////////////////////////nuevo///////////////////////////////////////////-->
                                    <td class="td-download">
                                        <input  style="margin-top: 9px; margin-left: 8px" v-model="file.delete" type="checkbox">
                                    </td>
                                </tr>
                            </tbody>
                        </table>

                        <!--///////////////////////////////////nuevo///////////////////////////////////////////-->
                        <button type="button"  @click="onDeleteSelectedFiles(data.fields.descripcion_adjuntos.name)" class="btn btn-danger">Eliminar archivos</button>
                        <button type="button" @click="onSubmit(false)"  class="btn btn-guardar">Guardar archivos</button>
                    </template>

                    <!--///////////////////////////////////nuevo///////////////////////////////////////////-->
                    <template v-if="data.fields.descripcion_adjuntos.finished" >

                        <table class="table table-download" style="margin-top:20px;">

                            <thead>
                                <tr>
                                    <th>
                                        <h5 class="step-title" style="display: inline" >Archivos ascociados</h5>

                                        <!--///////////////////////////////////nuevo///////////////////////////////////////////-->
                                        <input style="margin-top: 9px; margin-left: 8px"
                                                @click="checkAllFiles(data.fields.descripcion_adjuntos.name, data.fields.descripcion_adjuntos.selectAll)"
                                                v-model="data.fields.descripcion_adjuntos.selectAll" 
                                                type="checkbox"
                                        >

                                    </th>
                                </tr>
                            </thead>

                            <tbody >
                                <tr  v-for="file in data.fields.descripcion_adjuntos.data">
                                    <td class="td-download"><span style="font-size: 14px;font-family: 'Open Sans'; color: #a09b9b">{{file.nombre}} </span></td>
                                
                                    <td class="td-download">
                                        <a :href="`/activos/donwloadFile/${replaceSlash(file.id)}`" 
                                            class="fa fa-cloud-download"
                                            style="color: #490E6F;cursor: pointer;display: inline; margin-right: 5px; text-decoration: none;">
                                        </a>
                                    </td>

                                    <td class="td-download">

                                        <span @click="deleteFile(activo_id, replaceSlash(file.id))"
                                            class="fa fa-trash"
                                            style="cursor: pointer; color: red; padding-bottom: 8px; width: 20px; padding-left: 0px">
                                        </span>
                                    </td>

                                    <!--///////////////nuevo//////////////////-->
                                    <td class="td-download">
                                        <input  style="margin-top: 9px; margin-left: 8px" v-model="file.delete" type="checkbox">
                                    </td>

                                </tr>

                            </tbody>
                        </table>

                        <!--///////////////nuevo//////////////////-->
                        <button type="button"  @click="onDeleteFiles(activo_id, data.fields.descripcion_adjuntos.name)" class="btn btn-danger">Eliminar archivos</button>
                        <!--<button type="button"  @click="onDownloadFiles(activo_id, data.fields.descripcion_adjuntos.name)" class="btn btn-info">Descargar</button>-->

                        <br><br>

                    </template>

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

<style>


table tr td:last-child {
  text-align: right;
}
</style>

<script>

import VTooltip from "v-tooltip";
import { CONSTANTS as constants } from "../../constants";
import mixinStep from "./ActivosMixin";

export default {
  mixins: [mixinStep],
  data() {
    return {
      step: "1",
      constants: constants.stateMessages,
      constantsDescripcion: constants.descripcion
    };

  },

};
</script>
