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
            'image_path',
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
        DB::table('products')->insert([
            'image_path' => $image_path,
            'product_name' => $request->product_name,
            'price' => $request->price,
            'stock' => $request->stock,
            'comment' => $request->comment,
            'company_id' => $request->company_id,
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
