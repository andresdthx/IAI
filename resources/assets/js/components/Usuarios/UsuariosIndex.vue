<template lang="html">
    <div>

        <usuarios-invitation
            v-if="openModalCreate"
            :roles="roles"
            @close="onCloseModal()">
        </usuarios-invitation>

        <span class="header-table">Usuarios</span>
        <br><br>

        <crud-index
            v-on:updateData="updateData"
            :dataProp="mutableUsers"
            :configProp="config"
            :crudProp="crud"
            :sortValuesProp="dataUsers"
            :rolProp="user_role">
        </crud-index>

    </div>
</template>

<script>
    import swal from 'sweetalert2';
    import axios from 'axios';

    export default {
        props: ['users', 'roles', 'user_role', 'config', 'values', 'all_users'],
        data() {
            return {
                filter: '',
                openModalCreate: false,
                mutableUsers: this.users,
                crud: {
                    create: {
                        displayRules: true,
                        handler: () => {
                            this.openModalCreate = true;
                        }
                    },

                    update: {
                        displayRules: true,
                        handler: this.onEdit,
                    },

                    delete: {
                        displayRules: this.isDelete,
                        handler: this.onDelete

                    }
                }
            }   
        },

        computed: {
            
            dataUsers: function() {
                let dataUser = {
                    nombre: {
                        headName: 'Nombre',
                        displayRules: true,
                        linkRules: false,

                        isFilter: true,
                            urlPos: 0,
                            filter: null,
                            //type(text)
                            placeholder: 'Buscar por nombre de usuario',
                        isSorted: true,
                            select: false,
                            dir: null,
                            style: 'glyphicon-sort',
                    },

                    email: {
                        headName: 'Correo electrónico',
                        displayRules: true,
                        linkRules: false,
                        //type(text)
                        isFilter: true,
                            urlPos: 1,
                            filter: null,
                            placeholder: 'Buscar por correo electrónico',

                        isSorted: true,
                            select:false,
                            dir: null,
                            style: 'glyphicon-sort'
                    },
                    rol: {
                        headName: 'Rol',
                        displayRules: true,
                        linkRules: false,
                        //type(select)
                        isFilter: true,
                            urlPos: 2,
                            filter: null,
                            relation: 'roles',
                            selectValues: this.roles,
                            placeholder:'Buscar por rol',

                        isSorted: true,
                            select:false,
                            dir: null,
                            style: 'glyphicon-sort'
                    }
                }
                
                _.each(dataUser, (value, key) => {
                    let field = this.values[key];
                    value.fieldName = field.name;
                    value.type = field.type;
                })

                return dataUser;
            },

            filterUsers: function() {
                return this.mutableUsers.filter( user => 
                    user.name.toUpperCase().includes(this.filter.toUpperCase()) || 
                    user.email.toUpperCase().includes(this.filter.toUpperCase()));
            },

            
        },

        methods:{

        onCloseModal: function() {
            this.openModalCreate = false;
        },

         updateData: function(data){
            this.mutableUsers = data;
         },

         countAdmins: function() {
            return _.size(_.filter(this.mutableUsers.data, (user => user.rol == 'admin')));
        },

        isDelete: function(id){
           return !(_.filter(this.mutableUsers.data, user => user.id == id)[0].rol == 'admin' && this.countAdmins() < 2) ;
        },

          getRoles: function(roles) {
            let mappingRoles = {};
            roles.forEach(rol => mappingRoles[rol.id] = rol.name)
            return mappingRoles;
          },

          getRoleById: function(id, roles) {
              return roles.filter( role => role.id == id);
          },
          getUsersOnDelete: function(users, deleteUserId) {
              let mappingUsers = {};
              users.forEach( user => {
                  if (user.id != deleteUserId) {
                    mappingUsers[user.id] = user.name
                  }
              });
              return mappingUsers;
          },

          onEdit: function(userId) {

            swal({
            title: 'Selecciona el rol',
            input: 'select',
            inputOptions: this.getRoles(this.roles),
            inputPlaceholder: 'Selecciona un rol para el empleado',
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Actualizar',
            cancelButtonText: 'Cancelar',
            showCancelButton: true,
            inputValidator: (value) => {
                return new Promise((resolve) => {
                    if (value != '') {
                        resolve()
                    } else {
                        resolve('Debes seleccionar un rol.');
                    }
                })
            }
            }).then( response => {
                if (response.value) {
                    let rolId = response.value
                    axios.put(`/users/${userId}`, {'rol': response.value}).then( response => {

                        this.mutableUsers.data = this.mutableUsers.data.map( user => {
                            if (user.id == userId) {
                                user.rol = this.getRoleById(rolId, this.roles)[0].name;
                            }
                            return user;
                        });

                    }).catch( e => {
                        console.log(e);
                    })
                }
            });
          },

          onDelete:  function(userId) {
              let proyectos = _.filter(this.mutableUsers.data, user => user.id == userId)[0].proyectos

              swal({
                title: 'Estas seguro que deseas eliminar este usuario?',
                text: "No podras revertir esta acción!",
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Si, borrar!',
                cancelButtonText: 'Cancelar'
                }).then((result) => {
                    if (result.value) {
                        if (proyectos == 0) {
                            axios.delete(`/users/${userId}`)
                                .then( reponse => {
                                    console
                                    this.mutableUsers.data = this.mutableUsers.data.filter( user => user.id != userId);
                                    swal(
                                        'Eliminado!',
                                        'El usuario ha sido eliminado.',
                                        'success'
                                    );
                                }).catch( e => {
                                    console.log(e);
                                });
                        } else {
                            swal({
                                title: 'Este usuario tiene grupos de investigación que deben ser reasignados',
                                type: 'warning',
                                inputPlaceholder: 'Seleccionar usuario',
                                confirmButtonColor: '#3085d6',
                                cancelButtonColor: '#d33',
                                confirmButtonText: 'Reasignar grupos',
                                cancelButtonText: 'Cancelar',
                                showCancelButton: true
                            }).then( response => {
                                if (response.value) {
                                    window.location.href=`/users/reasignarProyectos/${userId}`
                                    // let assinguserId = response.value;  
                                    // axios.delete(`/users/asignProyectsAndDestroy/${assinguserId}/${userId}`)
                                    // .then(response =>{
                                    //     this.mutableUsers.data = this.mutableUsers.data.filter( user => user.id != userId);
                                    //     swal(
                                    //         'Eliminado!',
                                    //         'El usuario ha sido eliminado.',
                                    //         'success'
                                    //     );
                                    // }).catch( e => {
                                    //     console.log(e);
                                    // })

                                }
                            }).catch(e => {
                                swal.noop;
                            });
                        }
                    }
                }).catch(e=> {
                    swal.noop
                });
            }
        }
    }
</script>
