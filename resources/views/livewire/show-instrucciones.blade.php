<x-guest-layout>
    {{--
    /imagenesDoc
    /imagenesDoc/barraNav
    /imagenesDoc/opcionesUser
    /imagenesDoc/otros

    Modificar iconos de users:
    Añadir amigos:<i class="fa-solid fa-person-circle-plus"></i>
    Eliminar amigos:<i class="fa-solid fa-person-circle-minus"></i>
    Rechazar solicitud:<i class="fa-solid fa-person-circle-xmark"></i>
    Esperando (si le pinchas elimina la solicitud): <i class="fa-solid fa-person-circle-question"></i>
    --}}
    <div>
        <div class="h-24"></div>
        <div class="min-[650px]:flex min-[650px]:flex-wrap min-[650px]:justify-around">
            <div class="min-[650px]:w-2/3 min-[800px]:w-1/2 min-[1100px]:w-1/3">
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
                        <a href="#seccion05" class="min-[400px]:ml-6 text-blue-500 hover:text-blue-700">ETIQUETAS</a>
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
                        <a href="#seccion15" class="min-[400px]:ml-6 text-blue-500 hover:text-blue-700">CONTACTANOS</a>
                    </li>
                </ul>
            </div>
            <div class="sm:w-2/3 min-[800px]:w-1/2 min-[1100px]:w-1/3">
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
                        <a href="#seccion20" class="min-[400px]:ml-6 text-blue-500 hover:text-blue-700">GUARDADOS</a>
                    </li>
                    <li>
                        <a href="#seccion21" class="min-[400px]:ml-6 text-blue-500 hover:text-blue-700">LOGIN</a>
                    </li>
                    <li>
                        <a href="#seccion22" class="min-[400px]:ml-6 text-blue-500 hover:text-blue-700">REGISTER</a>
                    </li>
                </ul>
            </div>
            <div class="sm:w-2/3 min-[800px]:w-1/2 min-[1100px]:w-1/3">
                <p class="text-xl min-[400px]:text-3xl mb-3">OTROS</p>
                <ul class="text-base min-[400px]:text-xl">
                    <li>
                        <a href="#seccion23" class="min-[400px]:ml-6 text-blue-500 hover:text-blue-700">
                            VERIFICACIÓN DE CORREO
                        </a>
                    </li>
                </ul>
            </div>
        </div>
        <div id="seccion01" class="h-16"></div>
        <p class="text-3xl text-center">BARRA DE NAVEGACIÓN</p>
        <div class="h-8"></div>
        <div @class([
            'rounded-lg text-center',
            'bg-gray-800' => auth()->check() && auth()->user()->temaoscuro,
            'bg-gray-300' => auth()->guest() || !auth()->user()->temaoscuro,
        ])>
            <p class="text-2xl py-3">PUBLICACIONES SIN COMUNIDAD</p>
            <div class="pb-2 text-left mx-3">
                <p> Aunque puede sonar raro este apartado, en realidad es la primera vista que encuentras al entrar a la
                    página, la forma de acceder a este es mediante la imagen (el logo) que hay situada en la barra de
                    navegación de la página.
                </p>
                <p>
                    Cuando entras a la página lo primero que encontrarás es una sección en la que se muestran
                    publicaciones
                    de usuarios que han subido una publicación la cual no pertenece a una comunidad.
                </p>
                <p class="mb-2">
                    En la parte superior de esta encontrarás un buscador que te permite encontrar las publicaciones
                    mediante
                    el nombre del usuario, o por el titulo de la publicación. Mientras que debajo de este se encuentran
                    3
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
                <p class="my-2">Si estás logueado puedes encontrarte con este botón:</p>
                <span class="mx-3 cursor-pointer bg-red-600 hover:bg-red-700 p-2 rounded-lg">FOLLOW</span>
                <p class="my-2">
                    Al pulsar en este se mostrarán las publicaciones de las personas a las que le has dado follow y en
                    su lugar aparecerá un nuevo botón para volver a la vista anterior, el cual es:
                </p>
                <span class="mx-3 cursor-pointer bg-red-600 hover:bg-red-700 p-2 rounded-lg">GENERAL</span>
                <div class="h-2"></div>
            </div>
        </div>
        <div id="seccion02" class="h-24"></div>
        <div @class([
            'rounded-lg text-center',
            'bg-gray-700' => auth()->check() && auth()->user()->temaoscuro,
            'bg-gray-200' => auth()->guest() || !auth()->user()->temaoscuro,
        ])>
            <p class="text-2xl py-3">PUBLICACIONES CON COMUNIDAD</p>
            <div class="pb-2 text-left mx-3">
                <p>
                    Para poder acceder a este apartado debes pinchar en el primer icono que aparece en
                    la barra de navegación, el cual es: <i class="fa-solid fa-house"></i>
                </p>
                <p>
                    Cuando accedes a esta vista lo que encontrarás es una sección en la que se muestran publicaciones de
                    usuarios que han subido una publicación la cual si pertenece a una comunidad.
                </p>
                <p class="mb-2">
                    En la parte superior de esta encontrarás un buscador que te permite encontrar las publicaciones
                    mediante
                    el nombre del usuario, el nombre de la comunidad o por el titulo de la publicación. Mientras que
                    debajo
                    de este se encuentran 4 iconos:
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
        <div id="seccion03" class="h-24"></div>
        <div @class([
            'rounded-lg text-center',
            'bg-gray-800' => auth()->check() && auth()->user()->temaoscuro,
            'bg-gray-300' => auth()->guest() || !auth()->user()->temaoscuro,
        ])>
            <p class="text-2xl py-3">COMUNIDADES</p>
            <div class="pb-2 text-left mx-3">
                <p>
                    Para poder acceder a este apartado debes pinchar en el segundo icono que aparece en
                    la barra de navegación, el cual es: <i class="fa-solid fa-people-roof"></i>
                </p>
                <p>
                    Cuando accedes a esta vista lo que encontrarás es una sección en la que se muestran publicaciones de
                    usuarios que han subido una publicación la cual si pertenece a una comunidad.
                </p>
                <p class="mb-2">
                    En la parte superior de esta encontrarás un buscador que te permite encontrar las publicaciones
                    mediante
                    el nombre del usuario, el nombre de la comunidad o por el titulo de la publicación. Mientras que
                    debajo
                    de este se encuentran 4 iconos:
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
        <div id="seccion04" class="h-24"></div>
        <div @class([
            'rounded-lg text-center',
            'bg-gray-700' => auth()->check() && auth()->user()->temaoscuro,
            'bg-gray-200' => auth()->guest() || !auth()->user()->temaoscuro,
        ])>
            <p class="text-2xl py-3">PERFIL DE USUARIO</p>
            <div class="pb-2 text-left mx-3">
                <p>
                    Para poder acceder a este apartado debes pinchar en el tercer icono que aparece en
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
                    Posteriormente encontrarás un buscador que te permite encontrar las publicaciones mediante el nombre
                    de
                    la comunidad o por el titulo de la publicación. Mientras que debajo de este se encuentran 4 iconos:
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
        @if (auth()->check() && auth()->user()->is_admin)
            <div id="seccion05" class="h-24"></div>
            <div @class([
                'rounded-lg text-center',
                'bg-gray-800' => auth()->user()->temaoscuro,
                'bg-gray-300' => !auth()->user()->temaoscuro,
            ])>
                <p class="text-2xl py-3">ETIQUETAS</p>
                <div class="pb-2 text-left mx-3">
                    <p>
                        Para poder acceder a este apartado debes pinchar en el cuarto icono que aparece en
                        la barra de navegación, el cual es: <i class="fa-solid fa-tags"></i>
                    </p>
                    <p>
                        Al entrar en esta vista lo que se mostrarán son las etiquetas que los usuarios de la página
                        pueden
                        añadir a sus publicaciones:
                    </p>
                    <p class="mb-2">
                        En la parte superior de la pantalla encontrarás un buscador que te permite encontrar las
                        etiquetas
                        por su nombre. Mientras que debajo de este se encuentran 2 iconos:
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
        @endif
        <div id="seccion06" class="h-24"></div>
        <div @class([
            'rounded-lg text-center',
            'bg-gray-700' => auth()->check() && auth()->user()->temaoscuro,
            'bg-gray-200' => auth()->guest() || !auth()->user()->temaoscuro,
        ])>
            <p class="text-2xl py-3">USUARIOS</p>
            <div class="pb-2 text-left mx-3">
                @if (auth()->check() && auth()->user()->is_admin)
                    <p>
                        Para poder acceder a este apartado debes pinchar en el quinto icono que aparece en
                        la barra de navegación, el cual es: <i class="fa-solid fa-users"></i>
                    </p>
                @else
                    <p>
                        Para poder acceder a este apartado debes pinchar en el cuarto icono que aparece en
                        la barra de navegación, el cual es: <i class="fa-solid fa-users"></i>
                    </p>
                @endif
                <p>Al entrar en esta vista lo que se mostrarán son todos los usuarios de la página.</p>
                <p class="mb-2">
                    En la parte superior de la pantalla encontrarás un buscador que te permite encontrar los usuarios
                    por su
                    nombre o por su apellido. Mientras que debajo de este se encuentran 2 iconos:
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
                    A la derecha tienes acciones que puedes hacer con los usuarios, como puede ser el de mandar,
                    rechazar o
                    eliminar solicitudes de amistad.
                </p>
            </div>
        </div>
        <div id="seccion07" class="h-24"></div>
        <div @class([
            'rounded-lg text-center',
            'bg-gray-800' => auth()->check() && auth()->user()->temaoscuro,
            'bg-gray-300' => auth()->guest() || !auth()->user()->temaoscuro,
        ])>
            <p class="text-2xl py-3">NOTIFICACIONES</p>
            <div class="pb-2 text-left mx-3">
                @if (auth()->check() && auth()->user()->is_admin)
                    <p>
                        Para poder acceder a este apartado debes pinchar en el sexto icono que aparece
                        en la barra de navegación, el cual es: <i class="fa-regular fa-bell"></i>
                    </p>
                @else
                    <p>
                        Para poder acceder a este apartado debes pinchar en el quinto icono que aparece
                        en la barra de navegación, el cual es: <i class="fa-regular fa-bell"></i>
                    </p>
                @endif
                <p>
                    Al pulsar en esta opcón lo que se mostrará es un dropdown con diferentes opciones.
                </p>
            </div>
            <div id="seccion08" class="h-24"></div>
            <div>
                <p class="text-xl py-3">LIKES</p>
                <div class="pb-2 text-left mx-3">
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
            <div id="seccion09" class="h-24"></div>
            <div>
                <p class="text-xl py-3">GUARDADOS</p>
                <div class="pb-2 text-left mx-3">
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
            <div id="seccion10" class="h-24"></div>
            <div>
                <p class="text-xl py-3">COMENTARIOS</p>
                <div class="pb-2 text-left mx-3">
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
            <div id="seccion11" class="h-24"></div>
            <div>
                <p class="text-xl py-3">COMUNIDADES</p>
                <div class="pb-2 text-left mx-3">
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
            <div id="seccion12" class="h-24"></div>
            <div>
                <p class="text-xl py-3">AMIGOS</p>
                <div class="pb-2 text-left mx-3">
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
            <div id="seccion13" class="h-24"></div>
            <div>
                <p class="text-xl py-3">FOLLOWS</p>
                <div class="pb-2 text-left mx-3">
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
        <div id="seccion14" class="h-24"></div>
        <div @class([
            'rounded-lg text-center',
            'bg-gray-700' => auth()->check() && auth()->user()->temaoscuro,
            'bg-gray-200' => auth()->guest() || !auth()->user()->temaoscuro,
        ])>
            <p class="text-2xl py-3">CHAT</p>
            <div class="pb-2 text-left mx-3">
                @if (auth()->check() && auth()->user()->is_admin)
                    <p>
                        Para poder acceder a este apartado debes pinchar en el séptimo icono que aparece
                        en la barra de navegación, el cual es: <i class="fa-regular fa-comment-dots"></i>
                    </p>
                @else
                    <p>
                        Para poder acceder a este apartado debes pinchar en el sexto icono que aparece
                        en la barra de navegación, el cual es: <i class="fa-regular fa-comment-dots"></i>
                    </p>
                @endif
                <p>
                    Esta vista muestra un chat, la cual cuenta con un apartado para ver los contactos, los
                    cuales son los amigos que tengas en la página y las comunidades que has creado o bien en las que
                    participas:
                </p>
                <p>Los mensajes de esta vista se mostrarán de la siguiente manera:</p>
                <div id="mostrarEjemplo" class="mt-2">
                </div>
            </div>
        </div>
        <div id="seccion15" class="h-24"></div>
        <div @class([
            'rounded-lg text-center',
            'bg-gray-800' => auth()->check() && auth()->user()->temaoscuro,
            'bg-gray-300' => auth()->guest() || !auth()->user()->temaoscuro,
        ])>
            <p class="text-2xl py-3">CONTACTANOS</p>
            <div class="pb-2 text-left mx-3">
                @if (auth()->check() && auth()->user()->is_admin)
                    <p>
                        Para poder acceder a este apartado debes pinchar en el octavo icono que aparece
                        en la barra de navegación, el cual es: <i class="fa-regular fa-envelope"></i>
                    </p>
                @else
                    <p>
                        Para poder acceder a este apartado debes pinchar en el séptimo icono que aparece
                        en la barra de navegación, el cual es: <i class="fa-regular fa-envelope"></i>
                    </p>
                @endif
                @auth()
                    <p>
                        Rellene el formulario que tiene a la vista introduciendo su nombre y el mensaje que quiera dar al
                        administrador del sistema. Como podrá observar su email ya viene por defecto.
                    </p>
                @else
                    <p>
                        Rellene el formulario que tiene a la vista introduciendo su nombre, email y el mensaje que quiera
                        dar al
                        administrador del sistema.
                    </p>
                @endauth
                <p>
                    En la parte inferior verá dos botones, si ha introducido en todos los campos los datos correctamente
                    al
                    pulsar en
                    <button class="bg-blue-500 mx-1 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded my-1">
                        <i class="fas fa-paper-plane"></i> Enviar
                    </button>
                    se deberá de mandar el formulario.
                </p>
                <p>
                    En cambio si quieres cancelar el correo puedes moverte con la barra de navegación o pulsar en el
                    botón
                    <button
                        class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded cursor-pointer my-1">
                        <i class="fas fa-backward"></i> Cancelar
                    </button>
                    se deverá de mandar el formulario.
                </p>
            </div>
        </div>
        <div id="seccion16" class="h-16"></div>
        <p class="text-3xl text-center">OPCIONES DE USUARIO</p>
        <div class="h-8"></div>
        <div @class([
            'rounded-lg text-center',
            'bg-gray-700' => auth()->check() && auth()->user()->temaoscuro,
            'bg-gray-200' => auth()->guest() || !auth()->user()->temaoscuro,
        ])>
            <p class="text-2xl py-3">PROFILE</p>
            <div class="pb-2 text-left mx-3">
            </div>
        </div>
        <div id="seccion17" class="h-24"></div>
        <div @class([
            'rounded-lg text-center',
            'bg-gray-800' => auth()->check() && auth()->user()->temaoscuro,
            'bg-gray-300' => auth()->guest() || !auth()->user()->temaoscuro,
        ])>
            <p class="text-2xl py-3">AMIGOS</p>
            <div class="pb-2 text-left mx-3">
            </div>
        </div>
        <div id="seccion18" class="h-24"></div>
        <div @class([
            'rounded-lg text-center',
            'bg-gray-700' => auth()->check() && auth()->user()->temaoscuro,
            'bg-gray-200' => auth()->guest() || !auth()->user()->temaoscuro,
        ])>
            <p class="text-2xl py-3">MODO OSCURO</p>
            <div class="pb-2 text-left mx-3">
            </div>
        </div>
        <div id="seccion19" class="h-24"></div>
        <div @class([
            'rounded-lg text-center',
            'bg-gray-800' => auth()->check() && auth()->user()->temaoscuro,
            'bg-gray-300' => auth()->guest() || !auth()->user()->temaoscuro,
        ])>
            <p class="text-2xl py-3">LIKES</p>
            <div class="pb-2 text-left mx-3">
            </div>
        </div>
        <div id="seccion20" class="h-24"></div>
        <div @class([
            'rounded-lg text-center',
            'bg-gray-700' => auth()->check() && auth()->user()->temaoscuro,
            'bg-gray-200' => auth()->guest() || !auth()->user()->temaoscuro,
        ])>
            <p class="text-2xl py-3">GUARDADOS</p>
            <div class="pb-2 text-left mx-3">
            </div>
        </div>
        <div id="seccion21" class="h-24"></div>
        <div @class([
            'rounded-lg text-center',
            'bg-gray-800' => auth()->check() && auth()->user()->temaoscuro,
            'bg-gray-300' => auth()->guest() || !auth()->user()->temaoscuro,
        ])>
            <p class="text-2xl py-3">LOGIN</p>
            <div class="pb-2 text-left mx-3">
                <p>
                    Para poder acceder a este apartado debes pinchar en donde pone 'login', situado a la derecha en la
                    barra
                    de navegación:
                </p>
                <p>
                    Lo que se mostrará por pantalla es un formulario muy básico que te pedirá el email y la contraseña
                    que
                    has introducido cuando te registraste.
                    Si te has registrado con google la contraseña será la de tu correo.
                </p>
                <p>
                    En este formulario podrás observar el icono de google, el cual si lo pulsas podrás acceder a la
                    página
                    con tu cuenta de google sin preocuparte en registrarte primero, ya que te registras de forma
                    automática.
                </p>
                <p>
                    Justo encima del formulario observarás un simpático fantasma al cual si le haces click te dará un
                    susto
                    que te mandará directo a la vista principal
                    <a href="#seccion01" class="text-blue-500 hover:text-blue-700">(PUBLICACIONES SIN COMUNIDAD)</a>.
                </p>
            </div>
        </div>
        <div id="seccion22" class="h-24"></div>
        <div @class([
            'rounded-lg text-center',
            'bg-gray-700' => auth()->check() && auth()->user()->temaoscuro,
            'bg-gray-200' => auth()->guest() || !auth()->user()->temaoscuro,
        ])>
            <p class="text-2xl py-3">REGISTER</p>
            <div class="pb-2 text-left mx-3">
                <p>
                    Para poder acceder a este apartado debes pinchar en donde pone 'register', situado a la derecha en
                    la
                    barra de navegación:
                </p>
                <p>
                    Lo que se mostrará por pantalla es un formulario muy básico que te pedirá el nombre de usuario, el
                    email
                    y la contraseña que quieras para la cuenta.
                </p>
                <p>
                    En este formulario podrás observar el icono de google, el cual si lo pulsas podrás acceder a la
                    página
                    con tu cuenta de google.
                </p>
                <p>
                    Al registrarte se mandará un correo de verificación a tu cuenta de google (te llegará por gmail)
                    para
                    que otra persona no se haga pasar por ti.
                </p>
                <p>
                    Justo encima del formulario observarás un simpático fantasma al cual si le haces click te dará un
                    susto
                    que te mandará directo a la vista principal
                    <a href="#seccion01" class="text-blue-500 hover:text-blue-700">(PUBLICACIONES SIN COMUNIDAD)</a>.
                </p>
            </div>
        </div>
        <div id="seccion23" class="h-16"></div>
        <p class="text-3xl text-center">OTROS</p>
        <div class="h-8"></div>
        <div @class([
            'rounded-lg text-center',
            'bg-gray-800' => auth()->check() && auth()->user()->temaoscuro,
            'bg-gray-300' => auth()->guest() || !auth()->user()->temaoscuro,
        ])>
            <p class="text-2xl py-3">VERIFICACIÓN DE CORREO</p>
            <div class="pb-2 text-left mx-3">
                <p></p>
                <p></p>
                <p></p>
                <p></p>
                <p></p>
            </div>
        </div>
    </div>
    <script>
        // script con funciones para realizar explicación del chat interactivo
        var modoOscuro = ("{{ auth()->check() && auth()->user()->temaoscuro }}") ? 1 : 0;
        var usuarioLogueado = 1;

        function cambiarModoOscuro() {
            modoOscuro = (modoOscuro) ? 0 : 1;
            var nuevo = document.getElementById('mostrarEjemplo');
            if (usuarioLogueado) {
                if (modoOscuro) {
                    nuevo.innerHTML =
                        "<div class='bg-gray-600 border-solid border-2 border-indigo-600 rounded-lg'><div class='flex flex-wrap justify-center mt-1'><button onclick='cambiarLoginUsuario()' class='mr-1 bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-full'>Usuario logueado</button><button onclick='cambiarModoOscuro()' class='ml-1 bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-full max-[422px]:mt-1'>Modo oscuro</button></div><div class='mb-3 flex flex-row-reverse'><p class = 'max-w-[80%] xl:max-w-2xl py-1 px-4 rounded-br-xl rounded-bl-xl mt-2 mx-2 rounded-tl-xl bg-gray-700 text-white'>Usuario normal modo oscuro</p></div><div class = 'mb-3 flex flex-row-reverse'><p class = 'max-w-[80%] xl:max-w-2xl py-1 px-4 rounded-br-xl rounded-bl-xl mx-2 rounded-tl-xl bg-blue-700 text-white'>Dueño de la comunidad modo oscuro</p></div><div class = 'mb-3 flex flex-row-reverse'><p class = 'max-w-[80%] xl:max-w-2xl py-1 px-4 rounded-br-xl rounded-bl-xl font-bold text-white mx-2 rounded-tl-xl bg-gradient-to-r from-red-600 from-10% via-indigo-600 via-80% to-blue-600 to-90%'>Administrador modo oscuro</p></div></div>";
                } else {
                    nuevo.innerHTML =
                        "<div class='bg-gray-100 border-solid border-2 border-indigo-600 rounded-lg'><div class='flex flex-wrap justify-center mt-1'><button onclick='cambiarLoginUsuario()' class='mr-1 bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-full'>Usuario logueado</button><button onclick='cambiarModoOscuro()' class='ml-1 bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-full max-[422px]:mt-1'>Modo claro</button></div><div class = 'mb-3 flex flex-row-reverse'><p class = 'max-w-[80%] xl:max-w-2xl py-1 px-4 rounded-br-xl rounded-bl-xl mt-2 mx-2 rounded-tl-xl bg-gray-300'>Usuario normal modo claro</p></div><div class = 'mb-3 flex flex-row-reverse'><p class = 'max-w-[80%] xl:max-w-2xl py-1 px-4 rounded-br-xl rounded-bl-xl mx-2 rounded-tl-xl bg-blue-400'>Dueño dela comunidad modo claro</p></div><div class = 'mb-3 flex flex-row-reverse'><p class = 'max-w-[80%] xl:max-w-2xl py-1 px-4 rounded-br-xl rounded-bl-xl font-bold text-white mx-2 rounded-tl-xl bg-gradient-to-r from-red-500 from-10% via-indigo-500 via-80% to-blue-500 to-90%'>Administrador modo claro</p></div></div>";
                }
            } else {
                if (modoOscuro) {
                    nuevo.innerHTML =
                        "<div class='bg-gray-600 border-solid border-2 border-indigo-600 rounded-lg'><div class='flex flex-wrap justify-center mt-1'><button onclick='cambiarLoginUsuario()' class='mr-1 bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-full'>Usuario no logueado</button><button onclick='cambiarModoOscuro()' class='ml-1 bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-full max-[422px]:mt-1'>Modo oscuro</button></div><div class = 'mb-3 flex'><p class = 'max-w-[80%] xl:max-w-2xl py-1 px-4 rounded-br-xl rounded-bl-xl mt-2 mx-2 rounded-tr-xl bg-gray-700 text-white'>Usuario normal modo oscuro</p></div><div class = 'mb-3 flex'><p class = 'max-w-[80%] xl:max-w-2xl py-1 px-4 rounded-br-xl rounded-bl-xl mx-2 rounded-tr-xl bg-blue-700 text-white'>Dueño de la comunidad modo oscuro</p></div><div class = 'mb-3 flex'><p class = 'max-w-[80%] xl:max-w-2xl py-1 px-4 rounded-br-xl rounded-bl-xl font-bold text-white mx-2 rounded-tr-xl bg-gradient-to-r from-red-600 from-10% via-indigo-600 via-80% to-blue-600 to-90%'>Administrador modo oscuro</p></div></div>";
                } else {
                    nuevo.innerHTML =
                        "<div class='bg-gray-100 border-solid border-2 border-indigo-600 rounded-lg'><div class='flex flex-wrap justify-center mt-1'><button onclick='cambiarLoginUsuario()' class='mr-1 bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-full'>Usuario no logueado</button><button onclick='cambiarModoOscuro()' class='ml-1 bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-full max-[422px]:mt-1'>Modo claro</button></div><div class = 'mb-3 flex'><p class='max-w-[80%] xl:max-w-2xl py-1 px-4 rounded-br-xl rounded-bl-xl mt-2 mx-2 rounded-tr-xl bg-gray-300'>Usuario normal modo claro</p></div><div class = 'mb-3 flex'><p class = 'max-w-[80%] xl:max-w-2xl py-1 px-4 rounded-br-xl rounded-bl-xl mx-2 rounded-tr-xl bg-blue-400'>Dueño de la comunidad modo claro</p></div><div class = 'mb-3 flex'><p class = 'max-w-[80%] xl:max-w-2xl py-1 px-4 rounded-br-xl rounded-bl-xl font-bold text-white mx-2 rounded-tr-xl bg-gradient-to-r from-red-500 from-10% via-indigo-500 via-80% to-blue-500 to-90%'>Administrador modo claro</p></div></div>";
                }
            }
        }

        function cambiarLoginUsuario() {
            usuarioLogueado = (usuarioLogueado) ? 0 : 1;
            var nuevo = document.getElementById('mostrarEjemplo');
            if (usuarioLogueado) {
                if (modoOscuro) {
                    nuevo.innerHTML =
                        "<div class='bg-gray-600 border-solid border-2 border-indigo-600 rounded-lg'><div class='flex flex-wrap justify-center mt-1'><button onclick='cambiarLoginUsuario()' class='mr-1 bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-full'>Usuario logueado</button><button onclick='cambiarModoOscuro()' class='ml-1 bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-full max-[422px]:mt-1'>Modo oscuro</button></div><div class='mb-3 flex flex-row-reverse'><p class = 'max-w-[80%] xl:max-w-2xl py-1 px-4 rounded-br-xl rounded-bl-xl mt-2 mx-2 rounded-tl-xl bg-gray-700 text-white'>Usuario normal modo oscuro</p></div><div class = 'mb-3 flex flex-row-reverse'><p class = 'max-w-[80%] xl:max-w-2xl py-1 px-4 rounded-br-xl rounded-bl-xl mx-2 rounded-tl-xl bg-blue-700 text-white'>Dueño de la comunidad modo oscuro</p></div><div class = 'mb-3 flex flex-row-reverse'><p class = 'max-w-[80%] xl:max-w-2xl py-1 px-4 rounded-br-xl rounded-bl-xl font-bold text-white mx-2 rounded-tl-xl bg-gradient-to-r from-red-600 from-10% via-indigo-600 via-80% to-blue-600 to-90%'>Administrador modo oscuro</p></div></div>";
                } else {
                    nuevo.innerHTML =
                        "<div class='bg-gray-100 border-solid border-2 border-indigo-600 rounded-lg'><div class='flex flex-wrap justify-center mt-1'><button onclick='cambiarLoginUsuario()' class='mr-1 bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-full'>Usuario logueado</button><button onclick='cambiarModoOscuro()' class='ml-1 bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-full max-[422px]:mt-1'>Modo claro</button></div><div class = 'mb-3 flex flex-row-reverse'><p class = 'max-w-[80%] xl:max-w-2xl py-1 px-4 rounded-br-xl rounded-bl-xl mt-2 mx-2 rounded-tl-xl bg-gray-300'>Usuario normal modo claro</p></div><div class = 'mb-3 flex flex-row-reverse'><p class = 'max-w-[80%] xl:max-w-2xl py-1 px-4 rounded-br-xl rounded-bl-xl mx-2 rounded-tl-xl bg-blue-400'>Dueño dela comunidad modo claro</p></div><div class = 'mb-3 flex flex-row-reverse'><p class = 'max-w-[80%] xl:max-w-2xl py-1 px-4 rounded-br-xl rounded-bl-xl font-bold text-white mx-2 rounded-tl-xl bg-gradient-to-r from-red-500 from-10% via-indigo-500 via-80% to-blue-500 to-90%'>Administrador modo claro</p></div></div>";
                }
            } else {
                if (modoOscuro) {
                    nuevo.innerHTML =
                        "<div class='bg-gray-600 border-solid border-2 border-indigo-600 rounded-lg'><div class='flex flex-wrap justify-center mt-1'><button onclick='cambiarLoginUsuario()' class='mr-1 bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-full'>Usuario no logueado</button><button onclick='cambiarModoOscuro()' class='ml-1 bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-full max-[422px]:mt-1'>Modo oscuro</button></div><div class = 'mb-3 flex'><p class = 'max-w-[80%] xl:max-w-2xl py-1 px-4 rounded-br-xl rounded-bl-xl mt-2 mx-2 rounded-tr-xl bg-gray-700 text-white'>Usuario normal modo oscuro</p></div><div class = 'mb-3 flex'><p class = 'max-w-[80%] xl:max-w-2xl py-1 px-4 rounded-br-xl rounded-bl-xl mx-2 rounded-tr-xl bg-blue-700 text-white'>Dueño de la comunidad modo oscuro</p></div><div class = 'mb-3 flex'><p class = 'max-w-[80%] xl:max-w-2xl py-1 px-4 rounded-br-xl rounded-bl-xl font-bold text-white mx-2 rounded-tr-xl bg-gradient-to-r from-red-600 from-10% via-indigo-600 via-80% to-blue-600 to-90%'>Administrador modo oscuro</p></div></div>";
                } else {
                    nuevo.innerHTML =
                        "<div class='bg-gray-100 border-solid border-2 border-indigo-600 rounded-lg'><div class='flex flex-wrap justify-center mt-1'><button onclick='cambiarLoginUsuario()' class='mr-1 bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-full'>Usuario no logueado</button><button onclick='cambiarModoOscuro()' class='ml-1 bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-full max-[422px]:mt-1'>Modo claro</button></div><div class = 'mb-3 flex'><p class='max-w-[80%] xl:max-w-2xl py-1 px-4 rounded-br-xl rounded-bl-xl mt-2 mx-2 rounded-tr-xl bg-gray-300'>Usuario normal modo claro</p></div><div class = 'mb-3 flex'><p class = 'max-w-[80%] xl:max-w-2xl py-1 px-4 rounded-br-xl rounded-bl-xl mx-2 rounded-tr-xl bg-blue-400'>Dueño de la comunidad modo claro</p></div><div class = 'mb-3 flex'><p class = 'max-w-[80%] xl:max-w-2xl py-1 px-4 rounded-br-xl rounded-bl-xl font-bold text-white mx-2 rounded-tr-xl bg-gradient-to-r from-red-500 from-10% via-indigo-500 via-80% to-blue-500 to-90%'>Administrador modo claro</p></div></div>";
                }
            }
        }
        cambiarLoginUsuario();
    </script>
</x-guest-layout>
