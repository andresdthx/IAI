<template lang='html'>
       <transition id="modal" name="modal">
            <div class="modal-mask">
            <div class="modal-wrapper">
                <div class="modal-container">
                    <span class="glyphicon glyphicon-remove close-modal" @click="$emit('close')" ></span>

                    <form v-on:submit.prevent="onSubmit">
                        <h4 class="step-title">Nombre de activo proyecto*</h4>
                        <input class="input-style" v-model="nombre" placeholder="Ingresa el nombre del proyecto" required>

                        <span v-if="errors.hasOwnProperty('nombre')" class="help-block" style="color: red; margin-bottom: 40px;">
                            <strong v-for="err in errors.nombre" class="col-md-12" >{{err}}</strong>
                        </span>

                        <h4 class="step-title">Elegir grupo de investigación para el proyecto*</h4>
                        <select class="select-style" v-model="grupo" required >
                            <option style="color: #88A6B0"  selected disabled value=''>Selecciona un grupo de investigación</option>
                            <option v-for="proyecto in proyectos" :value="proyecto.id">
                                    {{proyecto.nombre}}
                            </option>
                        </select>

                        <h4 class="step-title">Descripción del proyecto</h4>
                         
                        <textarea placeholder="Ingresa una descripción para el proyecto(opcional)"
                                  class="area-style" 
                                  v-model="descripcion">
                        </textarea>



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
import swal from 'sweetalert2';

export default {
    props: ['user'],
    data() {
        return {
            nombre: '',
            grupo: '',
            proyectos: '',
            descripcion: '',
            errors:{}
        }
    },

    methods: {
        onSubmit() {

            axios.post(`/subproyectos/create`, { nombre: this.nombre, proyecto: this.grupo, descripcion: this.descripcion } ).then( response => {
                swal({
                        type: 'success',
                        title: 'Proyecto creado',
                        showConfirmButton: false,
                        timer: 1000
                    }).then( response  => {
                        window.location.reload();
                    })
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

     created() {
        axios.get(`/proyectos/api-user/${this.user.id}`).then( response => {
            this.proyectos = response.data.proyectos;
        }).catch( e => {
            this.errors = e.response.data.errors;
        })
    },

    mounted() {
        window.addEventListener('click', this.handleClick)
    },

    beforeDestroy: function () {
        window.removeEventListener('click', this.handleClick)
    },
    
}
</script>
