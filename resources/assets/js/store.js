window.Vue = require('vue');
import Vuex from 'vuex';

Vue.use(Vuex)

export default new Vuex.Store({
  state: {
    count: 1,
    activo: {
        data: '',
        mainInfo: ''
    }
  },

  getters: {
    fileSize: state => state.activo.mainInfo ? state.activo.mainInfo.file_size : 0,
    counter: state => state.count * 2,
    dataReady: state => (state.activo.data != '' && state.activo.mainInfo != ''),
    data: state => state.activo.data,
    mainInfo: state => state.activo.mainInfo,
    descripcion: state => state.activo.data ? state.activo.data.steps.submenus['1'] : '',

    historial: state => {
      if (state.activo.mainInfo.historial) {
        let hist = _.map(state.activo.mainInfo.historial, item => {
          if (!item.init) {
            item.modal = false;
            item.select = true;
          }
          item.init = true;
          return item;
        });
        return (_.sortBy(hist, (item) => item.created_at)).reverse();
      } else {
        return ''
      }
    },

    step: state => { 
          return (step, process) => {
            if (state.activo.data) {
              return process(state.activo.data.steps.submenus[step]);
            } else { 
              return '';
            }
          }

    },

    isEstrategias: state => (_.size(state.activo.data.steps.estrategias) > 1) ,
    doughnoutDiligencia: state => {
      let number = state.activo.data.steps.percentage_complete;
      let complete = number%1==0 ? number*100 : (number*100).toFixed(2)
      let incomplete = 100 - complete;

      let labels = ['Completo', 'Incompleto'];
      let backgroundColor = ['green', '#f58345'];
      let data = [complete, incomplete];

      let x = {
        labels: labels,
        datasets: [
          {
            backgroundColor: backgroundColor,
            data: data
          }
        ]
      } 

      return x;
    },

    doughnoutData: state => { 

      let mapEstado = {
        warning: {label: 'Pendientes', color: '#f58345'},
        danger: {label: 'Pendientes urgentes', color: 'red'},
        good: {label: 'Satisfactorias', color: '#00a651'},
      }

      let group = _.filter( state.activo.data.steps.estrategias, item => item.campo != "estrategia_general" );
          group = _.sortBy( _.groupBy( group, item => item.estado ), item => item.estado );

      let labels = _.map(group, item => mapEstado[item[0].estado].label);

      let backgroundColor = _.map(group, item => mapEstado[item[0].estado].color);
      let data = _.map(group, item => _.size(item));


      let x =
      {
        labels: labels,
        datasets: [
          {
            backgroundColor: backgroundColor,
            data: data
          }
        ]
      }
      return x;
     },

     estrategiaGeneral: state => {
       let general = _.filter( state.activo.data.steps.estrategias, estrategia => estrategia.campo == 'estrategia_general' )[0];
       return general;
      }
  },

  mutations: {

    setActivo: (state, payload) => {
        state.activo.mainInfo = payload.activo;
        state.activo.data = payload.side_menu;
    },

    closeModalHist: (state, payload) => {
      let hist = _.map(state.activo.mainInfo.historial, item => {
        item.modal = false;
        return item;
      });
      state.activo.mainInfo.historial = hist;
    },

    clickHistorial: (state, id) => {

      let hist = _.map(state.activo.mainInfo.historial, item => {
        item.modal = item.id == id;
        return item;
      });

      state.activo.mainInfo.historial = hist;
    },

    filterHistorial: (state, ids) => {
      let hist = _.map(state.activo.mainInfo.historial, item => {

          item.select = ids.indexOf(item.commit_field) >= 0 ;
          return item
      });
      state.activo.mainInfo.historial = hist;
    },

    onClickEstrategia: (state, id) => {

      let estrategias = _.map( state.activo.data.steps.estrategias , item => {
                                if (item.id == id) {
                                  item.click = !item.click;
                                }
                                return item;
                          });

      state.activo.data.steps.estrategias = estrategias;
    },

    setDataStep: (state, payload) => {
        state.activo.data.steps.submenus[payload.step] = payload.data;
    }
  }

})