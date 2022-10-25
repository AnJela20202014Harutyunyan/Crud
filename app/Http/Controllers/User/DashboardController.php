<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\CategoryRequest;
use App\Http\Requests\ProductRequest;
use App\Models\Category;
use App\Models\Category\Product;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        return view('user.dashboard');
    }

    /**
     * @return JsonResponse
     */
    public function getCategories(): JsonResponse
    {
        $categories = Category::where('user_id', auth()->id())
            ->orderBy('id', 'DESC')
            ->paginate(5);
        return response()->json(['categories' => $categories]);

    }

    /**
     * @return JsonResponse
     */
    public function getProducts(): JsonResponse
    {
        $products = Product::where('user_id', auth()->id())
            ->with('category')
            ->orderBy('id', 'DESC')
            ->paginate(5);
        return response()->json(['products' => $products]);
    }

    /**
     * @return JsonResponse
     */
    public function getCategoryList(): JsonResponse
    {
        $categoryList = Category::where('user_id', auth()->id())->get();
        return response()->json(['category_list' => $categoryList]);
    }

    /**
     * @param ProductRequest $request
     * @return JsonResponse
     */

    public function addProduct(ProductRequest $request): JsonResponse
    {
        $product = Product::create(
            [
                'name' => $request->input('name'),
                'price' => $request->input('price'),
                'user_id' => auth()->id(),
                'category_id' => $request->input('category_id')
            ]
        );
        $product = Product::where('id', $product->id)->with('category')->first();
        return response()->json([
            'status' => 'success',
            'product' => $product
        ]);
    }

    /**
     * @param CategoryRequest $request
     * @return JsonResponse
     */

    public function addCategory(CategoryRequest $request): JsonResponse
    {
        $category = Category::create(
            [
                'name' => $request->input('name'),
                'description' => $request->input('description'),
                'user_id' => auth()->id(),
            ]
        );
        return response()->json([
            'status' => 'success',
            'category' => Category::find($category->id)

        ]);
    }

    /**
     * @param ProductRequest $request
     * @return JsonResponse
     */
    public function updateProduct(ProductRequest $request): JsonResponse
    {
        $id = $request->input('id');
        Product::where('id', $id)->update(
            [
                'name' => $request->input('name'),
                'price' => $request['price'],
                'category_id' => $request['category_id']

            ]);
        $product = Product::where('id', $id)->with('category')->first();
        return response()->json([
            'product' => $product
        ]);
    }

    /**
     * @param CategoryRequest $request
     * @return JsonResponse
     */
    public function updateCategory(CategoryRequest $request): JsonResponse
    {
        $id = $request->input('id');
        $category = Category::where('id', $id)->update(
            [
                'name' => $request->input('name'),
                'description' => $request['description']
            ]);
        return response()->json([
            'status' => 'success',
            'post' => $category
        ]);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function deleteProduct(Request $request): JsonResponse
    {
        $id = $request->input('id');
        $product = Product::find($id);

        if (!$product) {
            return response()->json([
                'status' => false,
                'message' => 'Product not found'
            ]);
        }

        $product->delete();
        $product = Product::orderBy('id', 'desc')
            ->with('category')
            ->skip($request->input('current_page') * 5 - 1)
            ->first();

        return response()->json([
            'message' => 'The Product successfully deleted!',
            'product' => $product
        ]);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */

    public function deleteCategory(Request $request): JsonResponse
    {
        $id = $request->input('id');
        Category::where('id', $id)->delete();
        Product::where('category_id', $id)->delete();
        $category = Category::orderBy('id', 'desc')
            ->skip($request->input('current_page') * 5 - 1)
            ->first();
        return response()->json(['message' => 'The Category successfully deleted!', 'category' => $category]);

    }

}
