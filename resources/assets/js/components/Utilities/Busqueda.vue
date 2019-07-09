<template lang="html">

    <div>
        <span class="header-table">Búsqueda</span>

        <div class="card-create-container" style="max-width: 1000px; float: left; width: 100%; margin-top: 30px;">

            <div v-if=" (proyectos.length + sub_proyectos.length + activos.length) > 0">


                <span class="header-table" style="font-weight: bold; font-size: 20px; font-family: Open Sans">Resultados de la búsqueda para "{{busqueda}}":</span>

                <div class="chunk" v-if="proyectos.length > 0">
                    <span class="header-table" style="font-weight: bold; font-size: 20px; font-family: Open Sans">Grupos de investigación: </span>
                    <ul>
                        <li v-for="proyecto in proyectos"> <a :href="`/proyectos/${proyecto.id}`">{{ proyecto.nombre }}</a></li>
                    </ul>
                </div>


                <div class="chunk"  v-if="sub_proyectos.length > 0">
                    <span class="header-table" style="font-weight: bold; font-size: 20px; font-family: Open Sans">Proyectos: </span>
                    <ul>
                        <li v-for="subProyecto in sub_proyectos" ><a :href="`/subproyectos/${subProyecto.id}`">{{ subProyecto.nombre }}</a></li>
                    </ul>
                </div>

                <div class="chunk" v-if=" activos.length > 0 ">
                    <span class="header-table" style="font-weight: bold; font-size: 20px; font-family: Open Sans">Activos: </span>
                    <ul>
                        <li v-for="activo in activos"> <a :href="`/activos/show/${activo.id}`" >{{ activo.nombre_asociado }}</a></li>
                    </ul>
                </div>

            </div>

            <div v-else>
                <span class="header-table" style="font-weight: bold; font-size: 20px; font-family: Open Sans">No se han encontrado resultados para "{{busqueda}}".</span>
            </div>

        </div>

    </div>

</template>

<style>

div.chunk ul {
    list-style:none;
}

.chunk li {
    margin-top: 3px;
}

div.chunk li:before {
    font-family: 'FontAwesome';
    content: '\f058';
    margin:0 10px 0 -15px;
    color: #88A6B0;
    font-size: 17px;
}

div.chunk li span {
    font-family: "Open Sans";
    color: #88A6B0;
    font-size: 16px;
}

</style>

<script>

export default {
    props: ['activos', 'sub_proyectos', 'proyectos', 'busqueda'],
    data() {
        return {

        }
    }
}
</script>
