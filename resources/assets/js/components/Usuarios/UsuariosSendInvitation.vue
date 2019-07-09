<template lang='html'>
       <transition id="modal" name="modal">
            <div class="modal-mask">
            <div class="modal-wrapper">
                <div class="modal-container">
                    <span class="glyphicon glyphicon-remove close-modal" @click="$emit('close')" ></span>

                      <form v-on:submit.prevent="onSubmit">

                            <h4 class="step-title">Correo electrónico*</h4>
                            <input class="input-style" type="email" v-model="email" name="email" placeholder="ingresa el correo electrónico" required>

                            <span v-if="errores.hasOwnProperty('email')" class="help-block" style="color: red; margin-bottom: 40px;">
                                <strong v-for="err in errores.email" class="col-md-12" >{{err}}</strong>
                            </span>
              
                            <h4 class="step-title">Confirmar correo electrónico*</h4>
                            <input class="input-style" type="email" v-model="emailConfirm" name="emailConfirm" placeholder="Confirma el correo electrónico" required>
   

                            <h4 class="step-title">Rol*</h4>
                            <select class="select-style " name="rol" v-model="rol" required>
                                <option disabled value="">Selecciona el rol del usuario</option>
                                <option v-for="rol in roles" 
                                    :value="rol.id">{{rol.name}}</option>
                            </select>

                            <span v-if="errores.hasOwnProperty('rol')" class="help-block" style="color: red; margin-bottom: 40px;">
                                <strong v-for="err in errores.rol" class="col-md-12" >{{err}}</strong>
                            </span>

                        <div style="float: right; margin-top:30px">
                            <button type="button" style="margin-right: 15px;" @click="$emit('close')" class="btn btn-cancelar">Cancelar</button>
                            <button class="btn btn-guardar">Enviar invitación</button>
                        </div>


                    </form>

                 </div>
            </div>
            </div>
        </transition>
</template>


<style>
.area-style {
    height: 230px;
    width: 100%;
    border-radius: 10px;
    padding-left: 8px;
    border: solid #88A6B0;
}

.area-style::placeholder {
    font-family: 'Open Sans';
    color: #88A6B0;;
}

.area-style:focus {
    outline: none;
}

.input-style {
    width: 100%;
    border-radius: 10px;
    background-color: #fff;
    padding-left: 8px;
    border: solid #88A6B0;
}

.select-style {
    font-family:'Open Sans';
    width: 100%;
    border-radius: 10px;
    padding-left: 8px;
    border: solid #88A6B0;
    background-color: white; ;

}

.select-style:focus {
    outline: none;
}


.input-style:focus {
    outline: none;
}

.input-style::placeholder {
    font-family: 'Open Sans';
    color: #88A6B0;;
}

</style>


<script>
import swal from "sweetalert2";
export default {
  props: ["roles"],
  data() {
    return {
      email: "",
      emailConfirm: "",
      rol: "",
      errores: {}
    };
  },

  mounted() {
    window.addEventListener('click', this.handleClick)
  },

  beforeDestroy: function () {
    window.removeEventListener('click', this.handleClick)
  },

  methods: {
    handleClick(event) {
      if (event.target.className == 'modal-wrapper') {
          this.$emit('close')
      }
    },

    onSubmit: function() {
      let data = "";
      swal({
        title: "Estas seguro de enviar esta invitación?",
        showCancelButton: true,
        confirmButtonText: "Enviar",
        cancelButtonText: "Cancelar",
        showLoaderOnConfirm: true,
        preConfirm: email => {
          return axios
            .post("/users/invitation", {
              email: this.email,
              email_confirmation: this.emailConfirm,
              contraseña: this.password,
              rol: this.rol
            })
            .then(response => {
              data = {type:'success', data: response};
            })
            .catch(e => {
              this.errores = {};
              data = {type:'error', data: e.response.data.errors};
              this.errores = e.response.data.errors;
            });
        },
        allowOutsideClick: () => !swal.isLoading()
      }).then(result => {
        if (result.value) {
          if (data.type == 'success'){
            this.errores='';
            swal({
                type: "success",
                title: "invitación enviada"
            }).then( response => {
                this.$emit('close');
            });
          }
        }
      });
    }
  }
};
</script>
