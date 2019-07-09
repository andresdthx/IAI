<template lang="html">
  <div>

        <div style="position: relative">
            <back-button
                :url="`/proyectos/${this.subproyecto.proyecto_id}`"
                text="Volver al grupo de investigación"
            />
            <div class="table-filters" >
                <img src="/images/filter.png">
                <input type="text"
                    v-model="filters[indexFilter('nombre')].value" 
                    placeholder="Buscar por nombre del activo"/>
            </div>
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

            <button @click="onCreate" style="margin-bottom: 20px; float: right" class="btn-add btn">
              <span style="margin-right: 10px;"class="glyphicon glyphicon-plus-sign"></span> 
              <span>Crear nuevo activo</span>
            </button>
        </div>


        <div class="card-index-container">
        <table class="table" style="margin-top:50px;">
          <thead>

              <tr>

                <th>Nombre del activo


                            <span  
                                @click="onSort(filters[indexFilter('nombre')], 'asc')"
                                class="sort glyphicon glyphicon-triangle-top">
                            </span>

                            <span  
                                @click="onSort(filters[indexFilter('nombre')], 'desc')"
                                class="sort glyphicon glyphicon-triangle-bottom">
                            </span>

                        </th>

                        <th>Estado del formulario

                            <span  
                                @click="onSort(filters[indexFilter('estado_diligencia')], 'asc')"
                                class="sort glyphicon glyphicon-triangle-top">
                            </span>

                            <span  
                                @click="onSort(filters[indexFilter('estado_diligencia')], 'desc')"
                                class="sort glyphicon glyphicon-triangle-bottom">
                            </span>

                        </th>

                        <th>Clasificación

                            <span  
                                @click="onSort(filters[indexFilter('clasificacion')], 'asc')"
                                class="sort glyphicon glyphicon-triangle-top">
                            </span>

                            <span  
                                @click="onSort(filters[indexFilter('clasificacion')], 'desc')"
                                class="sort glyphicon glyphicon-triangle-bottom">
                            </span>

                        </th>
                  
              </tr>

          </thead>

          <tbody>
            <tr v-for="activo in currentValues">
                <td><a :href="`/activos/show/${activo.id}`">{{activo.nombre}}</a></td>

                <td>
                    <i v-if="activo.estado_diligencia == 'Terminado'" style="color: #00a651; font-size:1.5em;" class="fa fa-battery-full" aria-hidden="true"></i>
                    <i v-else style="color: #f58345; font-size:1.5em;" class="fa fa-battery-half" aria-hidden="true"></i>
                </td>
                <td>{{mapClasificacion(activo.clasificacion)}}</td>

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

    <!-- <button style="margin-top: -190px; float: right" class="btn btn-info" @click="onBack">Regresar</button> -->
  </div>
    
</template>

<script>

import Multiselect from 'vue-multiselect';
import indexMixin from "../Crud/indexMixin";
import swal from 'sweetalert2';

export default {
  props: ['subproyecto_id', 'init_data', 'filt', 'subproyecto'],
  mixins: [indexMixin],
  components: {Multiselect},



  methods: {

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

    onBack: () => window.history.back(),

    onCreate: function() {
      //window.history.pushState({page: 1}, "title 1", "?page=1");
      let nuevoActivo;
      swal({
        title: "Ingresa un nombre para el nuevo activo intangible",
        input: "text",
        showCancelButton: true,
        confirmButtonText: "Crear",
        cancelButtonText: "Cancelar",
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        preConfirm: nombre => {
          return axios
            .put(`/activos/create`, {
              nombre: nombre,
              subproyecto: this.subproyecto_id
            })
            .then(response => {
              nuevoActivo = response.data.activo;
              this.initData.push(response.data.activo);
              this.total = _.size(this.initData);
              this.currentPage = 1;
              this.numberPages = this.calculateNumberPages(_.size(this.initData));
              //window.history.replaceState({}, '', '#new');
            })
            .catch(e => {
              _.each(e.response.data.errors, error => {
                swal.showValidationError(error);
              });
            });
        },

        allowOutsideClick: () => !swal.isLoading()
      })
        .then(result => {
          if (result.value) {
            swal({
              type: "success",
              title: "Activo intangible creado",
              confirmButtonText: "Diligenciar"
            }).then(result => {
              if (result.value) {
                  window.location.assign(`/activos/show/${nuevoActivo.id}`);
              }
            });
          }
        })
        .catch(e => {
          console.log(e);
        });
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
};
</script>
