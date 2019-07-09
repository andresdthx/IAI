<template>
    <div>
        <div class="header-index">
            <span class="header-table">Reasignar grupos de investigación de {{usuario.name}}</span>
            <br>
            <span class="header-table" style="font-weight: bold; font-size: 20px; font-family: 'Open Sans'">Grupos por asignar: <strong>{{selectProyects.length}}</strong> </span>

        </div>

         <div class="card-create-container" style="float: left; width: 100% ">

            <form v-on:submit.prevent="onSubmit">

                <div class="form-group">
                  <h4 class="step-title">Seleccionar usuarios para reasignar grupos</h4>
                </div>

                <multiselect
                    v-model="selectUsuarios"
                    :options="users"
                    @remove="onRemoveUser"
                    :select-label="'Presiona enter para seleccionar'"
                    :multiple="true"
                    :close-on-select="false" 
                    :clear-on-select="true" 
                    :hide-selected="true" 
                    :preserve-search="true" 
                    placeholder="seleccciona los usuarios"
                    label="name"
                    track-by="id">
                </multiselect>

                <template v-for="selectUsuario in selectUsuarios">

                    <div class="reasignar">
                        <h4 class="step-title">grupos a asignar para {{selectUsuario.name}}</h4>
                    </div>

                    <multiselect
                        v-model="selectUsuario.newProyects"
                        :options="selectProyects"
                        :select-label="'Presiona enter para seleccionar'"
                        :multiple="true"
                        :close-on-select="false" 
                        :clear-on-select="true" 
                        :hide-selected="true" 
                        :preserve-search="true" 
                        placeholder="seleccciona los proyectos"
                        label="nombre"
                        track-by="id"
                        @select="onSelectProyect"
                        @remove="onRemoveProyect"
                        >
                    </multiselect>
  
                </template>

                <br>


                <div style="float: right; margin-top:30px">
                    <button type="button" style="margin-right: 15px;" @click="onClose" class="btn btn-cancelar">Cancelar</button>
                    <button class="btn btn-guardar">Asignar proyectos y eliminar usuario</button>
                </div>


            </form>

        </div>

    </div>
</template>

<style lang="scss">
.card-create-container {
  max-width: 1000px;
}

.reasignar {
  margin-top: 20px;
}
</style>


<script>
import Multiselect from "vue-multiselect";
import swal from "sweetalert2";
import axios from "axios";

export default {
  props: ["proyectos", "usuarios", "usuario"],
  components: { Multiselect },
  data() {
    return {
      selectUsuarios: "",
      selectProyects: this.proyectos,
      users: this.usuarios
    };
  },

  methods: {
    onClose: function() {
      window.history.back()
    },
    onSubmit: function() {
      if (this.selectProyects.length > 0) {
        swal(
          `Faltan ${this.selectProyects.length} ${
            this.selectProyects.length > 1 ? "proyectos" : "proyecto"
          } por reasignar`
        );
      } else {
        swal({
          title: `Estas a punto de eliminar el usuario ${this.usuario.name}`,
          text: "No podras revertir esta acción!",
          type: "warning",
          showCancelButton: true,
          confirmButtonColor: "#3085d6",
          cancelButtonColor: "#d33",
          confirmButtonText: "Continuar!",
          cancelButtonText: "Cancelar"
        })
          .then(response => {
            if (response.value) {
              axios
                .post(`/users/reasignProyectAndDestroy/${this.usuario.id}`, {
                  selectUsers: _.filter(this.users, user => user.newProyects)
                })
                .then(response => {
                  swal({
                    type: "success",
                    title: "Usuario eliminado",
                    showConfirmButton: false,
                    timer: 1000
                  }).then(response => {
                    window.location.href = "/users";
                  });
                })
                .catch(e => {
                  console.log(e);
                });
            }
          })
          .catch(e => {
            console.log(e);
          });
      }
    },

    onRemoveUser: function(val) {
      this.selectProyects = this.selectProyects.concat(val.newProyects);
      this.users = _.map(this.users, user => {
        if (val.id == user.id) {
          user.newProyects = "";
          return user;
        } else {
          return user;
        }
      });
    },

    onSelectProyect: function(val) {
      this.selectProyects = _.filter(
        this.selectProyects,
        proyect => proyect.id != val.id
      );
    },

    onRemoveProyect: function(val) {
      this.selectProyects.push(val);
    }
  }
};
</script>
