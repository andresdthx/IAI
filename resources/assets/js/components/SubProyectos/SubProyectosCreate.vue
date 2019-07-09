<template lang='html'>
       <transition id="modal" name="modal">
            <div class="modal-mask">
            <div class="modal-wrapper">
                <div class="modal-container">
                    <span class="glyphicon glyphicon-remove close-modal" @click="$emit('close')" ></span>

                        <form v-on:submit.prevent="onSubmit">
                            <h4 class="step-title">Nombre del proyecto*</h4>
                            <input class="input-style" v-model="nombre" placeholder="Ingresa el nombre del proyecto" required>

                            <span v-if="errors.hasOwnProperty('nombre')" class="help-block" style="color: red; margin-bottom: 40px;">
                                <strong v-for="err in errors.nombre" class="col-md-12" >{{err}}</strong>
                            </span>


                            <h4 class="step-title">Investigador principal*</h4>
                            <input class="input-style" v-model="investigador_principal" placeholder="Ingresa el nombre del investigador principal" required>


                             <h4 class="step-title">Descripción del proyecto</h4>
                             <textarea placeholder="Ingresa una descripción para el proyecto (opcion)"class="area-style" v-model="descripcion" ></textarea>

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
export default {
    props: ['proyecto_id'],
    data() {
        return {
            nombre: '',
            descripcion: '',
            investigador_principal: '',
            errors: {},
        }
    },

    methods: {

        onSubmit: function () {
            this.errors = {};
            axios.post(`/subproyectos/create`, { 
                    nombre: this.nombre,
                    proyecto: this.proyecto_id,
                    investigador_principal: this.investigador_principal,
                    descripcion: this.descripcion} ).then( response => {

                let newSubproyecto = response.data.subproyecto;
                this.$emit('create', newSubproyecto);
            }).catch( e  => {
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
