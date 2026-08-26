<?php

namespace App\Http\Controllers\Supplier;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Product;

class ProductController extends Controller
{
        public function index()
    {
           $supplier_id  = Auth::guard('supplier')->user();
        return view('supplier.products.list', compact('supplier_id'));
    }

    public function view($id)
{
    $supplier_id = Auth::guard('supplier')->id();

    $product = Product::where('id', $id)
                      ->where('uid', $supplier_id)
                      ->first();

    if (!$product) {
       
        return redirect()
            ->route('supplier.products.index');
    }

    return view('supplier.products.view', compact('product', 'supplier_id'));
}


    public function add()
{
    $supplier_id = Auth::guard('supplier')->id();

    return view('supplier.products.view', compact('supplier_id'));
}

}
