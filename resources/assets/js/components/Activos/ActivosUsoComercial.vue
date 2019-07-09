<template lang="html">
  <div v-if="dataReady">
        <div class='step-container'>
            <div>
                <div>
                    <div>
                        <h4>
                            <strong class="step-title">Uso comercial de los DPI asociados al AI</strong>          
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
                        <strong class="step-title">¿Hay uso comercial de uno o más de los DPI asociados al AI? 
                            <span style="color:red">*
                                <span class="glyphicon glyphicon-question-sign" 
                                      v-tooltip.right="{
                                        content: constantsUsoComercial.tooltips[data.fields.uso_comercial.name],
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

                    <select v-model="uso_comercial" :ref="data.fields.uso_comercial.name" >
                        <option selected disabled value=''>Selecciona una opción</option>
                        <option v-for="(value, key) in data.fields.uso_comercial.values" :value="key">
                                {{value}}
                        </option>
                    </select>

                    <template v-if="uso_comercial == 'si'">
                        <br><br>
                        <h5>
                            <strong class="step-title">¿Cuál?
                                <span style="color:red">*
                                     <span class="glyphicon glyphicon-question-sign" 
                                      v-tooltip.right="{
                                        content: constantsUsoComercial.tooltips[data.fields.uso_comercial.name],
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


                        <textarea   
                                name ='uso'
                                v-model="cual_uso_comercial"
                                :ref="data.fields.cual_uso_comercial.name" 
                                placeholder="Ingresa el uso comercial"
                                rows="9"
                                cols="80">
                        </textarea>
                        
                        <strong v-if="data.fields.cual_uso_comercial.textAlert" 
                            style="color:red; display:block">Este campo es requerido
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
import swal from "sweetalert2";
import Multiselect from "vue-multiselect";

export default {
    mixins: [mixinStep],
    components: { Multiselect },
    data() {
        return {
            step: '9',
            constantsUsoComercial: constants.usoComercial,
            constants: constants.stateMessages,
            uso_comercial: '',
            cual_uso_comercial: ''
        }
    },
    
    created() {
        if (this.data) {
            this.cual_uso_comercial = this.data.fields.cual_uso_comercial.data || '';
            this.uso_comercial = this.data.fields.uso_comercial.data || '';
        }
    },

    watch: {
        data: function(data) {
            this.cual_uso_comercial = this.data.fields.cual_uso_comercial.data || '';
            this.uso_comercial = this.data.fields.uso_comercial.data || '';
        }
    }
}
</script>
