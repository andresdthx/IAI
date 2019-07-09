<template lang='html'>
       <transition id="modal" name="modal">
            <div class="modal-mask">
                <div class="modal-wrapper">
                    <div class="modal-container">
                        <span class="glyphicon glyphicon-remove close-modal" @click="$emit('close')" ></span>

                        <form v-on:submit.prevent="onSubmit">

                            <h4 class="step-title">Nombre del grupo de investigación*</h4>
                            <input class="input-style" v-model="nombre" placeholder="Ingresa el nombre del grupo de investigación" required>

                            <span v-if="errors.hasOwnProperty('nombre')" class="help-block" style="color: red; margin-bottom: 40px;">
                                <strong v-for="err in errors.nombre" class="col-md-12" >{{err}}</strong>
                            </span>

                            <h4 class="step-title">Marca esta casilla si este grupo es un semillero:</h4>
                            <input type="checkbox" id="checkbox" v-model="is_semillero">
                            <label for="checkbox">{{ checked }}</label>

                            <div>
                                <h4 class="step-title">Director del grupo de investigación*</h4>

                               <input v-model ="director"
                                      class="input-style" 
                                      type="text"
                                      placeholder="Ingresa el nombre del director del grupo de investigación" required
                                >

                                <span v-if="errors.hasOwnProperty('director')" class="help-block" style="color: red; margin-bottom: 40px;">
                                    <strong v-for="err in errors.director" class="col-md-12" >{{err}}</strong>
                                </span> 
                            </div>

                            <div v-if="user_role == 'admin'">
                                <h4 class="step-title">Encargado del inventario del grupo de investigación*</h4>
                                <select class="select-style" name="rol" v-model="nombre_encargado" required>
                                    <option disabled value="">Selecciona al encargado del grupo de investigación</option>
                                    <option v-for="user in users" 
                                        :value="user.id">{{user.name}}
                                    </option>
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
        props: ['proyecto', 'users', 'user_role', 'auth-user', 'refresh'],
        data(){
            return {
                nombre: this.proyecto.nombre,
                director: this.proyecto.director_del_grupo,
                nombre_encargado: this.proyecto.user_id,
                descripcion: this.proyecto.descripcion,
                is_semillero : null,
                errors: ''
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

            onSubmit: function() {
                axios.put(`/proyectos/${this.proyecto.id}`, {'nombre': this.nombre,
                                                             'encargado': this.nombre_encargado,
                                                             'director': this.director,
                                                             'is_semillero' : this.is_semillero,
                                                             'descripcion': this.descripcion})
                .then( response => {
                    swal({
                        type: 'success',
                        title: 'Grupo de investigación actualizado',
                        showConfirmButton: false,
                        timer: 800
                    }).then( reponse => {
                        window.location.href = this.refresh;
                    })
                }).catch( e => {
                    this.errors = e.response.data.errors;
                })
                
            }
        }
    }
</script>

