<template lang='html'>
    <div v-if="dataReady">
        <div class='step-container'>
            <div>
                <div>
                    <div>
                        <h4>
                            <strong class="step-title">Comentarios sobre el AI</strong>          
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
                    <!-- <div v-if="values.comentarios.length > 0" class="comentarios">
                        <h5><strong class="step-title">Comentarios asociados</strong> </h5>
                            <ul>
                                <li v-for="(comentario, index) in values.comentarios">
                                    <span>{{comentario.comentario}}</span>
                                    <br>
                                    <span @click="deleteComment(comentario.id)" class="fa fa-trash" style="cursor: pointer; color: red; padding-bottom: 8px; width: 20px; padding-left: 0px"></span>
                                </li>
                            </ul>
                    </div> -->

                    <h5>
                        <strong class="step-title">Agregar comentario

                            <span style="color:red">
                                
                                <span class="glyphicon glyphicon-question-sign" 
                                        v-tooltip.right="{
                                        content: constantsComentarios.tooltips[data.fields.comentarios.name],
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

                    <textarea   name ='descripcion'
                                v-model="data.fields.comentarios.data[0].comentario"
                                :ref="data.fields.comentarios.name" 
                                placeholder="Ingresa tus comentarios"
                                rows="9"
                                cols="80">
                    </textarea>
                     <!-- <button type="button" style="margin-right: 15px;" class="btn btn-comment">Agregar comentario</button> -->
                    
                    <!-- <strong v-if="data.fields.comentarios.textAlert" 
                            style="color:red; display:block">{{constants.fieldRequired(data.fields.comentarios.name, 'm')}}
                    </strong> -->

                    <br><br>
                    <div style="float: right">
                        <button type="button" style="margin-right: 15px;" @click="$emit('cerrar')" class="btn btn-cancelar">Cancelar</button>
                        <button type="button" @click="onSubmit" class="btn btn-guardar">Guardar</button>
                    </div>
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

export default {
  mixins: [mixinStep],
  data() {
    return {
      step: "6",
      constantsComentarios: constants.comentarios,
      constants: constants.stateMessages,
      comentario: ""
    };
  },

  methods: {
    deleteComment: function(index) {
      swal({
        title: "Estas seguro de que deseas eliminar este comentario?",
        text: "No podras deshacer esta accion!",
        type: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Si, borrar!",
        cancelButtonText: "Cancelar"
      }).then(response => {

        if (response.value) {
            let commentToDelete = _.find(this.values.comentarios, (comentario, i) => comentario.id == index);
            this.values.comentarios = _.filter(this.values.comentarios, (comentario, i) => comentario.id != index);
            axios.delete(`/comentario/${commentToDelete.id}`).then( response => {

            })
        }

      });
    },

    addComment: function() {
        this.values.comentarios.push({comentario: this.comentario, agregado: false});
        this.comentario = "";
        this.onSubmit();
    },

    /*
    initValues: function(data) {
        let comments = [];
        for (let key in data.fields.comentarios.data) {
            let comentario = data.fields.comentarios.data[key];
            comments.push({comentario: comentario.comentario, agregado: true, id: comentario.id});
        }

        return { comentarios: comments }
    }
    */

  }
};
</script>

