<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category\Product;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()

    {
        $products = Product::with('category')
            ->orderBy('id', 'DESC')
            ->paginate(5);
        return view('admin/dashboard')->with(compact('products'));
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function changeProductStatus(Request $request): \Illuminate\Http\JsonResponse
    {
        $id = $request->input('id');
        $status = $request->input('status');
        Product::where('id', $id)->update(['status' => $status]);
        return response()->json('The Product successfully changed.');
    }
}
