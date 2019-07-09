<template lang="html">
     <form v-on:submit.prevent="onSubmit" style="cursor: initial" >
        <i style="margin-right: 10px;font-size: 20px;" class="fa fa-search"></i>
        <input style="border: none; outline: none; " type="text" placeholder="Buscar..." name="search" v-model="search">
        
    </form>
</template>

<script>
export default {
    data() {
        return {
            search: '',
        }
    },

    methods: {
        onSubmit: function() {
            console.log('sdsdf');
             window.location.href = `/busqueda/${this.search}`;
        }
    }
}
</script>
