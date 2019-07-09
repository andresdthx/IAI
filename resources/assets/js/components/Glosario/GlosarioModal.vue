<template lang='html'>
       <transition id="modal" name="modal">
            <div class="modal-mask">
            <div class="modal-wrapper">
                <div class="modal-container">
                    <span class="glyphicon glyphicon-remove close-modal" @click="$emit('close')" ></span>
                    <h3 style="font-family: 'Open Sans'; font-weight: bold;" >{{data.title}}</h3>
                    <p style="font-family: 'Open Sans'" v-html="data.info" ></p>
                    <blockquote v-html="data.fuente" v-if="data.fuente" style="font-size: 15px; font-family: 'Open Sans'"></blockquote>
                </div>
            </div>
            </div>
        </transition>
</template>

<style>


    .modal-container ul {
        list-style: initial !important;
    }

     .modal-container ul li:before {
        content:  '';
    }

</style>

<script>
export default {
    props: ['data'],

    methods: {
        handleClick(event) {
            if (event.target.className == 'modal-wrapper') {
                this.$emit('close')
            }
        }
    },

    mounted() {
        window.addEventListener('click', this.handleClick)
    },

    beforeDestroy: function () {
        window.removeEventListener('click', this.handleClick)
    },
}
</script>
