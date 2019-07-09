<template lang="html">

    <div v-if="dataReady">
        <div class='step-container'>
            <div>
                <div>
                    <div>
                        <h4>
                            <strong class="step-title">Herramientas para la priorización y decisión del AI</strong>
                            <span class="glyphicon glyphicon-question-sign" 
                                      v-tooltip.right="{
                                        content: 'Herramientas evaluación de registrabilidad y/o priorización para tomar decisiones sobre la protección, gestión, uso, comercialización, transferencia, monetización o defensa del DPI asociado al AI',
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
                    </div> 
                        <strong>Estado: </strong><span>{{constants.state(data.finished)}}</span>
                        <br>
                        <span v-if="data.finished">{{constants.stepFinished}} </span>
                </div>
            </div>
            <hr>


            <div @click="changeInfo" class="get-info"><span><span class="glyphicon glyphicon-book"></span> <strong>Obtener información sobre las herramientas de priorización</strong></span></div>
            <ul v-if="openInfo" style="text-align: justify;">
                <li v-for="herramienta in herramientas.values.herramientas"><strong>{{herramienta.nombre}}: </strong>{{herramienta.descripcion}}</li>
                <li><strong>Otro: </strong>Indique cualquier otro estudio o herramienta que le permita tomar decisiones de priorización en relación al activo intangible.</li>
            </ul>
            
            
            <div>
                <form name="form">
                    <h5>
                        <strong class="step-title">¿Se debe realizar una búsqueda relacionada con los potenciales DPI asociados al AI?
                            <span style="color:red">*
                                <span class="glyphicon glyphicon-question-sign" 
                                      v-tooltip.right="{
                                        content: constantsPriorizacion.tooltips[data.fields.busqueda.name],
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


                    <select v-model="busqueda" :ref="data.fields.busqueda.name" >
                        <option selected disabled value=''>Selecciona una opción</option>
                        <option v-for="(value, key) in data.fields.busqueda.values" :value="key">
                                {{value}}
                        </option>
                    </select>




                    <template v-if="busqueda == 'si'">
     

                            <!-- <h5>
                                <strong>Para cuales DPI?
                                    <span style="color:red">*
                                        <span class="glyphicon glyphicon-question-sign" 
                                            v-tooltip.right="{
                                                content: constantsPriorizacion.tooltips[data.fields.busqueda.name],
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
                            v-model="multiSelect.herramientas"
                            :options="data.fields.herramientas.values.dpis"
                            :multiple="true"
                            :close-on-select="false" 
                            :clear-on-select="true" 
                            :hide-selected="true" 
                            :preserve-search="true" 
                            placeholder="seleccciona los DPI"
                            label="nombre"
                            track-by="nombre">
                        </multiselect>
                        
                        <strong v-if="data.fields.herramientas.textAlert" 
                                style="color:red; display:block">{{constants.fieldRequired(data.fields.herramientas.name, 'f')}}
                        </strong> -->

                        <template>
                                
                            <div v-for="dpi in herramientas.values.dpis">
                                <br><br>

                                <h5>
                                    <strong class="step-title">Selecciona las herramientas de priorización para {{dpi.nombre.toLowerCase()}}
                    
                                    </strong>
                                </h5>

                                <multiselect
                                    v-model="dpi.herramientas"
                                    :options="herramientas.values.herramientas"
                                    :select-label="'Presiona enter para seleccionar'"
                                    :multiple="true"
                                    :close-on-select="false" 
                                    :clear-on-select="true" 
                                    :hide-selected="true" 
                                    :preserve-search="true" 
                                    placeholder="Seleccciona las herramientas"
                                    label="nombre"
                                    track-by="nombre">
                                </multiselect>

                                <h5 v-if="dpi.herramientas_nuevas.length > 0">
                                    <strong class="step-title">Otras herramientas</strong
                                ></h5>

                                <ul>
                                    <li v-for="herramienta in dpi.herramientas_nuevas">
                                        {{ herramienta.nombre }} <span @click="deleteHerramienta(herramienta.nombre, herramienta.id,activo_id, dpi.id)" class="fa fa-trash" style="display: inline;cursor: pointer; color: red; padding-bottom: 8px; width: 20px; padding-left: 0px;"></span>
                                    </li>
                                </ul>

                                
                                <input type="text" :ref="`new_tool_${dpi.id}`" style="display:inline; width:15%">
                                <span @click="addTool(dpi.id)" style="margin-left: 15px;cursor:pointer; color: #3097D1">Agregar otra herramienta</span>
                                
                            </div>

                        </template>
                        
                    </template>
                    <br><br>
                    <h5>
                        <strong class="step-title">¿Existe presupuesto para la protección de los DPI?
                            <span style="color:red">*
                                <span class="glyphicon glyphicon-question-sign" 
                                      v-tooltip.right="{
                                        content: constantsPriorizacion.tooltips[data.fields.presupuesto_priorizacion.name],
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

                    <select v-model="presupuesto_priorizacion" :ref="data.fields.presupuesto_priorizacion.name" >
                        <option selected disabled value=''>Selecciona una opción</option>
                        <option v-for="(value, key) in data.fields.presupuesto_priorizacion.values" :value="key">
                                {{value}}
                        </option>
                    </select>

                    <template v-if="presupuesto_priorizacion == 'si'">
                        <br><br>
                         <h5>
                        <strong class="step-title">¿Cuánto?
                            <span style="color:red">*    
                            </span>
                        </strong>
                    </h5>

                    <input 
                        :ref="data.fields.cantidad_presupuesto.name"
                        v-model="cantidad_presupuesto"
                        type="number" 
                        class="input-text-step" 
                        name="nombre" 
                        placeholder="Ingresa la cantidad de presupuesto">
                    </template>

                    <strong v-if="data.fields.cantidad_presupuesto.textAlert" 
                            style="color:red; display:block">La cantidad de presupuesto es requerido
                    </strong>


                    <br><br><br>
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

    .newTool{
        display: inline;
        width: 10%;
    }

</style>
<script>
import VTooltip from "v-tooltip";
import { CONSTANTS as constants } from "../../constants";
import mixinStep from "./ActivosMixin";
import swal from "sweetalert2";
import Multiselect from "vue-multiselect";
import store from "../../store";

export default {
  store,
  mixins: [mixinStep],
  components: { Multiselect },
  data() {
    return {
      openInfo: false,
      step: "8",
      showInfo: false,
      constantsPriorizacion: constants.priorizacion,
      constants: constants.stateMessages,
      herramientas:"",
      busqueda: "",
      presupuesto_priorizacion: '',
      cantidad_presupuesto: ''
    };
  },

  methods: {

      changeInfo: function() {
          this.openInfo = !this.openInfo;
      },

      // si se borra una en el backend se borran las nuevas del frontend
      deleteHerramienta(name, herramienta_id, activo_id, dpi_id) {

          swal({
                title: "Estas seguro que deseas eliminar este archivo?",
                text: "No podras deshacer esta accion",
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Si, borrar!",
                cancelButtonText: "Cancelar"
            }).then(result => {
                if (result.value) {
                    if (herramienta_id == undefined ) {
                let dpi = _.find(this.herramientas.values.dpis, dpi => dpi.id == dpi_id);
                dpi.herramientas_nuevas =  _.filter(dpi.herramientas_nuevas, herr => {
                    return  herr.nombre != name;
                })} else {
             
                    axios.delete(`/activos/delete/${herramienta_id}/${activo_id}/${dpi_id}`).then( response => {
                        let data = response.data;
                        console.log(data);
                        store.commit("setActivo", data);
                    }).catch( e => {
                        console.log(e);
                    })
                }
            }
        }).catch( e => {
            console.log(e);
        })

      },

      addTool(dpi_id) {
          let newVal = this.$refs[`new_tool_${dpi_id}`][0].value;
          if (newVal != '') {
            let dpi = _.find(this.herramientas.values.dpis, dpi => dpi.id == dpi_id);
            dpi.herramientas_nuevas.push( {nombre: newVal} )
            this.$refs[`new_tool_${dpi_id}`][0].value = '';
          }
      },

      onInput: function(val) {
        console.log(val);
      },

      getInfo: function() {
        (this.showInfo = !this.showInfo);
      }

  },

  created() {
    if (this.data) {
        this.busqueda = this.data.fields.busqueda.data || '';
        this.herramientas = this.data.fields.herramientas || '';
        this.cantidad_presupuesto = this.data.fields.cantidad_presupuesto.data || '';
        this.presupuesto_priorizacion = this.data.fields.presupuesto_priorizacion.data || '';
    }
  },

  watch: {
    data: function(data) {
        this.busqueda = this.data.fields.busqueda.data || '';    
        this.herramientas = this.data.fields.herramientas || '';
        this.cantidad_presupuesto = this.data.fields.cantidad_presupuesto.data || '';
        this.presupuesto_priorizacion = this.data.fields.presupuesto_priorizacion.data || '';
    }
  }
};
</script>
