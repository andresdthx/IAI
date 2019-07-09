<template lang="html">
    <div>
            <div class="header-index">
                <span class="header-table">Editar perfil</span>
            </div>

           
            <div class="card-create-container" style="max-width: 1000px; float: left; width: 100%; margin-top: 0px ">
                 <p><a :href="`/user/perfil/${user.id}/password`">Cambiar contraseña</a></p>
                <form v-on:submit.prevent="onSubmit(user.id)">
                    
                    <div v-bind:class="{'form-group': true, 'has-error': errores.hasOwnProperty('nombre') }">
                        <h4 class="step-title">Nombre</h4>
                        <input type="text" class="input-style" v-model="nombre" name="nombre" placeholder="ingresa tu nombre" required>
                        
                        <span v-if="errores.hasOwnProperty('nombre')" class="help-block">
                            <strong v-for="err in errores.nombre" class="col-md-12" >{{err}}</strong>
                        </span>
                    </div>

                    <div style="float: right; margin-top:30px">
                        <button type="button" style="margin-right: 15px;" @click="onCancel" class="btn btn-cancelar">Cancelar</button>
                        <button class="btn btn-edit">Actualizar</button>
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
            nombre: this.user.name,
            email: this.user.email,
            errores: ''
        }
    },
    methods: {
        onCancel: () => window.location.href= '/user/perfil',
        onSubmit: function(id) {
            axios.put(`/user/perfil/${id}`, {name: this.nombre}).then( response => {
                swal({
                    type: 'success',
                    title: 'Información actualizada',
                    showConfirmButton: false,
                    timer: 1000
                }).then( e => {
                   window.location.href= '/user/perfil'
                })
            }).then( e => {
                console.log(e)
            })
        }
    }
}
</script>

