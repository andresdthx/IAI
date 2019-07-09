<template lang='html'>
    <div>

        <subproyectos-create
            v-if="openModalCreate" 
            :proyecto_id="this.proyecto.id"
            @close="onCloseModal('create')"
            @create="updateData">
        </subproyectos-create>

        <subproyectos-edit
            v-if="openModalEdit"
            :subproyecto="subProyectoSelect"
            @close="onCloseModal('edit')">
        </subproyectos-edit>

        <proyecto-users
            v-if="openModalAddUser"
            :project="proyecto.id"
            :users="allusers"
            @close="onCloseModal('user')">
        ></proyecto-users>

        <span class="header-table" style="text-decoration: underline; font-size: 25px;">Grupo de investigación: {{proyecto.nombre}}</span>

        <div>
            <img style="float: left; margin-right: 10px; padding-top: 5px" src="/images/user.png" alt="" width="20">
            <span class="header-table" style="font-size: 20px; font-family: 'Open Sans'">Director:</span>
            <span class="header-table" style=" font-size: 20px; font-family: 'Open Sans'"> {{proyecto.director_del_grupo}} </span>
        </div>

        <div>
            <img style="float: left; margin-right: 10px; padding-top: 5px" src="/images/user.png" alt="" width="20">
            <span class="header-table" style="font-size: 20px; font-family: 'Open Sans'">Responsable:</span>
            <span class="header-table" style=" font-size: 20px; font-family: 'Open Sans'"> {{proyecto.encargado}} </span>
        </div>

        <div>
            <img style="float: left; margin-right: 10px; padding-top: 5px" src="/images/user.png" alt="" width="20">
            <span class="header-table" style="font-size: 20px; font-family: 'Open Sans'">Integrantes:</span>
            <ul class="integrantes_table">
                <li v-for="integrante in integrantes">{{integrante. name}}</li>
            </ul>
        </div>



        <br>
        <span style="display:block; margin-bottom: 30px" class="description-style">{{proyecto.descripcion}}</span>

        <br><br>

        <div style="position: relative;">

            <back-button
                :url="`/mis_proyectos`"
                text="Volver a grupos de investigación"
            />

            <div class="table-filters" >
                <img src="/images/filter.png">
                <input type="text"
                    v-model="filters[indexFilter('nombre')].value" 
                    placeholder="Buscar por nombre del proyecto"/>
            </div>
        </div>

         <div style="margin-top: 40px">
            <button class="btn btn-info" @click="onBuscar">Buscar</button>
            <button class="btn btn-danger" @click="onBorrarFiltros">Borrar filtros</button>

            <button @click="openModalCreate = true" style="margin-bottom: 20px; float: right" class="btn-add btn">
              <span style="margin-right: 10px;"class="glyphicon glyphicon-plus-sign"></span> 
              <span>Crear nuevo proyecto</span>
            </button>

            <button @click="showUsers" style="float: right; margin-right:-60px;" class="btn-add btn">
              <span class="glyphicon glyphicon-plus-sign"></span> 
              <span>Agregar integrantes</span>
            </button>
        </div>

        <div class="card-index-container">
          <table class="table" style="margin-top:50px;">

             <thead>

                    <tr>
                        <th style="width: 260px;">Nombre del proyecto

                            <span  
                                @click="onSort(filters[indexFilter('nombre')], 'asc')"
                                class="sort glyphicon glyphicon-triangle-top">
                            </span>

                            <span  
                                @click="onSort(filters[indexFilter('nombre')], 'desc')"
                                class="sort glyphicon glyphicon-triangle-bottom">
                            </span>

                        </th>

                        <th>
                            Investigador principal

                            <span  
                                @click="onSort(filters[indexFilter('investigador_principal')], 'asc')"
                                class="sort glyphicon glyphicon-triangle-top">
                            </span>

                            <span  
                                @click="onSort(filters[indexFilter('investigador_principal')], 'desc')"
                                class="sort glyphicon glyphicon-triangle-bottom">
                            </span>

                        </th>

                        <th>
                          Descripción
                        </th>

                        <th style="width: 230px;">AI del proyecto</th>

                        <th style="width: 50px;"></th>

                  </tr>
            </thead>

            <tbody>
              <tr v-for="subproyecto in currentValues">
                    <td style="width: 260px;"><a :href="`/subproyectos/${subproyecto.id}`">{{subproyecto.nombre}}</a></td>
                    <td style="width: 230px;">{{subproyecto.investigador_principal}}</td>
                    <td style="text-align: justify;">{{subproyecto.descripcion}}</td>

                    <td style="width: 230px;">
                        <span><strong>Total:</strong> {{subproyecto.activos.length}}</span>
                        <br>
                        <span v-if="!getOpenActivos(subproyecto.id).open" @click="updateActivo(subproyecto.id)" style="cursor: pointer; color: #3097D1">Ver activos</span>
                        <span v-else @click="updateActivo(subproyecto.id)" style="cursor: pointer; color: #3097D1">Ocultar activos</span>
                        <ul v-if="getOpenActivos(subproyecto.id).open">
                            <li v-for="x in subproyecto.activos">{{x.nombre_asociado }}</li>
                        </ul> 
                    </td>

                    <td style="width: 50px;">
                        <img @click="onUpdate(subproyecto.id)" src="/images/editar.png"/>
                        <img @click="onDelete(subproyecto.id)" src="/images/delete.png"/>
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
        
        <!-- <h4><strong>Proyectos de {{proyecto.nombre}}:</strong> </h4>
        <ul>
            <li v-for="proyecto in subProyectos"><a :href="`/subproyectos/${proyecto.id}`">{{proyecto.nombre}}</a></li>
        </ul>
        <hr>
        <button class="btn btn-success" @click="onClick">Crear proyecto de {{proyecto.nombre}}</button>
        <button class="btn btn-info" @click="onBack">Regresar</button> -->

        <br>
        
    </div>
</template>


<style>
    .card-create-container {
        max-width: none;
        margin: 50px;
    }
</style>

<script>

import swal from 'sweetalert2';
import indexMixin from "../Crud/indexMixin";
import axios from 'axios';

export default {
  props: ["proyecto", 'subproyectos', 'filt', 'init_data', 'users', 'integrantes'],
  mixins: [indexMixin],
  data() {
      return {
          allusers: this.users,
          subProyectoSelect:'',
          subProyectos: this.subproyectos,
          openModalCreate: false,
          openModalAddUser: false,
          openModalEdit: false,
          openActivos: this.init_data,
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

    onUpdate(id) {
        this.showuser = _.find( this.data, (subProyecto) => subProyecto.id == id);
        this.openModalEdit = true;
    },

    showUsers(){
        console.log(this.integrantes);
        this.openModalAddUser = true;
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

    updateData(data) {
      this.initData.push(data);
      this.total = _.size(this.initData);
      this.currentPage = 1;
      this.numberPages = this.calculateNumberPages(_.size(this.initData));
      swal({
        type: 'success',
        title: 'Proyecto creado',
        showConfirmButton: false,
        timer: 1000
      }).then( response  => {
        this.openModalCreate = false;
        window.location.reload();
      })
    },

    onCloseModal: function(modal) { 
        let modales = {
            'edit': (() => this.openModalEdit = false)(),
            'create': (() => this.openModalCreate = false)(),
            'user': (() => this.openModalAddUser = false)()
        }
        modales[modal]
    },
 
    onBack: () => window.history.back(),

    onClick: function() {
        let nuevoSubProyecto;
        swal({
        title: `Ingresa un nombre para el nuevo proyecto de ${this.proyecto.nombre}`,
        input: "text",
        showCancelButton: true,
        confirmButtonText: "Crear",
        cancelButtonText: "Cancelar",
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        preConfirm: nombre => {
          return axios.post(`/subproyectos/create`, {
              nombre: nombre,
              proyecto: this.proyecto.id
            })
            .then(response => {
              this.subProyectos = response.data.subproyectos;
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
              type: 'success',
              title: 'Proyecto creado',
              showConfirmButton: false,
              timer: 1000
            }).then(result => {

                console.log('sdasd');
                window.location.href= `/proyectos/${this.proyecto.id}`

            });
          }
        })
        .catch(e => {
          console.log(e);
        });
    }

  }
};
</script>

