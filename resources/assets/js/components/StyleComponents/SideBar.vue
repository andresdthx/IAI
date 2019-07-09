<template lang="html">

    <div>
        
      <div>
          <router-view></router-view>
      </div>

      <notifications v-if="openNotification" group="foo" position="bottom right" :duration="1000*60">
        <template slot="body" slot-scope="props">
            <div class="my-notification-style">
                <span class="close-notification glyphicon glyphicon-remove" @click="onCloseNotification(props.close)"></span>
                <div @click="onClickNotification(props.close)">
                    <span class="notification-title"> {{props.item.title}}</span>
                    
                    <br><br>
                    <div class="notification-text" v-html="props.item.text"></div>

                </div>
            </div>
        </template>
      </notifications>

    <activos-modal-info
        v-if="openModalHelp" 
        @close="onCloseModal()"
        :data="infoModal" >
    </activos-modal-info>

    </div>
    </div>

</template>

<script>
import store from "../../store";
import axios from "axios";

export default {
  store,
  props: ["activo_id"],

  data() {
    return {
      open: false,
      subMenu: false,
      openNotification: true,
      openModalHelp: false,
      infoModal: {title: 'Diligenciamiento de un activo intangible.'} 
    };
  },

  mounted() {
    this.$notify({
        group: 'foo',
        title: 'Necesitas ayuda?',
        text: 'Da click aqui para recibir información sobre como comenzar el diligenciamiento del activo.'
    });
  },


  created() {
    if (!store.data) {
      axios.get(`/activos/showApi/${this.activo_id}`)
        .then(response => {
          let data = response.data;
          let estrategias = _.map( data.side_menu.steps.estrategias , item => {
                                        item.error = false;
                                        item.click = false;
                                        return item;
                                  });

          data.side_menu.steps.estrategias = estrategias;
          store.commit('setActivo', data);
        })
        .catch(e => {
          console.log(e);
        });
    }
  },

  computed: {
    side_menu: function() {
      return store.getters.data;
    },

    activo: function() {
      return store.getters.mainInfo;
    },
    
    data: function() {
      let path = _.filter(this.$route.path.split("/"), x => x != "");

      return _.mapValues(this.side_menu, (item, key) => {
        item.selected = item.url == path[0];
        if (item.submenus) {
          _.mapValues(item.submenus, subItem => {
            if (path.length > 1) {
              subItem.selected = subItem.url == path[1];
            } else {
              subItem.selected = false;
            }
            return subItem;
          });
        }
        return item;
      });
    }
  },

  methods: {

    onCloseModal: function() {
      this.openModalHelp = false;
    },

    onCloseNotification: function(callback) {
      this.openNotification = false;
      callback();
    },

    onClickNotification: function(callback) {
      this.openNotification = false;
      this.openModalHelp = true;
      callback();
    },

    foo: function(item) {
      console.log(item);
    },

    sortMenu: function(list, field) {
      return _.sortBy(list, item => item[field]);
    },

    onClickButton: function() {
      this.open = !this.open;
    },

    round: function(number) {
      return number % 1 == 0 ? number * 100 : (number * 100).toFixed(2);
    },

    onSubMenu: function() {
      this.subMenu = !this.subMenu;
    }
  }
};
</script>

<style>

.super-container {
  display: grid;
  grid-template-columns: 40px auto;
  height: 100vh;
}

.super-container-open {
  display: grid;
  grid-template-columns: 320px auto;
  height: 100vh;
}

.selected {
  width: 3px;
  background-color: white;
  height: 100%;
}

.tittle {
  position: relative;
  text-align: center;
  width: 100%;
  height: 50px;
  top: 40px;
}

.tittle h4 {
  color: white;
}

.main-menu li:hover > a,
nav.main-menu li.active > a,
.dropdown-menu > li > a:hover,
.dropdown-menu > li > a:focus,
.dropdown-menu > .active > a,
.dropdown-menu > .active > a:hover,
.dropdown-menu > .active > a:focus,
.no-touch .dashboard-page nav.dashboard-menu ul li:hover a,
.dashboard-page nav.dashboard-menu ul li.active a {
  color: #fff;
  background-color: #5fa2db;
}

.fa-2x {
  font-size: 2em;
}

.main-menu .nav-text-available {
  padding-left: 10px;
  position: relative;
  display: table-cell;
  vertical-align: middle;
  width: 280px;
  font-family: "Titillium Web", sans-serif;
}

.fa {
  position: relative;
  display: table-cell;
  width: 40px;
  height: 36px;
  text-align: center;
  vertical-align: middle;
  font-size: 20px;
}

.main-menu {
  width: 40px;
  height: 100vh;
  position: fixed;
  overflow: hidden;
  cursor: default;
  background-color: #212121;
}

.main-menu-open {
  width: 320px;
  height: 100vh;
  position: fixed;
  overflow: hidden;
  cursor: default;
  overflow: scroll;
  background-color: #212121;
}

.main-menu > ul {
  margin: 60px 0;
  padding-left: 0px;
}

.main-menu li {
  position: relative;
  display: block;
  width: 320px;
}

.main-menu li > a,
.main-menu li > span {
  height: 36px;
  position: relative;
  display: table;
  border-collapse: collapse;
  border-spacing: 0;
  color: #999;
  font-family: arial;
  font-size: 14px;
  text-decoration: none;
  -webkit-transform: translateZ(0) scale(1, 1);
  -webkit-transition: all 0.1s linear;
  transition: all 0.1s linear;
}

.transform {
  -webkit-transition: all 0.3s ease;
  -moz-transition: all 0.3s ease;
  -o-transition: all 0.3s ease;
  -ms-transition: all 0.3s ease;
  transition: all 0.3s ease;
}

.glyphicon.glyphicon-menu-right,
.glyphicon.glyphicon-menu-left {
  font-size: 20px;
  color: white;
}

.glyphicon.glyphicon-time {
  font-size: 25px;
}

.button-side {
  cursor: pointer;
  right: auto;
  left: 7px;
  top: 10px;
}
</style>
