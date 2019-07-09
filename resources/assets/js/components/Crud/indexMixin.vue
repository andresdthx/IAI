<script>

import Multiselect from 'vue-multiselect';

export default {
    components: {Multiselect},

    data() {
        return {
            valuesPerPage: 10,
            data: this.init_data,
            initData: this.init_data,
            total: _.size(this.init_data),
            filters: this.filt,
            currentPage: 1,
            numberPages: 0,
        }
    },

    created() {
        this.numberPages = this.calculateNumberPages(_.size(this.init_data))
    },

    computed: {
        currentValues: function() {
            return this.data.slice( (this.currentPage - 1) * this.valuesPerPage, this.currentPage * this.valuesPerPage)
        },

    },

     methods: {

         onSort(filter, dir) {

            this.data = _.sortBy(this.data, item => {
                /////////////para clasificacion/////////////////
                let x = item[filter.name];
                if (x == null && filter.name=='clasificacion') {
                    x = 'Sin definir';
                }
                ////////////////////////////////////
                return (x && x.toLowerCase()) || '';
            });

            if(dir == 'desc') {
                this.data = this.data.reverse();
            }

         },

         onBuscar: function() {
            let data = this.filterData(this.filters, this.initData);
            this.data = data;
            this.total = _.size(this.data);
            this.currentPage = 1;
            this.numberPages = this.calculateNumberPages(_.size(data));
        },

        onBorrarFiltros: function() {
            this.filters = _.map(this.filters, filter => {
                    let type = this.toType(filter.value)
                    if(type == 'string') {
                        filter.value = ''
                    } else if(type == 'array') {
                        filter.value = []
                    }
                    return filter;
                })

            this.data = this.initData;
            this.total = _.size(this.data);
            this.currentPage = 1;
            this.numberPages = this.calculateNumberPages(_.size(this.data));
        },

        filterData: function(filters, data) {
           let filterData = _.filter( data, item => {
                let add = true;
                _.each(filters, filter => {

                    let type = this.toType(filter.value)
                    if (type == 'string') {
                        add = (add && item[filter.name].toLowerCase().includes(filter.value.toLowerCase()));
                    }

                    else if(type == 'array') {
                        if (_.size(filter.value) != 0 ) { 
                            add = (add && _.size((_.filter(filter.value, opt => opt.id == item[filter.name])) ) > 0 )
                        }
                    }
                })

                return add;
            })

            return filterData;
        },

        toType: function(obj) {
            return ({}).toString.call(obj).match(/\s([a-zA-Z]+)/)[1].toLowerCase();
        },

        updatePage: function(page) {
            if (page > 0 && page <= this.numberPages) {
                this.currentPage = page;
            }
        },

        calculateNumberPages: function(numberValues) {
            return Math.ceil(numberValues/this.valuesPerPage);
        },

        indexFilter: function (nombreFiltro) {
            let index;
                _.each(this.filters, (filter, ind) => {
                    if (filter.name == nombreFiltro) {
                        index = ind
                    }
                })

            return index;
        }

     }

}
</script>
