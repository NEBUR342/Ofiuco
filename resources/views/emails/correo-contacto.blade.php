@component('mail::message')
# Formulario de Contacto
## Enviado por:
{{$nombre}}
## Email del remitente:
{{$email}}
## Contenido del mensaje:
> {{$contenido}}
@endcomponent