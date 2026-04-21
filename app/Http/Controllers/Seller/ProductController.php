<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\models\Category;
use App\models\Product;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;


class ProductController extends Controller
{
    // --INDEX: Daftar produk milik seller yang login--
    public function index(): Response
    {
        $products = Product::with('category')       //eager load kategori
            ->where('user_id', Auth::id())          //hanya produk milik saya
            ->latest()                              //terbaru di atas
            ->paginate(12);                         //12 produk per halaman

        //Tambahkan URL foto ke setiap produk
        $products->getCollection()->transform(function ($product) {
            $product->image_url = $product->image_url;
            $product->formatted_price = $product->formatted_price;
            return $product; 
        });

        return Inertia::render('Seller/Products/Index', [
            'products' =>$products
        ]);
    }


    // --CREATE: Tampilkan form tambah produk--
    public function create(): Response
    {
        return Inertia::render('Seller/Products/Create', [
            'categories' => Category::orderBy('name')->get(['id', 'name']),
        ]);
    }


    // --STORE: Simpan produk baru --
    public function store(Request $request)
    {
        // Simpan foto ke storage/app/public/products/
        $imagePath = $request->file('image')->store('products', 'public');

        Product::create([
            ...$request->validated(),
            'user_id'   => Auth::id(),
            'image'     => $imagePath
        ]);

        return redirect()->route('seller.products.index')
            ->with('success',  'Produk berhasil ditambahkan!');
    }


    // --SHOW--
    public function show(string $id)
    {
        //
    }


    // --EDIT: Tampilkan form edit produk--
    public function edit(Product $product): Response
    {
        //Pastikan hanya pemilik produk yang bisa edit
        abort_if($product->user_id !== Auth::id(), 403);

        return Inertia::render('Seller/Products/Edit', [
            'product' => array_merge($product->toArray(), [
                'image_url' => $product->image_url,
            ]),
            'categories' => Category::orderBy('name')->get(['id', 'name']),
        ]);
    }


    // --UPDATE: Simpan perubahan produk__
    public function update(UpdateProductRequest $request, Product $product)
    {
        $data = $request->validated();

        // Jika ada foto baru diupload
        if ($request->hasFile('image')) {
            //Hapus foto lama dari storage
            if ($product->image) {
                Storage::disk('public')->delete($product->image);
            }
            $data['image'] = $request->file('iamge')->store('products', 'public');
        } else {
            // Tidak ada foto baru, pertahankan foto lama
            unset($data['image']);
        }

        $product->update($data);

        return redirect()->route('seller.products.index')
            ->with('success', 'Produk berhasil diperbarui!');
    }


    // --DESTROY: Hapus produk (soft delete)__
    public function destroy(Product $product)
    {
        abort_if($product->user_id !== Auth::id(), 403);
        
        $product->delete(); // SoftDeletes: tidak benar-benar dihapus

        return redirect()->route('seller.products.index')
            ->with('success', 'Product berhasil dihapus');
    }
}
