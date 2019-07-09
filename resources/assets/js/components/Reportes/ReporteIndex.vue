<template>

    <div>
        <div style="display: none">
            <canvas ref="myCanvas" id="myCanvas" width="200" height="100"></canvas>
        </div>

        <reporte-modal v-if="openModal"
            @close="closeModal"
            :activos="activosSelect"
            :type="type"
            :title="title">
        </reporte-modal>

        <descarga-modal v-if="openModalDescarga"
            @close="closeModalDescarga"
            @descargar="descargarPDF"
            :options="reportInfo"
        >

        </descarga-modal>

        <div>
            <span class="header-table" style="display: block; font-size: 25px;margin-bottom: 50px;">Reporte general</span>
            
            <div class="row">
                <div class="col-md-7">

                    <multiselect
                                v-model="selectedGrupos"
                                :options="grupos"
                                :multiple="true"
                                :close-on-select="false"
                                :clear-on-select="false"
                                :hide-selected="true"
                                :preserve-search="true"
                                select-label="Presiona enter para seleccionar"
                                placeholder="Seleccionar grupos"
                                label="nombre"
                                track-by="id">
                    </multiselect>
                </div>

                <div class="col-md-5">
                    <button class="btn-info btn" @click="selectAll" ><span>Seleccionar todos</span></button>
                    <button class="btn-info btn" style="background-color: #B80808" @click="deleteAll" ><span>Borrar todos</span></button>
                </div>

            </div>

        <button class="btn-add btn" @click="getInfo" style="margin-left: 0px;margin-top: 20px;margin-right: 10px;border-color: rgb(48, 151, 209);background-color: rgb(48, 151, 209);"><span>Generar reporte</span></button>
        <button v-if="generateCharts" style="margin-left: 0px;margin-top: 20px;margin-right: 10px;border-color: rgb(122, 184, 0);background-color: rgb(122, 184, 0);" @click="openModalDescarga = true" class="btn-add btn">Descargar PDF</button>
        <button v-else class="btn-add btn" style="margin-left: 0px;margin-top: 20px" disabled>Descargar PDF</button>

        <div class="card-index-container card-chart" :style="`width: 1000px;height: ${displayCharts[10] ? 'auto' : '50px'};`" >

            <span style="font-size: 18px;font-family: 'Zil Semi Slab';">Información sobre los grupos de investigación</span>
            <div :class="displayCharts[10] ? 'button-show-charts': 'button-hidden-charts'" @click="toogleDisplay(10)">
                <i :class="`fa fa-chevron-${displayCharts[10] ? 'up': 'down'}`" aria-hidden="true"></i>
            </div>
            <ul style="text-align: initial; margin-top: 20px;" v-if="displayCharts[10]">
                <li v-for="grupo in grupos_display" v-bind:key="grupo.id">{{grupo.nombre}}
                    <ul>
                        <li>Número de proyectos: {{grupo.sub_proyectos.length}}</li>
                        <li style="inline-block;"><span style="color: #216a94"><span @click="toogleDisplayProyectos(grupo.id)" style="cursor: pointer;display:" >Ver proyectos</span> <i :class="`fa fa-chevron-${grupo.display_proyectos ? 'up': 'down'}`" aria-hidden="true"></i></span> 
                            <ul v-if="grupo.display_proyectos">
                                <li v-for="proyecto in grupo.sub_proyectos" v-bind:key="proyecto.id" >{{proyecto.nombre}}
                                    <ul style="cursor: inital">
                                        <li>Número de activos: {{proyecto.activos.length}}</li>

                                            <li style="inline-block;">
                                                <span style="color: #216a94"><span @click="toogleDisplayActivos(grupo.id, proyecto.id)" style="cursor: pointer;display:" >Ver activos</span> <i :class="`fa fa-chevron-${proyecto.display_activos ? 'up': 'down'}`" aria-hidden="true"></i></span> 
                                                <ul v-if ="proyecto.display_activos" >
                                                    <li v-for="activo in proyecto.activos" v-bind:key="activo.id">{{activo.nombre_asociado}}</li>
                                                </ul>
                                            </li>
                                    </ul>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </li> 
            </ul>
        </div>

        <div class="card-index-container card-chart" :style="`width: 1000px;height: ${displayCharts[0] ? '550px' : '50px'};`" >

            <span style="font-size: 18px;font-family: 'Zil Semi Slab';" >DPI asociados a los AI</span>
            <div :class="displayCharts[0] ? 'button-show-charts': 'button-hidden-charts'" @click="toogleDisplay(0)">
                <i :class="`fa fa-chevron-${displayCharts[0] ? 'up': 'down'}`" aria-hidden="true"></i>
            </div>

            <div :style="`display: ${displayCharts[0] ? 'block' : 'none'}; padding-left: 230px;` " >
                <pie-chart :width="450" :height="450" ref="dpi_chart" @click-pie="clickChartDPI" :chartData="dpi_chart"  title="DPI asociados a los AI"></pie-chart>
            </div>
            
        </div>

        <div class="card-index-container card-chart" :style="`width: 1000px;height: ${displayCharts[1] ? '550px' : '50px'};`">
            <span style="font-size: 18px;font-family: 'Zil Semi Slab';" >AI segun su clasificación</span>
            <div :class="displayCharts[1] ? 'button-show-charts': 'button-hidden-charts'" @click="toogleDisplay(1)">
                <i :class="`fa fa-chevron-${displayCharts[1] ? 'up': 'down'}`" aria-hidden="true"></i>
            </div>
            <div :style="`display: ${displayCharts[1] ? 'block' : 'none'};padding-left: 230px;`" >
                <pie-chart :width="450" :height="450"  ref="clasificacion_chart" @click-pie="clickChartClasificacion" :chartData="clasificacion_chart"  title="AI segun su clasificación"></pie-chart>
            </div>
        </div>

        <div class="card-index-container card-chart" :style="`width: 1000px;height: ${displayCharts[2] ? '550px' : '50px'};`">
            <span style="font-size: 18px;font-family: 'Zil Semi Slab';">AI con contrato de cesión</span>
            <div :class="displayCharts[2] ? 'button-show-charts': 'button-hidden-charts'" @click="toogleDisplay(2)">
                <i :class="`fa fa-chevron-${displayCharts[2] ? 'up': 'down'}`" aria-hidden="true"></i>
            </div>
            <div :style="`display: ${displayCharts[2] ? 'block' : 'none'};padding-left: 240px`" >
                <pie-chart :width="450" :height="450" ref="cesion_chart" @click-pie="clickChartCesion" :chartData="cesion_chart"  title="AI con contrato de cesión"></pie-chart>
            </div>
        </div>

        <div class="card-index-container card-chart" :style="`width: 1000px;height: ${displayCharts[3] ? '550px' : '50px'};`">
            <span style="font-size: 18px;font-family: 'Zil Semi Slab';">AI con acuerdos de confidencialidad</span>
            <div :class="displayCharts[3] ? 'button-show-charts': 'button-hidden-charts'" @click="toogleDisplay(3)">
                <i :class="`fa fa-chevron-${displayCharts[3] ? 'up': 'down'}`" aria-hidden="true"></i>
            </div>
            <div :style="`display: ${displayCharts[3] ? 'block' : 'none'};padding-left: 240px`" >
                <pie-chart :width="450" :height="450" ref="confidencialidad_chart" @click-pie="clickChartConfidencialidad" :chartData="confidencialidad_chart"  title="AI con acuerdos de confidencialidad"></pie-chart>
            </div>
        </div>

        <div class="card-index-container card-chart" :style="`width: 1000px;height: ${displayCharts[4] ? '550px' : '50px'};`">
            <span style="font-size: 18px;font-family: 'Zil Semi Slab';">AI según su estado</span>
            <div :class="displayCharts[4] ? 'button-show-charts': 'button-hidden-charts'" @click="toogleDisplay(4)">
                <i :class="`fa fa-chevron-${displayCharts[4] ? 'up': 'down'}`" aria-hidden="true"></i>
            </div>
            <div :style="`display: ${displayCharts[4] ? 'block' : 'none'};padding-left: 240px`" >
                <pie-chart :width="450" :height="450" ref="estados_chart" @click-pie="clickChartEstado" :chartData="estados_chart"  title="AI según su estado"></pie-chart>
            </div>
        </div>


        <div class="card-index-container card-chart" :style="`width: 1000px;height: ${displayCharts[5] ? '550px' : '50px'};`">
            <span style="font-size: 18px;font-family: 'Zil Semi Slab';">AI con sugerencia de deposito/registro</span>
            <div :class="displayCharts[5] ? 'button-show-charts': 'button-hidden-charts'" @click="toogleDisplay(5)">
                <i :class="`fa fa-chevron-${displayCharts[5] ? 'up': 'down'}`" aria-hidden="true"></i>
            </div>
            <div :style="`display: ${displayCharts[5] ? 'block' : 'none'};padding-left: 240px`" >
                <pie-chart :width="450" :height="450" ref="depositos_chart" @click-pie="clickChartDepositos" :chartData="depositos_chart"  title="AI con sugerencia de deposito/registro"></pie-chart>
            </div>
        </div>

        <div class="card-index-container card-chart" :style="`width: 1000px;height: ${displayCharts[6] ? '550px' : '50px'};`">
            <span style="font-size: 18px;font-family: 'Zil Semi Slab';">AI con deposito/registro asociado</span>
            <div :class="displayCharts[6] ? 'button-show-charts': 'button-hidden-charts'" @click="toogleDisplay(6)">
                <i :class="`fa fa-chevron-${displayCharts[6] ? 'up': 'down'}`" aria-hidden="true"></i>
            </div>
            <div :style="`display: ${displayCharts[6] ? 'block' : 'none'};padding-left: 240px`" >
                <pie-chart :width="450" :height="450" ref="registros_chart" @click-pie="clickChartRegistros" :chartData="registros_chart"  title="AI con deposito/registro asociado"></pie-chart>
            </div>
        </div>

        
        <div class="card-index-container card-chart" :style="`width: 1000px;height: ${displayCharts[7] ? '550px' : '50px'};`">
            <span style="font-size: 18px;font-family: 'Zil Semi Slab';">AI a los que se les sugiere tomar medidas razonables para conservar como secreto</span>
            <div :class="displayCharts[7] ? 'button-show-charts': 'button-hidden-charts'" @click="toogleDisplay(7)">
                <i :class="`fa fa-chevron-${displayCharts[7] ? 'up': 'down'}`" aria-hidden="true"></i>
            </div>
            <div :style="`display: ${displayCharts[7] ? 'block' : 'none'};padding-left: 240px`" >
                <pie-chart :width="450" :height="450" ref="se_chart" @click-pie="clickChartSE" :chartData="se_chart"  title="AI a los que se les sugiere tomar medidas razonables para conservar como secreto"></pie-chart>
            </div>
        </div>

        <div class="card-index-container card-chart" :style="`width: 1000px;height: ${displayCharts[8] ? '550px' : '50px'};`">
            <span style="font-size: 18px;font-family: 'Zil Semi Slab';">AI incorporados en contabilidad</span>
            <div :class="displayCharts[8] ? 'button-show-charts': 'button-hidden-charts'" @click="toogleDisplay(8)">
                <i :class="`fa fa-chevron-${displayCharts[8] ? 'up': 'down'}`" aria-hidden="true"></i>
            </div>
            <div :style="`display: ${displayCharts[8] ? 'block' : 'none'};padding-left: 240px`" >
                <pie-chart :width="450" :height="450" ref="contabilidad_chart" @click-pie="clickChartContabilidad" :chartData="contabilidad_chart"  title="AI incorporados en contabilidad"></pie-chart>
            </div>
        </div>

        <div class="card-index-container card-chart" :style="`width: 1000px;    margin-bottom: 50px; margin-bottom: 200px; height: ${displayCharts[9] ? '550px' : '50px'};`">
            <span style="font-size: 18px;font-family: 'Zil Semi Slab';">AI que requieren de herramientas de priorización</span>
            <div :class="displayCharts[9] ? 'button-show-charts': 'button-hidden-charts'" @click="toogleDisplay(9)">
                <i :class="`fa fa-chevron-${displayCharts[9] ? 'up': 'down'}`" aria-hidden="true"></i>
            </div>
            <div :style="`display: ${displayCharts[9] ? 'block' : 'none'};padding-left: 240px`" >
                <pie-chart :width="450" :height="450" ref="priorizacion_chart" @click-pie="clickChartPriorizacion" :chartData="priorizacion_chart"  title="AI que requieren de herramientas de priorización"></pie-chart>
            </div>
        </div>

      

        </div>
    </div>
</template>

<style lang="scss">

    %button-charts {
        width:  30px;
        height:  30px;
        border-radius: 50%;
        cursor: pointer;
        display: inline-block;
        float: right;
    }

    .card-chart {
        margin-bottom: 0px;
        margin-top: 35px;
        text-align: center;
        padding-top: 10px;
        -webkit-touch-callout: none; /* iOS Safari */
        -webkit-user-select: none; /* Safari */
        -khtml-user-select: none; /* Konqueror HTML */
        -moz-user-select: none; /* Firefox */
        -ms-user-select: none; /* Internet Explorer/Edge */
        user-select: none; /* Non-prefixed version, currently*/
    }

    .button-show-charts {
        @extend %button-charts;
        border: solid black;
        border-width: thin;
        padding-top: 2px;
        padding-left: 1px;
    }

    .button-hidden-charts {
        @extend %button-charts;
        color: white;
        background-color: black;
        padding-top: 4px;
        padding-left: 1px;
    }
</style>

<script>

import Multiselect from 'vue-multiselect';
import axios from 'axios';
import jspdf from 'jspdf';
import autotable from 'jspdf-autotable';
import customfonts from 'jspdf-customfonts';

export default {
    props: ['grupos'],
    components: {Multiselect},
    data() {
        return {
            selectedGrupos          : '',
            openModal               : false,
            openModalDescarga       : false,
            activosSelect           : '',
            type                    : '',
            title                   : '',
            reportInfo: [
                {key: 'informe_grupos',         nombre: 'Información sobre los grupos de investigación',                                    select: true},
                {key: 'dpi_chart',              nombre: 'DPI asociados a los AI',                                                           select: true},
                {key: 'clasificacion_chart',    nombre: 'AI segun su clasificación',                                                        select: true}, 
                {key: 'cesion_chart',           nombre: 'AI con contrato de cesión',                                                        select: true}, 
                {key: 'confidencialidad_chart', nombre: 'AI con acuerdos de confidencialidad',                                              select: true}, 
                {key: 'estados_chart',          nombre: 'AI según su estado',                                                               select: true}, 
                {key: 'depositos_chart',        nombre: 'AI con sugerencia de deposito/registro',                                           select: true}, 
                {key: 'registros_chart',        nombre: 'AI con deposito/registro asociado',                                                select: true}, 
                {key: 'se_chart',               nombre: 'AI a los que se les sugiere tomar medidas razonables para conservar como secreto', select: true}, 
                {key: 'contabilidad_chart',     nombre: 'AI incorporados en contabilidad',                                                  select: true}, 
                {key: 'priorizacion_chart',     nombre: 'AI que requieren de herramientas de priorización',                                 select: true} 
                ],

            generateCharts          : false,
            dpi_chart               : '',
            clasificacion_chart     : '', 
            cesion_chart            : '', 
            confidencialidad_chart  : '', 
            estados_chart           : '',
            depositos_chart         : '', 
            registros_chart         : '', 
            se_chart                : '', 
            contabilidad_chart      : '', 
            priorizacion_chart      : '',
            displayCharts           : _.map(new Array(11), x => true),

            grupos_display          : ''
        }
    },

    mounted() {

        var canvas = document.getElementById('myCanvas'),
        context = canvas.getContext('2d');

        let base_image = new Image();
        base_image.src = '/images/escuela.png';
        base_image.onload = function() {
            context.drawImage(base_image, 0, 0);
        }

        let gruposId = _.map(this.grupos, grupo => grupo.id);
            axios.post('/apiReport', {grupos: gruposId}).then( response => {

                let data = response.data;

                this.dpi_chart              = data.dpi_chart
                this.clasificacion_chart    = data.clasificacion_chart
                this.cesion_chart           = data.cesion_chart
                this.confidencialidad_chart = data.confidencialidad_chart
                this.estados_chart          = data.estados_chart
                this.depositos_chart        = data.depositos_chart
                this.registros_chart        = data.registros_chart
                this.se_chart               = data.se_chart
                this.contabilidad_chart     = data.contabilidad_chart
                this.priorizacion_chart     = data.priorizacion_chart

                this.generateCharts = true

                this.initDisplayCharts(this.grupos);

            }).catch( e => {
                console.log('error');
            });

    },

    methods: {

        roundToTwo: function(num) {
            return +(Math.round(num + "e+1")  + "e-1");
        },

        initDisplayCharts(grupos) {
            this.grupos_display = _.map(grupos, grupo => {
                    grupo.display_proyectos = false;
                    grupo.sub_proyectos = _.map(grupo.sub_proyectos, proyecto => {
                        proyecto.display_activos = false;
                        return proyecto;
                    })
                    return grupo;
                });
        },

        toogleDisplayProyectos(index) {
            this.grupos_display = _.map(this.grupos_display, grupo => {
                grupo.display_proyectos =  (grupo.id == index) ? !grupo.display_proyectos : grupo.display_proyectos;
                return grupo;
            });
        },

        toogleDisplayActivos(grupoId, proyectoId) {

            this.grupos_display = _.map(this.grupos_display, grupo => {

                if (grupo.id == grupoId) {
                    grupo.sub_proyectos = _.map(grupo.sub_proyectos, proyecto => {
                        proyecto.display_activos = (proyecto.id == proyectoId) ? !proyecto.display_activos : proyecto.display_activos;
                        return proyecto;
                    });
                }

                return grupo;
            });

        },

        toogleDisplay: function(index) {

            this.displayCharts = _.map( this.displayCharts, (x, ind) => {
                return (ind == index) ? !x : x;
            })
        },

        descargarPDF: function(options) {
            var doc = new jspdf();

            let marginTop= 23;
            var imgData = this.$refs.myCanvas.toDataURL('image/png');
            let pages = 0;

            var charts = [
                {
                    name: this.$refs.dpi_chart.$refs.canvas.toDataURL('image/png'),
                    key: 'dpi_chart',
                    x: 10,
                    y: 25,
                    width: 190,
                    heigth: 90
                },

                {
                    name: this.$refs.clasificacion_chart.$refs.canvas.toDataURL('image/png'),
                    key: 'clasificacion_chart',
                    x: 10,
                    y: 130,
                    width: 190,
                    heigth: 80
                },

                {
                    name: this.$refs.cesion_chart.$refs.canvas.toDataURL('image/png'),
                    key: 'cesion_chart',
                    x: 10,
                    y: 230,
                    width: 180,
                    heigth: 80
                },

                {
                    name: this.$refs.confidencialidad_chart.$refs.canvas.toDataURL('image/png'),
                    key: 'confidencialidad_chart',
                    x: 10,
                    y: 330,
                    width: 190,
                    heigth: 80
                },

                {
                    name: this.$refs.estados_chart.$refs.canvas.toDataURL('image/png'),
                    key: 'estados_chart',
                    x: 10,
                    y: 430,
                    width: 190,
                    heigth: 80
                },

                {
                    name: this.$refs.depositos_chart.$refs.canvas.toDataURL('image/png'),
                    key: 'depositos_chart',
                    x: 10,
                    y: 530,
                    width: 190,
                    heigth: 80
                },

                 {
                    name: this.$refs.registros_chart.$refs.canvas.toDataURL('image/png'),
                    key: 'registros_chart',
                    x: 10,
                    y: 630,
                    width: 190,
                    heigth: 80
                },

                {
                    name: this.$refs.se_chart.$refs.canvas.toDataURL('image/png'),
                    key: 'se_chart',
                    x: 10,
                    y: 730,
                    width: 190,
                    heigth: 80
                },

                {
                    name: this.$refs.contabilidad_chart.$refs.canvas.toDataURL('image/png'),
                    key: 'contabilidad_chart',
                    x: 10,
                    y: 830,
                    width: 190,
                    heigth: 80
                },

                {
                    name: this.$refs.priorizacion_chart.$refs.canvas.toDataURL('image/png'),
                    key: 'priorizacion_chart',
                    x: 10,
                    y: 930,
                    width: 190,
                    heigth: 80
                },
            ]
            
            // doc.addFileToVFS('../../../../fonts/', Base64content);
            // doc.addFont('zil.ttf', 'Zil Semi Slab', 'normal');
            // doc.setFont('Zil Semi Slab');

            doc.setFontSize(20);
            doc.addImage(imgData, 'PNG', 180, 5, 30, 15);

            var textWidth = doc.getStringUnitWidth("Reporte general") * doc.internal.getFontSize() / doc.internal.scaleFactor;
            var textOffset = (210.00197555866663 - textWidth) / 2;
            doc.text('Reporte general', textOffset, marginTop);

            doc.setFontSize(13);

            if (_.filter(options, report => (report.key == 'informe_grupos' && report.select) ).length > 0) {

                let columns =['Grupo de investigación', 'Proyecto', 'Activo intangible'];
                let rows = [];

                _.each(this.grupos_display, grupo => {
                        let n_grupo,
                            n_proyecto,
                            n_activo

                        n_grupo = grupo.nombre.replace('“', '"').replace('”', '"'),
                    _.each(grupo.sub_proyectos, proyecto => {
                        n_proyecto = proyecto.nombre.replace('“', '"').replace('”', '"'),
                        _.each(proyecto.activos, activo => {
                            n_activo = activo.nombre_asociado.replace('“', '"').replace('”', '"')
                            rows.push([n_grupo, n_proyecto, n_activo])
                        })
                        if (proyecto.activos.length == 0) {
                            rows.push([n_grupo, n_proyecto, 'No tiene activos intangibles'])
                        }
                    })
                    if (grupo.sub_proyectos.length == 0) {
                        rows.push([n_grupo, 'No tiene proyectos', 'No tiene activos intangibles'])
                    }
                })

                let textWidth = doc.getStringUnitWidth('Información sobre los grupos de investigación') * doc.internal.getFontSize() / doc.internal.scaleFactor;
                doc.text('Información sobre los grupos de investigación', 10, 35);
                doc.setFillColor(0,166,81);
                doc.rect(10, 36, textWidth, 0.5, 'F');
                doc.autoTable(columns, rows, {
                    margin: {bottom: 25, top: 23},
                    addPageContent: () => {
                        doc.addImage(imgData, 'PNG', 180, 5, 30, 15);
                        doc.setFillColor(8,54,123);
                        doc.rect(0, 280, 220.00197555866663, 300, 'F');
                    },
                    startY: 45,

                    bodyStyles: { valign: 'top' },
                    styles: { overflow: 'linebreak' },
                    headerStyles: {
                        fillColor: [51, 122, 183],
                        textColor: [255],
                        halign: 'center'
                    },
                    theme: 'grid',

                    columnStyles: {
                        0: {columnWidth: 60},
                        1: {columnWidth: 60},
                        2: {columnWidth: 60},
                        // etc
                    }

                });
                doc.addPage();
                pages+=1;
            }

            let y = 15;
            let index = 0;

            _.each(charts, (chart) => {

                let s = _.filter(options, report => report.key == chart.key)[0];

                if(s.select) {
                    let nombre = s.nombre;

                    let textWidth = doc.getStringUnitWidth(nombre) * doc.internal.getFontSize() / doc.internal.scaleFactor;
                    let textOffset = (210.00197555866663 - textWidth) / 2;

                    doc.text(nombre, 10, marginTop);

                    doc.setFillColor(0,166,81);
                    doc.rect(10, 24, textWidth, 0.5, 'F');

                    doc.addImage(chart.name, 'PNG', 60, marginTop + 5, 90, 80);

                    let data = this[s.key];
                    let t = 0 ;

                    _.each(data.activos, activo => {
                        t += activo.length
                    })

                    let indexes = [];
                    let startY = 120;
                    let init= 0;
                    let x = 0

                    _.each(data.labels, (label, index) => {
                        indexes.push({label: label, index: x});
                        let color = data.datasets[0].backgroundColor[index];
                        let sumY = 11
                        let body = [];

                        _.each(data.activos[index], activo => {
                            x += 1;

                            let n_grupo,
                                n_proyecto,
                                n_activo

                            _.each(this.grupos, grupo => {
                                _.each(grupo.sub_proyectos, proyecto => {
                                    _.each(proyecto.activos, activo_loop => {
                                        if (activo.pivot) {
                                            if (activo_loop.id == activo.pivot.activo_id) {
                                               n_grupo = grupo.nombre.replace('“', '"').replace('”', '"'),
                                                n_proyecto = proyecto.nombre.replace('“', '"').replace('”', '"'),
                                                n_activo = activo.nombre_asociado.replace('“', '"').replace('”', '"')
                                            }
                                        } else {
                                            if (activo_loop.id == activo.id){
                                               n_grupo = grupo.nombre.replace('“', '"').replace('”', '"'),
                                                n_proyecto = proyecto.nombre.replace('“', '"').replace('”', '"'),
                                                n_activo = activo.nombre_asociado.replace('“', '"').replace('”', '"')
                                            }
                                        } 
                                    })
                                })
                            })  

                            // body.push([activo.nombre_asociado])

                            body.push([n_activo, n_proyecto, n_grupo])
                            sumY += 11;
                        });

                        if (data.activos[index].length == 0) {
                            body.push(['Sin activos asociados', 'Sin proyectos asociados', 'Sin grupos asociados'])
                            x+=1
                            sumY += 11;
                        }


                        if (init == 0) {
                            init = 1;
                        } else {
                            startY = doc.autoTable.previous.finalY + 20;
                        }

                        doc.setFontSize(11);
                        doc.text(`${label} (${  (this.roundToTwo((data.activos[index].length/t ) * 100 )) }%):`, 15, startY - 5 );
                        doc.setFontSize(13);

                        doc.autoTable( ['Activo', 'Proyecto', 'Grupo de investigación'], body, {
                            margin: {bottom: 25, top: 23},
                            startY: startY,
                            bodyStyles: { valign: 'top' },
                            styles: { overflow: 'linebreak' },
                            headerStyles: {
                                fillColor: [51, 122, 183],
                                textColor: [255],
                                halign: 'center',
                                fillColor: [this.hexToRgb(color).r, this.hexToRgb(color).g, this.hexToRgb(color).b]
                            },
                            addPageContent: () => {
                                doc.addImage(imgData, 'PNG', 180, 5, 30, 15);
                                doc.setFillColor(8,54,123);
                                doc.rect(0, 280, 220.00197555866663, 300, 'F');
                            },
                            theme: 'grid',

                            columnStyles: {
                                0: {columnWidth: 61},
                                1: {columnWidth: 61},
                                2: {columnWidth: 61},
                            }
                        });

                        if ( (index < (data.labels.length -1) ) && (doc.autoTable.previous.finalY + 20) > 230) {
                            this.footer(doc);
                            doc.addPage();
                            pages+=1;
                            startY= marginTop;
                            init = 0;
                        }

                    });

                    let i = 0;
                    let ind = indexes[i];

                    this.footer(doc)
                    doc.addPage();
                    pages+=1;

                    index+=1;
                }
                
            })

            doc.deletePage(pages + 1);
            doc.save('ReporteGeneralIAMD.pdf');
            document.getElementById("descarga").disabled = false;
        },

        hexToRgb: function(hex) {
            var shorthandRegex = /^#?([a-f\d])([a-f\d])([a-f\d])$/i;
            hex = hex.replace(shorthandRegex, function(m, r, g, b) {
                return r + r + g + g + b + b;
            });

            var result = /^#?([a-f\d]{2})([a-f\d]{2})([a-f\d]{2})$/i.exec(hex);
            return result ? {
                r: parseInt(result[1], 16),
                g: parseInt(result[2], 16),
                b: parseInt(result[3], 16)
            } : null;
        },


        getInfo: function() {

            let gruposId = _.map(this.selectedGrupos, grupo => grupo.id);
            axios.post('/apiReport', {grupos: gruposId}).then( response => {

                let data = response.data;

                this.dpi_chart              = data.dpi_chart
                this.clasificacion_chart    = data.clasificacion_chart
                this.cesion_chart           = data.cesion_chart
                this.confidencialidad_chart = data.confidencialidad_chart
                this.estados_chart          = data.estados_chart
                this.depositos_chart        = data.depositos_chart
                this.registros_chart        = data.registros_chart
                this.se_chart               = data.se_chart
                this.contabilidad_chart     = data.contabilidad_chart
                this.priorizacion_chart     = data.priorizacion_chart

                this.generateCharts = true

                this.grupos_display = this.selectedGrupos;

                this.initDisplayCharts(this.selectedGrupos);

            }).catch( e => {
                console.log('error');
            });

        },

        footer: function(doc){ 
            doc.setFillColor(8,54,123);
            doc.rect(0, 280, 220.00197555866663, 300, 'F');
            doc.page ++;
        },

        selectAll: function name() {
            this.selectedGrupos = this.grupos;
        },

        deleteAll: function name() {
            this.selectedGrupos = ''
        },

        clickChartDPI: function(index) {
            this.activosSelect = this.dpi_chart.activos[index];
            this.title = `AI con ${this.dpi_chart.labels[index].toLowerCase()} asociado `
            this.type = "DPI"
            this.openModal = true;
        },

        clickChartClasificacion: function(index) {
            this.activosSelect = this.clasificacion_chart.activos[index];
            this.title = ` AI clasificado como ${this.clasificacion_chart.labels[index].toLowerCase()}`
            this.type = "clasificacion"
            this.openModal = true;
        },

        clickChartCesion: function(index) {
            this.activosSelect = this.cesion_chart.activos[index];
            this.title = `${this.cesion_chart.labels[index]}`
            this.type = "cesion"
            this.openModal = true;
        },

        clickChartConfidencialidad: function(index) {
            this.activosSelect = this.confidencialidad_chart.activos[index];
            this.title = `${this.confidencialidad_chart.labels[index]}`
            this.type = "confidencialidad"
            this.openModal = true;
        },

        clickChartEstado: function(index) {
            this.activosSelect = this.estados_chart.activos[index];
            this.title = `${this.estados_chart.labels[index]}`
            this.type = "estado"
            this.openModal = true;
        },

        clickChartDepositos: function(index) {

            let modalLabels = {
                'Diseño industrial'     :  'AI con solicitud de registro para diseño industrial',
                'Patente de invención'  :  'AI con solicitud de registro para patente de invención',
                'Signos distintivos'    :  'AI con solicitud de deposito para signos distintivos',
                'Variedades vegetales'  :  'AI con solicitud de registro para variedades vegetales',
                'Derecho de autor'      :  'AI con solicitud de deposito para derecho de autor',
                'Esquema de trazado'    :  'AI con solicitud de registro para esquema de trazado',
                'Ninguno'               :  'AI sin solicitud de registro/deposito'
            }

            this.activosSelect = this.depositos_chart.activos[index];
            this.title = `${modalLabels[this.depositos_chart.labels[index]]}`
            this.type = "deposito"
            this.openModal = true;
        },

        clickChartRegistros: function(index) {
            let modalLabels = {
                'Diseño industrial'     :  'AI con registro para diseño industrial',
                'Patente de invención'  :  'AI con registro para patente de invención',
                'Signos distintivos'    :  'AI con deposito para signos distintivos',
                'Variedades vegetales'  :  'AI con registro para variedades vegetales',
                'Derecho de autor'      :  'AI con deposito para derecho de autor',
                'Esquema de trazado'    :  'AI con registro para esquema de trazado',
                'Ninguno'               :  'AI sin registro/deposito'
            }
            
            this.activosSelect = this.registros_chart.activos[index];
            this.title = `${modalLabels[this.registros_chart.labels[index]]}`
            this.type = "registro"
            this.openModal = true;
        },

        clickChartSE: function(index) {
            this.activosSelect = this.se_chart.activos[index];
            this.title = `${this.se_chart.labels[index]}`
            this.type = "se"
            this.openModal = true;
        },

        clickChartContabilidad: function(index) {
            this.activosSelect = this.contabilidad_chart.activos[index];
            this.title = `${this.contabilidad_chart.labels[index]}`
            this.type = "contabilidad"
            this.openModal = true;
        },

        clickChartPriorizacion: function name(index) {

            this.activosSelect = this.priorizacion_chart.activos[index];
            let x = [];

            _.each( this.activosSelect, row => {
                if (! _.some(x, subrow => row.nombre_asociado ==  subrow.nombre_asociado )) {
                    x.push(row);
                }
            })

            this.activosSelect = x;

            this.title = ['Ninguno'].includes(this.priorizacion_chart.labels[index]) ? 'AI que no requieren herramienta de priorización' :`AI que requieren ${this.priorizacion_chart.labels[index].toLowerCase()}`
            this.type = "priorizacion"
            this.openModal = true;

        },

        closeModal: function() {
            this.openModal = false;
        },

        closeModalDescarga: function() {
            this.openModalDescarga = false;
        }
    }
    
}
</script>
