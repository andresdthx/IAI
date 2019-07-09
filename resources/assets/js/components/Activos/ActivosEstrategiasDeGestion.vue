<template lang="html">
    <div v-if="dataReady">
        <div class='step-container'>
            <div>
                <div>
                    <div>
                        <h4>
                            <strong>Estrategias generales para la gestión del AI</strong>      
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
                    <div v-if="values.estrategias.length > 0" class="comentarios">
                        <h5><strong>Estrategias</strong> </h5>
                            <ul>
                                <li v-for="(estrategia, index) in values.estrategias">
                                    <span>{{estrategia.estrategia}}</span>
                                    <br>
                                    <span @click="deleteEstrategia(estrategia.id)">Eliminar</span>
                                </li>
                            </ul>
                    </div>

                    <h5>
                        <strong>Estrategia de gestión
                            <span style="color:red">
                                <span class="glyphicon glyphicon-question-sign" 
                                        v-tooltip.right="{
                                        content: constantsEstrategiasGestion.tooltips[data.fields.estrategias.name],
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

                    <textarea   name ='estrategia'
                                v-model="estrategia"
                                placeholder="Ingresa una estrategia de gestión"
                                rows="7"
                                cols="90">
                    </textarea>
                    
                    <strong v-if="data.fields.estrategias.textAlert" 
                            style="color:red; display:block">{{constants.fieldRequired(data.fields.estrategias.name, 'm')}}
                    </strong>

                    <br><br>
                    <button type="button" @click="addEstrategia"  class="btn btn-success">Agregar estrategia</button>
                    <br><br>

                </form>
            </div>
        </div>
    </div>

</template>

<style>
.comentarios {
}

.comentarios li {
  margin-right: 200px;
  text-align: justify;
  margin-bottom: 10px;
}

.comentarios li span:last-child {
  color: red;
  font-weight: bold;
  cursor: pointer;
  padding-top: 5px;
}
</style>

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
            step: '10',
            constantsEstrategiasGestion: constants.estrategiasGestion,
            constants: constants.stateMessages,
            estrategia: ''
        }
    },

    methods: {
        deleteEstrategia: function(index) {
            swal({
                title: "Estas seguro de que deseas eliminar esta estrategia?",
                text: "No podras deshacer esta accion!",
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Si, borrar!",
                cancelButtonText: "Cancelar"
            }).then(response => {

                if (response.value) {
                    let commentToDelete = _.find(this.values.estrategias, (estrategia, i) => estrategia.id == index);
                    axios.delete(`/estrategia/${commentToDelete.id}`).then( response => {
                        this.values.estrategias = _.filter(this.values.estrategias, (estrategia, i) => estrategia.id != index);
                    })
                }

            });
        },

        addEstrategia: function() {
            this.values.estrategias.push({estrategia: this.estrategia, agregado: false});
            this.estrategia = "";
            this.onSubmit();
        },

        initValues: function(data) {
        let estrategias = [];
        for (let key in data.fields.estrategias.data) {
            let estrategia = data.fields.estrategias.data[key];
            estrategias.push({estrategia: estrategia.estrategia, agregado: true, id: estrategia.id});
        }

        return { estrategias: estrategias }
    }
    },
    
    created() {
        if (this.data) {

        }
    },

    watch: {
        data: function(data) {

        }
    }
}
</script>

