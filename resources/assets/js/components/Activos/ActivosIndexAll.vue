<template lang="html">
    <div v-if="filters">

        <activos-modal-create
            v-if="openModalCreate" 
            :user="user"
            @close="onCloseModal()">
        </activos-modal-create>

        <div class="header-index">
            <span class="header-table">Activos intangibles</span>
            <span class="glyphicon glyphicon-question-sign" v-tooltip.right="{
                                    content: 'Los activos intangibles son todos aquellos activos inmateriales, que son creación del intelecto humano y que son susceptibles de valoración económica. Por ejemplo, la letra de una canción, un artículo de investigación, resultados de proyectos de I+D, una fotografía, una tesis, una metodología, un proceso, entre otros.',
                                    placement: 'bottom-center',
                                    classes: ['info'],
                                    targetClasses: ['it-has-a-tooltip'],
                                    offset: 5,
                                    delay: {
                                        show: 500,
                                        hide: 300,
                                    },
                                    }"></span> 

            <div >
                <img style="float: left; margin-right: 10px; padding-top: 5px" src="/images/user.png" alt="" width="20">
                <span class="header-table" style="font-weight: bold; font-size: 20px; font-family: 'Open Sans'">Responsable del inventario del grupo de investigación:</span>
                <span class="header-table" style=" font-size: 20px; font-family: 'Open Sans'"> {{user.name}}</span>
            </div>
        </div>

        <div class="table-filters" >
            <img src="/images/filter.png">
            <input type="text"
                   v-model="filters[indexFilter('nombre')].value" 
                   placeholder="Buscar por nombre del activo"/>
        </div>

        <multiselect
            v-model="filters[indexFilter('estado_diligencia')].value" 
            :options="filters[indexFilter('estado_diligencia')].options"
            :multiple="true"
            :close-on-select="false" 
            :clear-on-select="false" 
            :hide-selected="true" 
            :preserve-search="true" 
            select-label="Presiona enter para seleccionar"
            placeholder="Buscar por estado de la diligencia"
            label="id"
            track-by="id">
        </multiselect>
        <br>
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

        <br>
        <multiselect
            v-model="filters[indexFilter('proyecto')].value" 
            :options="filters[indexFilter('proyecto')].options"
            :multiple="true"
            :close-on-select="false" 
            :clear-on-select="false" 
            :hide-selected="true" 
            :preserve-search="true" 
            select-label="Presiona enter para seleccionar"
            placeholder="Buscar por proyecto"
            label="name"
            track-by="id">
        </multiselect>

        <br>
        <multiselect
            v-model="filters[indexFilter('clasificacion')].value" 
            :options="filters[indexFilter('clasificacion')].options"
            :multiple="true"
            :close-on-select="false" 
            :clear-on-select="false" 
            :hide-selected="true" 
            :preserve-search="true" 
            select-label="Presiona enter para seleccionar"
            placeholder="Buscar por clasificación"
            label="name"
            track-by="id">
        </multiselect>


        <div style="margin-top: 40px">
            <button class="btn btn-info" @click="onBuscar">Buscar</button>
            <button class="btn btn-danger" @click="onBorrarFiltros">Borrar filtros</button>

            <button @click="openModalCreate = true" style="margin-bottom: 20px; float: right" class="btn-add btn">
              <span style="margin-right: 10px;"class="glyphicon glyphicon-plus-sign"></span> 
              <span>Crear nuevo activo</span>
            </button>
        </div>

        <div class="card-index-container">
        <table class="table" style="margin-top:50px;">
                
                <thead>

                    <tr>
                        <th style="width: 200px">Activo


                            <span  
                                @click="onSort(filters[indexFilter('nombre')], 'asc')"
                                class="sort glyphicon glyphicon-triangle-top">
                            </span>

                            <span  
                                @click="onSort(filters[indexFilter('nombre')], 'desc')"
                                class="sort glyphicon glyphicon-triangle-bottom">
                            </span>

                        </th>

                        <th style="width: 163px;">Clasificación 

                            <span  
                                @click="onSort(filters[indexFilter('clasificacion')], 'asc')"
                                class="sort glyphicon glyphicon-triangle-top">
                            </span>

                            <span  
                                @click="onSort(filters[indexFilter('clasificacion')], 'desc')"
                                class="sort glyphicon glyphicon-triangle-bottom">
                            </span>

                        </th>

                        <th style="width: 146px;">Estado

                            <span  
                                @click="onSort(filters[indexFilter('estado_diligencia')], 'asc')"
                                class="sort glyphicon glyphicon-triangle-top">
                            </span>

                            <span  
                                @click="onSort(filters[indexFilter('estado_diligencia')], 'desc')"
                                class="sort glyphicon glyphicon-triangle-bottom">
                            </span>

                        </th>

                        <th style="width: 246px;">Grupo de investigación

                            <span  
                                @click="onSort(filters[indexFilter('grupo_investigacion')], 'asc')"
                                class="sort glyphicon glyphicon-triangle-top">
                            </span>

                            <span  
                                @click="onSort(filters[indexFilter('grupo_investigacion')], 'desc')"
                                class="sort glyphicon glyphicon-triangle-bottom">
                            </span>

                        </th>

                        <th style="width: 126px;">Proyecto

                             <span  
                                @click="onSort(filters[indexFilter('proyecto')], 'asc')"
                                class="sort glyphicon glyphicon-triangle-top">
                            </span>

                            <span  
                                @click="onSort(filters[indexFilter('proyecto')], 'desc')"
                                class="sort glyphicon glyphicon-triangle-bottom">
                            </span>
                        </th>
                        
                    </tr>

                </thead>

                <tbody>
                    <tr v-for="activo in currentValues">
                        <td style="width: 200px"><a :href="`/activos/show/${activo.id}`">{{activo.nombre}}</a></td>
                        <td style="width: 163px ">{{mapClasificacion(activo.clasificacion)}}</td>
                        <td style="width: 146px;">
                            <i v-if="activo.estado_diligencia == 'Terminado'" style="color: #00a651; font-size:1.5em;" class="fa fa-battery-full" aria-hidden="true"></i>
                            <i v-else style="color: #f58345; font-size:1.5em;" class="fa fa-battery-half" aria-hidden="true"></i>
                            
                            <!-- {{activo.estado_diligencia}} -->
                        </td>
                        <td style="width: 246px;">{{activo.grupo_investigacion}}</td>
                        <td style="width: 126px;">{{activo.proyecto}}</td>

                        <td>
                            <img @click="onUpdate(activo.id, activo.nombre)" src="/images/editar.png"/>
                            <img @click="onDelete(activo.id)" src="/images/delete.png"/>
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
    components: {Multiselect},

    data() {
        return {
            openModalCreate: false
        }
    },

    methods: {

        onDelete: function(id) {
            swal({
                title: 'Estas seguro que deseas eliminar este AI?',
                text: "No podras revertir esta acción!",
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Si, borrar!',
                cancelButtonText: 'Cancelar'
                }).then((result) => {
                    if (result.value) {
                        axios.delete(`/activos/${id}`).then( response => {
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

        onUpdate: function(id, nombre) {
            swal({
            title: "Ingresa un nombre para el activo intangible",
            input: "text",
            inputValue: nombre,
            showCancelButton: true,
            confirmButtonText: "Actualizar",
            cancelButtonText: "Cancelar",
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            preConfirm: nombre => {

            return axios.put(`/activos/updateName/${id}`, { nombre: nombre}).then( response => {

                })
                .catch(e => {
                _.each(e.response.data.errors, error => {
                    swal.showValidationError(error);
                });
                });
            },

            allowOutsideClick: () => !swal.isLoading()

        }).then(result => {
            if (result.value) {
                swal({
                    type: 'success',
                    title: 'Nombre actualizado.',
                    showConfirmButton: false,
                    timer: 800
                }).then( response  => {
                    window.location.reload();
                })
            }
            })
            .catch(e => {
            console.log(e);
            });
        },

        onCloseModal: function() {
            this.openModalCreate = false
        },


        mapClasificacion : function(clasificacion) {
            let map  = {
                                logos_signos_palabras : 'Logos, signos, palabras o frases distintivas',
                                publicacion           : 'Publicación',
                                articulo              : 'Artículo',
                                ensayo                : 'Ensayo',
                                presentacion          : 'Presentación',
                                poster                : 'Poster',
                                diseño                : 'Diseños',
                                planos_esquemas       : 'Planos, esquemas, representaciones gráficas, dibujos, posters, fotografías',
                                lema                  : 'Lema',
                                resultadoID           : 'Resultado de I+D',
                                audiovisual           : 'Obra Audiovisual',
                                musical               : 'Obra musical',
                                info                  : 'Información confidencial',
                                software              : 'Software',
                                base_datos            : 'Base de datos',
                                know_how              : 'Know-how',
                                otro                  : 'Otro'
            }

            if (clasificacion == null) {
                return 'Sin definir'
            } 

            return  map.hasOwnProperty(clasificacion) ?  map[clasificacion] : clasificacion;
        },


    }
    
}
</script>
