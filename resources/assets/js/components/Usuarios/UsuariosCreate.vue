<template lang="html">
    <div>


        <div class="card-create-container" style="height: 400px;">

            <form v-on:submit.prevent="onSubmit">

                <div v-bind:class="{'form-group': true, 'has-error': errores.hasOwnProperty('nombre') }">

                    <h4 class="step-title">Nombre*</h4>
                    <input type="text" class="input-style" v-model="nombre"  name="nombre" placeholder="Ingresa tu nombre de usuario" required>
                    
                    <span v-if="errores.hasOwnProperty('nombre')" class="help-block">
                        <strong v-for="err in errores.nombre" class="col-md-12" >{{err}}</strong>
                    </span>
                </div>
                
                <div v-bind:class="{'form-group': true, 'has-error': errores.hasOwnProperty('contraseña') }">
                    <h4 class="step-title">Contraseña*</h4>
                    <input type="password" class="input-style"v-model="password" name="password" placeholder="Ingresa tu contraseña" required>
                
                    <span v-if="errores.hasOwnProperty('contraseña')" class="help-block">
                        <strong v-for="err in errores.contraseña"  class="col-md-12" >{{err}}</strong>
                    </span>
                </div>

                <div class="form-group">
                    <h4 class="step-title">Confirmar contraseña*</h4>
                    <input type="password" class="input-style" v-model="passwordConfirm" name="passwordConfirm" placeholder="Ingresa tu contraseña nuevamente" required>
                </div>

                <br>
                <!-- <button type="submit" class="btn btn-success">Registrarme</button>

                <a href="/users"> <button type="button"class="btn btn-danger">Cancelar</button></a> TODO -->

                <div style="float: right; margin-top:30px">
                    <button type="submit" class="btn btn-guardar">Registrarme</button>
                </div>
            </form>

        </div>
    </div>
</template>

<script>
    import axios from 'axios';
    import swal from 'sweetalert2';

    export default {
        props: ['roles', 'token', 'errors'],
        data() {
            return {
                rol: '',
                errores: '',
                nombre: '',
                password: '',
                passwordConfirm: ''
            }
        },

        mounted() {
            this.errores = JSON.parse(this.errors);
        },

        methods: {

            onSubmit: function() {
                axios.post(`/users/${this.token}`, {'nombre': this.nombre,
                                     'contraseña': this.password,
                                     'contraseña_confirmation': this.passwordConfirm})
                .then( reponse => {
                    swal({
                        type: 'success',
                        title: 'Resgistro exitoso',
                        showConfirmButton: false,
                        timer: 800
                    }).then( reponse => {
                        window.location.href = '/';
                    })
                }).catch( e => {
                    this.errores = e.response.data.errors;
                });
            }
        }
    }
</script>

