<template lang="html">
    <div v-if="dataReady">
        <div class='step-container'>
            <div>
                <div>
                    <div>
                        <h4>
                            <strong class="step-title">Plan de acción y protección del AI</strong>
                                <span class="glyphicon glyphicon-question-sign" v-tooltip.right="{
                                content: constanstProteccion.tooltips.main,
                                placement: 'bottom-center',
                                classes: ['info'],
                                targetClasses: ['it-has-a-tooltip'],
                                offset: 5,
                                delay: {
                                    show: 500,
                                    hide: 300,
                                },
                                }"></span>            
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
                    <!-- <template v-if="dpis_asociados.includes('Derecho de autor')"> -->
                     <h5>
                        <strong class="step-title">¿Existe un depósito ante la autoridad competente para el derecho de autor?
                            <span style="color:red">*
                                <span class="glyphicon glyphicon-question-sign" 
                                      v-tooltip.right="{
                                        content: constanstProteccion.tooltips[data.fields.deposito_da.name],
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

                    <select v-model="deposito_da" :ref="data.fields.deposito_da.name" >
                        <option selected disabled value=''>Selecciona una opción</option>
                        <option v-for="(value, key) in data.fields.deposito_da.values" :value="key">
                                {{value}}
                        </option>
                    </select>
        
                    <template v-if="deposito_da=='no'">
                        <br><br>
                        <h5>
                        <strong class="step-title">¿Se sugiere un depósito para el derecho de autor?
                            <span style="color:red">*
                                <span class="glyphicon glyphicon-question-sign" 
                                      v-tooltip.right="{
                                        content: constanstProteccion.tooltips[data.fields.registro_da.name],
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

                    <select v-model="registro_da" :ref="data.fields.registro_da.name" >
                        <option selected disabled value=''>Selecciona una opción</option>
                        <option v-for="(value, key) in data.fields.registro_da.values" :value="key">
                                {{value}}
                        </option>
                    </select>

                    <strong v-if="data.fields.registro_da.textAlert" 
                        style="color:red; display:block">Este campo es requerido
                    </strong>

                    </template>

                    <template v-else-if="deposito_da=='si'">
                        <br><br>
                        <h5>
                        <strong class="step-title">Indique el número de referencia
                                <span style="color:red">*
                                       
                                </span>
                            </strong>
                        </h5>

                        <input 
                            :ref="data.fields.numero_registro_da.name"
                            v-model="numero_registro_da"
                            type="text"
                            name="nombre" 
                            placeholder="Ingresa el número de referencia">
                        
                        <strong v-if="data.fields.numero_registro_da.textAlert" 
                            style="color:red; display:block">Este campo es requerido
                        </strong>

                    </template>

                    <br><br>
                     <!-- </template> -->

                    <h5>
                        <strong class="step-title">¿Se sugiere tomar medidas razonables para la protección de los secretos empresariales?
                            <span style="color:red">*
                                    <span class="glyphicon glyphicon-question-sign" 
                                      v-tooltip.right="{
                                        content: constanstProteccion.tooltips[data.fields.cuales_medidas.name],
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
                    
                    <select v-model="medidas_proteccion" :ref="data.fields.medidas_proteccion.name" >
                        <option selected disabled value=''>Selecciona una opción</option>
                        <option v-for="(value, key) in data.fields.medidas_proteccion.values" :value="key">
                                {{value}}
                        </option>
                    </select>

                    <template v-if="medidas_proteccion == 'si'">
                        <br><br>

                        <h5>
                        <strong class="step-title">¿Cuáles medidas?
                            <span style="color:red">*
                                <span class="glyphicon glyphicon-question-sign" 
                                      v-tooltip.right="{
                                        content: constanstProteccion.tooltips[data.fields.cuales_medidas.name],
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
                                v-model="cuales_medidas"
                                :ref="data.fields.cuales_medidas.name" 
                                placeholder="Ingresa las medidas de protección sugeridas"
                                rows="9"
                                cols="80">
                        </textarea>

                        <strong v-if="data.fields.cuales_medidas.textAlert" 
                            style="color:red; display:block">Las medidas de protección son requeridas
                        </strong>

                    </template>

                                      

                    <br>
                    
                    <br>
                    <h5>
                        <strong class="step-title">¿Se sugiere registro o depósito de algun derecho de propiedad industrial?
                            <span style="color:red">*
                                <span class="glyphicon glyphicon-question-sign" 
                                    v-tooltip.right="{
                                        content: constanstProteccion.tooltips[data.fields.propiedad_industria_deposito.name],
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

                    <select v-model="propiedad_industrial" :ref="data.fields.propiedad_industrial.name" >
                        <option selected disabled value=''>Selecciona una opción</option>
                        <option v-for="(value, key) in data.fields.propiedad_industrial.values" :value="key">
                                {{value}}
                        </option>
                    </select>
                    <br><br>

                    <template v-if="propiedad_industrial == 'si'">
                        <h5>
                            <strong class="step-title">¿Para cuáles?
                                <span style="color:red">*
                                    <span class="glyphicon glyphicon-question-sign" 
                                        v-tooltip.right="{
                                            content: constanstProteccion.tooltips[data.fields.propiedad_industria_deposito.name],
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
                            v-model="multiSelect.propiedad_industria_deposito"
                            :options="filterSE(data.fields.propiedad_industria_deposito.values)"
                            :multiple="true"
                            :select-label="'Presiona enter para seleccionar'"
                            :close-on-select="false" 
                            :clear-on-select="false" 
                            :hide-selected="true" 
                            :preserve-search="true" 
                            placeholder="Seleccciona los DPI"
                            label="nombre"
                            track-by="nombre">
                        </multiselect>

                        <strong v-if="data.fields.propiedad_industria_deposito.textAlert" 
                            style="color:red; display:block">Al menos debe de elegir un DPI
                        </strong>
                        
                        <br>
                        
                    </template>
                    <h5>
                        <strong class="step-title">¿Para cuáles derechos de propiedad industrial ya existe registro?
                            <span style="color:red">
                                <span class="glyphicon glyphicon-question-sign" 
                                      v-tooltip.right="{
                                        content: constanstProteccion.tooltips[data.fields.propiedad_industria_registro.name],
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
                        v-model="multiSelect.propiedad_industria_registro"
                        :options="filterSE(data.fields.propiedad_industria_registro.values)"
                        :multiple="true"
                        :select-label="'Presiona enter para seleccionar'"
                        :close-on-select="false" 
                        :clear-on-select="false" 
                        :hide-selected="true" 
                        :preserve-search="true" 
                        placeholder="Seleccciona los DPI"
                        label="nombre"
                        track-by="nombre">
                    </multiselect>
                    <br>
                    <template v-if="multiSelect.propiedad_industria_registro.length > 0">
                        <div v-for="dpi in multiSelect.propiedad_industria_registro">
                            <h5>
                            <strong class="step-title">Indique el número de referencia para {{dpi.nombre.toLowerCase()}}
                                <span style="color:red">*
                    
                                    </span>     
                                </span>
                            </strong>
                        </h5>

                        <input v-if="dpi.pivot"
                            :ref="data.fields.propiedad_industria_registro.name + '/' + dpi.id"
                            v-model="dpi.pivot.numero_registro"
                            type="text" 
                            name="nombre" 
                            placeholder="Ingresa el numero de referencia"
                        >

                        <input v-else
                            :ref="data.fields.propiedad_industria_registro.name + '/' + dpi.id"
                            type="text" 
                            name="nombre" 
                            placeholder="Ingresa el número de referencia"
                        >
                        
                        <br>
                        </div>
                    
                    </template>

                    <br>
                    <h5>
                    <strong class="step-title">¿Se sugiere suscribir contrato para la protección del AI como licencia o cesión?
                        <span style="color:red">*
                            <span class="glyphicon glyphicon-question-sign" 
                                    v-tooltip.right="{
                                    content: constanstProteccion.tooltips[data.fields.contratos.name],
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

                    <select v-model="contratos" :ref="data.fields.contratos.name" >
                        <option selected disabled value=''>Selecciona una opción</option>
                        <option v-for="(value, key) in data.fields.contratos.values" :value="key">
                                {{value}}
                        </option>
                    </select>

                    <template v-if="contratos == 'si'">
                        <br><br>
                        <h5>
                            <strong class="step-title">¿Qué contrato se sugiere?
                                <span style="color:red">*  
                                </span>
                            </strong>
                        </h5>

                        <!-- :value="data.fields.cuales_contratos.data" -->

                        <textarea   
                                name ='uso'
                                v-model="cuales_contratos"
                                :ref="data.fields.cuales_contratos.name" 
                                placeholder="Ingresa el tipo de contrato"
                                rows="9"
                                cols="80">
                        </textarea>

                        <strong v-if="data.fields.cuales_contratos.textAlert" 
                            style="color:red; display:block">{{constants.fieldRequired('tipo de contrato sugerido', 'm')}}
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
import Multiselect from 'vue-multiselect';
import store from "../../store";

export default {
    store,
    mixins: [mixinStep],
    components: {Multiselect},
    data() {
        return {
            step: '7',
            constanstProteccion: constants.proteccion,
            constants: constants.stateMessages,
            deposito_da:'',
            registro_da:'',
            propiedad_industrial:'',
            medidas_proteccion:'',
            propiedad_industria: '',
            contratos: '',
            numero_registro_da:'',
            cuales_medidas: '',
            showInfo: false,
            dpis_asociados: [],
        }
    },
    
    mounted() {

        if (this.data) {
            this.cuales_contratos = this.data.fields.cuales_contratos.data ||'';
            this.numero_registro_da = this.data.fields.numero_registro_da.data ||'';
            this.cuales_medidas = this.data.fields.cuales_medidas.data ||'';
            this.contratos = this.data.fields.contratos.data || '';
            this.propiedad_industrial = this.data.fields.propiedad_industrial.data || '';
            this.medidas_proteccion = this.data.fields.medidas_proteccion.data || '';
            this.deposito_da = this.data.fields.deposito_da.data || '';
            this.registro_da = this.data.fields.registro_da.data || '';   
        }
    },

    watch: {
        data: function() {
            this.cuales_contratos = this.data.fields.cuales_contratos.data ||'';
            this.cuales_medidas = this.data.fields.cuales_medidas.data ||'';
            this.numero_registro_da = this.data.fields.numero_registro_da.data ||'';
            this.contratos = this.data.fields.contratos.data || '';
            this.propiedad_industrial = this.data.fields.propiedad_industrial.data || '';
            this.medidas_proteccion = this.data.fields.medidas_proteccion.data || '';
            this.deposito_da = this.data.fields.deposito_da.data || '';
            this.registro_da = this.data.fields.registro_da.data || '';
        },

        dataReady: function(a, b) {
            console.log(a);
        }
    },

    methods: {

        filterSE: function(list) {
            return _.filter(list, item => {return item.nombre != 'Secreto empresarial'})
        },

        getInfo: function(){
            this.showInfo = !this.showInfo
        }
    }
}
</script>
