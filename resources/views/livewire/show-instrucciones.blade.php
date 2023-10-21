<x-guest-layout>
    <div class="h-16"></div>
    <div class="min-[480px]:px-12 mt-4 ml-3 cursor-default">
        <div class="min-[650px]:flex min-[650px]:flex-wrap min-[650px]:justify-around">
            <div class="min-[650px]:w-2/3 min-[850px]:w-1/2 min-[1200px]:w-1/3">
                <p class="text-xl min-[400px]:text-3xl mb-3">BARRA DE NAVEGACIÓN</p>
                <ul class="text-base min-[400px]:text-xl">
                    <li>
                        <a href="#seccion01" class="min-[400px]:ml-6 text-blue-500 hover:text-blue-700">
                            PUBLICACIONES SIN COMUNIDAD
                        </a>
                    </li>
                    <li>
                        <a href="#seccion02" class="min-[400px]:ml-6 text-blue-500 hover:text-blue-700">
                            PUBLICACIONES CON COMUNIDAD
                        </a>
                    </li>
                    <li>
                        <a href="#seccion03" class="min-[400px]:ml-6 text-blue-500 hover:text-blue-700">
                            COMUNIDADES
                        </a>
                    </li>
                    <li>
                        <a href="#seccion04" class="min-[400px]:ml-6 text-blue-500 hover:text-blue-700">
                            PERFIL DE USUARIO
                        </a>
                    </li>
                    <li>
                        <a href="#seccion05"
                            class="min-[400px]:ml-6 text-blue-500 hover:text-blue-700">ETIQUETAS</a>
                    </li>
                    <li>
                        <a href="#seccion06" class="min-[400px]:ml-6 text-blue-500 hover:text-blue-700">USUARIOS</a>
                    </li>
                    <li>
                        <a href="#seccion07"
                            class="min-[400px]:ml-6 text-blue-500 hover:text-blue-700">NOTIFICACIONES</a>
                    </li>
                    <ol class="text-base min-[400px]:text-lg ml-6 min-[400px]:ml-12">
                        <li>
                            <a href="#seccion08" class="text-blue-500 hover:text-blue-700">
                                - LIKES
                            </a>
                        </li>
                        <li>
                            <a href="#seccion09" class="text-blue-500 hover:text-blue-700">
                                - GUARDADOS
                            </a>
                        </li>
                        <li>
                            <a href="#seccion10" class="text-blue-500 hover:text-blue-700">
                                - COMENTARIOS
                            </a>
                        </li>
                        <li>
                            <a href="#seccion11" class="text-blue-500 hover:text-blue-700">
                                - COMUNIDADES
                            </a>
                        </li>
                        <li>
                            <a href="#seccion12" class="text-blue-500 hover:text-blue-700">
                                - AMIGOS
                            </a>
                        </li>
                        <li>
                            <a href="#seccion13" class="text-blue-500 hover:text-blue-700">
                                - FOLLOWS
                            </a>
                        </li>
                    </ol>
                    <li>
                        <a href="#seccion14" class="min-[400px]:ml-6 text-blue-500 hover:text-blue-700">CHAT</a>
                    </li>
                    <li>
                        <a href="#seccion15"
                            class="min-[400px]:ml-6 text-blue-500 hover:text-blue-700">CONTACTANOS</a>
                    </li>
                </ul>
            </div>
            <div class="sm:w-2/3 min-[850px]:w-1/2 min-[1200px]:w-1/3 ">
                <p class="text-xl min-[400px]:text-3xl mb-3">OPCIONES DE USUARIO</p>
                <ul class="text-base min-[400px]:text-xl">
                    <li>
                        <a href="#seccion16" class="min-[400px]:ml-6 text-blue-500 hover:text-blue-700">PROFILE</a>
                    </li>
                    <li>
                        <a href="#seccion17" class="min-[400px]:ml-6 text-blue-500 hover:text-blue-700">AMIGOS</a>
                    </li>
                    <li>
                        <a href="#seccion18" class="min-[400px]:ml-6 text-blue-500 hover:text-blue-700">
                            MODO OSCURO
                        </a>
                    </li>
                    <li>
                        <a href="#seccion19" class="min-[400px]:ml-6 text-blue-500 hover:text-blue-700">LIKES</a>
                    </li>
                    <li>
                        <a href="#seccion20"
                            class="min-[400px]:ml-6 text-blue-500 hover:text-blue-700">GUARDADOS</a>
                    </li>
                    <li>
                        <a href="#seccion21" class="min-[400px]:ml-6 text-blue-500 hover:text-blue-700">LOGIN</a>
                    </li>
                    <li>
                        <a href="#seccion22" class="min-[400px]:ml-6 text-blue-500 hover:text-blue-700">REGISTER</a>
                    </li>
                </ul>
            </div>
            <div class="sm:w-2/3 min-[850px]:w-1/2 min-[1200px]:w-1/3">
                <p class="text-xl min-[400px]:text-3xl mb-3">OTROS</p>
                <ul class="text-base min-[400px]:text-xl">
                    <li>
                        <a href="#seccion16" class="min-[400px]:ml-6 text-blue-500 hover:text-blue-700">
                            VERIFICACIÓN DE CORREO
                        </a>
                    </li>
                </ul>
            </div>
        </div>
        <?php $cont = 0; ?>
        <div id="seccion01" @class([
            'rounded-lg text-center',
            'bg-gray-800' => auth()->check() && auth()->user()->temaoscuro,
            'bg-gray-300' => auth()->guest() || !auth()->user()->temaoscuro,
        ])>
            <p class="text-2xl mt-12 mb-3">PUBLICACIONES SIN COMUNIDAD</p>
            <div class="pb-2 text-left ml-3">
                <p> Aunque puede sonar raro este apartado, en realidad es la primera vista que encuentras al entrar a la
                    página,
                    la forma de acceder a este es mediante la imagen (el logo) que hay situada en la barra de navegación de
                    la página.
                </p>
                <p>
                    Cuando entras a la página lo primero que encontrarás es una sección en la que se muestran publicaciones
                    de usuarios que
                    han subido una publicación la cual no pertenece a una comunidad.
                </p>
                <p class="mb-2">
                    En la parte superior de esta encontrarás un buscador que te permite encontrar las publicaciones mediante
                    el nombre del usuario,
                    o por el titulo de la publicación. Mientras que debajo de este se encuentran 3 iconos:
                </p>
                <div class="flex flex-wrap items-center mb-1">
                    <div class="text-center w-1/6">
                        <i class="fa-solid fa-arrow-down-a-z"></i>
                    </div>
                    <div class="w-5/6">
                        <p class="ml-1">Ordena las publicaciones por su titulo.</p>
                    </div>
                </div>
                <div class="flex flex-wrap items-center mb-1">
                    <div class="text-center w-1/6">
                        <i class="fa-solid fa-fire"></i>
                    </div>
                    <div class="w-5/6">
                        <p class="ml-1">Ordena las publicaciones por cantidad de likes que tienen.</p>
                    </div>
                </div>
                <div class="flex flex-wrap items-center">
                    <div class="text-center w-1/6">
                        <i class="fa-regular fa-clock"></i>
                    </div>
                    <div class="w-5/6">
                        <p class="ml-1">Ordena las publicaciones según su antiguedad.</p>
                    </div>
                </div>
            </div>
        </div>
        <div id="seccion02" @class([
            'rounded-lg text-center',
            'bg-gray-700' =>
                auth()->check() && auth()->user()->temaoscuro && $cont % 2 == 0,
            'bg-gray-800' =>
                auth()->check() && auth()->user()->temaoscuro && $cont % 2 == 1,
            'bg-gray-200' =>
                (auth()->guest() || !auth()->user()->temaoscuro) && $cont % 2 == 0,
            'bg-gray-300' =>
                (auth()->guest() || !auth()->user()->temaoscuro) && $cont % 2 == 1,
        ])>
            <?php $cont++; ?>
            <p class="text-2xl mt-6 mb-3">PUBLICACIONES CON COMUNIDAD</p>
            <div class="pb-2 text-left ml-3">
                <p>
                    Para poder acceder a este apartado debes pinchar en el icono numero <?php echo $cont; ?> que aparece en
                    la barra de navegación, el cual es: <i class="fa-solid fa-house"></i>
                </p>
                <p>
                    Cuando accedes a esta vista lo que encontrarás es una sección en la que se muestran publicaciones de
                    usuarios que
                    han subido una publicación la cual si pertenece a una comunidad.
                </p>
                <p class="mb-2">
                    En la parte superior de esta encontrarás un buscador que te permite encontrar las publicaciones mediante
                    el nombre del usuario,
                    el nombre de la comunidad o por el titulo de la publicación. Mientras que debajo de este se encuentran 4
                    iconos:
                </p>
                <div class="flex flex-wrap items-center mb-1">
                    <div class="text-center w-1/6">
                        <i class="fa-solid fa-arrow-down-a-z"></i>
                    </div>
                    <div class="w-5/6">
                        <p class="ml-1">Ordena las publicaciones por su titulo.</p>
                    </div>
                </div>
                <div class="flex flex-wrap items-center mb-1">
                    <div class="text-center w-1/6">
                        <i class="fa-solid fa-users"></i>
                    </div>
                    <div class="w-5/6">
                        <p class="ml-1">Ordena las publicaciones según su comunidad.</p>
                    </div>
                </div>
                <div class="flex flex-wrap items-center mb-1">
                    <div class="text-center w-1/6">
                        <i class="fa-solid fa-fire"></i>
                    </div>
                    <div class="w-5/6">
                        <p class="ml-1">Ordena las publicaciones por cantidad de likes que tienen.</p>
                    </div>
                </div>
                <div class="flex flex-wrap items-center">
                    <div class="text-center w-1/6">
                        <i class="fa-regular fa-clock"></i>
                    </div>
                    <div class="w-5/6">
                        <p class="ml-1">Ordena las publicaciones según su antiguedad.</p>
                    </div>
                </div>
            </div>
        </div>
        <div id="seccion03" @class([
            'rounded-lg text-center',
            'bg-gray-700' =>
                auth()->check() && auth()->user()->temaoscuro && $cont % 2 == 0,
            'bg-gray-800' =>
                auth()->check() && auth()->user()->temaoscuro && $cont % 2 == 1,
            'bg-gray-200' =>
                (auth()->guest() || !auth()->user()->temaoscuro) && $cont % 2 == 0,
            'bg-gray-300' =>
                (auth()->guest() || !auth()->user()->temaoscuro) && $cont % 2 == 1,
        ])>
            <?php $cont++; ?>
            <p class="text-2xl mt-6 mb-3">COMUNIDADES</p>
            <div class="pb-2 text-left ml-3">
                <p>
                    Para poder acceder a este apartado debes pinchar en el icono numero <?php echo $cont; ?> que aparece en
                    la barra de navegación, el cual es: <i class="fa-solid fa-people-roof"></i>
                </p>
                <p>
                    Cuando accedes a esta vista lo que encontrarás es una sección en la que se muestran publicaciones de
                    usuarios que
                    han subido una publicación la cual si pertenece a una comunidad.
                </p>
                <p class="mb-2">
                    En la parte superior de esta encontrarás un buscador que te permite encontrar las publicaciones mediante
                    el nombre del usuario,
                    el nombre de la comunidad o por el titulo de la publicación. Mientras que debajo de este se encuentran 4
                    iconos:
                </p>
                <div class="flex flex-wrap items-center mb-1">
                    <div class="text-center w-1/6">
                        <i class="fa-solid fa-arrow-down-a-z"></i>
                    </div>
                    <div class="w-5/6">
                        <p class="ml-1">Ordena las comunidades por nombre.</p>
                    </div>
                </div>
                <div class="flex flex-wrap items-center mb-1">
                    <div class="text-center w-1/6">
                        <i class="fa-regular fa-clock"></i>
                    </div>
                    <div class="w-5/6">
                        <p class="ml-1">Ordena las comunidades por antiguedad.</p>
                    </div>
                </div>
                <div class="flex flex-wrap items-center mb-1">
                    <div class="text-center w-1/6 text-blue-500">
                        <i class="fa-solid fa-users-between-lines"></i>
                    </div>
                    <div class="w-5/6">
                        <p class="ml-1">Muestra todas las comunidades.</p>
                    </div>
                </div>
                <div class="flex flex-wrap items-center mb-1">
                    <div class="text-center w-1/6 text-blue-500">
                        <i class="fa-solid fa-users-viewfinder"></i>
                    </div>
                    <div class="w-5/6">
                        <p class="ml-1">Muestra las comunidades que has creado.</p>
                    </div>
                </div>
                <div class="flex flex-wrap items-center mb-1">
                    <div class="text-center w-1/6 text-blue-500">
                        <i class="fa-solid fa-users-rays"></i>
                    </div>
                    <div class="w-5/6">
                        <p class="ml-1">Muestra las comunidades en las que participas.</p>
                    </div>
                </div>
            </div>
        </div>
        <div id="seccion04" @class([
            'rounded-lg text-center',
            'bg-gray-700' =>
                auth()->check() && auth()->user()->temaoscuro && $cont % 2 == 0,
            'bg-gray-800' =>
                auth()->check() && auth()->user()->temaoscuro && $cont % 2 == 1,
            'bg-gray-200' =>
                (auth()->guest() || !auth()->user()->temaoscuro) && $cont % 2 == 0,
            'bg-gray-300' =>
                (auth()->guest() || !auth()->user()->temaoscuro) && $cont % 2 == 1,
        ])>
            <?php $cont++; ?>
            <p class="text-2xl mt-6 mb-3">PERFIL DE USUARIO</p>
            <div class="pb-2 text-left ml-3">
                <p>
                    Para poder acceder a este apartado debes pinchar en el icono numero <?php echo $cont; ?> que aparece en
                    la barra de navegación, el cual es: <i class="fa-solid fa-person-shelter"></i>
                </p>
                <p>
                    Al entrar en esta vista lo que se mostrará es el perfil de tu usuario, mostrando primero tu foto de
                    usuario, el nombre y otras cosas:
                </p>
                <p>
                    Los iconos de redes sociales te permiten compartir el perfil de usuario en estas redes sociales:
                </p>
                <p class="mb-2">
                    Posteriormente encontrarás un buscador que te permite encontrar las publicaciones mediante el nombre de
                    la comunidad o
                    por el titulo de la publicación. Mientras que debajo de este se encuentran 4 iconos:
                </p>
                <div class="flex flex-wrap items-center mb-1">
                    <div class="text-center w-1/6">
                        <i class="fa-solid fa-arrow-down-a-z"></i>
                    </div>
                    <div class="w-5/6">
                        <p class="ml-1">Ordena las publicaciones por su titulo.</p>
                    </div>
                </div>
                <div class="flex flex-wrap items-center mb-1">
                    <div class="text-center w-1/6">
                        <i class="fa-solid fa-users"></i>
                    </div>
                    <div class="w-5/6">
                        <p class="ml-1">Ordena las publicaciones según su comunidad.</p>
                    </div>
                </div>
                <div class="flex flex-wrap items-center mb-1">
                    <div class="text-center w-1/6">
                        <i class="fa-solid fa-fire"></i>
                    </div>
                    <div class="w-5/6">
                        <p class="ml-1">Ordena las publicaciones por cantidad de likes que tienen.</p>
                    </div>
                </div>
                <div class="flex flex-wrap items-center mb-1">
                    <div class="text-center w-1/6">
                        <i class="fa-regular fa-clock"></i>
                    </div>
                    <div class="w-5/6">
                        <p class="ml-1">Ordena las publicaciones según su antiguedad.</p>
                    </div>
                </div>
                <p>
                    Debajo de las publicaciones encontrarás las comunidades has creado y las comunidades en las que
                    participas.
                </p>
            </div>
        </div>
        <div id="seccion05" @class([
            'rounded-lg text-center',
            'bg-gray-700' =>
                auth()->check() && auth()->user()->temaoscuro && $cont % 2 == 0,
            'bg-gray-800' =>
                auth()->check() && auth()->user()->temaoscuro && $cont % 2 == 1,
            'bg-gray-200' =>
                (auth()->guest() || !auth()->user()->temaoscuro) && $cont % 2 == 0,
            'bg-gray-300' =>
                (auth()->guest() || !auth()->user()->temaoscuro) && $cont % 2 == 1,
        ])>
            <?php $cont++; ?>
            <p class="text-2xl mt-6 mb-3">ETIQUETAS</p>
            <div class="pb-2 text-left ml-3">
                <p>
                    Para poder acceder a este apartado debes pinchar en el icono numero <?php echo $cont; ?> que aparece en
                    la barra de navegación, el cual es: <i class="fa-solid fa-tags"></i>
                </p>
                <p>
                    Al entrar en esta vista lo que se mostrarán son las etiquetas que los usuarios de la página pueden
                    añadir a sus publicaciones:
                </p>
                <p class="mb-2">
                    En la parte superior de la pantalla encontrarás un buscador que te permite encontrar las etiquetas por
                    su nombre.
                    Mientras que debajo de este se encuentran 2 iconos:
                </p>
                <div class="flex flex-wrap items-center mb-1">
                    <div class="text-center w-1/6">
                        <i class="fa-solid fa-arrow-down-a-z"></i>
                    </div>
                    <div class="w-5/6">
                        <p class="ml-1">Ordena las etiquetas por su nombre.</p>
                    </div>
                </div>
                <div class="flex flex-wrap items-center mb-1">
                    <div class="text-center w-1/6">
                        <i class="fa-regular fa-clock"></i>
                    </div>
                    <div class="w-5/6">
                        <p class="ml-1">Ordena las etiquetas según su antiguedad.</p>
                    </div>
                </div>
            </div>
        </div>
        <div id="seccion06" @class([
            'rounded-lg text-center',
            'bg-gray-700' =>
                auth()->check() && auth()->user()->temaoscuro && $cont % 2 == 0,
            'bg-gray-800' =>
                auth()->check() && auth()->user()->temaoscuro && $cont % 2 == 1,
            'bg-gray-200' =>
                (auth()->guest() || !auth()->user()->temaoscuro) && $cont % 2 == 0,
            'bg-gray-300' =>
                (auth()->guest() || !auth()->user()->temaoscuro) && $cont % 2 == 1,
        ])>
            <?php $cont++; ?>
            <p class="text-2xl mt-6 mb-3">USUARIOS</p>
            <div class="pb-2 text-left ml-3">
                <p>
                    Para poder acceder a este apartado debes pinchar en el icono numero <?php echo $cont; ?> que aparece en
                    la barra de navegación, el cual es: <i class="fa-solid fa-users"></i>
                </p>
                <p>Al entrar en esta vista lo que se mostrarán son todos los usuarios de la página.</p>
                <p class="mb-2">
                    En la parte superior de la pantalla encontrarás un buscador que te permite encontrar los usuarios por su
                    nombre o por su apellido.
                    Mientras que debajo de este se encuentran 2 iconos:
                </p>
                <div class="flex flex-wrap items-center mb-1">
                    <div class="text-center w-1/6">
                        <i class="fa-solid fa-arrow-down-a-z"></i>
                    </div>
                    <div class="w-5/6">
                        <p class="ml-1">Ordena las etiquetas por su nombre.</p>
                    </div>
                </div>
                <div class="flex flex-wrap items-center mb-1">
                    <div class="text-center w-1/6">
                        <i class="fa-regular fa-clock"></i>
                    </div>
                    <div class="w-5/6">
                        <p class="ml-1">Ordena las etiquetas según su antiguedad.</p>
                    </div>
                </div>
                <p>
                    A la derecha tienes acciones que puedes hacer con los usuarios, como puede ser el de mandar, rechazar o
                    eliminar solicitudes de amistad.
                </p>
            </div>
        </div>
        <div id="seccion07" @class([
            'rounded-lg text-center',
            'bg-gray-700' =>
                auth()->check() && auth()->user()->temaoscuro && $cont % 2 == 0,
            'bg-gray-800' =>
                auth()->check() && auth()->user()->temaoscuro && $cont % 2 == 1,
            'bg-gray-200' =>
                (auth()->guest() || !auth()->user()->temaoscuro) && $cont % 2 == 0,
            'bg-gray-300' =>
                (auth()->guest() || !auth()->user()->temaoscuro) && $cont % 2 == 1,
        ])>
            <?php $cont++; ?>
            <p class="text-2xl mt-6 mb-3">NOTIFICACIONES</p>
            <div class="pb-2 text-left ml-3">
                <p>
                    Para poder acceder a este apartado debes pinchar en el icono numero <?php echo $cont; ?> que aparece en
                    la barra de navegación, el cual es: <i class="fa-regular fa-bell"></i>
                </p>
                <p>
                    Al pulsar en esta opcón lo que se mostrará es un dropdown con diferentes opciones.
                </p>
            </div>
            <div id="seccion08">
                <p class="text-xl mt-3 mb-3">LIKES</p>
                <div class="pb-2 text-left ml-3">
                    <p>
                        Para poder acceder a este apartado debes pinchar en el icono que aparece en las opciones de las
                        notificaciones, el cual es: <i class="fa-regular fa-heart"></i>
                    </p>
                    <p>
                        Al pulsar en esta opcón se mostrará una vista que enseña que usuarios ha dado like a
                        nuestras publicaciones.
                    </p>
                </div>
            </div>
            <div id="seccion09">
                <p class="text-xl mt-3 mb-3">GUARDADOS</p>
                <div class="pb-2 text-left ml-3">
                    <p>
                        Para poder acceder a este apartado debes pinchar en el icono que aparece en las opciones de las
                        notificaciones, el cual es: <i class="fa-regular fa-floppy-disk"></i>
                    </p>
                    <p>
                        Al pulsar en esta opcón se mostrará una vista que enseña que usuarios ha dado save
                        (se han guardado la publicación) a nuestras publicaciones.
                    </p>
                </div>
            </div>
            <div id="seccion10">
                <p class="text-xl mt-3 mb-3">COMENTARIOS</p>
                <div class="pb-2 text-left ml-3">
                    <p>
                        Para poder acceder a este apartado debes pinchar en el icono que aparece en las opciones de las
                        notificaciones, el cual es: <i class="fa-regular fa-message"></i>
                    </p>
                    <p>
                        Al pulsar en esta opcón se mostrará una vista que enseña que usuarios han comentado
                        en nuestras publicaciones.
                    </p>
                </div>
            </div>
            <div id="seccion11">
                <p class="text-xl mt-3 mb-3">COMUNIDADES</p>
                <div class="pb-2 text-left ml-3">
                    <p>
                        Para poder acceder a este apartado debes pinchar en el icono que aparece en las opciones de las
                        notificaciones, el cual es: <i class="fa-solid fa-users-gear"></i>
                    </p>
                    <p>
                        Al pulsar en esta opcón se mostrará una vista que enseña que usuarios han enviado
                        una solicitud para participar en alguna de tus comunidades.
                    </p>
                    <p>También mostrará un listado de personas que se han unido a tus comunidades.</p>
                </div>
            </div>
            <div id="seccion12">
                <p class="text-xl mt-3 mb-3">AMIGOS</p>
                <div class="pb-2 text-left ml-3">
                    <p>
                        Para poder acceder a este apartado debes pinchar en el icono que aparece en las opciones de las
                        notificaciones, el cual es: <i class="fa-solid fa-user-group"></i>
                    </p>
                    <p>
                        Al pulsar en esta opcón se mostrará una vista que enseña que usuarios han enviado
                        una solicitud para ser tu amigo, lo que te permite esto es poder mandarte mensajes con dicha
                        persona.
                    </p>
                </div>
            </div>
            <div id="seccion13">
                <p class="text-xl mt-3 mb-3">FOLLOWS</p>
                <div class="pb-2 text-left ml-3">
                    <p>
                        Para poder acceder a este apartado debes pinchar en el icono que aparece en las opciones de las
                        notificaciones, el cual es: <i class="fa-solid fa-person-walking-arrow-right"></i><i
                            class="fa-solid fa-person"></i>
                    </p>
                    <p>
                        Al pulsar en esta opcón se mostrará una vista que enseña que usuarios han enviado
                        una solicitud para poder seguirte.
                    </p>
                    <p>También mostrará un listado de personas que te están siguiendo.</p>
                </div>
            </div>
        </div>
        <div id="seccion14" @class([
            'rounded-lg text-center',
            'bg-gray-700' =>
                auth()->check() && auth()->user()->temaoscuro && $cont % 2 == 0,
            'bg-gray-800' =>
                auth()->check() && auth()->user()->temaoscuro && $cont % 2 == 1,
            'bg-gray-200' =>
                (auth()->guest() || !auth()->user()->temaoscuro) && $cont % 2 == 0,
            'bg-gray-300' =>
                (auth()->guest() || !auth()->user()->temaoscuro) && $cont % 2 == 1,
        ])>
            <?php $cont++; ?>
            <p class="text-2xl mt-6 mb-3">CHAT</p>
            <div class="pb-2 text-left ml-3">

            </div>
        </div>
        <div id="seccion15" @class([
            'rounded-lg text-center',
            'bg-gray-700' =>
                auth()->check() && auth()->user()->temaoscuro && $cont % 2 == 0,
            'bg-gray-800' =>
                auth()->check() && auth()->user()->temaoscuro && $cont % 2 == 1,
            'bg-gray-200' =>
                (auth()->guest() || !auth()->user()->temaoscuro) && $cont % 2 == 0,
            'bg-gray-300' =>
                (auth()->guest() || !auth()->user()->temaoscuro) && $cont % 2 == 1,
        ])>
            <?php $cont++; ?>
            <p class="text-2xl mt-6 mb-3">CONTACTANOS</p>
            <div class="pb-2 text-left ml-3">
                <p>
                    Para poder acceder a este apartado debes pinchar en el icono numero <?php echo $cont; ?> que aparece en
                    la barra de navegación, el cual es: <i class="fa-regular fa-envelope"></i>
                </p>
                @auth()
                    <p>
                        Rellene el formulario que tiene a la vista introduciendo su nombre y el mensaje que quiera dar al
                        administrador del sistema. Como podrá observar su email ya viene por defecto.
                    </p>
                @else
                    <p>
                        Rellene el formulario que tiene a la vista introduciendo su nombre, email y el mensaje que quiera dar al
                        administrador del sistema.
                    </p>
                @endauth
                <p>
                    En la parte inferior verá dos botones, si ha introducido en todos los campos los datos correctamente al
                    pulsar en
                    <button class="bg-blue-500 mx-1 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded my-1">
                        <i class="fas fa-paper-plane"></i> Enviar
                    </button>
                    se deberá de mandar el formulario.
                </p>
                <p>
                    En cambio si quieres cancelar el correo puedes moverte con la barra de navegación o pulsar en el botón
                    <button class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded cursor-pointer my-1">
                        <i class="fas fa-backward"></i> Cancelar
                    </button>
                    se deverá de mandar el formulario.
                </p>
            </div>
        </div>
        <div id="seccion16" @class([
            'rounded-lg text-center',
            'bg-gray-700' =>
                auth()->check() && auth()->user()->temaoscuro && $cont % 2 == 0,
            'bg-gray-800' =>
                auth()->check() && auth()->user()->temaoscuro && $cont % 2 == 1,
            'bg-gray-200' =>
                (auth()->guest() || !auth()->user()->temaoscuro) && $cont % 2 == 0,
            'bg-gray-300' =>
                (auth()->guest() || !auth()->user()->temaoscuro) && $cont % 2 == 1,
        ])>
            <?php $cont++; ?>
            <p class="text-2xl mt-6 mb-3">PROFILE</p>
            <div class="pb-2 text-left ml-3">

            </div>
        </div>
        <div id="seccion17" @class([
            'rounded-lg text-center',
            'bg-gray-700' =>
                auth()->check() && auth()->user()->temaoscuro && $cont % 2 == 0,
            'bg-gray-800' =>
                auth()->check() && auth()->user()->temaoscuro && $cont % 2 == 1,
            'bg-gray-200' =>
                (auth()->guest() || !auth()->user()->temaoscuro) && $cont % 2 == 0,
            'bg-gray-300' =>
                (auth()->guest() || !auth()->user()->temaoscuro) && $cont % 2 == 1,
        ])>
            <?php $cont++; ?>
            <p class="text-2xl mt-6 mb-3">AMIGOS</p>
            <div class="pb-2 text-left ml-3">

            </div>
        </div>
        <div id="seccion18" @class([
            'rounded-lg text-center',
            'bg-gray-700' =>
                auth()->check() && auth()->user()->temaoscuro && $cont % 2 == 0,
            'bg-gray-800' =>
                auth()->check() && auth()->user()->temaoscuro && $cont % 2 == 1,
            'bg-gray-200' =>
                (auth()->guest() || !auth()->user()->temaoscuro) && $cont % 2 == 0,
            'bg-gray-300' =>
                (auth()->guest() || !auth()->user()->temaoscuro) && $cont % 2 == 1,
        ])>
            <?php $cont++; ?>
            <p class="text-2xl mt-6 mb-3">MODO OSCURO</p>
            <div class="pb-2 text-left ml-3">

            </div>
        </div>
        <div id="seccion19" @class([
            'rounded-lg text-center',
            'bg-gray-700' =>
                auth()->check() && auth()->user()->temaoscuro && $cont % 2 == 0,
            'bg-gray-800' =>
                auth()->check() && auth()->user()->temaoscuro && $cont % 2 == 1,
            'bg-gray-200' =>
                (auth()->guest() || !auth()->user()->temaoscuro) && $cont % 2 == 0,
            'bg-gray-300' =>
                (auth()->guest() || !auth()->user()->temaoscuro) && $cont % 2 == 1,
        ])>
            <?php $cont++; ?>
            <p class="text-2xl mt-6 mb-3">LIKES</p>
            <div class="pb-2 text-left ml-3">

            </div>
        </div>
        <div id="seccion20" @class([
            'rounded-lg text-center',
            'bg-gray-700' =>
                auth()->check() && auth()->user()->temaoscuro && $cont % 2 == 0,
            'bg-gray-800' =>
                auth()->check() && auth()->user()->temaoscuro && $cont % 2 == 1,
            'bg-gray-200' =>
                (auth()->guest() || !auth()->user()->temaoscuro) && $cont % 2 == 0,
            'bg-gray-300' =>
                (auth()->guest() || !auth()->user()->temaoscuro) && $cont % 2 == 1,
        ])>
            <?php $cont++; ?>
            <p class="text-2xl mt-6 mb-3">GUARDADOS</p>
            <div class="pb-2 text-left ml-3">
            </div>
        </div>
        <div id="seccion21" @class([
            'rounded-lg text-center',
            'bg-gray-700' =>
                auth()->check() && auth()->user()->temaoscuro && $cont % 2 == 0,
            'bg-gray-800' =>
                auth()->check() && auth()->user()->temaoscuro && $cont % 2 == 1,
            'bg-gray-200' =>
                (auth()->guest() || !auth()->user()->temaoscuro) && $cont % 2 == 0,
            'bg-gray-300' =>
                (auth()->guest() || !auth()->user()->temaoscuro) && $cont % 2 == 1,
        ])>
            <?php $cont++; ?>
            <p class="text-2xl mt-6 mb-3">LOGIN</p>
            <div class="pb-2 text-left ml-3">
                <p>
                    Para poder acceder a este apartado debes pinchar en donde pone 'login', situado a la derecha en la barra
                    de navegación:
                </p>
                <p>
                    Lo que se mostrará por pantalla es un formulario muy básico que te pedirá el email y la contraseña que
                    has introducido cuando te registraste.
                    Si te has registrado con google la contraseña será la de tu correo.
                </p>
                <p>
                    En este formulario podrás observar el icono de google, el cual si lo pulsas podrás acceder a la página
                    con tu cuenta de google sin preocuparte en registrarte primero, ya que te registras de forma automática.
                </p>
                <p>
                    Justo encima del formulario observarás un simpático fantasma al cual si le haces click te dará un susto
                    que te mandará directo a la vista principal
                    <a href="#seccion01" class="text-blue-500 hover:text-blue-700">(PUBLICACIONES SIN COMUNIDAD)</a>.
                </p>
            </div>
        </div>
        <div id="seccion22" @class([
            'rounded-lg text-center',
            'bg-gray-700' =>
                auth()->check() && auth()->user()->temaoscuro && $cont % 2 == 0,
            'bg-gray-800' =>
                auth()->check() && auth()->user()->temaoscuro && $cont % 2 == 1,
            'bg-gray-200' =>
                (auth()->guest() || !auth()->user()->temaoscuro) && $cont % 2 == 0,
            'bg-gray-300' =>
                (auth()->guest() || !auth()->user()->temaoscuro) && $cont % 2 == 1,
        ])>
            <?php $cont++; ?>
            <p class="text-2xl mt-6 mb-3">REGISTER</p>
            <div class="pb-2 text-left ml-3">
                <p>
                    Para poder acceder a este apartado debes pinchar en donde pone 'register', situado a la derecha en la
                    barra de navegación:
                </p>
                <p>
                    Lo que se mostrará por pantalla es un formulario muy básico que te pedirá el nombre de usuario, el email
                    y la contraseña que quieras para la cuenta.
                </p>
                <p>
                    En este formulario podrás observar el icono de google, el cual si lo pulsas podrás acceder a la página
                    con tu cuenta de google.
                </p>
                <p>
                    Al registrarte se mandará un correo de verificación a tu cuenta de google (te llegará por gmail) para
                    que otra persona no se haga pasar por ti.
                </p>
                <p>
                    Justo encima del formulario observarás un simpático fantasma al cual si le haces click te dará un susto
                    que te mandará directo a la vista principal
                    <a href="#seccion01" class="text-blue-500 hover:text-blue-700">(PUBLICACIONES SIN COMUNIDAD)</a>.
                </p>
            </div>
        </div>
    </div>
</x-guest-layout>