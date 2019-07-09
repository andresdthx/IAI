<template lang="html">
        <transition id="modal" name="modal">
            <div class="modal-mask">
                <div class="modal-wrapper">
                    <div class="modal-container">
                        <span class="glyphicon glyphicon-remove close-modal" @click="$emit('close')" ></span>
                        <h3 class="step-title"><strong>{{title}}</strong></h3>
                        <ul v-if="['DPI', 'deposito', 'registro'].includes(type)">
                            <li v-for="activo in activos"><a target="_blank" :href="`/activos/show/${activo.pivot.activo_id}`">{{activo.nombre_asociado}}</a></li>
                        </ul>

                        <ul v-else>
                            <li v-for="activo in activos"><a target="_blank" :href="`/activos/show/${activo.id}`">{{activo.nombre_asociado}}</a></li>
                        </ul>

                    </div>
                </div>
            </div>
        </transition>
</template>

<script>
export default {
    props: ['activos', 'title','type'],
    data() {
        return {}
    },

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
