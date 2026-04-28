<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class PublicProductController extends Controller
{
    //Halaman katalog: daftar semua produk aktif
    public function index(Request $request): Response
    {
        //Ambil Query String dari URL
        $search     = $request->input('search', '');
        $categoryId = $request->input('category', '');
        $sort       = $request->input('sort', 'latest');

        $query = Product::with('category', 'seller')
            ->where('status', 'active'); //hanya menampilkan produk aktif

        //--Filter Pencarian-- server-side search
        //LIKE '%kata%' mencari di nama DAN deskripsi
        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'LIKE', "%{$search}%")
                ->orWhere('description', 'LIKE', "%{$search}%");
            });
        }

        //--Filter Kategori--
        if ($categoryId) {
            $query->where('category_id', $categoryId);
        }

        //--Sort (Pengurutan)--
        match ($sort) {
            'price_asc'  => $query->orderBy('price', 'asc'),
            'price_desc' => $query->orderBy('price', 'desc'),
            'name_asc'   => $query->orderBy('name', 'asc'),
            default      => $query->latest() // terbaru (created_at DESC)
        };

        // Pagination + pertahankan query string di link halaman berikutnya
        $products = $query->paginate(12)->withQueryString();

        //Tambahkan accesor ke setiap produk
        $products->getCollection()->transform(fn($p) => [
            ...$p->toArray(),
            'image_url'       => $p->image_url,
            'formatted_price' => $p->formatted_price,
        ]);

        return Inertia::render('Products/Index', [
            'products'  => $products,
            'categories'=> Category::orderBy('name')->get(['id', 'name']),
            //kembalikan filter aktif ke Vue agar form tetap terisi
            'filters'   => [
                'search'     => $search,
                'categoryId' => $categoryId,
                'sort'       => $sort,
            ],
        ]);
    }

    //--Halaman detail produk--
    public function show(string $slug): Response
    {
        //firstOrFail(): otomatis 404 jika produk tidak ditemukan
        $product = Product::with('category', 'seller')
            ->where('slug', $slug)
            ->where('status', 'active')
            ->firstOrFail();

        //Produk terkait: kategori sama, bukan produk itu sendiri
        $related = Product::with('category')
            ->where('category_id', $product->category_id)
            ->where('id', '!=', $product->id)
            ->where('status', 'active')
            ->take(4)
            ->get()
            ->map(fn($p) => [
                ...$p->toArray(),
                'image_url' => $p->image_url,
                'formatted_price' => $p->formatted_price,
            ]);

        return Inertia::render('Products/Show', [
            'product' => array_merge($product->toArray(), [
                'image_url' => $product->image_url,
                'formatted_price' => $product->formatted_price,
            ]),
            'related' => $related,
        ]);
    }
}   
