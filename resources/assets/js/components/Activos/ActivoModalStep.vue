<template lang='html'>
       <transition id="modal" name="modal">
           
            <div class="modal-mask">
                
            <div class="modal-wrapper">

                <div class="modal-container" style="width: 900px; margin-top: 50px;">
                    <img src="/images/close.png" class="close-modal" @click="$emit('close')" />

                     <component @cerrar="onCerrar" @closeStepFinalizado="oncloseStepFinalizado" @closeStepFalta="oncloseStepFalta" :is="component"></component>

                 </div>
            </div>
            </div>
        </transition>
</template>


<script>

import swal from 'sweetalert2';

export default {
    props: ['component'],

    methods: {
        handleClick(event) {
            if (event.target.className == 'modal-wrapper') {
                this.$emit('close');
            }
        },

        onCerrar: function() {
            console.log('wewerwerwer') ;
            this.$emit('close')
        },

        oncloseStepFinalizado: function() {
            this.$emit('close');
        },

        oncloseStepFalta: function() {

        }


    },

    mounted() {
        //window.addEventListener('click', this.handleClick)
    },

    beforeDestroy: function () {
        //window.removeEventListener('click', this.handleClick)
    },
}
</script>