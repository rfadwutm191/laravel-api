<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreOrderRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'user_id' => 'required|integer|exists:users,id',
            'shipping_address' => 'required|string',
            'pelanggan_id' => 'nullable|integer|exists:pelanggan,id',

            'items' => 'required|array|min:1',
            'items.*.produk_id' => 'required|integer|exists:produks,id',
            'items.*.quantity' => 'required|integer|min:1',
        ];
    }

    public function messages(): array
    {
        return [
            'user_id.exists' => 'User tidak ditemukan',
            'items.required' => 'Keranjang belanja kosong',
            'items.*.produk_id.exists' => 'Produk tidak ditemukan',
            'items.*.quantity.min' => 'Jumlah minimal 1',
        ];
    }
}