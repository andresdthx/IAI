<template lang='html'>
    <div>

        <span class="header-table">Glosario</span>

        <div class="card-index-container row" style="padding: 0 0 30px 0">

            <div style="margin: 0"class="table-filters"><img src="/images/filter.png">
                <input type="text" v-model="input" placeholder="Ingresar el término de búsqueda">
            </div>
            
            <template v-for="chunk in chunkData">
                <div class="col-md-4 chunk">
                    <ul style="margin-top: 40px">
                        <template v-for="item in chunk">

                            <li>
                                <span @click="onOpenModal(item['key'])" class="item-glosario">{{item['title']}}</span>
                                <div @click="openList(item['key'])" style="cursor: pointer" v-if="item.subComponent" :class="`glyphicon glyphicon-menu-${item.openList ? 'up' : 'down'}`"></div>

                                <ul v-if="item.subComponent && item.openList">
                                    <template v-for="subItem in item.subComponent"> 

                                        <li @click="onOpenModal(subItem['key'])">
                                            <span class="item-glosario">{{subItem.title}}</span>
                                        </li>

                                        <glosario-modal
                                            v-if="subItem['modal']" 
                                            @close="onCloseModal()"
                                            :data="subItem" >
                                        </glosario-modal>

                                    </template>

                                </ul>

                            </li>

                            <glosario-modal
                                v-if="item['modal']" 
                                @close="onCloseModal()"
                                :data="item" >
                            </glosario-modal>

                        </template>
                    </ul>
                </div>
            </template>
        </div>

    </div>
</template>


<style>

div.chunk {
    border-width: thin;
    border-right-style: dotted;
    border-right-color: rgb(83, 197, 207);
}

div.chunk:last-child  {
    border-right: none;
}

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

.input {
  display: block;
  width: 50%;
  margin-bottom: 40px;
  height: 36px;
  padding: 6px 12px;
  font-size: 14px;
  line-height: 1.6;
  color: #555555;
  background-color: #fff;
  background-image: none;
  border: 1px solid #ccd0d2;
  border-radius: 4px;
  -webkit-box-shadow: inset 0 1px 1px rgba(0, 0, 0, 0.075);
  box-shadow: inset 0 1px 1px rgba(0, 0, 0, 0.075);
  -webkit-transition: border-color ease-in-out 0.15s,
    box-shadow ease-in-out 0.15s;
  -webkit-transition: border-color ease-in-out 0.15s,
    -webkit-box-shadow ease-in-out 0.15s;
  transition: border-color ease-in-out 0.15s,
    -webkit-box-shadow ease-in-out 0.15s;
  transition: border-color ease-in-out 0.15s, box-shadow ease-in-out 0.15s;
  transition: border-color ease-in-out 0.15s, box-shadow ease-in-out 0.15s,
    -webkit-box-shadow ease-in-out 0.15s;
}

.item-glosario {
  cursor: pointer;
  color: #216a94;
}

.item-glosario:hover {
  border-bottom: solid #216a94;
  border-bottom-width: 1px;
}
</style>

<script>
export default {
    computed: {
        chunkData: function() {
            return _.chunk(_.sortBy(
                    _.filter(this.data, item => item['title'].toLowerCase().includes(this.input.toLowerCase())),
                    item => item['title']), Math.ceil(this.data.length / this.columns))
        }
    },

    methods: {

        openList(key) {
            let newData = _.map(this.data, item => {
                if (item.key == key) {
                    item.openList = !item.openList
                }
                return item;
            })

            this.data = newData;
        },

        onOpenModal(key) {
            let newData = _.map(this.data, item => {
                item.modal = item['key'] == key;

                if (item.subComponent) {

                    item.subComponent = _.map(item.subComponent, subItem => {
                        subItem.modal = subItem['key'] == key;
                        return subItem;
                    })

                }

                return item;
            })

            this.data = newData;
        },

        onCloseModal() {
            let newData = _.map(this.data, item => {
                item.modal = false;

                if (item.subComponent) {

                    item.subComponent = _.map(item.subComponent, subItem => {
                        subItem.modal = false;
                        return subItem;
                    })

                }

                return item;
            })

            this.data = newData;
        },


    },



    data() {
        let data = [
            { 
                title: "Acción de cancelación",
                key: "accion_cancelacion",
                info: "Es la acción que se lleva a cabo para iniciar el procedimiento mediante el cual se solicita la cancelación del registro de una marca cuya titularidad la ostenta un tercero, por no uso, notoriedad o vulgarización de ésta.",
                fuente: 'Tomado de la página web de la SIC: <a target="blank" href="http://www.sic.gov.co/marcas/despues-de-la-concesion">http://www.sic.gov.co/marcas/despues-de-la-concesion</a>.'
            },
            {
                title: "Afectaciones al registro",
                key: "afectaciones_registro",
                info: "Son los cambios que puede sufrir el registro de un derecho de propiedad intelectual, durante el trámite o con posterioridad a su concesión como por ejemplo, el cambio de titularidad, dirección, licencias, entre otros. Se debe solicitar para mantener la información actualizada y que tengan efectos frente a terceros.",
                fuente: 'Tomado de la página web de la SIC: <a target="blank" href="http://www.sic.gov.co/marcas/despues-de-la-concesion">http://www.sic.gov.co/marcas/despues-de-la-concesion</a>.'
            },
            {
                title: "Aplicación Industrial",
                key: "aplicacion_industrial",
                info: "Cuando el objeto de la invención puede ser producido o utilizado en cualquier tipo de industria.",
                fuente: "Tomado de Artículo 19, Decisión 486 de 2000 de la CAN."
            },

            {
                title: "Artista intérprete o ejecutante de una obra",
                key: "artista_interprete",
                info: "Persona que representa, canta, lee, recita, interpreta o ejecuta en cualquier forma una obra.",
                fuente: "Tomado de la Decisión 351 de la CAN."
            },

            {
                title: 'Autor de una obra',
                key: 'autor_obra',
                info: 'Persona física que realiza la creación intelectual.',
                fuente: 'Tomado de la Decisión 351 de la CAN.'
            },

            {
                title: 'Autoridad Nacional Competente',
                key: 'autoridad_nacional',
                info: '<p>Entidad del Estado respectivo designada, por la legislación nacional, supranacional o internacional, para llevar a cabo los trámites de protección, depósito y registro de uno o más derechos de propiedad intelectual.</p> <p>En Colombia la autoridad nacional competente para conocer de Derecho de Autor es la Dirección Nacional de Derecho de Autor (DNDA) y para conocer de los Derechos de Propiedad Industrial es la Superintendencia de Industria y Comercio (SIC).</p>',
                fuente: ''
            },

            {
                title: 'Base de datos',
                key: 'bases_de_datos',
                info: 'Es una compilación de datos o información, independientemente que existan en forma impresa, en unidades de almacenamiento en computador o de cualquier otra forma seleccionados y dispuestos original y sistemáticamente para su posterior uso. Están protegidas por el derecho de autor siempre que por la selección o disposición de las materias constituyan creaciones personales. La protección concedida por el derecho de autor a las bases de datos no será extensiva a los datos o información compilados (Interpretación Prejudicial 10-IP-99. Tribunal Andino de Justicia. 11 julio de 1999).',
                fuente: ''
            },


            {
                title: 'Búsqueda de antecedentes marcarios',
                key: 'busqueda_marcarios',
                info: 'Es una búsqueda para verificar si existen registradas o solicitadas con anterioridad marcas o signos iguales o parecidos que identifiquen productos o servicios iguales o similares que puedan obstaculizar el registro.',
                fuente: 'Tomado de la página web de la SIC: <a target="blank" href="http://www.sic.gov.co/marcas/antes-de-solicitar">http://www.sic.gov.co/marcas/antes-de-solicitar</a>.'
            },

            {
                title: 'Caducidad de la patente',
                key: 'caducidad_patente',
                info: '<p>Es la condición jurídica por la cual una patente concedida y la invención que la incluye pasa a ser de dominio público y cualquier persona puede utilizarla sin necesidad de solicitar permiso o autorización del titular de la patente. Es decir, el titular de la patente pierde el derecho exclusivo que le concedió la patente.</p> <p>Una patente puede caducar por el incumplimiento en el pago de una anualidad o porque ya venció el plazo de vigencia de la patente.</p>',
                fuente: ''
            },

            {
                title: 'Caducidad de la marca',
                key: 'caducidad_marca',
                info: 'El registro marcario caduca cuando se vence el término de vigencia de la marca, no se renueva, por falta de pago de las tasas de renovación o cuando el titular renuncia al derecho.',
                fuente: ''
            },

            {
                title: 'Clasificación Internacional de Niza',
                key: 'clasificacion_niza',
                info: 'La Clasificación de Niza es un sistema internacional utilizado para clasificar productos y servicios a los fines del registro de las marcas.',
                fuente: 'Tomado de la página web de la WIPO: <a target="blank" href="http://www.wipo.int/classifications/es/">http://www.wipo.int/classifications/es/</a>.'
            },

            {
                title: 'Competencia Desleal',
                key: 'competencia_desleal',
                info: '<p>Todo acto o hecho que se realice en el mercado con fines concurrenciales, cuando resulte contrario a las sanas costumbres mercantiles, al principio de la buena fe comercial, a los usos honestos en materia industrial o comercial, o bien cuando esté encaminado a afectar o afecte la libertad de decisión del comprador o consumidor, o el funcionamiento concurrencial del mercado. <p>Igualmente se considera competencia desleal explotar, copiar, divulgar, acceder, usar, usufructuar u obtener beneficio, para sí o para un tercero, de secretos empresariales con actos contrarios a los usos comerciales honestos y sin permiso, autorización o licencia del titular de los secretos empresariales.</p>',
                fuente: ''
            },

            {
                title: 'Confidencialidad',
                key: 'confidencialidad',
                info: 'Es la reserva obligatoria, derivada de la ley, acuerdo o contrato, que debe mantener todo miembro de la universidad o cualquier tercero con quien la Universidad tenga alguna relación, contrato, convenio o acuerdo sobre toda información que sea definida como confidencial, incluyendo toda información que sea resultado de las actividades de investigación, desarrollo e innovación y cualquier otra sobre la cual la Universidad tenga o pueda tener derechos de propiedad intelectual.',
                fuente: ''
            },

            {
                title: 'Contrato de cesión',
                key: 'contrato_cesión',
                info: 'Por medio de este contrato, se transfiere todo o parte de la titularidad que se tiene sobre un derecho de propiedad intelectual a un tercero a cambio de, generalmente, una remuneración. Este contrato debe hacerse por escrito y debe registrarse ante la autoridad competente (que son la Colombia: Dirección Nacional de Derechos de Autor-DNDA, Superintendencia de Industria y Comercio-SIC o el Instituto Colombiano Agropecuario-ICA) para que tenga efectos frente a terceros.',
                fuente: ''
            },

            {
                title: 'Copia o ejemplar de una obra',
                key: 'copia_obra',
                info: 'Soporte material que contiene la obra, como resultado de un acto de reproducción.',
                fuente: 'Tomado de la Decisión 351 de la CAN.'
            },

            {
                title: 'Derechohabiente',
                key: 'derechohabiente',
                info: 'Persona natural o jurídica a quien por cualquier título se transmite derechos reconocidos.',
                fuente: 'Tomado de la Decisión 351 de la CAN.'
            },

            {
                title: 'Derechos conexos al derecho de autor',
                key: 'derechos_conexos',
                info: 'Prerrogativas concedidas exclusivamente a los artistas, intérpretes y ejecutantes en relación con la explotación de sus interpretaciones o ejecuciones; a los productores de fonogramas en relación con la utilización de sus fonogramas, y, a los organismos de radiodifusión en relación con la utilización de sus emisiones de radiodifusión.',
                fuente: ''
            },

            {
                title: 'Derechos morales',
                key: 'derechos_morales',
                info: 'Son derechos que concede la ley nacional y supranacional al autor y que son inalienables, inembargables, imprescriptibles e irrenunciables (aún si el autor así lo quiera).',
                fuente: '',
                subComponent: [
                    {
                        title: 'Derecho de paternidad',
                        key: 'derecho_paternidad',
                        info: 'Posibilidad de reivindicar en todo tiempo la paternidad de su obra y, en especial, para que se indique su nombre o seudónimo cuando se realice cualquier acto de reproducción, adaptación, traducción, modificación o comunicación al público.',
                        fuente: ''
                    },

                    {
                        title: 'Derecho a la integridad',
                        key: 'derecho_integridad',
                        info: 'Facultad de oponerse a toda deformación, mutilación u otra modificación de la obra, cuando tales actos puedan causar o acusen perjuicio a su honor o a su reputación, o la obra se demerite, y a pedir reparación por esto.',
                        fuente: ''
                    },

                    {
                        title: 'Derecho de divulgación',
                        key: 'derecho_divulgacion',
                        info: 'Derecho a publicar, divulgar o conservar su obra inédita hasta su fallecimiento, o después de él cuando así lo ordenase por disposición testamentaria.',
                        fuente: ''
                    },

                    {
                        title: 'Derecho de arrepentimiento',
                        key: 'derecho_arrepentimiento',
                        info: 'Facultad de retirar la obra de la circulación o suspender cualquier forma de utilización aunque ella hubiere sido previamente autorizada.',
                        fuente: ''
                    },

                    {
                        title: 'Derecho de modificación',
                        key: 'derecho_modificación',
                        info: 'Posibilidad de modificar la obra antes o después de su publicación.',
                        fuente: ''
                    }
                ]
            },

            {
                title: 'Derechos patrimoniales',
                key: 'derechos_patrimoniales',
                info: 'Son prerrogativas de carácter económico que le permiten al autor, titular o tercero facultado controlar los actos de explotación de la obra y le confieren los siguientes derechos, susceptibles de cesión, enajenación transferencia y/o cualquier otro acto de disposición, y son limitados en el tiempo.',
                fuente: '',
                subComponent: [

                    {
                        title: 'Derecho de reproducción',
                        key: 'derecho_reproduccion',
                        info: 'Facultad de autorizar o prohibir la realización de copias de su obra, ya sea por medio impreso, sistemas digitales, y en general, por cualquier medio de reproducción conocido o por conocer, incluido el almacenamiento digital o la reproducción por Internet.',
                        fuente: ''
                    },

                    {
                        title: 'Derecho de comunicación pública',
                        key: 'derecho_comunicación_publica',
                        info: 'Todo acto por el cual una pluralidad de personas, reunidas o no en un mismo lugar, pueden tener acceso a toda o parte de la obra, por medios que no consisten en la distribución de ejemplares. No hay comunicación al público cuando se realice en un ambiente estrictamente cerrado o familiar.',
                        fuente: ''
                    },


                    {
                        title: 'Derecho de transformación',
                        key: 'derecho_transformacion',
                        info: 'Facultad de autorizar a otro la modificación de su obra a través de la creación de adaptaciones, traducciones, compilaciones, actualizaciones, revisiones, y, en general, cualquier modificación que de la obra se pueda realizar. La nueva obra resultante se constituye en una obra derivada protegida igualmente por el derecho de autor.',
                        fuente: ''
                    },

                    {
                        title: 'Derecho de distribución',
                        key: 'derecho_distribución',
                        info: 'Cualquier forma de distribución al público de una obra o de copias de la misma mediante la venta, arrendamiento o alquiler.',
                        fuente: ''
                    },

                ]
            },

            {
                title: 'Diseño industrial',
                key: 'diseno_industrial',
                info: 'La apariencia particular de un producto que resulte de cualquier reunión de líneas o combinación de colores, o de cualquier forma externa bidimensional o tridimensional, línea, contorno, configuración, textura o material, sin que cambie el destino o finalidad de dicho producto.',
                fuente: 'Tomado de Artículo 113, Decisión 486 de la CAN.'
            },

            {
                title: 'Diseño novedoso',
                key: 'diseno_novedoso',
                info: 'Que no haya sido accesible al público o se haya hecho uso comercial del mismo en cualquier lugar y por cualquier medio. La novedad del diseño se predica a nivel mundial.',
                fuente: ''
            },

            {
                title: 'Distribución al público',
                key: 'distribución_público',
                info: 'Puesta a disposición del público del original o copias de la obra mediante su venta, alquiler, préstamo o de cualquier otra forma.',
                fuente: 'Tomado de la Decisión 351 de la CAN.'
            },

            {
                title: 'Divulgación de una obra',
                key: 'divulgacion_obra',
                info: 'Hacer accesible la obra al público por cualquier medio o procedimiento.',
                fuente: 'Tomado de la Decisión 351 de la CAN.'
            },

            {
                title: 'Dominio público',
                key: 'dominio_publico',
                info: 'Es la situación jurídica en la que todos los derechos de explotación se han extinguido, y que, por lo tanto, no son de nadie. Las obras se encuentran en el dominio público porque ha terminado su plazo de protección o porque se encuentran en situaciones especiales descritas en la Ley, como por ejemplo las sentencias y las leyes.',
                fuente: ''
            },

            {
                title: 'Emisión de una obra',
                key: 'emisión_obra',
                info: 'Difusión a distancia de sonidos o de imágenes y sonidos para su recepción por el público.',
                fuente: 'Tomado de la Decisión 351 de la CAN.'
            },

            {
                title: 'Enseña comercial',
                key: 'ensena_comercial',
                info: 'Signo distintivo perceptible por la vista que sirve para identificar a un establecimiento de comercio.',
                fuente: ''
            },

            {
                title: 'Familia de diseños',
                key: 'familia_disenos',
                info: 'Varios productos que comparten un mismo concepto de diseño, es decir, un mismo manejo en los rasgos de la forma.',
                fuente: ''
            },

            {
                title: 'Fijación de una obra',
                key: 'fijación_obra',
                info: 'Incorporación de signos, sonidos o imágenes y sonidos sobre una base material que permita su percepción, reproducción o comunicación.',
                fuente: 'Tomado de la Decisión 351 de la CAN.'
            },

            {
                title: 'Fonograma',
                key: 'fonograma',
                info: 'Toda fijación exclusivamente sonora de los sonidos de una representación o ejecución de otros sonidos. Las grabaciones gramofónicas y magnetofónicas se consideran copias de fonogramas.',
                fuente: 'Tomado de la Decisión 351 de la CAN.'
            },

            {
                title: 'Gaceta de Propiedad Industrial',
                key: 'gaceta_industrial',
                info: 'Medio de información y publicación oficial de la SIC mediante el cual se dan a conocer las solicitudes presentadas y títulos otorgados en relación con marcas y demás signos distintivos, patentes de invención, modelos de utilidad y diseños industriales.',
                fuente: ''
            },

            {
                title: 'Grabación Efímera',
                key: 'grabación_efímera',
                info: 'Fijación sonora o audiovisual de una representación o ejecución o de una emisión de radiodifusión, realizada por un período transitorio por un organismo de radiodifusión, utilizando sus propios medios, y empleada en sus propias emisiones de radiodifusión.',
                fuente: 'Tomado de la Decisión 351 de la CAN.'
            },

            {
                title: 'Invención',
                key: 'invencion',
                info: 'Es un producto, metodología, proceso, técnica o desarrollo tecnológico resultado de la actividad humana por la cual se soluciona un problema técnico. Una invención para ser patentable deberá ser un nuevo producto o procedimiento que sean nuevos, tengan nivel inventivo o no sean obvios y tengan una aplicación industrial.',
                fuente: ''
            },

            {
                title: 'Inventor',
                key: 'inventor',
                info: 'Se considera inventor a aquella persona que ha contribuido intelectualmente al concepto inventivo y la materialización o puesta en práctica de la invención. Los inventores siempre serán personas naturales y tienen derecho a ser mencionados como tal en la patente. No se considera inventor la persona que sigue instrucciones o realiza trabajos de rutina.',
                fuente: ''
            },

            {
                title: 'Lema comercial',
                key: 'lema_comercial',
                info: 'Es un signo distintivo consistente en una palabra, frase o leyenda que se utiliza como complemento de una marca para reforzar su recordación. Se conoce comúnmente como slogan.',
                fuente: 'Tomado de la página web de la SIC: <a target="blank" href="http://www.sic.gov.co/lemas-comerciales/antes-de-solicitar">http://www.sic.gov.co/lemas-comerciales/antes-de-solicitar</a>.'
            },

            {
                title: 'Licencia de uso',
                key: 'licencia_de_uso',
                info: 'Es un contrato por el cual el titular de un derecho de propiedad intelectual autoriza a un tercero el uso del derecho para el propósito que acuerden las partes a cambio de una remuneración, compensación o reconocimiento. Este contrato debe hacerse por escrito y registrarse ante la autoridad nacional competente (DNDA, SIC o ICA en Colombia) para que tenga efectos frente a terceros.',
                fuente: ''
            },

            {
                title: 'Marcas',
                key: 'marcas',
                info: 'Cualquier signo que sea apto para distinguir productos o servicios en el mercado. Podrán registrarse como marcas los signos susceptibles de representación gráfica.',
                fuente: ''
            },

            {
                title: 'Marca Colectiva',
                key: 'marca_colectiva',
                info: 'Todo signo que sirva para distinguir el origen o cualquier otra característica común de productos o servicios pertenecientes a empresas diferentes y que lo utilicen bajo el control de un titular.',
                fuente: ''
            },

            {
                title: 'Marca de Certificación',
                key: 'marca_ertificacion',
                info: 'Un signo destinado a ser aplicado a productos o servicios cuya calidad u otras características han sido certificadas por el titular de la marca.',
                fuente: ''
            },

            {
                title: 'Marca multiclase',
                key: 'marca_multiclase',
                info: 'Marca que se registra para la protección de más de un producto o servicio que se encuentren clasificados en diferentes clases de las que trae la Clasificación Internacional de Niza.',
                fuente: 'Tomado de la página web de la SIC: <a target="blank" href="http://www.sic.gov.co/marcas/durante-el-tramite?qt-durante_el_tr_mite_de_marcas=1">http://www.sic.gov.co/marcas/durante-el-tramite?qt-durante_el_tr_mite_de_marcas=1</a>.'
            },

            {
                title: 'Nombre comercial',
                key: 'nombre_comercial',
                info: 'Signo que identifica al empresario en el desarrollo de una actividad mercantil.',
                fuente: ''
            },

            {
                title: 'Novedad de un invento',
                key: 'novedad_invento',
                info: 'Se considera nuevo todo lo que no está comprendido en el estado de la técnica a nivel mundial. Es decir, todo lo que antes de la fecha de presentación de la solicitud de patente no se ha hecho accesible al público en Colombia o en el extranjero.',
                fuente: ''
            },

            {
                title: 'Obra',
                key: 'obra',
                info: 'Toda creación intelectual original de naturaleza artística, científica o literaria, susceptible de ser divulgada o reproducida en cualquier forma.',
                fuente: 'Tomado de la Decisión 351 de la CAN.'
            },

            {
                title: 'Obra anónima',
                key: 'obra_anonima',
                info: 'Es aquella en donde no se menciona el nombre o seudónimo de autor por voluntad del mismo o por no ser conocido. En este último evento, la ley atribuye la titularidad de los derechos patrimoniales al editor de la obra, sin perjuicio de que en el momento en que el autor revele su identidad se le reconozca la titularidad correspondiente de los derechos de autor sobre la obra.',
                fuente: ''
            },

            {
                title: 'Obra audiovisual',
                key: 'obra_audiovisual',
                info: 'Toda creación expresada mediante una serie de imágenes asociadas, con o sin sonorización incorporada, que esté destinada esencialmente a ser mostrada a través de aparatos de proyección o cualquier otro medio de comunicación de la imagen y de sonido, independientemente de las características del soporte material que la contiene.',
                fuente: 'Tomado de la Decisión 351 de la CAN.'
            },

            {
                title: 'Obra Compuesta',
                key: 'obra_compuesta',
                info: 'Es la obra nueva a la cual se incorpora una obra preexistente, sin que medie colaboración entre los respectivos autores. Los autores de la obra compuesta son titulares de los derechos de autor sobre sus respectivas creaciones. La persona natural o jurídica que coordine una compilación se considera autor de ella sin perjuicio de los derechos de los titulares de las obras seleccionadas.',
                fuente: ''
            },

            {
                title: 'Obras con autoría plural',
                key: 'obras_con_autoria_plural',
                info: 'Son aquellas en las que para su creación intervienen dos o más personas, y de acuerdo a la naturaleza de sus aportes pueden dividirse en obra colectiva o obra colaboración.',
                fuente: '',
                subComponent: [
                    {
                        title: 'Obra Colectiva',
                        key: 'obra_colectiva',
                        info: 'Es aquella producida por un grupo de autores, por iniciativa y bajo la orientación de una persona natural o jurídica que la coordine, divulgue y publique bajo su nombre. En este caso, la ley presume que esta última detentará los derechos patrimoniales. Los autores conservarán las prerrogativas morales.',
                        fuente: '',
                    },
                    {
                        title: 'Obra en Colaboración',
                        key: 'obra_colaboracion',
                        info: 'Es la producida, conjuntamente, por dos o más personas naturales cuyos aportes no pueden ser separados. En este evento el ejercicio de los derechos patrimoniales corresponderá a todos los autores de tal manera que para que uno de ellos utilice la obra, necesitará el consentimiento de todos los demás.',
                        fuente: '',
                    },
                ]
            },

            {
                title: 'Obra de arte aplicado',
                key: 'obra_arte_aplicado',
                info: 'Creación artística con funciones utilitarias o incorporada en un artículo útil, ya sea una obra de artesanía o producida en escala industrial.',
                fuente: 'Tomado de la Decisión 351 de la CAN.'
            },

            {
                title: 'Obra Derivada',
                key: 'obra_derivada',
                info: 'Es aquella que resulta de la adaptación, traducción, u otra transformación de una originaria, siempre que constituya una creación autónoma.',
                fuente: '',
                subComponent: [
                    
                    {
                        title: 'Adaptaciones',
                        key: 'adaptaciones',
                        info: 'Esta clase de trabajo creativo va dirigido no a cambiar la esencia o filosofía de la obra original o preexistente, sino a variar algunos elementos relacionados con la forma de expresión, tiempo o circunstancias o, en muchos casos, se incorporan elementos que corresponden a otros géneros de creación artística o literaria. El ejemplo clásico de una adaptación es la versión cinematográfica de una novela.',
                        fuente: ''
                    },
                    
                    {
                        title: 'Compilaciones',
                        key: 'compilaciones',
                        info: 'En esta clase de obras derivadas, también llamadas "colecciones", se encuentran las antologías, las crestomatías y las enciclopedias. Las compilaciones pueden estar conformadas por obras preexistentes, o por datos e informaciones que tengan elementos creativos en razón de la organización o disposición de su contenido.',
                        fuente: ''
                    },
                    
                    {
                        title: 'Traducciones',
                        key: 'traducciones',
                        info: 'En este tipo de obras existe un esfuerzo creativo que es protegido por el derecho de autor, pues no sólo se requiere el dominio de los idiomas involucrados, sino la disposición de los recursos técnicos y literarios para lograr transmitir a cabalidad el sentido de la obra preexistente. En el caso de las obras audiovisuales, los doblajes y subtitulados dan como consecuencia una traducción de una obra que requiere de previa y expresa autorización del productor.',
                        fuente: ''
                    }
                ]
            },

            {
                title: 'Ocupación ilegítima o ciberocupación',
                key: 'ocupacion_ciberocupación',
                info: 'Consiste en registrar la marca de otra empresa o empresario como nombre de dominio.',
                fuente: ''
            },

            {
                title: 'Obras individuales',
                key: 'obras_individuales',
                info: 'Todas aquellas obras creadas por una sola persona.',
                fuente: ''
            },

            {
                title: 'Obra musical',
                key: 'obra_musical',
                info: 'Combinación de diferentes sonidos creando una obra artística.',
                fuente: ''
            },

            {
                title: 'Obra plástica o de bellas artes',
                key: 'obra_plástica_bellas',
                info: 'Creación artística cuya finalidad apela al sentido estético de la persona que la contempla, como las pinturas, dibujos, grabados y litografías. No quedan comprendidas en la definición las fotografías, obras arquitectónicas y las audiovisuales.',
                fuente: 'Tomado de la Decisión 351 de la CAN.'
            },

            {
                title: 'Obra por encargo',
                key: 'obra_encargo',
                info: 'Cuando la obra es creada en desarrollo de un contrato de prestación de servicios o el contrato de trabajo, la ley presume que la titularidad de los derechos patrimoniales la tiene el contratante o empleador.  El autor solo conserva las prerrogativas morales.',
                fuente: ''
            },

            {
                title: 'Obra póstuma',
                key: 'obra_postuma',
                info: 'Es aquella que ha sido dada a conocer al público sólo después de la muerte del autor.',
                fuente: ''
            },

            {
                title: 'Obras protegidas por Derecho de Autor',
                key: 'obras_derecho_de_autor',
                info: 'Obras originales fijadas en un medio físico, cualquiera que sea su naturaleza o sea el modo o forma de expresión o destinación y que están protegidas desde el momento mismo de su creación por el autor.',
                fuente: ''
            },

            {
                title: 'Obra originaria',
                key: 'obra_originaria',
                info: 'Aquella que resulta del trabajo intelectual del autor sin basarse en obra preexistente.',
                fuente: ''
            },

            {
                title: 'Obra seudónima',
                key: 'obra_seudonima',
                info: 'Es aquella en que el autor se oculta bajo un seudónimo o nombre que no lo identifica. En caso de usarlo, deberá acompañar una declaración de seudónimo efectuada ante notario donde conste que este se haya registrado conforme a las disposiciones relativas al estado civil de las personas, ya que de lo contrario el ejercicio de los derechos patrimoniales corresponderá al editor.',
                fuente: ''
            },

            {
                title: 'Oposición al registro',
                key: 'oposición_al_registro',
                info: 'Trámite que puede iniciar cualquier persona en un momento determinado del registro, cuando esta tenga interés legítimo para impedir el registro del derecho de propiedad intelectual, por considerar que se encuentra incurso en alguna de las causales de irregistrabilidad contenidas en la Ley.',
                fuente: ''
            },

            {
                title: 'Organismo de radiodifusión',
                key: 'organismo_radiodifusion',
                info: 'Empresa de radio o televisión que transmite programas al público.',
                fuente: 'Tomado de la Decisión 351 de la CAN.'
            },

            {
                title: 'Piratería',
                key: 'pirateria',
                info: 'Consiste en la fabricación, venta y cualquier forma de distribución comercial, ilegal, de ejemplares de obras literarias, artísticas, audiovisuales, musicales, de las interpretaciones o ejecuciones de las mismas, de programas de ordenador y de bancos de datos.',
                fuente: 'Tomado de Lipszyc, Delia, Derecho de Autor y Derechos Conexo, Tomo 2, Editorial. Félix Varela, La Habana, 2005, P. 560.'
            },

            {
                title: 'Plagio de una obra',
                key: 'plagio_obra',
                info: 'Es el acto de copiar una obra, entera o parcialmente, pretendiendo ser su autor original.',
                fuente: 'Tomado de la página web de la WIPO: <a target="blank" href="http://www.wipo.int/edocs/pubdocs/es/copyright/935/wipo_pub_935.pdf">http://www.wipo.int/edocs/pubdocs/es/copyright/935/wipo_pub_935.pdf</a>.'
            },

            {
                title: 'Producto',
                key: 'producto',
                info: 'todo aquello que haya sido fabricado por o con la intervención humana y que puede tener una aplicación, utilidad o uso en la industria o comercio y que puede también ser o formar parte de un invento susceptible de patente de invención.',
                fuente: ''
            },

            {
                title: 'Productor',
                key: 'productor',
                info: 'Persona natural o jurídica que tiene la iniciativa, la coordinación y la responsabilidad en la producción de la obra, por ejemplo, de la obra audiovisual o del programa de ordenador.',
                fuente: 'Tomado de la Decisión 351 de la CAN.'
            },

            {
                title: 'Productor de fonogramas',
                key: 'productor_fonogramas',
                info: 'Persona natural o jurídica bajo cuya iniciativa, responsabilidad y coordinación, se fijan por primera vez los sonidos de una ejecución u otros sonidos.',
                fuente: 'Tomado de la Decisión 351 de la CAN.'
            },

            {
                title: 'Programa de ordenador (Software)',
                key: 'programa_ordenador',
                info: 'Expresión de un conjunto de instrucciones mediante palabras, códigos, planes o en cualquier otra forma que, al ser incorporadas en un dispositivo de lectura automatizada, es capaz de hacer que un ordenador , aparato electrónico o similar capaz de elaborar informaciones, ejecute determinada tarea u obtenga determinado resultado. El programa de ordenador comprende también la documentación técnica y los manuales de uso.',
                fuente: 'Tomado de la Decisión 351 de la CAN.'
            },

            {
                title: 'Propiedad Industrial',
                key: 'propiedad_industrial',
                info: 'Conjunto de derechos que detenta una persona física o jurídica sobre un signo distintivo, una creación, o un secreto empresarial.',
                fuente: ''
            },

            {
                title: 'Protección de Secreto Empresarial',
                key: 'Protección secreto_empresarial',
                info: 'Quien lícitamente sea el titular de los derechos y tenga control de un derecho de secreto empresarial, estará protegido contra la divulgación, adquisición o uso de tal secreto de manera contraria a las prácticas leales de comercio por parte de terceros. Para ello, el titular del derecho deberá tomar las medidas razonables para mantener el secreto y de esa forma mantener el valor económico y comercial del mismo.',
                fuente: ''
            },

            {
                title: 'Publicación',
                key: 'publicacion',
                info: ' Es la divulgación de una obra artística, científica o artística protegida por el derecho de autor mediante la impresión, producción o permitiendo el acceso o disponibilidad por cualquier medio la obra, al alcance del público y con el consentimiento del titular del respectivo derecho.',
                fuente: ''
            },

            {
                title: 'Reivindicaciones',
                key: 'reivindicaciones',
                info: 'Son oraciones ubicadas en el capítulo reividicativo de la patente o patente de modelo de utilidad que definen la materia que se desea proteger con la patente y determina el alcance de la protección del derecho. La reivindicación debe estar redactada de manera clara, no ambigua y concisa y estar enteramente sustentada en la descripción. La extensión legal de la protección conferida por la patente se determina por el contenido de cada una de las reivindicaciones.',
                fuente: ''
            },

            {
                title: 'Retransmisión',
                key: 'retransmision',
                info: 'Reemisión de una señal o de un programa recibido de otra fuente, efectuada por difusión inalámbrica de signos, sonidos o imagines, o mediante hilo, cable, fibra óptica u otro procedimiento análogo.',
                fuente: 'Tomado de la Decisión 351 de la CAN.'
            },

            {
                title: 'Secretos Empresariales',
                key: 'secretos_empresariales',
                info: 'Es cualquier información no divulgada que una persona natural o jurídica legítimamente posea, que pueda usarse en alguna actividad productiva, industrial o comercial, y que sea susceptible de transmitirse a un tercero, en la medida que dicha información sea: <ul><li>Secreta.</li><li>Tenga un valor comercial por ser secreta.</li><li>Haya sido objeto de medidas razonables tomadas por su legítimo poseedor para mantenerla secreta.</li></ul>',
                fuente: 'Tomado de la Decisión 486.'
            },

            {
                title: 'Servicio',
                key: 'servicio',
                info: 'Es la actividad que busca brindar a sus clientes una satisfacción a sus necesidades.',
                fuente: ''
            },

            {
                title: 'Signos distintivos',
                key: 'signos_distintivos',
                info: 'Símbolos capaces de distinguir en el mercado, los productos o servicios de un comerciante de los de otro. Son especies de signos distintivos las marcas, los lemas comerciales, los nombres y enseñas comerciales, las denominaciones de origen y las indicaciones de procedencia.',
                fuente: ''
            },

            {
                title: 'Titular',
                key: 'titular',
                info: 'Es la persona, natural o jurídica, a quien pertenece el derecho de propiedad intelectual y puede ejercer las prerrogativas, acciones, exclusiones y poderes que la ley o la norma supranacional le concede al respectivo derecho de propiedad intelectual.',
                fuente: ''
            },

            {
                title: 'Usos honrados',
                key: 'usos_honrados',
                info: 'Los que no interfieran con la explotación normal de la obra ni causen un perjuicio irrazonable a los intereses legítimos del autor.',
                fuente: 'Tomado de la Decisión 351 de la CAN.'
            },

            {
                title: 'Uso personal',
                key: 'uso_personal',
                info: 'Reproducción u otra forma de utilización, de la obra de otra persona, en un solo ejemplar, exclusivamente para el propio uso de un individuo, en casos tales como la investigación y el esparcimiento personal.',
                fuente: 'Tomado de la Decisión 351 de la CAN.'
            }
          
        ];

        return {
            openModal: true,
            input: '',
            columns: 3,
            data:_.map(data, item => {
                        item.modal = false;
                        if (item.subComponent) {
                            item.openList = false;
                            item.subComponent = _.map(item.subComponent, subItem => {
                                                        subItem.modal = false;
                                                        return subItem})
                        }
                        return item;
                    })
        }

    } 
}
</script>

