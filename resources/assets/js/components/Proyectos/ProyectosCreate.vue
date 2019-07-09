<template lang='html'>
       <transition id="modal" name="modal">
            <div class="modal-mask">
                <div class="modal-wrapper">
                    <div class="modal-container">
                        <span class="glyphicon glyphicon-remove close-modal" @click="$emit('close')" ></span>

                        <form v-on:submit.prevent="onSubmit">


                            <h4 class="step-title">Nombre del grupo de investigación o semillero*</h4>
                            <input class="input-style" v-model="nombre" placeholder="Ingresa el nombre del grupo de investigación o semillero" required>
                            <span v-if="errors.hasOwnProperty('nombre')" class="help-block" style="color: red; margin-bottom: 40px;">
                                <strong v-for="err in errors.nombre" class="col-md-12" >{{err}}</strong>
                            </span> 

                            <h4 class="step-title">Marca esta casilla si este grupo es un semillero:</h4>
                            <input type="checkbox" id="checkbox" v-model="is_semillero">
                            <label for="checkbox">{{ checked }}</label>

                            <div v-if="user_role == 'admin'">
                                <h4 class="step-title">Director del inventario del grupo de investigación*</h4>
                                <select class="select-style" name="rol" v-model="director" required>
                                    <option disabled value="">Selecciona el director del inventario del grupo de investigación</option>
                                    <option v-for="user in users" 
                                        :value="user.name">{{user.name}}</option>
                                </select>

                                <span v-if="errors.hasOwnProperty('nombre_encargado')" class="help-block" style="color: red; margin-bottom: 40px;">
                                    <strong v-for="err in errors.nombre_encargado" class="col-md-12" >{{err}}</strong>
                                </span> 
                            </div>

                            <div v-if="user_role == 'admin'">
                                <h4 class="step-title">Responsable del inventario del grupo de investigación*</h4>
                                <select class="select-style" name="rol" v-model="nombre_encargado" required>
                                    <option disabled value="">Selecciona al responsable del inventario del grupo de investigación</option>
                                    <option v-for="user in users" 
                                        :value="user.id">{{user.name}}</option>
                                </select>

                                <span v-if="errors.hasOwnProperty('nombre_encargado')" class="help-block" style="color: red; margin-bottom: 40px;">
                                    <strong v-for="err in errors.nombre_encargado" class="col-md-12" >{{err}}</strong>
                                </span> 
                            </div>

                            <h4 class="step-title">Descripción del grupo de investigación</h4>
                            <textarea placeholder="Ingresa una descripción para el grupo de investigación (opcional)"class="area-style" v-model="descripcion" ></textarea>

                            <div style="float: right; margin-top:30px">
                                <button type="button" style="margin-right: 15px;" @click="$emit('close')" class="btn btn-cancelar">Cancelar</button>
                                <button class="btn btn-guardar">Guardar</button>
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
    import axios from 'axios';
    import swal from 'sweetalert2';

    export default {
        props: ['users', 'auth-user', 'user_role', 'refresh'],
        data(){
            return {
                nombre: '',
                nombre_encargado: '',
                director: '',
                descripcion: '',
                is_semillero : null,

                errors: {}
            }
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

        encargado() {
            return (this.user_role == 'admin') ? this.nombre_encargado :  this.authUser;
        },

        onSubmit: function() {
            let encargado = this.encargado();
            axios.post('/proyectos',{'nombre': this.nombre, 'director': this.director, 'encargado': encargado, 'is_semillero':this.is_semillero, 'descripcion': this.descripcion}).then( response => {
                swal({
                    type: 'success',
                    title: 'Grupo de investigación creado',
                    showConfirmButton: false,
                    timer: 1000
                }).then( response  => {
                    window.location.reload();
                })
            }).catch( e =>{
                this.errors = e.response.data.errors;
            });
        }
        }
    }
</script>

