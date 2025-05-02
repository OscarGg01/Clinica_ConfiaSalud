<!DOCTYPE html>
<html>
<head>
    <title>Confirmación de Cita</title>
</head>
<body>
    <h2 style="color: #2d3748;">¡Hola {{ $paciente->nombres }}!</h2>
    
    <p>Tu cita ha sido agendada exitosamente con los siguientes detalles:</p>
    
    <div style="background: #f7fafc; padding: 20px; border-radius: 8px;">
        <p><strong>Especialista:</strong> {{ $cita->especialista->nombre }}</p>
        <p><strong>Área:</strong> {{ $cita->especialista->area->nombre }}</p>
        <p><strong>Fecha:</strong> {{ \Carbon\Carbon::parse($cita->fecha)->format('d/m/Y') }}</p>
        <p><strong>Hora:</strong> {{ \Carbon\Carbon::parse($cita->hora)->format('h:i A') }}</p>
        <p><strong>Dirección:</strong> Av. Ejemplo 123, Consultorio 45</p>
    </div>

    <p style="margin-top: 20px;">
        <strong>Importante:</strong><br>
        • Presentarse 15 minutos antes<br>
        • Traer documento de identidad<br>
        • Cancelación con 24h de anticipación
    </p>

    <footer style="margin-top: 30px; color: #718096;">
        <small>
            Este correo es generado automáticamente. Por favor no responder.<br>
            Clínica ConfíaSalud - Central de Citas: 01-2345678
        </small>
    </footer>
</body>
</html>