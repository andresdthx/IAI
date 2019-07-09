<template lang="html">
        <transition id="modal" name="modal">
            <div class="modal-mask">
                <div class="modal-wrapper">
                    <div class="modal-container">
                        <span class="glyphicon glyphicon-remove close-modal" @click="$emit('close')" ></span>
                        <h3 class="step-title"><strong>Descargar reporte</strong></h3>

                        <strong class="step-title" style="font-size: 17px;">Información a incluir en el reporte: </strong>

                        <template v-for=" option in options">
                            <div class="checkbox" style="font-family: 'Open Sans'">
                                <label><input type="checkbox" v-model="option.select">{{option.nombre}}</label> 
                            </div>
                        </template>

                        <div style="float: right; margin-top:30px">
                            <button type="button" style="margin-right: 15px;" @click="$emit('close')" class="btn btn-cancelar">Cancelar</button>
                            <button class="btn-info btn" id="descarga" @click="clickDescargar"  style="background-color: #008C44;">Descargar</button>
                        </div>

                    </div>
                </div>
            </div>
        </transition>
</template>

<script>
export default {
    props: ['options'],


    data() {
        return {
            disabledDownload: false
        }
    },

    methods: {
        handleClick(event) {
            if (event.target.className == 'modal-wrapper') {
                this.$emit('close')
            }
        },

        clickDescargar() {
            this.disabledDownload = true;
            document.getElementById("descarga").disabled = true;
            if ( document.getElementById("descarga").disabled == true ) {
                this.$emit('descargar', this.options);
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
