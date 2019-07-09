<template lang='html'>
       <transition id="modal" name="modal">
            <div class="modal-mask">
            <div class="modal-wrapper">
                <div v-if="proyectos" class="modal-container">
                    <span class="glyphicon glyphicon-remove close-modal" @click="$emit('close')" ></span>

                    <form v-on:submit.prevent="onSubmit">
                        <h4 class="step-title">Nombre de activo intangible*</h4>
                        <input class="input-style" v-model="nombre" placeholder="Ingresa el nombre del activo" required>

                        <span v-if="errors.hasOwnProperty('nombre')" class="help-block" style="color: red; margin-bottom: 40px;">
                                <strong v-for="err in errors.nombre" class="col-md-12" >{{err}}</strong>
                            </span>

                        <h4 class="step-title">Elegir grupo de investigación para el activo*</h4>
                        <select class="select-style" v-model="grupo" required >
                            <option style="color: #88A6B0"  selected disabled value=''>Selecciona un grupo de investigación</option>
                            <option v-for="proyecto in proyectos" :value="proyecto.id">
                                    {{proyecto.nombre}}
                            </option>
                        </select>

                        <div v-if="grupo">
                            <h4 class="step-title">Elegir proyecto para el activo*</h4>
                            <select class="select-style" v-model="proyecto" required>
                                <option style="color: #88A6B0"  selected disabled value=''>Selecciona un grupo de investigación</option>
                                <option v-for="proyecto in selectProyectos" :value="proyecto.id">
                                        {{proyecto.nombre}}
                                </option>
                            </select>
                        </div>
                        
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

import Multiselect from 'vue-multiselect';
import axios from 'axios';
import swal from 'sweetalert2';

export default {
    props: ['user'],
    components: {Multiselect},

    data() {
        return {
            proyectos: null,
            nombre: '',
            grupo: '',
            proyecto: '',
            errors: {},
        }
    },


    computed: {
        selectProyectos: function() {
            let x =  _.filter(this.proyectos, x => x.id == this.grupo);
            return x[0].sub_proyectos;
        }
    },

    created() {
        axios.get(`/proyectos/api-user/${this.user.id}`).then( response => {
            this.proyectos = _.filter(response.data.proyectos, grupo => _.size(grupo.sub_proyectos) > 0);
        }).catch( e => {
            this.errors = e.response.data.errors;
        })
    },

    methods: {

        onSubmit() {
            axios.put(`/activos/create`, { nombre: this.nombre, subproyecto: this.proyecto} ).then( response => {
                let nuevoActivo = response.data.activo;
                //window.history.replaceState({}, '', '#new');
                swal({
                type: "success",
                title: "Activo intangible creado",
                confirmButtonText: "Diligenciar"
                }).then(result => {
                    if (result.value) {
                        window.location.href = `/activos/show/${nuevoActivo.id}`;
                    } else {
                        window.location.reload();
                    }
                });

            }).catch( e => {
                this.errors = e.response.data.errors;
            })
        },

        handleClick(event) {
            if (event.target.className == 'modal-wrapper') {
                this.$emit('close')
            }
        }
    },

    mounted() {
        window.addEventListener('click', this.handleClick)
    },

    beforeDestroy: function () {
        window.removeEventListener('click', this.handleClick)
    },
}
</script>
