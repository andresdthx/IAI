<template lang="html">
    <div>

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


        <div>
            <span class="header-table" style="text-decoration: underline;font-size: 25px;">Grupo de investigación</span>
            <span class="header-table" style="font-size: 25px;">: {{subproyecto.proyecto.nombre}}</span>
        </div>

        <div>
            <span class="header-table" style="text-decoration: underline;font-size: 25px;">Proyecto</span>
            <span class="header-table" style="font-size: 25px;">: {{subproyecto.nombre}}</span>
        </div>

        <div>
            <img style="float: left; margin-right: 10px; padding-top: 5px" src="/images/user.png" alt="" width="20">
            <span class="header-table" style="font-weight: bold; font-size: 20px; font-family: 'Open Sans'">Director del grupo de investigación:</span>
            <span class="header-table" style=" font-size: 20px; font-family: 'Open Sans'"> {{user.director}} </span>
        </div>

        <div>
            <img style="float: left; margin-right: 10px; padding-top: 5px" src="/images/user.png" alt="" width="20">
            <span class="header-table" style="font-weight: bold; font-size: 20px; font-family: 'Open Sans'">Responsable del inventario del grupo de investigación:</span>
            <span class="header-table" style=" font-size: 20px; font-family: 'Open Sans'"> {{user.encargado.name}} </span>
        </div>

        <br><br>
        
        </h2>
    </div>

</template>


<script>
export default {
  props: ['user', 'subproyecto'],
}
</script>

