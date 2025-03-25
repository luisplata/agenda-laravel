<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class VirtualServicesController extends Controller
{
    //
    public function virtualServicesList(): JsonResponse
    {
        $virtualServicesList = [
            'Creadora de contenido',
            'Videollamadas',
            'Novia virtual',
            'Videos personalizados',
            'Pack de Fotos',
            'Pack de Videos pregrabados',
            'Foto Zing',
            'Gif Zing',
            'Dickrate',
            'Sexting',
            'Chat Hot',
            'Canal VIP Telegram',
            'Venta de ropa',
            'Servicios personalizados',
            'Otros, a consultar'
        ];

        return response()->json(['virtual_services' => $virtualServicesList]);
    }
}
