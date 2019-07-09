<template lang='html'>
       <transition id="modal" name="modal">
            <div class="modal-mask" >
                <div class="modal-wrapper">
                    <div class="modal-container" v-bind:style="styleObject">
                        <span class="glyphicon glyphicon-remove close-modal" @click="$emit('close')" ></span>
                        <h3 >Agregar integrantes al grupo</h3>

                        <multiselect 
                            v-model="value"
                            :options="options"
                            :multiple="true"
                            :close-on-select="false"
                            :clear-on-select="false"
                            :preserve-search="true"
                            placeholder="Seleccciona"
                            label="name" track-by="name"
                            :preselect-first="true">
                            <template slot="selection" slot-scope="{ values, search, isOpen }"><span class="multiselect__single" v-if="values.length &amp;&amp; !isOpen">{{ values.length }} options selected</span></template>
                        </multiselect>

                        <button @click="addUsers()">Agregar usuarios</button>
                    </div>
                </div>
            </div>
        </transition>
</template>


<style>

</style>

<script>
    import Multiselect from 'vue-multiselect';
    import axios from 'axios';
    import swal from 'sweetalert2';

    export default {
        props:['users', 'project'],
        components: {Multiselect},

        data(){
            return{
                value:[],
                options: this.users,
                styleObject: {
                    color: 'black',
                    textAlign: 'center',
                    height: '300px'
                }
            }
        },

        methods: {
            addUsers(){

                let usuarios = [];

                this.value.forEach(value => {
                    usuarios.push(value['id']);
                })

                axios.post('/proyectos/users', {
                    users: usuarios,
                    proyecto: this.project
                })
                .then( response => {
                    swal({
                        type: 'success',
                        title: 'Grupo de investigación actualizado',
                        showConfirmButton: false,
                        timer: 2000
                    }).then( reponse => {
                        window.location.href = "/todos_los_proyectos";
                    })
                })
                .catch(function (error) {
                    console.log(error);
                });

                console.log(usuarios); 
                // console.log(this.value); 
            },
        },

        mounted() {
            console.log('Component mounted.')
        }
    }
</script>

