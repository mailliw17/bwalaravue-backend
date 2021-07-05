<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function all(Request $request)
    {
        // cari barang berdasarkan id
        $id = $request->input('id');

        // mau ambil berapa data. default nya 6 data
        $limit = $request->input('limit', 6);

        // cari barang berdasarkan name
        $name = $request->input('name');

        // cari barang berdasarkan slug
        $slug = $request->input('slug');

        // cari barang berdasarkan type
        $type = $request->input('type');

        // cari barang dengan rentang harga
        $price_from = $request->input('price_from');
        $price_to = $request->input('price_to');

        // UNTUK API YANG HASILNYA TUNGGAL
        if ($id) {
            $product = Product::with('galleries')->find($id);

            if ($product) {
                return ResponseFormatter::success($product, 'Data produk berhasil diambil');
            } else {
                return ResponseFormatter::error(null, 'Data produk tidak ada', 404);
            }
        }

        if ($slug) {
            $product = Product::with('galleries')
                ->where('slug', $slug)
                ->first();

            if ($product) {
                return ResponseFormatter::success($product, 'Data produk berhasil diambil');
            } else {
                return ResponseFormatter::error(null, 'Data produk tidak ada', 404);
            }
        }

        // UNTUK API YANG HASILNYA MORE THAN ONE
        $product = Product::with('galleries');

        if ($name) {
            $product->where('name', 'like', '%' . $name . '%');
        }

        if ($type) {
            $product->where('type', 'like', '%' . $name . '%');
        }

        if ($price_from) {
            $product->where('price', '>=', $price_from);
        }

        if ($price_to) {
            $product->where('price', '<=', $price_to);
        }

        return ResponseFormatter::success(
            $product->paginate($limit),
            'Data list produk berhasil diambil'
        );
    }
}
