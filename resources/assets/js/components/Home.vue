<template lang="html">
<div>
  <div style="margin-left: 20px;">
    <h4 class="step-title " style="margin:0">Bienvenido</h4>
    <h4 class="step-title " style="font-family: 'Open Sans'; font-size: 28px">{{user.name}}</h4>
    <br>
    <span class="step-title" style="font-family: 'Open Sans'; font-size: 20px">Usted está asociado a:</span>
  </div>

    <div class="home-container">

        <!-- <div class="header-home">Inventario de activos intangibles</div> -->

        <div class="card-home" style="background-color: #990000;" @click="onClick('/mis_proyectos')">
            <img src="images/grupos.png" class="img-rounded">
            <div class="card-home-data">
              <span>{{proyectos_count}}</span>
              <br>
              <span>{{ (proyectos_count != 1) ? 'grupos de investigación' : 'grupo de investigación'}}</span>
            </div>
        </div>

        <div style="background-color: #E93A3A;" class="card-home"@click="onClick('todos_mis_activos')">
            <img src="images/activos.png" class="img-rounded">
            <div class="card-home-data">
              <span>{{activos_count}}</span>
              <br>
              <span>{{ (activos_count != 1) ? 'activos' : 'activo'}}</span>
            </div>
        </div>

        <div v-if="role.name == 'admin'" style="background-color:#990000;" class="card-home" @click="onClick('/users')">
            <img src="images/users.png" class="img-rounded">
            <div class="card-home-data">
              <span>{{users_count}}</span>
              <br>
              <span>{{ (users_count != 1) ? 'usuarios' : 'usuario'}}</span>
            </div>
        </div>

    </div>
    
     <div class="col-md-10 col-md-offset-1 sub-card" style="background-color: white;  display: flex;
        display: -webkit-flex;  margin-bottom: 80px;
        border-radius: 10px;
        flex-wrap: wrap;">

         <div class="col-md-6" style="border-right: dotted #53c5cf;
    border-width: thin;">
            <h4 class="step-title">Estado de los activos intangibles</h4>
            <br>
            <div class="center-doughnut">
              <doughnut-chart :width="250"  :chart-data="char_data" :options="{ responsive: false, maintainAspectRatio: false}"></doughnut-chart>
            </div>
          </div>
          
          <div class="col-md-6" style="" >
            <h4 class="step-title" style="margin-bottom: 30px">Últimos activos modificados</h4>
            
            <table  class="last-updates">
              <tbody style="padding:20px;">
                    <tr v-for="activo in last_activos" style="padding:5px;">
                      <td><a :href="`/activos/show/${activo.id}`">{{activo.nombre_asociado}}</a></td>
                      <td>
                        <i v-if="activo.estado_diligencia == 'Terminado'" style="color: #00a651; font-size:1.5em;" class="fa fa-battery-full" aria-hidden="true"></i>
                        <i v-else style="color: #f58345; font-size:1.5em;" class="fa fa-battery-half" aria-hidden="true"></i>
                      </td>
                    </tr>
                </tbody>
            </table>


            
          </div>

      </div>

 </div>
</template>

<script>

export default {
  props: ['role', 'proyectos_count', 'activos_count', 'users_count', 'char_data', 'last_activos', 'user'],
  methods: {
      onClick(url) {
        window.location.href = url;
      }
  },

  mounted: function(){
    console.log(this.char_data);
  }

}

</script>


<style lang="scss">
$container-lateral-padding: 20px;

.center-doughnut {
  margin-left: 50px;
}

.last-updates {
  width: 100%
}

.last-updates tbody tr {
    height: 50px;
    border-bottom: solid #53c5cf;
    border-width: thin;
}

.last-updates tbody tr:last-child {
    border-bottom: none;
}


.last-updates tbody tr td:first-child {
    border-right: dotted #53c5cf;
    border-width: thin;
    width: 200px;
}

.last-updates tbody tr td:last-child {
  padding-left: 20px;
}

@media only screen and (max-width: 991px) {
    .center-doughnut {
        margin-left: 10px;
    }
}

.home-container {
  display: grid;
  height: 100%;
  grid-template-columns: auto auto auto;
  grid-gap: 30px;
  padding-left: $container-lateral-padding;
  padding-right: $container-lateral-padding;
  padding-top: 20px;
  padding-bottom: 50px;
}

.header-home {
  background-color: rgba(255, 255, 255, 0.8);
  border-radius: 10px;
  background-color: #009688;
  color: white;
  grid-area: 1 / 1 / span 1 / span 3;
  margin-bottom: 70px;
  height: 80px;
  line-height: 80px;
  text-align: center;
  font-size: 30px;
  font-weight: 900;
}

.reports-home {
  grid-area: 2 / 1 / span 1 / span 3;
  min-height: 500px;
  background-color: #fff;
}

.card-home {
  cursor: pointer;
  border-radius: 10px;
  width: 300px;
  height: 150px;
  padding-left: 30px;
  text-align: center;
  font-size: 30px;
  color:white;
  line-height: 1;
  img {
    float: left;
    width: 80px;
    margin-top: 30px;
  }

  .card-home-data {
    text-align: left;
    padding-top: 20px;
    margin-left: 100px;
  }
}

.card-home-data span:first-child {
    padding-top: 30px;
    font-size: 45px;
  }

.card-home-data span:last-child {
    padding-top: 30px;
    font-size: 25px;
    font-weight: bold;
  }


</style>