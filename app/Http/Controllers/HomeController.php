<?php
 
namespace App\Http\Controllers;
 
use Inertia\Inertia;
use Inertia\Response;
 
class HomeController extends Controller
{
    public function index(): Response
    {
        // Fase 2: render halaman Vue dengan data
        return Inertia::render('Home', [
            'pesan' => 'Halo dari Laravel + Vue 3!',
            'versi' => app()->version(),
        ]);
        //           ↑                  ↑
        //           Nama file Vue       Data yang jadi props di Vue
        //           Pages/Home.vue
    }
}
