<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\API\CheckoutRequest;
use App\Models\Transaction;
use App\Models\Product;
use App\Models\TransactionDetail;
use Illuminate\Http\Request;

class CheckoutController extends Controller
{
    public function checkout(CheckoutRequest $request)
    {
        // ambil semua data dan simpan ke tabel Transaction $request kecuali transaction_detail
        $data = $request->except('transaction_details');

        // indetifier transaksi
        $data['uuid'] = 'TRX' . mt_rand(10000, 99999) . mt_rand(100, 999);

        // masukan data dari $data ke tabel
        $transaction = Transaction::create($data);

        // perulangan untuk membuat array transaction_detail
        foreach ($request->transaction_details as $product) {
            $details[] = new TransactionDetail([
                'transactions_id' => $transaction->id,
                'products_id' => $product,
            ]);

            // pengurangan Qty produk sesudah diambil
            Product::find($product)->decrement('quantity');
        }

        // menyimpan data transaction_detail
        $transaction->details()->saveMany($details);

        return ResponseFormatter::success($transaction);
    }
}
