<template lang="html">
    <div>
        <div class="container-create ">
            <h2>Resgitrarse</h2>
        </div>

        <div class="card-create-container ">
            <!-- v-on:submit.prevent="onSubmit -->
            <form>

                <div v-bind:class="{'form-group': true, 'has-error': errores.hasOwnProperty('codigo') }">
                    <h4 class="step-title">Ingresa el codigo de registro*</h4>
                    <input type="string" class="form-control" v-model="codigo" name="codigo" placeholder="ingresa el de registro envidado al correo" required>

                    <span v-if="errores.hasOwnProperty('codigo')" class="help-block">
                        <strong v-for="err in errores.codigo" class="col-md-12" >{{err}}</strong>
                    </span>
                </div>
    
                <button type="submit" class="btn btn-success">Continuar</button>
            </form>

        </div>
    </div>
</template>

<script>
import axios from 'axios';
import swal from 'sweetalert2';

export default {
    props: ['token'],
    data(){
        return {
            codigo: '',
            errores: '',
        }
    },

    methods: {
        onSubmit: function() {
            axios.get(`/users/validateCode/${this.token}/${this.codigo}`).then(response => {
                if(response.data.valid) {
                    swal({
                        type: 'success',
                        title: 'Codigo correcto',
                        showConfirmButton: false,
                        timer: 900
                    })
                } else {
                    swal({
                        type: 'error',
                        title: 'El codigo es incorrecto'
                    })
                }

            }).catch( e => {
                console.log(e);
            });
        }
    }
}
</script>
