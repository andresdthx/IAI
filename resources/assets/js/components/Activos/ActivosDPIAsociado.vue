<template lang="html">
    <div v-if="dataReady">
        <div class='step-container'>

            <div>
                <div>
                    <div>
                        <h4 class="step-title">
                            <strong>Derechos de propiedad intelectual asociados al AI</strong>       
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
                        <strong class="step-title">DPI asociados
                            <span style="color:red">*
                                <span class="glyphicon glyphicon-question-sign" 
                                      v-tooltip.right="{
                                        content: constantsDpiAsociado.tooltips[data.fields.dpi_asociado.name],
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

                     <multiselect
                            v-model="multiSelect.dpi_asociado"
                            :options="data.fields.dpi_asociado.values"
                            open-direction="bottom"
                            :select-label="'Presiona enter para seleccionar'"
                            :multiple="true"
                            :close-on-select="false" 
                            :clear-on-select="true" 
                            :hide-selected="true" 
                            :preserve-search="true" 
                            placeholder="Seleccciona los DPI"
                            label="nombre"
                            track-by="nombre">
                    </multiselect>

                    <strong v-if="data.fields.dpi_asociado.textAlert" 
                            style="color:red; display:block">{{constants.fieldRequired(data.fields.dpi_asociado.name, 'm')}}
                    </strong>
                    <br>

                    <div class="get-info">
                        <span  @click.preven="getInfo"><span class="glyphicon glyphicon-book"></span> <strong>Obtener información sobre los tipos de DPI</strong></span>

                        <template v-if="showInfo">
                            <br><br>
                            <p style="color: #636b6f">En esta opción seleccione todos los DPI que se le puedan asociar según su conocimiento 
                                y use los siguientes conceptos como guía:</p>
                            <ul>
                               <li v-for="item in this.data.fields.dpi_asociado.values">
                                   <strong>{{item.nombre}}: </strong>
                                   <span>{{item.descripcion}}</span>
                                   <br>
                               </li>
                            </ul>
                        </template>
                    </div>
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
import Multiselect from 'vue-multiselect';

export default {
  mixins: [mixinStep],
  components: {Multiselect},
  data() {
      return {
          step: '4',
          showInfo: false,
          constantsDpiAsociado: constants.dpi_asociado,
          constants: constants.stateMessages,

      }
  },

  methods: {
      getInfo: function() {
          this.showInfo = !this.showInfo;
      }
  }
}
</script>
