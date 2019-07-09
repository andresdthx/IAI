<template lang="html">
    <div>

        <div class="header-index">
            <span class="header-table">Cambiar contraseña</span>
        </div>

        <div class="card-create-container" style="max-width: 1000px; float: left; width: 100%; margin-top: 0px ">
            <form v-on:submit.prevent="onSubmit(user.id)">
                
                <div v-bind:class="{'form-group': true, 'has-error': errores.hasOwnProperty('current_password') }">
                    <h4 class="step-title">Contraseña actual</h4>
                    <input type="password" class="input-style" v-model="current_password" name="current_password" placeholder="ingresa tu contraseña actual" required>
                    
                    <span v-if="errores.hasOwnProperty('current_password')" class="help-block">
                        <strong v-for="err in errores.current_password" class="col-md-12" >{{err}}</strong>
                    </span>
                </div>
                
                <div v-bind:class="{'form-group': true, 'has-error': errores.hasOwnProperty('new_password') }">
                     <h4 class="step-title">Nueva contraseña</h4>
                    <input type="password" class="input-style" v-model="new_password" name="new_password" placeholder="ingresa tu nueva contraseña" required>
                    
                    <span v-if="errores.hasOwnProperty('new_password')" class="help-block">
                        <strong v-for="err in errores.new_password" class="col-md-12" >{{err}}</strong>
                    </span>
                </div>
                
                <div v-bind:class="{'form-group': true, 'has-error': errores.hasOwnProperty('new_password_confirmation') }">
                    <h4 class="step-title">Confirmar nueva contraseña</h4>
                    <input type="password" class="input-style" v-model="new_password_confirmation" name="new_password_confirmation" placeholder="confirma tu nueva contraseña" required>
                    
                    <span v-if="errores.hasOwnProperty('new_password_confirmation')" class="help-block">
                        <strong v-for="err in errores.new_password_confirmation" class="col-md-12" >{{err}}</strong>
                    </span>
                </div>



                 <div style="float: right; margin-top:30px">
                    <button type="button" style="margin-right: 15px;" @click="onCancel" class="btn btn-cancelar">Cancelar</button>
                    <button type="submit" class="btn btn-edit">Actualizar</button>
                </div>



            </form>
        </div>
    </div>
</template>

<script>

import axios from 'axios';
import swal from 'sweetalert2';

export default {
    props: ['user'],
    data() {
        return {
            current_password: '',
            new_password: '',
            new_password_confirmation: '',
            errores: ''
        }
    },
    methods: {
        onSubmit: function(id) {
            console.log(id);
            axios.put(`/user/perfil/${id}/password`, {current_password: this.current_password, new_password: this.new_password, new_password_confirmation: this.new_password_confirmation}).then( response => {
                swal({
                    type: 'success',
                    title: 'Contraseña actualizada',
                    showConfirmButton: false,
                    timer: 1000
                }).then( e => {
                   window.location.href= '/user/perfil'
                }).catch( e => {
                    console.log(e.response)
                })
            }).catch( e => {
                this.errores = e.response.data.errors;
                console.log(this.errores.current_password);
            })
        },

        onCancel: () => window.history.back()
    }
}
</script>
