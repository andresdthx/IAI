<template lang="html">
  <div v-if="dataReady">
        <div class='step-container'>

            <div>
                <div>
                    <div>
                        <h4 class="step-title">
                            <strong>Estado del AI</strong>         
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
                        <strong class="step-title">Estado del AI identificado
                            <span style="color:red">*
                                <span class="glyphicon glyphicon-question-sign" 
                                      v-tooltip.right="{
                                        content: constantsEstado.tooltips[data.fields.estado.name],
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

                    <select :ref="data.fields.estado.name">
                        <option selected disabled value=''>Selecciona un estado</option>
                        <option v-for="(value, key) in data.fields.estado.values" :value="key"
                                :selected='data.fields.estado.data && key == data.fields.estado.data'>
                                {{value}}
                        </option>

                    </select>

                    <strong v-if="data.fields.estado.textAlert" 
                            style="color:red; display:block">{{constants.fieldRequired(data.fields.estado.name, 'm')}}
                    </strong>
                    
                    <br><br>

                    <div class="get-info">
                        <span  @click.preven="getInfo"><span class="glyphicon glyphicon-book"></span> <strong>Obtener información sobre los tipos de estado</strong></span>
                        
                        <template v-if="showInfo">
                            
                            <ul>
                               <li v-for="item in this.data.fields.estado.descripciones">
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

export default {
    mixins: [mixinStep],
    data() {
        return {
            step: '3',
            constantsEstado: constants.estado,
            constants: constants.stateMessages,
            showInfo: false
        }
    },

    methods:{
        getInfo: function() {
            this.showInfo = !this.showInfo;
        }
    }

};
</script>

