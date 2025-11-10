@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>商品詳細</h1>

        <table class="table table-bordered">
            <tr>
                <th>ID</th>
                <td>{{ $product->id }}</td>
            </tr>
            <tr>
                <th>商品名</th>
                <td>{{ $product->product_name }}</td>
            </tr>
            <tr>
                <th>メーカー名</th>
                <td>{{ $product->company_name }}</td>
            </tr>
            <tr>
                <th>コメント</th>
                <td>{{ $product->comment }}</td>
            </tr>
            <tr>
                <th>価格</th>
                <td>{{ number_format($product->price) }} 円</td>
            </tr>
            <tr>
                <th>在庫</th>
                <td>{{ $product->stock }} 個</td>
            </tr>
            <tr>
                <td><a href="{{ route('modification', ['id' => $product->id]) }}">編集</a></td>

            </tr>
        </table>

        <a href="{{ route('list') }}" class="btn btn-secondary">← 一覧に戻る</a>

    </div>
@endsection
