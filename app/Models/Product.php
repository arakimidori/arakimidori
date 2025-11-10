<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Product extends Model
{
    use HasFactory;
    public function getList()
    {
        $products = DB::table('products')
            ->join('companies', 'company_id', '=', 'companies.id')
            ->select('products.*', 'companies.company_name')
            ->get();

        return $products;
    }

    protected $fillable = ['product_name', 'company_name', 'price', 'stock', 'comment'];

    public function company()
    {
        return $this->belongsTo(Company::class, 'company_id', 'id');
    }

    public function registProduct($data)
    {
        // 登録処理

        DB::table('products')->insert([
            'image_path' => $data-> image_path,
            'product_name' => $data-> product_name,
            'price' => $data-> price,
            'stock' => $data-> stock,
            'company_id' => $data->company_id,
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

}
