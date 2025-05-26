@component('mail::message')
# Nuevo mensaje de contacto

**Nombre:** {{ $datos['nombre'] }}  
**Correo:** {{ $datos['email'] }}  
**Asunto:** {{ $datos['asunto'] }}

**Mensaje:**  
{{ $datos['mensaje'] }}

Thanks,<br>
{{ config('app.name') }}
@endcomponent
