<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
            'product_name',
            'price',
            'stock',
            'comment',
            'company_id',
            'img_path',
        ];

    public function getList()
    {
        $products = DB::table('products')
            ->join('companies', 'company_id', '=', 'companies.id')
            ->select('products.*', 'companies.company_name')
            ->get();

        return $products;
    }



    public function company()
    {
        return $this->belongsTo(Company::class, 'company_id', 'id');
    }

    public function registProduct($request, $image_path)
    {
        return Product::create([
            'img_path' => $image_path,
            'product_name' => $request->product_name,
            'price' => $request->price,
            'stock' => $request->stock,
            'comment' => $request->comment,
            'company_id' => $request->company_id,
            'created_at'  => now(),
            'updated_at' => now(),


        ]);
    }

    public function getDetail($id)
    {
        $product = DB::table("products")
        ->join('companies', 'company_id', '=', 'companies.id')
        ->select('products.*', 'companies.company_name')
        ->where('products.id', '=', $id)
        ->first();

        return $product;
    }

    public function updateProduct($request, $image_path)
    {
        return $this->update([
            'img_path' => $image_path,
            'product_name' => $request->product_name,
            'price' => $request->price,
            'stock' => $request->stock,
            'company_id' => $request->company_id,
            'comment' => $request->comment,
        ]);
    }

    public function ajaxSearch(array $params)
    {
        $query = DB::table('products')
        ->join('companies', 'products.company_id', '=', 'companies.id')
        ->select('products.*', 'companies.company_name');

        // 商品名検索
        if (!empty($params['word'])) {
            $query->where('products.product_name', 'like', '%' . $params['word'] . '%');
        }

        // 会社検索
        if (!empty($params['company_id'])) {
            $query->where('products.company_id', $params['company_id']);
        }

        // 価格下限
        if (!empty($params['price_min'])) {
            $query->where('products.price', '>=', $params['price_min']);
        }

        // 価格上限
        if (!empty($params['price_max'])) {
            $query->where('products.price', '<=', $params['price_max']);
        }

        // 在庫下限
        if (!empty($params['stock_min'])) {
            $query->where('products.stock', '>=', $params['stock_min']);
        }

        //在庫上限
        if (!empty($params['stock_max'])) {
            $query->where('products.stock', '<=', $params['stock_max']);
        }

        return $query->get();
    }
}
