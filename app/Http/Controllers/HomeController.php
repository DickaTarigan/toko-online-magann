<?php
 
namespace App\Http\Controllers;
 
use App\Models\Product;
use Inertia\Inertia;
use Inertia\Response;
 
class HomeController extends Controller
{
    public function index(): Response
    {
        // Ambil 8 produk terbaru yang aktif untuk ditampilkan di beranda
        $featured = Product::with('category')
            ->where('status', 'active')
            ->latest()
            ->take(8)
            ->get()
            ->map(fn ($p) => [
                ...$p -> toArray(),
                'image_url' => $p->image_url,
                'formatted_price' => $p->formatted_price,
            ]);

        // Fase 2: render halaman Vue dengan data
        return Inertia::render('Home', [
            'pesan' => 'Selamat berbelanja di Toko Online Magann',
            'versi' => app()->version(),
            'featured' => $featured,
        ]);
        //           ↑                  ↑
        //           Nama file Vue       Data yang jadi props di Vue
        //           Pages/Home.vue
    }
}
