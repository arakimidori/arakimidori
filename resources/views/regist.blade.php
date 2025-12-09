@extends('layouts.app')

@section('title', '投稿画面')

@section('content')
    <div class="container">
        <div class="row">
            <h1>商品新規登録画面</h1>
            <form action="{{ route('submit') }}" method="post" enctype="multipart/form-data">
                @csrf

                <div class="form-group">
                    <label for="product_name">商品名<span style="color: red;">※</span></label>
                    <input type="text" class="form-control" id="product_name" name="product_name"
                        placeholder="Product_name" value="{{ old('product_name') }}">
                    @if ($errors->has('product_name'))
                        <p>{{ $errors->first('product_name') }}</p>
                    @endif
                </div>

                <div class="form-group">
                    <label for="company_id">メーカー名<span style="color: red;">※</span></label>
                    <select name="company_id" id="company_id" class="form-control">
                        <option value="">選択してください</option>

                        @foreach ($companies as $company)
                            <option value="{{ $company->id }}" {{ old('company_id') == $company->id ? 'selected' : '' }}>
                                {{ $company->company_name }}
                            </option>
                        @endforeach
                    </select>
                    @if ($errors->has('company_id'))
                        <p>{{ $errors->first('company_id') }}</p>
                    @endif
                </div>

                <div class="form-group">
                    <label for="price">価格<span style="color: red;">※</span></label>
                    <input type="number" class="form-control" id="price" name="price" placeholder="Price"
                        value="{{ old('price') }}">
                    @if ($errors->has('price'))
                        <p>{{ $errors->first('price') }}</p>
                    @endif
                </div>

                <div class="form-group">
                    <label for="stock">在庫<span style="color: red;">※</span></label>
                    <input type="number" class="form-control" id="stock" name="stock" placeholder="Stock"
                        value="{{ old('stock') }}">
                    @if ($errors->has('stock'))
                        <p>{{ $errors->first('stock') }}</p>
                    @endif
                </div>

                <div class="form-group">
                    <label for="comment">コメント</label>
                    <textarea class="form-control" id="comment" name="comment" rows="4" placeholder="コメントを入力してください">{{ old('comment') }}</textarea>
                    @if ($errors->has('comment'))
                        <p>{{ $errors->first('comment') }}</p>
                    @endif
                </div>

                <div class="form-group">
                    <label for="iae">商品画像</label>
                    <input type="file" class="form-control" id="img_path" name="img_path">
                </div>

                <button type="submit" class="btn btn-default">登録</button>

                <a href="{{ route('list') }}">
                    <button type="button">戻る</button>
                </a>
            </form>
        </div>
    </div>
@endsection
