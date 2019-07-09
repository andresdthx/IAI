<template lang="html">
    <div>

        <subproyectos-edit
            v-if="openModalEdit"
            :subproyecto="subProyectoSelect"
            @close="onCloseModal('edit')">
        </subproyectos-edit>

        <subproyectos-create-all
            v-if="openModalCreate"
            :user="user"
            @close="onCloseModal('create')"
        >
        </subproyectos-create-all>

        <span class="header-table" style="display:block; font-size: 25px;">Proyectos</span>
        <div style="margin-bottom: 40px">
                <img style="float: left; margin-right: 10px; padding-top: 5px" src="/images/user.png" alt="" width="20">
                <span class="header-table" style="font-weight: bold; font-size: 20px; font-family: 'Open Sans'">Responsable del inventario del grupo de investigación: </span>
                <span class="header-table" style=" font-size: 20px; font-family: 'Open Sans'">{{user.name}}</span>
            </div>

        <div class="table-filters" >
                <img src="/images/filter.png">
                <input type="text"
                v-model="filters[indexFilter('nombre')].value" 
                placeholder="Buscar por nombre del proyecto"/>
        </div>

        <multiselect
            v-model="filters[indexFilter('grupo_investigacion')].value" 
            :options="filters[indexFilter('grupo_investigacion')].options"
            :multiple="true"
            :close-on-select="false" 
            :clear-on-select="false" 
            :hide-selected="true" 
            :preserve-search="true" 
            select-label="Presiona enter para seleccionar"
            placeholder="Buscar por grupo de investigación"
            label="name"
            track-by="id">
        </multiselect>

        <div style="margin-top: 40px">
            <button class="btn btn-info" @click="onBuscar">Buscar</button>
            <button class="btn btn-danger" @click="onBorrarFiltros">Borrar filtros</button>

           <button @click="openModalCreate = true" style="margin-bottom: 20px; float: right" class="btn-add btn">
              <span style="margin-right: 10px;"class="glyphicon glyphicon-plus-sign"></span> 
              <span>Crear nuevo proyecto</span>
            </button>
           
        </div>

        <div class="card-index-container">
            <table class="table ListaTabla header_fijo" id="Topicos_Datatable" style="margin-top:50px;">

                <thead>

                <tr>
                    <th style="">Proyecto
                        <span  
                            @click="onSort(filters[indexFilter('nombre')], 'asc')"
                            class="sort glyphicon glyphicon-triangle-top">
                        </span>

                        <span  
                            @click="onSort(filters[indexFilter('nombre')], 'desc')"
                            class="sort glyphicon glyphicon-triangle-bottom">
                        </span>
                    </th>

                    <th style="width:35%;">Descripción</th>
                    <th style="">Grupo de investigación

                        <span  
                            @click="onSort(filters[indexFilter('grupo_investigacion')], 'asc')"
                            class="sort glyphicon glyphicon-triangle-top">
                        </span>

                        <span  
                            @click="onSort(filters[indexFilter('grupo_investigacion')], 'desc')"
                            class="sort glyphicon glyphicon-triangle-bottom">
                        </span>
                    </th>
                    <th style="">AI del proyecto</th>

                </tr>

                </thead>

                <tbody>

                    <tr v-for="proyecto in currentValues">
                        <td style=""><a :href="`/subproyectos/${proyecto.id}`">{{proyecto.nombre}}</a></td>
                        <td style=" width:35%;  text-align: justify;">{{proyecto.descripcion}}</td>
                        <td style="">{{proyecto.grupo_investigacion}}</td>
                        <td>
                            <span><strong>Total:</strong> {{proyecto.activos.length}}</span>
                            <br>
                            <span v-if="!getOpenActivos(proyecto.id).open" @click="updateActivo(proyecto.id)" style="cursor: pointer; color: #3097D1">Ver activos</span>
                            <span v-else @click="updateActivo(proyecto.id)" style="cursor: pointer; color: #3097D1">Ocultar activos</span>
                            <ul v-if="getOpenActivos(proyecto.id).open">
                                <li v-for="activo in proyecto.activos">{{activo.nombre_asociado}}</li>
                            </ul>
                        </td>

                        <td>
                            <img @click="onUpdate(proyecto.id, proyecto.nombre)" src="/images/editar.png"/>
                            <img @click="onDelete(proyecto.id)" src="/images/delete.png"/>
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

import Multiselect from 'vue-multiselect';
import indexMixin from "../Crud/indexMixin";
import swal from 'sweetalert2';

export default {
    props: ['user', 'init_data', 'filt'],
    mixins: [indexMixin],
    data() {
        return {
            openActivos: _.map(this.init_data, x => {return {id: x.id, open: false} } ),
            openModalCreate: false,
            openModalEdit: false,
            subProyectoSelect: ''
        }
    },

    methods: {

        getOpenActivos: function(id){
            return _.find(this.openActivos, activo => activo.id == id);
        },

        updateActivo: function(id) {
            this.openActivos =_.map(this.openActivos, activo => {
                activo.open = (activo.id == id) ? !activo.open : activo.open;
                return activo;
            });
        },

        onDelete(id) {
         swal({
            title: 'Estas seguro que deseas eliminar este proyecto?',
            text: "No podras revertir esta acción!",
            type: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Si, borrar!',
            cancelButtonText: 'Cancelar'
            }).then((result) => {
                if (result.value) {
                    axios.delete(`/subproyectos/${id}`).then( response => {
                        swal({
                            type: 'success',
                            title: 'Proyecto eliminado',
                            showConfirmButton: false,
                            timer: 1000
                        }).then( response  => {
                            this.openModalCreate = false;
                            window.location.reload();
                        })
                    }).catch ( e => {
                        console.log('error');
                    })
                }
        })
    },

        onUpdate: function(id) {
            this.subProyectoSelect = _.find(this.init_data, subproyecto => subproyecto.id == id)
            this.openModalEdit = true;
        },

        onCloseModal: function(method) {
            (method == 'edit') && (this.openModalEdit = false);
            (method == 'create') && (this.openModalCreate = false);
        }
    }
    
}
</script>
