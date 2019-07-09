<template lang='html'>

    <div class="manual-container">

        <div>
             <div @click="openMenu = !openMenu" :class="openMenu ? 'bar-button-click' : 'bar-button'" /> 

            <div :class="openMenu ? 'click-info-bar' : 'info-bar'">

                <ul style="padding-left: 0px;">
                    <li><a @click="onClickItem" href="#en_que_consiste">EN QUÉ CONSISTE LA HERRAMIENTA</a>

                      <ul>
                          <li><a @click="onClickItem"  href="#etapas">1 FORMULARIO DE DIAGNÓSTICO</a>

                            <ul style="padding-left: 25px;">

                              <li><a @click="onClickItem"  href="#descripcion">1.1 Descripción</a></li>
                              <li><a @click="onClickItem"  href="#clasificacion">1.2 Clasificación del AI</a></li>
                              <li><a @click="onClickItem"  href="#estado">1.3 Estado</a></li>
                              <li><a @click="onClickItem"  href="#dpi_asociado">1.4 DPI Asociados</a></li>
                              <li><a @click="onClickItem"  href="#estado_actual">1.5 Estado Actual del AI</a></li>
                              <li><a @click="onClickItem"  href="#comentarios">1.6 Comentarios</a></li>
                              <li><a @click="onClickItem"  href="#plan_accion">1.7 Plan de Acción y protección</a></li>
                              <li><a @click="onClickItem"  href="#priorizacion">1.8 Priorización y decisión</a></li>
                              <li><a @click="onClickItem"  href="#uso_comercial">1.9 Uso comercial</a></li>
                              
                            </ul>

                          </li>
                      </ul>

                    </li>
                    <li><a @click="onClickItem" href="#d_reporte">2 REPORTE</a></li>
                    <li><a @click="onClickItem" href="#d_estrategias">3 ESTRATEGIAS DE GESTIÓN</a></li>
                    <li><a @click="onClickItem" href="#d_historial">4 HISTORIAL</a></li>
                    <li><a @click="onClickItem" href="#siglas">5 SIGLAS IMPORTANTES</a></li>
                    <li><a @click="onClickItem" href="#d_grupos_investigacion">6 ¿A QUÉ HACE REFERENCIA UN GRUPO DE INVESTIGACIÓN EN LA APLICACIÓN?</a></li>
                    <li><a @click="onClickItem" href="#d_proyectos">7 ¿A QUÉ HACE REFERENCIA UN PROYECTO EN LA APLICACIÓN?</a></li>
                    <li><a @click="onClickItem" href="#d_activos_intangibles">8 ¿QUÉ ES UN ACTIVO INTANGIBLE?</a></li>
                    <li><a @click="onClickItem" href="#navegacion">9 GUÍA DE NAVEGACIÓN</a>
                      <ul style="padding-left: 20px;">
                          <li><a @click="onClickItem" href="#menu_vertical">9.1 MENÚ VERTICAL</a></li>
                          <li><a @click="onClickItem" href="#init">9.1 Página de inicio</a></li>
                          
                          <li><a @click="onClickItem" href="#grupos_investigacion">9.2 Grupos de investigación</a>
                            <ul style="padding-left: 20px;">
                                <li><a @click="onClickItem" href="#grupos_investigacion_todos">9.2.1 Todos los grupos</a></li>
                                <li><a @click="onClickItem" href="#grupos_investigacion_mis_grupos">9.2.2 Mis grupos</a></li>
                                <li><a @click="onClickItem" href="#crear_grupo">9.2.3 Crear grupo de investigación</a></li>
                                <li><a @click="onClickItem" href="#editar_grupo">9.2.4 Editar grupo de investigación</a></li>
                                <li><a @click="onClickItem" href="#proyectos">9.2.5 Proyectos</a>
                                <li><a @click="onClickItem" href="#crear_proyecto">9.2.6 Crear proyecto</a></li>
                            </ul>
                          </li>

                          <li><a @click="onClickItem" href="#proyectos">9.2 Proyectos</a>
                            <ul style="padding-left: 20px;">
                                <li><a @click="onClickItem" href="#crear_proyecto">9.2.6 Crear proyecto</a></li>
                            </ul>
                          </li>


                        <li><a @click="onClickItem" href="#activos">9.6 Activos</a>
                            <ul style="padding-left: 20px;">
                                <li><a @click="onClickItem" href="#crear_activo">9.6.1 Crear un activo intangible</a></li>
                                <li><a @click="onClickItem" href="#ver_activo">9.6.2 Ver un activo intangible</a></li>
                                <li><a @click="onClickItem" href="#formulario">9.6.3 Formulario</a></li>
                                <li><a @click="onClickItem" href="#reportes">9.6.4 Reporte</a></li>
                                <li><a @click="onClickItem" href="#estrategias">9.6.5 Estrategias de gestión</a></li>
                                <li><a @click="onClickItem" href="#historial">9.6.6 Historial</a></li>
                            </ul>
                        </li>


                        <li><a @click="onClickItem" href="#reporte_general">9.6 Reporte general</a>

                        </li>


                        <li><a @click="onClickItem"  href="#usuarios">9.3 Usuarios</a>
                            <ul style="padding-left: 20px;">
                                <li><a @click="onClickItem"  href="#lista_usuarios">9.3.1 Lista de usuarios</a></li>
                                <li><a @click="onClickItem"  href="#crear_usuarios">9.3.2 Crear usuarios</a></li>
                                <li><a @click="onClickItem"  href="#editar_usuarios">9.3.3 Editar usuarios</a></li>
                                <li><a @click="onClickItem"  href="#eliminar_usuarios">9.3.4 Eliminar usuarios</a></li>
                                 <li><a @click="onClickItem"  href="#perfil">9.3.5 Perfil</a>
                                 <li><a @click="onClickItem" href="#editar_perfil">9.3.6 Editar perfil</a></li>
                            </ul>
                          </li>

                      </ul>
                    </li>

                </ul>
            </div>
        </div>

        <div class="normatividad-content-container">

            <span class="info-title" style="font-size: 30px; font-weight: bold">Manual de Usuario Herramienta Inventario de AI - IAMD</span>

          <br><br>
            <div>

              <div>
                    <span class="info-title" style="font-size: 30px;">EN QUÉ CONSISTE LA HERRAMIENTA:</span>
                    <span class="anchor" id="en_que_consiste"></span>
                    <p>La Herramienta “IAMD - Intellectual Assets Managing Data By OlarteMoure” es una
                        herramienta que permite hacer inventario de activos intangibles (AI) de tal forma que los
                        responsables o encargados de gestionar los resultados de I+D+i+e de la Universidad tengan
                        una herramienta de referencia, guía o consulta. La herramienta incorpora un protocolo para
                        realizar el inventario de AI que puede ser particularmente útil para aquellos que no se
                        encuentran familiarizados con estos temas de propiedad intelectual (PI), personas involucradas
                        en las actividades de I+D+i+e y en la gestión, administración y dirección de los AI y los
                        derechos de propiedad intelectual (DPI). Esta herramienta organiza las etapas, pasos y
                        momentos relevantes para llevar a cabo las actividades de identificación de AI lo que permite
                        finalmente conocer el estado del AI y trazar un plan de acción para su protección, gestión y/o
                        comercialización. Las etapas que incorpora el protocolo de la herramienta para realizar el
                        inventario de AI son:</p>
                </div>


                 <div>
                    <span class="info-title" style="font-size: 30px;">FORMULARIO DE DIAGNÓSTICO: </span>
                    <span class="anchor" id="etapas"></span>
                </div>

                <div>
                    <span class="info-title" style="font-size: 25px;">Descripción:</span>
                    <span class="anchor" id="descripcion"></span>
                    <p>Esta etapa permite obtener una descripción detallada sobre el AI: en qué consiste, si pertenece
                        a un proyecto, a un producto, quiénes son los autores, diseñadores, inventores o titulares y en
                        general todas las particularidades del AI que para su evaluación puedan tener alta relevancia.</p>
                </div>

                <div>
                    <span class="info-title" style="font-size: 25px;">Clasificación del AI:</span>
                    <span class="anchor" id="clasificacion"></span>

                    <p>Esta etapa permite clasificar el AI según su naturaleza misma. En este sentido, la herramienta
le permite al usuario seleccionar entre varias opciones:</p>

                    <ul>

                      <li><strong>Logos, signos, palabras o frases distintivas: </strong>Corrientemente están asociadas y sirven para identificar, individualizar o hacer distintivo un producto o un servicio. No es necesario que se hayan solicitado o registrado  como maca o lema comercial ante la autoridad competente (en Colombia la Superintendencia de Industria y Comercio).</li>

                      <li><strong>Publicación: </strong>Documento escrito que ha sido puesto a disposición del público en alguna revista nacional o internacional, indexada o no indexada, en algún portal, página web, blog, etc. y en lo posible identifique el medio en el que se hizo la publicación en la descripción que puede ser científico, técnico o artístico y resultado de las actividades académicas o de I+D+i+e.  Si esta publicación se trata de un libro, una tesis de grado u otra clase de publicación independientemente del medio (impreso, digital electrónico, etc.) se debe indicar esta clase de publicación de preferencia.</li>

                      <li><strong>Artículo, ensayo, presentación o poster: </strong>Documento escrito que no ha sido publicado o está en proceso de ser publicado y que puede ser científico, técnico o artístico y resultado de las actividades académicas o de I+D+i+e.</li>

                      <li><strong>Diseños: </strong>Es el documento que contiene la apariencia particular de un producto que resulte de cualquier reunión de líneas o combinación de colores, o de cualquier forma externa bidimensional o tridimensional, línea, contorno, configuración, textura o material, sin que cambie el destino o finalidad de dicho producto.</li>

                      <li><strong>Tesis: </strong>Documento académico y de investigación sin importar si este se ha publicado o no.</li>

                      <li><strong>Planos, esquemas, representaciones gráficas, dibujos, posters, fotografías: </strong>Documentos que hacen representaciones gráficas, esquemáticas, artísticas, técnicas o científicas.</li>
                      <li><strong>Lema: </strong>Son las frases que acompañan una marca que distinguen un producto o servicio en el mercado. Seleccionarlas en esta categoría sin importar si aún no se han solicitado ante la autoridad competente.</li>
                      <li><strong>Resultado de I+D: </strong>Aquí se agrupa el conjunto de documentos, diseños, modelos, inventos, prototipos, productos, subproductos, metodologías o procesos que resulten de las actividades de investigación y desarrollo ya sea que se hayan desarrollado en un proyecto de la Universidad (o de un miembro de la comunidad universitaria), o de la Universidad con un tercero. Use esta opción cuando crea que no hay otra que identifique, describa o individualice mejor el activo intangible identificado.</li>
                      <li><strong>Obra Audiovisual: </strong>Es una obra que puede tener contenido artístico, científico o técnico que pueden componerse de  varios activos intangibles que en individualmente también son activos intangibles y podrían protegerse individualmente.  Por favor tome en cuenta que cada uno debe identificarse e inventariarse de manera independiente, por ejemplo, música que se crea para su banda sonora, el guion, los dibujos animados, los signos distintivos que individualiza e identifica la obra,  entre otros.</li>
                      <li><strong>Obra musical: </strong>Las obras musicales, al igual que las obras audiovisuales, pueden estar conformados por muchos activos intangibles. Por ejemplo, un activo intangible es la letra de la canción y otro activo intangible es la pista instrumental. Y si es así, por favor identifíquelos e inventaríelos de manera independiente.</li>
                      <li><strong>Información confidecial: </strong>Se refiere a toda la información que no es de carácter público y que por estrategia su acceso es limitado al personal autorizado. Por ejemplo. la información de un resultado de I+D puede ser confidencial antes de que se solicite una patente.</li>
                      <li><strong>Software: </strong>Si el activo intangible identificado es un programa de ordenador o instrucciones o tareas para una computadora, deberá seleccionarse esta opción.</li>
                      <li><strong>Base de datos: </strong>Compilación de datos o información, independientemente que existan en forma impresa, en unidades de almacenamiento en computador o de cualquier otra forma, seleccionados y dispuestos original y sistemáticamente para su posterior uso.</li>
                      <li><strong>Know-how: </strong>Conjunto estructurado o no estructurado de saber hacer o saber producir o saber creado, desarrollado, organizado u obtenido.</li>


                      <li><strong>Otros: </strong>Cuando el activo intangible identificado no se encuentre dentro de las opciones específicas deberá seleccionarse esta opción y hacerse precisión en cuál es la clasificación.</li>

                    </ul>
                </div>

                <div>
                    <span class="info-title" style="font-size: 25px;">Estado:</span>
                    <span class="anchor" id="estado"></span>

                    <p>Esta etapa permite obtener información sobre el estado de gestión del AI, es decir, si nunca se
había identificado el AI, si previamente se había identificado pero no se había protegido, o si
por el contrario se había identificado y se protegió debidamente.</p>
                </div>

                <div>
                    <span class="info-title" style="font-size: 25px;">DPI asociados: </span>
                    <span class="anchor" id="dpi_asociado"></span>

                    <p>Esta etapa permite identificar el o los DPI que se encuentren asociados al AI. Cada activo
intangible puede tener uno o más derechos de propiedad intelectual asociados para su
protección. Por ejemplo, un software puede protegerse a través del derecho de autor, pero
también a través de una patente si cumple con los requisitos y soluciona un problema técnico,
a su vez, este software puede tener una marca asociada y también un diseño industrial para
proteger su interfaz, entre otros.</p>

                    <p>La herramienta permite seleccionar uno o varios DPI asociados: derecho de autor, signos
distintivos, patentes, diseños industriales, secretos empresariales, esquemas de trazado y/o
variedades vegetales.</p>
                </div>

                <div>
                    <span class="info-title" style="font-size: 25px;">Estado actual del AI: </span>
                    <span class="anchor" id="estado_actual"></span>

                    <p>Esta etapa permite reconocer el estado de identificación del AI por medio de preguntas que
señalan factores como: estado de divulgación del AI; confidencialidad alrededor del AI;
titularidad del AI; ubicación del AI y si éste se ha incorporado o no en la contabilidad de la
Universidad.</p>

                </div>

                <div>
                    <span class="info-title" style="font-size: 25px;">Comentarios:</span>
                    <span class="anchor" id="comentarios"></span>

                    <p>Esta etapa permite indicar al usuario todos los comentarios que tenga adicionales sobre la
información que se ha diligenciado y que sean importantes para la evaluación del activo
intangible. En este espacio puede hacer todas las anotaciones que sean necesarias y que
considere pertinentes.</p>

                </div>

                <div>
                    <span class="info-title" style="font-size: 25px;">Plan de acción y protección:</span>
                    <span class="anchor" id="plan_accion"></span>

                    <p>Esta etapa permite la construcción de un plan de acción para la protección del AI a partir de la
información diligenciada en las etapas anteriores, por ejemplo, si se requiere el depósito o

registro de algún DPI asociado o si ya existe tener relación de los números de referencia de
dichos depósitos o registros. Igualmente permite saber si deben tomarse medidas razonables
para la protección de un secreto empresarial e indicar cuáles y si se requiere de la
suscripción de algún contrato para proteger el AI.</p>

                </div>

                <div>
                    <span class="info-title" style="font-size: 25px;">Priorización y decisión: </span>
                    <span class="anchor" id="priorizacion"></span>

                    <p>Esta etapa permite indicar si se requiere el uso de alguna herramienta de priorización como
vigilancias tecnológicas, libertad de operación, estudios de mercado, patent landscaping u
otros y además permite identificar si existe o no presupuesto para realizar estas actividades de
priorización y decisión.</p>

                </div>

                <div>
                    <span class="info-title" style="font-size: 25px;">Uso comercial: </span>
                    <span class="anchor" id="uso_comercial"></span>
                    <p>Esta etapa permite identificar si actualmente hay un uso comercial del AI y cuál es éste, o si se
tiene pensado hacerlo.</p>
                </div>


                 <div>
                    <span class="info-title" style="font-size: 30px;">REPORTE:</span>
                    <span class="anchor" id="d_reporte"></span>

                    <p>El reporte que arroja la herramienta es un reporte escrito que permite identificar de manera resumida las respuestas que indicó el usuario al diligenciar el formulario de identificación y cada una de sus etapas.</p>
                    <p>Adicionalmente, el reporte permite identificar de manera visual las etapas del AI que tienen mayor urgencia de gestión señalándolas en color rojo, igualmente, las etapas del AI que requieren de atención en su gestión pero que no son tan urgentes en color naranja, y las etapas del AI que se encuentran correctamente gestionadas en color verde.</p>
                    <p>El reporte permite también saber en qué estado se encuentra el diligenciamiento del formulario para la identificación e inventario del AI mostrando en una gráfica circular que identifica con color verde si la información se encuentra completa y color naranja si la información se encuentra incompleta.</p>
                </div>

                <div>
                    <span class="info-title" style="font-size: 30px;">ESTRATEGIAS DE GESTIÓN:</span>
                    <span class="anchor" id="d_estrategias"></span>

                    <p>Esta etapa permite, de acuerdo a la información recogida en el diligenciamiento, describir cuáles son las sugerencias y estrategias generales para la gestión, gerencia y administración del AI y los DPI asociados.</p>
                    <p>Igualmente, permite trazar estrategias de gestión específicas para cada alerta que se haya levantado en el diligenciamiento del formulario del diagnóstico que comprende el protocolo y asignar a cada una de estas estrategias un encargado para su ejecución.</p>

                </div>
                    <span class="info-title" style="font-size: 30px;">HISTORIAL:</span>
                    <span class="anchor" id="d_historial"></span>

                    <p>El módulo Historial permite tener una trazabilidad de las modificaciones y ediciones que se hayan hecho en el texto del diligenciamiento del formulario de diagnóstico que comprende el protocolo y lo relaciona con los usuarios que realizaron cada una de las modificaciones y la fecha en la que se hicieron.</p>
                    <p>Este módulo permite filtran las etapas sobre las cuales se quiere conocer la trazabilidad o historial de cambios, por ejemplo, si solo deseo conocer los cambios que se han hecho para la etapa “Descripción” puedo filtrarlo así en la herramienta.</p>
                    <p>Esta herramienta es un software cuyo principal objetivo es fortalecer el ciclo de gestión de PI (identificación, protección, gestión, transferencia y defensa) y dotar a la Escuela de Ingeniería con herramientas conceptuales, de procedimiento y de software para Gerencia efectiva de sus AI y su PI (lo que corrientemente se denomina IP Management).</p>
                <div>

                </div>

                <div>
                    <span class="info-title" style="font-size: 30px;">SIGLAS IMPORTANTES:</span>
                    <span class="anchor" id="siglas"></span>
                    <ul>
                      <li><strong>AI: </strong>Activos Intangibles</li>
                      <li><strong>DPI: </strong>Derechos de Propiedad Intelectual</li>
                      <li><strong>CAN: </strong>Comunidad Andina de Naciones</li>
                      <li><strong>DA: </strong>Derechos de Autor</li>
                      <li><strong>DNDA: </strong>Dirección Nacional de Derecho de Autor</li>
                      <li><strong>I+D+i+e: </strong>Investigación, Desarrollo, Innovación y Emprendimiento</li>
                      <li><strong>OMPI: </strong>Organización Mundial de la Propiedad Intelectual (WIPO por sus siglas en inglés)</li>
                      <li><strong>PCT: </strong>Tratado de Cooperación en Materia de Patentes</li>
                      <li><strong>PI: </strong>Propiedad Intelectual</li>
                      <li><strong>SD: </strong>Signos Distintivos</li>
                      <li><strong>SE: </strong>Secreto Empresarial</li>
                      <li><strong>SIC: </strong>Superintendencia de Industria y Comercio</li>
                    </ul>
                </div>

                <div>
                    <span class="info-title" style="font-size: 25px;">¿A QUÉ HACE REFERENCIA UN GRUPO DE INVESTIGACIÓN EN LA
APLICACIÓN?</span>
                    <span class="anchor" id="d_grupos_investigacion"></span>

                    <p>La Herramienta “IAMD - Intellectual Assets Managing Data By OlarteMoure” permite la
identificación de los AI que resulten de las actividades de I+D+i+e de los grupos de
investigación de la Escuela de Ingeniería, entendiendo como grupo de investigación
todas las unidades, áreas, direcciones o dependencias que tengan participación en actividades
de I+D+i+e y que tengan resultados que pueden protegerse a través de uno o más DPI.
                    </p>
                </div>

                <div>
                    <span class="info-title" style="font-size: 25px;">¿A QUÉ HACE REFERENCIA UN PROYECTO EN LA APLICACIÓN?</span>
                    <span class="anchor" id="d_proyectos"></span>

                    <p>Cada grupo de investigación, unidad, área, dirección o dependencia de la Universidad dirige
sus esfuerzos a diferentes proyectos de I+D+i+e de los cuales pueden resultar AI protegibles
por DPI. La herramienta pretende identificar cada AI con los proyectos a los que éstos se
encuentran vinculados y a los cuales pertenecen con el fin de crear un contexto más exacto al
momento de estudiarlos, analizarlos y diagnosticarlos para trazar un plan de acción y
protección del mismo.</p>
                </div>

                <div>
                    <span class="info-title" style="font-size: 25px;">¿QUÉ ES UN ACTIVO INTANGIBLE?</span>
                    <span class="anchor" id="d_activos_intangibles"></span>

                    <p>Los activos intangibles son todos aquellos activos inmateriales, que son creación del intelecto humano y que son susceptibles de valoración económica. Por ejemplo, la letra de una canción, un artículo de investigación, resultados de proyectos de I+D, una fotografía, una tesis, una metodología, un proceso, entre otros.</p>
                    <p>La herramienta permite inventariar cada uno de estos AI de manera independiente a los demás
                      AI que hagan parte del mismo proyecto del grupo de investigación, unidad, área, dirección o
                      dependencia de la Universidad, por ejemplo, dentro de un mismo proyecto de investigación
                      puede haber varios AI como una o varias publicaciones (cada publicación es un AI diferente),
                      un prototipo, una fórmula química, un modelo de negocio, un plan de negocio, etc. Esto con el
                      objetivo de que al final se tenga un panorama claro de cada uno de los AI que conforman un
                      proyecto y éste se pueda gestionar o gerenciar de la manera más adecuada de acuerdo a los
                      intereses de la Universidad.</p>
                </div>

                <div>
                    <span class="info-title" style="font-size: 30px;">GUÍA DE NAVEGACIÓN:</span>
                    <span class="anchor" id="navegacion"></span>
                </div>

                <div>
                    <span class="info-title" style="font-size: 30px;">MENÚ VERTICAL:</span>
                    <span class="anchor" id="menu_vertical"></span>
                    <p>
                      La herramienta cuenta con un menú vertical en el lado izquierdo de la pantalla el cual permite al usuario ingresar directamente a los módulos de navegación de principal interés para realizar el ejercicio de Inventario de Activos Intangibles. El Menú despliega las opciones de los módulos: Página de inicio, Grupos de Investigación, Proyectos, Activos, Reporte General y Usuarios (este último solo para administradores).
                    </p>
                </div>

                <div>
                    <span class="info-title" style="font-size: 30px;">Página de inicio:</span>
                    <span class="anchor" id="init"></span><p>
                    Al ingresar en ésta página se encontrarán los tres módulos principales de la aplicación:
proyectos, activos y usuarios (este último solo para administradores), y se desplegará una
gráfica indicando el número de activos en progreso de diligenciamiento (en proceso o

finalizados). También, se mostrará una lista con los últimos activos que se hayan modificado
en la herramienta permitiendo un acceso directo a los mismos.
                    </p>
                    <div class="row ">
                    <div class="col-md-6"><img src="images/manual_1.png" style="width: 100%" class="img-manual" /></div>

                    <div class="col-md-6"><img src="images/manual_2.png" style="width: 100%" class="img-manual" /></div>
                    </div>
                </div>

                <div>
                <span class="info-title" style="font-size: 30px;">Grupos de investigación: </span>
                <span class="anchor" id="grupos_investigacion"></span>
                   <p>El módulo de grupos de investigación se divide en dos: todos los grupos y mis grupos. Vamos
a explicar cada uno en detalle:</p>
                </div>

                <div>
                  <span class="info-title" style="font-size: 25px;">Mis grupos: </span>
                  <span class="anchor" id="grupos_investigacion_mis_grupos"></span>
                  <p>Acá se encuentran los grupos de investigación que pertenecen al usuario (que han
sido creados por el usuario o que se le han designado) que ha iniciado sesión en la aplicación.</p>

                  <p>Para acceder a mis grupos seleccionamos la opción grupos de investigación y luego mis grupos
en el menú lateral.</p>
                  <img src="images/manual_24.png" style="width: 60%%" class="img-manual" />
                </div>

                <div>
                  <span class="info-title" style="font-size: 25px;">Todos los grupos: </span>
                  <span class="anchor" id="grupos_investigacion_todos"></span>
                  <p>Acá se encuentran los grupos de investigación de todos los usuarios, en
caso de tener el rol de administrador este tendrá acceso a todos ellos tanto para revisarlos como
para editarlos.</p>

                  <p>Para acceder a todos los grupos seleccionamos la opción grupos de investigación y luego todos
los grupos en el menú lateral.</p>
                  <img src="images/manual_25.png" style="width: 60%%" class="img-manual" />
                  <p>Las acciones de editar y crear grupo de investigación son idénticas tanto en “Mis grupos” como
en “Todo los grupos”.</p>
                </div>
                
                <div>
                  <span class="info-title" style="font-size: 25px;">Crear grupo de investigación: </span>
                  <span class="anchor" id="crear_grupo"></span>
                  <p>Para crear un grupo de investigación damos click en el botón
“Crear nuevo grupo de investigación”.</p>
                  <img src="images/manual_26.png" style="width: 60%%" class="img-manual" />
                  <p>Esto nos desplegará un formulario donde podremos crear un nuevo grupo de investigación. Sin embargo, dicho formulario solo nos mostrará la opción de elegir un encargado del grupo de investigación si el usuario que inicio sesion es administrador, en caso contrario el encargado será quien cree el grupo.</p>
                  <img src="images/manual_27.png" style="width: 60%%" class="img-manual" />
                  <p><strong>Nota: Un usuario no puede tener más de un grupo de investigación con el mismo nombre.</strong></p>
                </div>

                <div>
                  <span class="info-title" style="font-size: 25px;">Editar grupo de investigación: </span>
                  <span class="anchor" id="editar_grupo"></span>
                  <p>Para editar un grupo de investigación se debe de seleccionar el icono de editar que aparece en la parte derecha de este en la lista de grupos de investigación.</p>
                  <img src="images/manual_28.png" style="width: 60%%" class="img-manual" />
                  <p>Esto nos desplegará un formulario donde podremos editar el grupo de investigación.</p>
                  <img src="images/manual_29.png" style="width: 60%%" class="img-manual" />
                </div>

                <div>
                <span class="info-title" style="font-size: 25px;">Proyectos:</span>
                <span class="anchor" id="proyectos"></span>
                    <p>Para ver los proyectos asociados a un grupo de investigación debemos de seleccionar el grupo en la lista de grupos de investigación ya sea accediendo a todos mis grupos(si se tiene cuenta de administrador) o a mis grupos.</p>
                    <img src="images/manual_30.png" style="width: 60%%" class="img-manual" />
                    <p>Al seleccionar un grupo se desplegará una ventana con la lista de proyectos asociados al grupo seleccionado.</p>
                    <img src="images/manual_31.png" style="width: 60%%" class="img-manual" />
                </div>

                 <div>
                  <span class="info-title" style="font-size: 25px;">Crear proyecto:</span>
                  <span class="anchor" id="crear_proyecto"></span>
                  <p>Para crear un proyecto debemos dar click en el botón “Crear nuevo proyecto”.</p>
                  <img src="images/manual_32.png" style="width: 60%%" class="img-manual" />
                  <p>Esto nos desplegará un formulario para crear un nuevo proyecto.</p>
                  <img src="images/manual_33.png" style="width: 60%%" class="img-manual" />
                  <p><strong>Nota: Un grupo de investigación no puede tener más de un proyecto con el mismo
nombre.</strong></p>
                </div>
                
                <div>
                <span class="info-title" style="font-size: 30px;">Activos:</span>
                <span class="anchor" id="activos"></span>
                    <p>Para ver los activos intangibles asociados a un proyecto debemos de seleccionar un
proyecto en la lista de proyectos.</p>
                    <img src="images/manual_34.png" style="width: 60%%" class="img-manual" />
                    <p>Esto nos desplegara la lista de activos intangibles asociados al proyecto seleccionado, en dicha
lista se muestra el nombre del activo, el estado del diligenciamiento y su clasificación.</p>
                    <p>También podemos acceder a todos nuestros activos intangibles seleccionando la opción
Activos situada en el menú lateral.</p>
                    <img src="images/manual_35.png" style="width: 60%%" class="img-manual" />
                </div>

                <div>
                <span class="info-title" style="font-size: 25px;">Crear un activo intangible:</span>
                <span class="anchor" id="crear_activo"></span>
                    <p>Para crear un nuevo activo intangible damos click en el botón
“Crear nuevo activo intangible”.</p>
                    <img src="images/manual_36.png" style="width: 60%%" class="img-manual" />
                    <p>Esto nos desplegará un formulario para ingresar el nombre del activo.</p>
                    <img src="images/manual_37.png" style="width: 60%%" class="img-manual" />
                    <p><strong>Nota: Un proyecto no puede tener más de un activo con el mismo nombre.</strong></p>
                </div>

                <div>
                <span class="info-title" style="font-size: 25px;">Ver un activo intangible:</span>
                <span class="anchor" id="ver_activo"></span>
                    <p>Una vez que creamos un activo intangible ya podemos acceder a
este, para ello seleccionamos el activo deseado en la lista de activos intangibles, lo cual nos
desplegara la siguiente ventana.</p>
                    <img src="images/manual_38.png" style="width: 60%%" class="img-manual" />
                    <p>Como vemos esta pestaña se divide en 4 partes: Formulario, Reporte, Estrategias de gestión e Historial. Vamos a ver cada una de ellas en más detalle:</p>
                </div>

                <div>
                  <span class="info-title" style="font-size: 25px;">Formulario:</span>
                  <span class="anchor" id="formulario"></span>
                  <p>En esta pestaña aparecerán cada uno de los pasos que debes de completar para diligenciar toda
la información asociada al activo intangible. Estos pasos se deben de diligenciar
secuencialmente y no se puede acceder a uno sin completar el anterior previamente. Para
acceder a uno de los pasos desbloqueados solo debes dar click en este, esto abrirá un formulario
el cual debes de diligenciar para completar el paso.</p>
                </div>

                <div>
                  <span class="info-title" style="font-size: 25px;">Reporte:</span>
                  <span class="anchor" id="reportes"></span>
                  <p>A medida que se diligencie la información del formulario, un resumen de dicha información
aparecerá en la pestaña de “Reporte”.</p>
                  <img src="images/manual_42.png" style="width: 60%%" class="img-manual" />
                  <p>Igualmente, cuando las respuestas diligenciadas sugieran que hay pendientes y pendientes
urgentes, la estrategia de gestión que se diligencie en la pestaña siguiente para el caso en
particular aparecerá en el “Reporte”, como se indicará más adelante.</p>
                  <p>También en esta pestaña podrás encontrar dos gráficas, una que muestra el porcentaje de
pendientes y pendientes urgentes para tener en cuenta en la estrategia de gestión y otra que
muestra el porcentaje relativo al progreso del formulario.</p>
                  <img src="images/manual_43.png" style="width: 60%%" class="img-manual" />
                  <p>Puedes descargar el reporte en formato .pdf dando click en el botón “Descargar reporte”.</p>
                  <img src="images/manual_44.png" style="width: 60%%" class="img-manual" />
                </div>

                <div>
                  <span class="info-title" style="font-size: 25px;">Estrategias de gestión:</span>
                  <span class="anchor" id="estrategias"></span>
                  <p>Esta pestaña permite visualizar los campos diligenciados en el formulario y que por su
respuesta se sugiera una estrategia para su gestión.</p>
                  <img src="images/manual_39.png" style="width: 60%%" class="img-manual" />
                  <p>Para agregar una estrategia de gestión a un determinado ítem da click en este para desplegar un
campo donde podrás diligenciarla. Una vez termines, da click en el botón guardar.</p>
                  <img src="images/manual_40.png" style="width: 60%%" class="img-manual" />
                  <p>Luego de guardar la estrategia de gestión que se sugiera para cada caso en particular, esta
aparecerá en la pestaña de “Reporte” debajo de su ítem asociado.</p>
                  <img src="images/manual_41.png" style="width: 60%%" class="img-manual" />
                </div>

                <div>
                  <span class="info-title" style="font-size: 25px;">Historial:</span>
                  <span class="anchor" id="historial"></span>
                  <p>Cuando realices un cambio en alguno de los campos del formulario dichos cambios quedarán guardados, y podrán ser visualizados en cualquier momento en la pestaña de historial.</p>
                  <img src="images/manual_45.png" style="width: 60%%" class="img-manual" />
                  <p>Para acceder a la modificación de algún paso debes de dar click sobre este. Esto desplegará una ventana la cual indicará cuáles fueron los cambios realizados, para ello se muestra resaltado en verde la información agregada, resaltado en rojo la eliminada y sin resaltar la que no se modificó.</p>
                  <img src="images/manual_46.png" style="width: 60%%" class="img-manual" />
                  <p>También puedes filtrar la lista de modificaciones por uno o más pasos, para ello indica los pasos por los que deseas filtrar en la barra superior y luego da click en el botón “Filtrar”.</p>
                  <p><strong>Nota:  La lista de modificaciones siempre estará ordenada por fecha de modificación, desplegando desde la más actual hasta la más antigua.</strong></p>
                  <img src="images/manual_47.png" style="width: 60%%" class="img-manual" />
                </div>

                </div>
                  <span class="info-title" style="font-size: 30px;">Reporte general:</span>
                  <span class="anchor" id="reporte_general"></span>
                  <p>Para ingresar al módulo de reporte general debes dar click en la opción “Reporte general” que se encuentra en el menú principal:</p>
                  <img src="images/manual_48.png" style="width: 60%%" class="img-manual" />
                  <p>El reporte general permite al usuario observar:</p>
                  <ol>
                    <li>Cuántos grupos de investigación hay en el inventario.</li>
                    <li>Cuántos proyectos hay en el inventario y a qué grupo de investigación pertenecen.</li>
                    <li>Cuántos activos intangibles hay en el inventario y a qué proyecto y grupo de investigación pertenecen.</li>
                  </ol>

                  <p>Por defecto, el reporte general muestra la información general de todos los grupos de investigación inventariados en la herramienta, sin embargo, el reporte también permite al usuario elegir el grupo de investigación sobre el que se quiere conocer el reporte general, es decir, permite tener un resumen de la información de todos los grupos o también una vista especializada de un único grupo o de los grupos específicamente seleccionados por el usuario, para lo cual se deben seleccionar en el filtro que se encuentra en la parte superior izquierda del módulo y luego dar click en el botón “Generar reporte”.</p>
                  <img src="images/manual_49.png" style="width: 60%%" class="img-manual" />
                  <p>Adicionalmente, el reporte general muestra al usuario las siguientes gráficas:</p>

                  <ol>
                    <li>Porcentaje que indica cuántos AI tienen asociados cada DPI. </li>
                    <li>Porcentaje que indica cuántos AI tienen contrato de cesión firmado a favor de la Institución.</li>
                    <li>Porcentaje que indica cuántos AI tienen contrato o acuerdo de confidencialidad firmado con todos los que participan en el proyecto.</li>
                    <li>Porcentaje que indica los AI en cada clasificación.</li>
                    <li>Porcentaje que indica los AI en su estado de protección.</li>
                    <li>Porcentaje que indica los AI a los que se le sugiere un depósito o registro.</li>
                    <li>Porcentaje que indica los DPI que ya tienen un depósito o registro. </li>
                    <li>Porcentaje que indica cuáles AI se les sugiere tomar medidas pertinentes para mantener la información confidencial y secreta.</li>
                    <li>Porcentaje que indica los AI a los que se le sugiere uso de una herramienta de priorización.</li>
                    <li>Porcentaje que indica los AI que están incorporados en la contabilidad.</li>
                  </ol>
                  
                  <img src="images/manual_50.png" style="width: 60%%" class="img-manual" />

                  <p>En todas las gráficas, una vez se de click en cada ítem mostrará cuáles AI asociados a cada porcentaje y permitirá al usuario, al dar click a cada AI, dirigirse al formulario de diagnóstico de cada uno.  </p>

                  <img src="images/manual_51.png" style="width: 60%%" class="img-manual" />

                  <p>Al dar click sobre alguna de las etiquetas de una gráfica puedes desactivarla para que no aparezca su porcentaje respectivo.</p>

                  <img src="images/manual_52.png" style="width: 60%%" class="img-manual" />

                  <p>Puedes ocultar alguna las gráficas o la información sobre los grupos de investigación dando click en el botón que se encuentra en la parte superior derecha de estas</p>

                  <img src="images/manual_53.png" style="width: 60%%" class="img-manual" />

                  <p>El reporte general puede descargarse en formato .pdf para su visualización e impresión dando click en el botón “Descargar PDF”</p>

                  <img src="images/manual_54.png" style="width: 60%%" class="img-manual" />

                <div>


                <div>
                    <hr>
                    <span class="info-title" style="font-size: 30px;">Usuarios:</span>
                    <span class="anchor" id="usuarios"></span>
                    <p>Este módulo solo se encuentra disponible para cuentas de administrador. Para acceder al
módulo se debe seleccionar en la opción de usuarios que aparece en el menú lateral izquierdo
o en la parte superior de la página de inicio de la aplicación.</p>
                    <img src="images/manual_3.png" style="width: 60%%" class="img-manual" />
                </div>
                
                <div>
                    <span class="info-title" style="font-size: 25px;">Lista de usuarios:</span>
                    <span class="anchor" id="lista_usuarios"></span>
                    <p>Una vez dentro del módulo de usuarios se desplegará una lista con todos
los usuarios registrados en la aplicación, mostrando su nombre, correo electrónico y su rol.</p>
                    <img src="images/manual_4.png" style="width: 60%%" class="img-manual" />
                    <p>La lista puede ser ordenada alfabéticamente en orden ascendente o descendente en cada uno de
sus campos (nombre, correo electrónico, rol), para ello damos click en las flechas que aparecen
al lado derecho del campo que deseemos ordenar.</p>

                    <img src="images/manual_5.png" style="width: 60%%" class="img-manual" />
                    <p>La lista puede ser filtrada por nombre, correo electrónico o rol. Para ello vamos a la parte
superior de la página e ingresamos los filtros deseados.</p>
                    <img src="images/manual_6.png" style="width: 60%%" class="img-manual" />
                    <p>Una vez ingresados los filtros deseados damos click en el botón “Buscar” para realizar el
filtrado.</p>
                    <img src="images/manual_7.png" style="width: 60%%" class="img-manual" />
                    <p>Si se desea limpiar todos los filtros establecidos damos click en el botón “Borrar Filtros”.</p>
                </div>
                
                <div>
                    <hr>
                    <span class="info-title" style="font-size: 25px;">Crear usuarios:</span>
                    <span class="anchor" id="crear_usuarios"></span>
                    <p>Para agregar usuarios a la aplicación debes dar click en el botón “Crear nuevo
usuario” que aparece sobre la lista de usuarios en la parte derecha.</p>
                    <img src="images/manual_8.png" style="width: 60%%" class="img-manual" />
                    <p>Una vez hagamos click en dicho botón se desplegará un formulario en el cual se debe de indicar
el correo electrónico y el rol de la persona que será agregada a la aplicación como nuevo
usuario. Cuando terminemos de diligenciarlo damos click en “Enviar invitación”.</p>
                    <img src="images/manual_9.png" style="width: 60%%" class="img-manual" />
                    <p>Al realizar esta acción se enviará un correo electrónico a la cuenta especificada en el
formulario. Dicho correo electrónico dará las indicaciones al usuario para finalizar su registro
en la aplicación. El correo electrónico tendrá un código de acceso y una link hacia la aplicación
donde el usuario podrá registrarse.</p>
                    <img src="images/manual_10.png" style="width: 60%%" class="img-manual" />
                    <p>Al ingresar al link se le pedirá al usuario ingresar el código dado en el correo electrónico.</p>
                    <img src="images/manual_11.png" style="width: 60%%" class="img-manual" />
                    <p>Una vez ingresado el código aparecerá un formulario donde el usuario podrá ingresar su
información personal para finalizar el registro.</p>
                    <img src="images/manual_12.png" style="width: 60%%" class="img-manual" />
                    <p>Al dar click en “Registrarme” el usuario quedará registrado en la aplicación.</p>
                  </div>
                
                <div>
                    <hr>
                    <span class="info-title" style="font-size: 25px;">Editar usuarios:</span>
                    <span class="anchor" id="editar_usuarios"></span>
                    <p>Para cambiar el rol de un usuario se debe seleccionar el icono de editar que
aparece en la parte derecha de este en la lista de usuarios.</p>
                    <img src="images/manual_13.png" style="width: 60%%" class="img-manual" />
                    <p>Una vez que hagamos click en este icono se desplegará una ventana donde podremos editar el
rol del usuario. Una vez seleccionado el nuevo rol, damos click en actualizar. La herramienta
no permitirá cambiar el rol de “Admin” a “Empleado” si no hay ningún otro usuario que tenga
el rol de “Admin”, por lo tanto, si se desea cambiar de administrador deberá primero cambiar
el rol de “empleado” a “Admin” a otro usuario designado para cumplir dicho rol.</p>
                    <img src="images/manual_14.png" style="width: 60%%" class="img-manual" />
                </div>
                
                <div>
                    <hr>
                    <span class="info-title" style="font-size: 25px;">Eliminar usuarios:</span>
                    <span class="anchor" id="eliminar_usuarios"></span>
                    <p>Para eliminar un usuario se debe seleccionar el icono de eliminar que
aparece en la parte derecha de este en la lista de usuarios.</p>
                    <img src="images/manual_15.png" style="width: 60%%" class="img-manual" />
                    <p>Una vez que hagamos click en este icono se desplegará una ventana que nos pedirá confirmar
la eliminación del usuario. En caso de que el usuario a eliminar tenga asociados grupos de
investigación o proyectos, éstos deben de ser reasignados, para ello damos click en el botón
“Reasignar grupos”.</p>
                    <img src="images/manual_16.png" style="width: 60%%" class="img-manual" />
                    <p>Al dar click en este botón seremos redirigidos hacia una nueva ventana donde se pueden
reasignar los grupos de investigación. En esta ventana debes de seleccionar a los usuarios que
quedaran como asociados a los grupos de investigación del usuario a eliminar. Por cada usuario
debes seleccionar los grupos de investigación que le serán asignados.</p>
                    <img src="images/manual_17.png" style="width: 60%%" class="img-manual" />
                </div>

                <div>
                <span class="info-title" style="font-size: 25px;">Perfil</span>
                <span class="anchor" id="perfil"></span>
                    <p>
                      Para entrar a nuestro perfil debemos dar click en la imagen de usuario que se encuentra
en la parte superior derecha de la pantalla y luego damos click en “Perfil”.
                    </p>
                    <img src="images/manual_18.png" style="width: 60%%" class="img-manual" />
                    <p>Esto nos abrirá una ventana con la información de nuestro perfil de usuario.</p>
                    <img src="images/manual_19.png" style="width: 60%%" class="img-manual" />
                </div>

                <div>
                  <span class="info-title" style="font-size: 25px;">Editar perfil:</span>
                  <span class="anchor" id="editar_perfil"></span>
                  <p>Para editar nuestro perfil ingresamos a la ventana de perfil y damos click en el
botón “Editar”.</p>
                  <img src="images/manual_20.png" style="width: 60%%" class="img-manual" />
                  <p>Esto nos abrirá una ventana donde podremos editar nuestro nombre de usuario.</p>
                  <img src="images/manual_21.png" style="width: 60%%" class="img-manual" />
                 <p>Si queremos editar nuestra contraseña entonces en la misma ventana de editar perfil damos
click en cambiar contraseña.</p>
                  <img src="images/manual_22.png" style="width: 60%%" class="img-manual" />
                  <p>Esto nos abrirá una nueva ventana donde podremos cambiar nuestra contraseña.</p>
                  <img src="images/manual_23.png" style="width: 60%%" class="img-manual" />
                </div>



            </div>
        </div>
    </div>        


</template>

<style>

.img-manual {
  margin-top: 30px;
  margin-bottom: 30px;
  display: block;
  margin-left: auto;
  margin-right: auto;
  width: 70%;
}

.anchor{
    display: block;
    height: 50px; /*same height as header*/
    margin-top: -50px; /*same height as header*/
    visibility: hidden;
  }

.normatividad-content-container {
    background-color: #fff;
    text-align: justify;
    grid-column: 2 ;
    padding-top: 10px;
    padding-bottom: 50px;
    padding-left: 30px;
    padding-right: 50px;
  }


.manual-container {
  display: grid;
  grid-template-columns: 22vw 78vw;
  font-family: 'Open Sans';
}

.info-bar {
  background: white;
  height: 100vh;
  width: 22vw;
  padding-top: 20px;
  padding-left: 20px;
  position: fixed;
  overflow: scroll;
  z-index: 1000;
  -webkit-touch-callout: none; /* iOS Safari */
  -webkit-user-select: none; /* Safari */
  -khtml-user-select: none; /* Konqueror HTML */
  -moz-user-select: none; /* Firefox */
  -ms-user-select: none; /* Internet Explorer/Edge */
  user-select: none; /* Non-prefixed version, currently*/
  padding-bottom: 100px;
}

.click-info-bar {
  background: white;
  height: 100vh;
  width: 100vw;
  padding-top: 50px;
  padding-left: 40px;
  position: fixed;
  margin-top: -30px;
  overflow: scroll;
  z-index: 1000;
  -webkit-touch-callout: none; /* iOS Safari */
  -webkit-user-select: none; /* Safari */
  -khtml-user-select: none; /* Konqueror HTML */
  -moz-user-select: none; /* Firefox */
  -ms-user-select: none; /* Internet Explorer/Edge */
  user-select: none; /* Non-prefixed version, currently*/
  padding-bottom: 100px;
}

.info-bar ul,
.click-info-bar ul {
  padding: 0;
  display: inline-block;
}

.info-bar ul li,
.click-info-bar ul li {
  list-style-type: none;
  color: black;
  font-weight: bold;
}

.info-bar ul li a,
.click-info-bar ul li a {
  cursor: pointer;
  display: block;
}

/* width */
.info-bar::-webkit-scrollbar,
.click-info-bar::-webkit-scrollbar {
  width: 5px;
}

/* Track */
.info-bar::-webkit-scrollbar-track,
.click-info-bar::-webkit-scrollbar-track {
  box-shadow: inset 0 0 5px grey;
  border-radius: 10px;
}

/* Handle */
.info-bar::-webkit-scrollbar-thumb,
.click-info-bar::-webkit-scrollbar-thumb {
  background: #08367b;
  border-radius: 10px;
}

/* Handle on hover */
.open-bar::-webkit-scrollbar-thumb:hover,
.click-info-bar::-webkit-scrollbar-thumb:hover {
  background: #08367b;
}

@media only screen and (max-width: 1150px) {
  .manual-container {
    display: grid;
    grid-template-columns: 25vw 75vw;
  }

  .info-bar {
    font-size: 1.5vw;
    padding-left: 10px;
  }
}

@media only screen and (max-width: 700px) {
  .manual-container {
    display: grid;
    grid-template-columns: 0px 100vw;
  }

  .info-bar {
    width: 0px;
    padding: 0px;
  }
  .bar-button:after {
    position: fixed;
    bottom: 5px;
    right: 10px;
    width: 50px;
    color: white;
    border-radius: 50%;
    height: 50px;
    text-align: center;
    padding: 13px;
    font-size: 15px;
    font-family: "Glyphicons Halflings";
    background-color: #f58345;
    box-shadow: 2px 2px 3px #999;
    font-family: "Glyphicons Halflings";
    content: "\2b";
    cursor: pointer;
    z-index: 200;
  }

  .bar-button-click:after {
    position: fixed;
    bottom: 5px;
    right: 10px;
    width: 50px;
    color: white;
    border-radius: 50%;
    height: 50px;
    text-align: center;
    padding: 13px;
    font-size: 15px;
    font-family: "Glyphicons Halflings";
    background-color: #db4437;
    box-shadow: 2px 2px 3px #999;
    font-family: "Glyphicons Halflings";
    cursor: pointer;
    z-index: -1;
    content: "\e106";
  }
}
</style>

<script>
export default {
  data() {
    return {
      openMenu: false,
      data: [
            {
              isRoot: true,
              link: '/normatividad/historia',
              title: 'Historia',
              route: '1 Historia',
              component: '<p><span>Provienen de las montañas de </span><a href="/#/manual/derecho_de_autor/en_que_consiste$cuales_derechos">Tian Shan</a><span>; una zona límite entre China, Kazajistán y </span><a href="/#/manual/derecho_de_autor/como_se_protegen$como_se_protege_encargo_colectivas_colaboracion$colectivas">Kirguistán</a><span>. Con las expediciones a América, la manzana arribó a la colonias de lo que actualmente es Estados Unidos y se extendió por todo el territorio. Se dice, tradicionalmente, que su origen estaría situado en la zona de Almá-Atá o Almatý, antigua capital de la exrepública soviética de Kazajistán y actual segunda ciudad más importante del estado kazajo independiente. De hecho, Almaty es la forma adjetivada del sustantivo "manzana" en kazajo y es popularmente traducida como "Padre de las Manzanas"</span></p>'
            },
            
      ]
    };
  },

  methods: {
    onClickItem: function() {
      this.openMenu = false;
    },

    updateDimensions(event) {
      if ($(window).width() > 700) {
        this.openMenu = false;
      }
    }
  },

  mounted() {
    window.addEventListener("resize", this.updateDimensions);
  },

  beforeDestroy: function() {
    window.removeEventListener("resize", this.updateDimensions);
  }
};
</script>
