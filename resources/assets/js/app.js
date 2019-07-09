require('./bootstrap');

window.Vue = require('vue');
import VueRouter from 'vue-router';
import VTooltip from 'v-tooltip';
import Notifications from 'vue-notification';
import VueCarousel from 'vue-carousel';
import VueCookies from 'vue-cookies'
import Vuex from 'vuex';

// console.log = function() {}

Vue.use(Vuex);
Vue.use(VTooltip);
Vue.use(VueRouter);
Vue.use(Notifications);
Vue.use(VueCarousel);
Vue.use(VueCookies);

Vue.component('example-component', require('./components/ExampleComponent.vue'));
Vue.component('nav-bar', require('./components/NavBar.vue'));

Vue.component('usuarios-index', require('./components/Usuarios/UsuariosIndex.vue'));
Vue.component('usuarios-create', require('./components/Usuarios/UsuariosCreate.vue'));
Vue.component('usuarios-invitation', require('./components/Usuarios/UsuariosSendInvitation.vue'));
Vue.component('usuarios-new', require('./components/Usuarios/UsuariosNew.vue'));
Vue.component('usuarios-reasignar-proyectos', require('./components/Usuarios/UsuariosReasignarProyectos.vue'));
Vue.component('usuarios-show-prfile', require('./components/Usuarios/UsuariosShowProfile.vue'));
Vue.component('usuarios-edit-prfile', require('./components/Usuarios/UsuariosEditProfile.vue'));

Vue.component('proyectos-index', require('./components/Proyectos/ProyectosIndex.vue'));
Vue.component('proyectos-create', require('./components/Proyectos/ProyectosCreate.vue'));
Vue.component('proyecto-users', require('./components/Proyectos/ProyectoUsers.vue'));
Vue.component('proyectos-edit', require('./components/Proyectos/ProyectosEdit.vue'));
Vue.component('proyectos-show', require('./components/Proyectos/ProyectosShow.vue'));
Vue.component('proyectos-show-all', require('./components/Proyectos/ProyectosShowAll.vue'));
Vue.component('proyectos-index-all', require('./components/Proyectos/ProyectosIndexAll.vue'));
Vue.component('proyectos-index-alls', require('./components/Proyectos/ProyectosIndexAllS.vue'));

Vue.component('activos-index', require('./components/Activos/ActivosIndex.vue'));
Vue.component('crud-index', require('./components/Crud/Index.vue'));
Vue.component('side-bar', require('./components/StyleComponents/SideBar.vue'));
Vue.component('home-component', require('./components/Home.vue'));

Vue.component('subproyectos-show', require('./components/SubProyectos/SubProyectosShow.vue'));
Vue.component('glosario-show', require('./components/Glosario/GlosarioShow.vue'));
Vue.component('glosario-modal', require('./components/Glosario/GlosarioModal.vue'));
Vue.component('manual-usuario-show', require('./components/ManualUsuario/ManualUsuarioShow.vue'));
Vue.component('activos-modal-info', require('./components/Activos/ActivoModalInfo.vue'));
Vue.component('password-edit', require('./components/Usuarios/PasswordEdit.vue'));
Vue.component('app-side-bar', require('./components/StyleComponents/AppSideBar.vue'));
Vue.component('activos-modal-step', require('./components/Activos/ActivoModalStep.vue'));

Vue.component('activos-descripcion', require('./components/Activos/ActivosDescripcion.vue'));
Vue.component('activos-clasificacion', require('./components/Activos/ActivosClasificacion.vue'));
Vue.component('activos-estado', require('./components/Activos/ActivosEstado.vue'));
Vue.component('activos-dpi-asociado', require('./components/Activos/ActivosDPIAsociado.vue'));
Vue.component('activos-estado-actual', require('./components/Activos/ActivosEstadoActual.vue'));
Vue.component('activos-comentarios', require('./components/Activos/ActivosComentarios.vue'));
Vue.component('activos-plan-proteccion', require('./components/Activos/ActivosPlanProteccion.vue'));
Vue.component('activos-priorizacion', require('./components/Activos/ActivosPriorizacion.vue'));
Vue.component('activos-uso-comercial', require('./components/Activos/ActivosUsoComercial.vue'));
Vue.component('activos-estrategias-gestion', require('./components/Activos/ActivosEstrategiasDeGestion.vue'));
Vue.component('activos-index-all', require('./components/Activos/ActivosIndexAll.vue'));
Vue.component('activos-modal-create', require('./components/Activos/ActivoModalCreate.vue'));
Vue.component('subproyectos-create', require('./components/SubProyectos/SubProyectosCreate.vue'));
Vue.component('subproyectos-edit', require('./components/SubProyectos/SubProyectosEdit.vue'));
Vue.component('subproyectos-create-all', require('./components/SubProyectos/SubProyectosCreateAll.vue'));

Vue.component('doughnut-chart' , require('./components/Charts/DoughnutChart.vue'));
Vue.component('pie-chart' , require('./components/Charts/PieChart.vue'));

Vue.component('back-button' , require('./components/Utilities/BackButton.vue'));
Vue.component('activo-historial' , require('./components/Activos/ActivoHistorial.vue'));
Vue.component('activo-modal-historial' , require('./components/Activos/ActivoModalHistorial.vue'));
Vue.component('reporte-index' , require('./components/Reportes/ReporteIndex.vue'));
Vue.component('reporte-modal' , require('./components/Reportes/ReporteModal.vue'));
Vue.component('descarga-modal' , require('./components/Reportes/DescargaModal.vue'));

Vue.component('busqueda' , require('./components/Utilities/Busqueda.vue'));
Vue.component('search-bar' , require('./components/Utilities/SearchBar.vue'));


const routes = [

    { path: '',
      redirect: {name: 'activo'}
    },

    { path: '/activo',
      name: 'activo', 
      component: require('./components/Activos/ActivosInfo.vue')
    },
    
    { path: '/diligencia/descripcion',
      name: 'descripcion',
      component: require('./components/Activos/ActivosDescripcion.vue')
    },

    {
      path: '/diligencia/clasificacion',
      name: 'clasificacion',
      component: require('./components/Activos/ActivosClasificacion.vue')
    },
    {
      path: '/diligencia/estado',
      name: 'estado',
      component: require('./components/Activos/ActivosEstado.vue')
    },
    {
      path: '/diligencia/dpiAsociado',
      name: 'dpiAsociado',
      component: require('./components/Activos/ActivosDPIAsociado.vue')
    },

    {
      path: '/diligencia/estadoActual',
      name: 'estadoActual',
      component: require('./components/Activos/ActivosEstadoActual.vue')
    },

    {
      path: '/diligencia/comentarios',
      name: 'comentarios',
      component:  require('./components/Activos/ActivosComentarios.vue')
    },

    {
      path: '/diligencia/proteccion',
      name: 'proteccion',
      component: require('./components/Activos/ActivosPlanProteccion.vue')
    },

    {
      path: '/diligencia/priorizacion',
      name: 'priorizacion',
      component: require('./components/Activos/ActivosPriorizacion.vue')
    },

    {
      path: '/diligencia/usoComercial',
      name: 'usoComercial',
      component: require('./components/Activos/ActivosUsoComercial.vue')
    },

    {
      path: '/diligencia/estrategiasGestion',
      name: 'estrategiasGestion',
      component: require('./components/Activos/ActivosEstrategiasDeGestion.vue')
    }

  ] 

  const router = new VueRouter({
    routes
  });

const app = new Vue({
    router
}).$mount('#app');

