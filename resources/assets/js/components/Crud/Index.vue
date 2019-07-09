<template lang="html">
    <span>
            <template v-for="value in sortValues">

                <template v-if="value.type=='text' && value.isFilter">
                        <div class="table-filters" >
                            <img src="/images/filter.png">
                            <input type="text" v-model="value.filter" :placeholder="value.placeholder"/>
                        </div>
                    
                </template>

                <template v-else-if="value.type=='select' && value.isFilter">
                    <multiselect
                        v-model="value.filter" 
                        :options="value.selectValues"
                        :multiple="true"
                        :close-on-select="false" 
                        :clear-on-select="false" 
                        :hide-selected="true" 
                        :preserve-search="true" 
                        :placeholder="value.placeholder"
                        label="name"
                        track-by="name">
                    </multiselect>
                    </br></br> 
                </template>
            </template>

            <button class="btn btn-info" @click="onBuscar">Buscar</button>
            <button class="btn btn-danger" @click="onBorrarFiltros">Borrar filtros</button>

        <a @click.prevent="crud.create.handler()" v-if="crud.create.displayRules" href="#">
            <button style="margin-bottom: 20px; float: right" class="btn-add btn">
                <span style="margin-right: 10px;"class="glyphicon glyphicon-plus-sign"></span> 

                <span v-if ="nameResource =='proyecto'">Crear nuevo grupo de investigación</span>
                <span v-else>Crear nuevo {{nameResource}}</span>

            </button>
        </a>

        <div class="card-index-container">
            
            <table class="table" style="margin-top:50px;">
                
                <thead>
                    <tr>
                        <template v-for="value in sortValues">
                            <th style="width:28%;" v-if="value.displayRules"> {{value.headName}}
                                <span v-if="value.isSorted" 
                                    @click="onSort(value.fieldName)"
                                    :class="`sort glyphicon ${value.style}`">
                                </span>
                            </th>
                        </template>
                    </tr>
                </thead>

                <tbody>
                    <tr v-for="value in processData.data">

                        <template v-for="field in sortValues">

                            <template v-if="field.displayRules">
                                <td v-if="field.linkRules">
                                    <a href='#' @click.prevent="field.handler(value.id)">{{value[field.fieldName]}}</a>
                                </td>
                                <td style="width:28%;" v-else>{{value[field.fieldName]}}</td>
                            </template>
                            
                        </template>

                        <td>

                            <img v-if="crud.update.displayRules" 
                                @click.prevent="crud.update.handler(value.id)" 
                                src="images/editar.png"
                            />

                            <img v-if="crud.delete.displayRules(value.id)"
                                 @click.prevent="crud.delete.handler(value.id)" 
                                 src="images/delete.png"
                            />

                        </td>

                    </tr>
                </tbody>
            </table>

            <div class="text-center">
                <ul class="pagination">
                    <li><a @click.prevent="onPagination(Math.max(0, processData.current_page -1))" href="#" rel="prev">&laquo;</a></li>
                            <template v-for="n in processData.last_page">
                                <li v-if="n == processData.current_page" class="active"><span>{{n}}</span></li>
                                <li v-else ><a @click.prevent="onPagination(n)" href="#">{{n}}</a></li>
                            </template>
                    <li><a @click.prevent="onPagination(Math.min(processData.last_page, processData.current_page + 1))" href="#" rel="next">&raquo;</a></li>
                </ul>

                <p v-if="dataProp.total > 0" >Mostrando {{dataProp.from}}-{{dataProp.to}} de {{dataProp.total}}</p>
            </div>

            
        </div>


    </span>

</template>

<script>
    import axios from 'axios';
    import Multiselect from 'vue-multiselect'

    export default {
        props: ['dataProp', 'configProp', 'crudProp', 'sortValuesProp', 'rolProp'],
        components: {Multiselect},
        data() {
            return {
                config: this.configProp,
                crud: this.crudProp,
                sortValues: this.sortValuesProp,
                rol: this.rolProp,
                prevUrl: ''
            }
        },

        mounted() {
            this.prevUrl = this.makeUrl(this.sortValues, this.config.basePath, this.config.nullParam);
        },

        updated() {
            this.config = this.configProp;
            this.crud = this.crudProp;
            this.sortValues = this.sortValuesProp;
            this.rol = this.rolProp;
        },

        computed: {
            currentUrl: function(){
                 return this.makeUrl(this.sortValues, this.config.basePath, this.config.nullParam)
            },
            processData: function(){ return this.dataProp},

            nameResource: function() {
                if (this.config.resource) {
                    var x = (this.config.resource == 'users') ? 'usuario' : this.config.resource;
                    return x[x.length - 1 ] == 's' ? x.slice(0, -1) : x; 
                }
            }
        },

        methods: {
            onSort: function(field) {
                if (!this.sortValues[field].select) {
                    this.sortValues[field].select = true;
                    this.sortValues[field].dir = this.config.sortAsc;
                    this.sortValues[field].style = this.config.sortAscImg;

                }else if(this.sortValues[field].dir == this.config.sortAsc) {
                    this.sortValues[field].dir = this.config.sortDesc;
                    this.sortValues[field].style = this.config.sortDescImg;

                }else if (this.sortValues[field].dir == this.config.sortDesc) {
                    this.sortValues[field].dir = this.config.sortAsc;
                    this.sortValues[field].style = this.config.sortAscImg;
                }

                _.each(this.sortValues, (val, key) => {
                    if (key!=field){
                         this.sortValues[key].style = this.config.sortImg;
                         this.sortValues[key].select = false;
                         this.sortValues[key].dir = null;
                    }
                });
                this.onBuscar();
            },

            sortUrl: function(values, nullParam) {
                let selectSort = _.filter( values, (value) => value.select)[0];
                return [(selectSort ? selectSort.fieldName : nullParam), (selectSort ? selectSort.dir : nullParam) ];
            },

            selectUrl: function(value, nullParam) {
                let users = [];
                if (value.filter) {
                    users = _.map(value.filter, user => user.id);
                } 
                if (value.defaultFilter) {
                    users.push(value.defaultFilter);
                }
                users = _.flatten(users);
                return !_.isEmpty(users) ? encodeURIComponent(JSON.stringify(users)) : nullParam;
            },

            textUrl: function(value, nullParam) {
                return value.filter ? value.filter : nullParam;
            },

            makeUrl: function(values, basePath, nullParam) {
                let url = basePath + '/' +
                    _.map(
                        _.sortBy( values, value => value.urlPos), 
                        value => {
                        switch(value.type) {
                            case 'text':
                                return this.textUrl(value, nullParam);
                            case 'select':
                                return this.selectUrl(value, nullParam)
                            default:
                                return ''
                        }
                    }).concat(this.sortUrl(values, nullParam)).join('/');
                console.log(url);
                return url;         
            },

            onBorrarFiltros: function() {
                _.each(this.sortValues, value => {
                    if (value.isFilter) {
                        value.filter = null;
                    } 
                });
                this.onBuscar();
            },

            onPagination: function(page) {
                axios.get(`${this.currentUrl}?page=${page}`).then( response => {
                    let data = response.data;
                    this.$emit('updateData', JSON.parse(data[this.config.resource]))
                    //this.processData = JSON.parse(data[this.config.resource]);
                }).catch( e => {
                    console.log(e)
                })
            },

            onBuscar: function() {
                if (this.prevUrl != this.currentUrl) {
                    axios.get(this.currentUrl).then( response => {
                        let data = response.data;
                        this.$emit('updateData', JSON.parse(data[this.config.resource]))
                        //this.processData = JSON.parse(data[this.config.resource]);
                    }).catch( e => {
                        console.log(e);
                    })
                    this.prevUrl = this.currentUrl;
                }
            }
        }

    }
</script>