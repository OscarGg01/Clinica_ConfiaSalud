<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\ContactoRecibido;

class ContactoController extends Controller
{
    public function enviar(Request $request)
    {
        $data = $request->validate([
            'nombre'  => 'required|string',
            'email'   => 'required|email',
            'asunto'  => 'required|string',
            'mensaje' => 'required|string',
            'privacy' => 'accepted',
        ]);

        // Envía el correo; como usas Mailtrap, llegará allí
        Mail::to(config('mail.from.address'))
            ->send(new ContactoRecibido($data));

        return back()->with('success', '¡Tu mensaje ha sido enviado correctamente!');
    }
}
