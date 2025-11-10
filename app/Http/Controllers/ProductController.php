<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Company;
use App\Http\Requests\ProductRequest;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function showList()
    {

        $model = new Product();
        $products = $model->getList();
        $companies = Company::all();

        return view('list', [
            'products' => $products,
            'companies' => $companies,
        ]);
    }


    public function showRegistForm()
    {
        $companies = Company::all();
        return view('regist', compact('companies'));
    }

    public function registSubmit(ProductRequest $request)
    {


        DB::beginTransaction();

        try {
            // 登録処理呼び出し
            $model = new Product();
            $model->registProduct($request);

            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            return back();
        }


        return redirect(route('list'));
    }

    public function showModificationForm($id)
    {
        $product = Product::findOrFail($id);
        $companies = Company::all();

        return view('modification', compact('product', 'companies'));
    }

    public function update(ProductRequest $request, $id)
    {
        DB::beginTransaction();

        try {
            $product = Product::findOrFail($id);

            $product->update([
                'image_path' => $request->image_path,
                'product_name' => $request->product_name,
                'price' => $request->price,
                'stock' => $request->stock,
                'company_id' => $request->company_id,
            ]);


            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            return back();
        }

        return redirect()->route('modification', $id);
    }

    public function show($id)
    {
        $model = new Product();
        $product = $model->getDetail($id);

        return view('show', compact('product'));
    }

    public function destroy($id)
    {
        $product = Product::findOrFail($id);
        $product->delete();

        return redirect()->route('list')->with('success', '商品を削除しました。');
    }

    public function index(Request $request)
    {
        $query = Product::with('company');

        // 検索フォーム商品名
        if ($request->filled('product_name')) {
            $query->where('product_name', 'like', '%' . $request->product_name . '%');
        }

        // 検索フォームメーカー
        if ($request->filled('company_id')) {
            $query->where('company_id', $request->company_id);
        }
        $products = $query->get();

        $companies = Company::all();

        return view('list', compact('products', 'companies'));
    }
}
