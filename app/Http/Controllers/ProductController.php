<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Company;
use App\Http\Requests\ProductRequest;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;

class ProductController extends Controller
{
    public function showList()
    {

        $products = Product::with('company')->get();
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

    //登録処理
    public function registSubmit(ProductRequest $request)
    {

        $image = $request->file('img_path');
        $image_path = null;

        if ($image) {
            $file_name = time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();
            $image->storeAs('public/images', $file_name);
            $image_path = 'storage/images/' . $file_name;
        }

        $model = new Product();

        DB::beginTransaction();

        try {

            $model->registProduct($request, $image_path);

            DB::commit();

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('商品登録エラー: ' . $e->getMessage());
            Log::error($e->getTraceAsString());
            return back()->withErrors(['error' => '商品の登録に失敗しました。'])->withInput();
        }

        return redirect()->route('regist');


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

            if ($request->hasFile('image')) {

                $image = $request->file('image');
                $file_name = $image->getClientOriginalName();
                $image->storeAs('public/images', $file_name);
                $image_path = 'storage/images/' . $file_name;

            } else {

                $image_path = $product->img_path;//画像なしの場合そのまま
            }

            $product->updateProduct($request, $image_path);

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

    public function index()
    {
        $products = Product::with('company')->get();
        $companies = Company::all();

        return view('list', compact('products', 'companies'));
    }

    public function ajaxSearch(Request $request)
    {
        $products = Product::with('company')
        ->when($request->filled('word'), function ($q) use ($request) {
            $q->where('product_name', 'like', '%' . $request->word . '%');
        })
        ->when($request->filled('company_id'), function ($q) use ($request) {
            $q->where('company_id', $request->company_id);
        })
        ->when($request->filled('price_min'), function ($q) use ($request) {
            $q->where('price', '>=', $request->price_min);
        })
        ->when($request->filled('price_max'), function ($q) use ($request) {
            $q->where('price', '<=', $request->price_max);
        })
        ->when($request->filled('stock_min'), function ($q) use ($request) {
            $q->where('stock', '>=', $request->stock_min);
        })
        ->when($request->filled('stock_max'), function ($q) use ($request) {
            $q->where('stock', '<=', $request->stock_max);
        })
        ->get();


        return response()->json($products);
    }

    public function up()
    {
        Schema::table('products', function (Blueprint $table) {
            $table->renameColumn('img_path', 'image_path');
        });
    }
}
