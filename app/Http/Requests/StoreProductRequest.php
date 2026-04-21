<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class StoreProductRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return Auth::check() && Auth::user()->isSeller();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name'          => 'required|string|max:255',
            'category_id'   => 'required|exists:categories,id',
            'price'         => 'nullable|string|max:2000',
            'stock'         => 'required|numeric|min:100|max:999999999',
            'status'        => 'required|in:active,inactive',
            // foto wajib saat tambah, maks 2MB, hanya jpg/jpeg/png/webp
            'image'         => 'required|image|mimes:jpg,jpeg,png,webp|max:2048',
            ];
    }

    public function messages(): array
    {
        return [
            'name.required'         => 'Nama prpduk wajib diisi.',
            'category_id.required'  => 'Pilih kategori produk.',
            'category_id.exists'     => 'Kategori tidak valid.',
            'price.min'             => 'Harga minimal Rp 100.',
            'stock.min'             => 'Stok tidak boleh negatif.',
            'image.required'        => 'Foto produk wajib diupload.',
            'image.max'             => 'Ukuran foto maksimal 2MB',
            'image.mimes'           => 'Foto harus berformat jpg, jpeg, png, atau webp'
        ];
    }
}
