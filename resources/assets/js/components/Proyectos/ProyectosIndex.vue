<template lang="html">
    <div>
        
        <proyectos-create
            v-if="openModalCreate"
            refresh="/mis_proyectos"
            :users="users"
            :user_role="role.name"
            :auth-user="user"
            @close="onCloseModal()">
        </proyectos-create>
        

        <proyectos-edit
            v-if="openModalEdit"
            refresh="/mis_proyectos"
            :proyecto="selectProyecto"
            :user_role="role.name"
            :users="users"
            :auth-user="user"
            @close="onCloseModalEdit()"
        >
        </proyectos-edit>


        <span class="header-table">Mis grupos de investigación</span>
        <br><br>

        <div class="table-filters" >
                <img src="/images/filter.png">
                <input type="text"
                v-model="filters[indexFilter('nombre')].value" 
                placeholder="Buscar por nombre del grupo de investigación"/>
        </div>

        <div style="margin-top: 40px">
            <button class="btn btn-info" @click="onBuscar">Buscar</button>
            <button class="btn btn-danger" @click="onBorrarFiltros">Borrar filtros</button>

           <button @click="openModalCreate = true" style="margin-bottom: 20px; float: right" class="btn-add btn">
              <span style="margin-right: 10px;"class="glyphicon glyphicon-plus-sign"></span> 
              <span>Crear nuevo grupo de investigación</span>
            </button>
        </div>


        <div class="card-index-container">
            <table class="table" style="margin-top:50px;">

                <thead>
                    <tr>
                        <th style="width: 320px;">Nombre del grupo de investigación
                        <span  
                            @click="onSort(filters[indexFilter('nombre')], 'asc')"
                            class="sort glyphicon glyphicon-triangle-top">
                        </span>

                        <span  
                            @click="onSort(filters[indexFilter('nombre')], 'desc')"
                            class="sort glyphicon glyphicon-triangle-bottom">
                        </span>
                        </th>

                        <th>Director del grupo
                            <span  
                                @click="onSort(filters[indexFilter('director_del_grupo')], 'asc')"
                                class="sort glyphicon glyphicon-triangle-top">
                            </span>

                            <span  
                                @click="onSort(filters[indexFilter('director_del_grupo')], 'desc')"
                                class="sort glyphicon glyphicon-triangle-bottom">
                            </span>
                        </th>

                        <th>Descripción</th>
                        <th style="width: 200px;">Proyectos del grupo</th>

                    </tr>
                </thead>

                <tbody>
                     <tr v-for="grupo in currentValues">
                         <td style="width: 320px;"><a :href="`/proyectos/${grupo.id}`">{{grupo.nombre}}</a></td>
                         <td >{{grupo.director_del_grupo}}</td>
                         <td style="text-align: justify;">{{grupo.descripcion}}</td>

                         <td style="width: 200px;">
                            <span><strong>Total:</strong> {{grupo.sub_proyectos.length}}</span>
                            <br>
                            <span v-if="!getOpenActivos(grupo.id).open" @click="updateActivo(grupo.id)" style="cursor: pointer; color: #3097D1">Ver proyectos</span>
                            <span v-else @click="updateActivo(grupo.id)" style="cursor: pointer; color: #3097D1">Ocultar proyectos</span>
                            <ul v-if="getOpenActivos(grupo.id).open">
                                <li v-for="proyecto in grupo.sub_proyectos">{{proyecto.nombre}}</li>
                            </ul> 
                        </td>

                         <td>
                            <img @click="onUpdate(grupo.id)" src="/images/editar.png"/>
                            <img @click="onDelete(grupo.id)" src="/images/delete.png"/>
                        </td>
                    </tr>
                </tbody>

            </table>

            <div v-if="total > valuesPerPage" class="text-center">
                <ul class="pagination">
                    <li>
                        <a @click.prevent="updatePage(currentPage - 1)" href="#" aria-label="Previous">
                            <span aria-hidden="true">&laquo;</span>
                        </a>
                    </li>

                    <li :class="((index + 1)  == currentPage ) ? 'active' : ''" v-for="(x, index) in Array(numberPages)">
                        <a @click.prevent="updatePage(index + 1)" href="#">{{index + 1}}</a>
                    </li>

                    <li>
                        <a @click.prevent="updatePage(currentPage + 1)" href="#" aria-label="Next">
                            <span aria-hidden="true">&raquo;</span>
                        </a>
                    </li>
                </ul>

                <p>Mostrando {{ ((currentPage - 1) * valuesPerPage) + 1 }}-{{ (currentPage  * valuesPerPage) < total ?  (currentPage  * valuesPerPage) : total}} de {{total}}</p>
                
            </div>

        </div>

    </div>
</template>

<script>

    import swal from 'sweetalert2';
    import indexMixin from "../Crud/indexMixin";
    import axios from 'axios';

    export default {
        props: ['user', 'users', 'role', 'init_data', 'filt'],
        mixins: [indexMixin],

        data() {
            return {
                openActivos: this.init_data,
                openModalEdit: false,
                openModalCreate: false,
                selectProyecto: ''
            }
        },

         methods: {

             getOpenActivos: function(id) {
                 return _.find(this.openActivos, proyecto => proyecto.id == id);
             },

             updateActivo: function(id) {
                 this.openActivos = _.map(this.openActivos, proyecto => {
                    proyecto.open = (proyecto.id == id) ? !proyecto.open : proyecto.open
                    return proyecto;
                 })
             },

             onUpdate: function(id)  {
                let x =  _.find(this.init_data, proyecto => {
                    return proyecto.id == id;
                })

                this.selectProyecto = x;
                this.openModalEdit = true;
            },


            onDelete: function(id) {
                swal({
                title: 'Estas seguro que deseas eliminar este grupo de investigación?',
                text: "No podras revertir esta acción!",
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Si, borrar!',
                cancelButtonText: 'Cancelar'
                }).then((result) => {
                    if (result.value) {
                        axios.delete(`/proyectos/${id}`).then( response => {

                            swal({
                                type: 'success',
                                title: 'El grupo de investigación ha sido eliminado.',
                                showConfirmButton: false,
                                timer: 1000
                            }).then( response  => {
                                window.location.reload();
                            })

                            
                        }).catch ( e => {
                            console.log('error');
                        })
                    }
                })
            },
         
            onCloseModalEdit: function() {
                this.openModalEdit = false;
            },

            onCloseModal: function() {
                this.openModalCreate = false
            },

            updateDataProyectos: function(data) {
                this.processData = data
            },

            updateDataUserProyectos: function(data) {
                this.proyectosUsuarioData = data
            }
        }

    }
</script>
