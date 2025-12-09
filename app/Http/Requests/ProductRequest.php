<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Log;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Validation\ValidationException;

class ProductRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'img_path' => 'nullable|image|max:2048',
            'product_name' => 'required|max:255',
            'price' => 'required|integer|min:0',
            'stock' => 'required|integer|min:0',
            'company_id' => 'required|integer',
            'comment' => 'nullable|string|max:1000',
        ];
    }

    public function attributes()
    {
        return [
            'img_path' => '画像',
            'product_name' => '商品名',
            'price' => '価格',
            'stock' => '在庫',
            'company_id' => 'メーカー名',
            'comment' =>  'コメント'
        ];
    }

    /**
     * エラーメッセージ
     *
     * @return array
     */
    public function messages()
    {
        return [
            'img_path.image' => ':attributeには画像ファイルを指定してください。',
            'product_name.required' => ':attributeは必須項目です。',
            'product_name.max' => ':attributeは:max字以内で入力してください。',
            'price.required' => ':attributeは必須項目です。',
            'price.integer' => ':attribute には整数を入力してください。',
            'stock.required' => ':attributeは必須項目です。',
            'stock.integer' => ':attribute には整数を入力してください。',
            'company_id.required' => ':attributeは必須項目です。',
            'comment.string' => ':attributeは文字で入力してください。',
            'comment.max'    => ':attributeは1000文字以内で入力してください。',
        ];
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */



    public function failedValidation($validator)
    {
        Log::error('Validation errors:', $validator->errors()->toArray());
        throw new ValidationException($validator);
    }

}
