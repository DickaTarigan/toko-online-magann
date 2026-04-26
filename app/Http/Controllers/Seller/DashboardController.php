<?php
namespace App\Http\Controllers\Seller;
 
use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
 
class DashboardController extends Controller
{
    public function index()
    {
        $sellerId = Auth::id();
 
        return Inertia::render('Seller/Dashboard', [
            'stats' => [
                'totalProduk'   => Product::where('user_id', $sellerId)->count(),
                'produkAktif'   => Product::where('user_id', $sellerId)
                                         ->where('status', 'active')->count(),
                'totalStok'     => Product::where('user_id', $sellerId)->sum('stock'),
                'totalPesanan'  => 0, // akan diisi di P5
                'totalPendapatan' => 0, // akan diisi di P5
            ],
            // 5 produk terbaru untuk ditampilkan di dashboard
            'recentProducts' => Product::with('category')
                ->where('user_id', $sellerId)
                ->latest()->take(5)->get()->map(fn($p) => [
                    ...$p->toArray(),
                    'image_url'       => $p->image_url,
                    'formatted_price' => $p->formatted_price,
                ]),
        ]);
    }
}
