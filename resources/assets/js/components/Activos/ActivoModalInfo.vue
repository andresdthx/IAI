<template lang='html'>
       <transition id="modal" name="modal">
            <div class="modal-mask">
            <div class="modal-wrapper">
                <div class="modal-container" style="font-family: 'Open Sans';width: 800px">
                    <span class="glyphicon glyphicon-remove close-modal" @click="$emit('close')" ></span>
                     <h3 style="font-family: 'Open Sans'; font-weight: bold;">{{data.title}}</h3>

                     <carousel :perPageCustom="[[800, 1]]" :navigationEnabled="true">

                        <slide>
                            <p>Para diligenciar el activo intangible debes de seleccionar uno de los pasos que se encuentran desbloqueados, estos son los que aparecen con el simbolo <img src="/images/teminado.png" alt="" width="20"> o <i style="display: inline; color: #f58345; font-size: 19px;" class="fa fa-hourglass-half" aria-hidden="true"></i>  a su izquierda.</p>
                            <img src="../../../../img/guia1.png" style="width: 680px"/>

                        </slide>
                        <slide>
                            <p>Al seleccionar el paso se abrira un formulario el cual debes de completar para desbloquear el siguiente paso.</p>
                            <img src="../../../../img/guia2.png" style="width: 680px"/>
                            <br><br>
                            <p><strong>Nota: </strong><i>Algunos pasos tienen un formulario extenso, puedes guardar tus avances sin terminarlo por completo.</i></p>
                            <p><strong>Nota: </strong><i>En cualquier momento puedes modificar la información que ya has diligenciado, para ello entra al paso donde se encuentre la información que desees modificar.</i></p>
                        </slide>
                        <slide>
                            <p>La información que diligencies aparecera en la pestaña de reportes.</p>
                            <img src="../../../../img/guia3.png" style="width: 680px"/>
                        </slide>

                        <slide>

                            <p>De acuerdo a la información recogida en el diligenciamiento, puedes describir cuáles son las sugerencias y estrategias generales para la gestión. Para ello ingresa en la pestaña de estrategias de gestión y selecciona el campo al que deseas añadir una estrategia. Estas apareceran en la pestaña de reportes.</p>
                            <img src="../../../../img/guia4.png" style="width: 680px"/>
                        </slide>

                        <slide>

                            <p>En la pestaña de historial puedes encontrar el registro de todos los cambios que se han realizado en el fomulario del activo intangible.</p>
                            <img src="../../../../img/guia5.png" style="width: 680px"/>
                        </slide>
                    </carousel>
                 </div>
            </div>
            </div>
        </transition>
</template>


<script>

import { Carousel, Slide } from 'vue-carousel';

export default {
    components: { Carousel, Slide, },
    props: ['data'],

    data () {
      return {
        datacollection: null
      }
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
