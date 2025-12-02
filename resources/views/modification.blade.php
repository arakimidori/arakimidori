@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <h1>商品情報編集画面</h1>
            <form action="{{ route('modification.update', $product->id) }}" method="post" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="form-group">
                    <label class="form-label">ID</label>
                    <span>{{ $product->id }}</span>
                    <input type="hidden" name="id" value="{{ $product->id }}">
                </div>

                <div class="form-group">
                    <label for="product_name">商品名<span style="color: red;">※</span></label>
                    <input type="text" class="form-control" id="product_name" name="product_name"
                        placeholder="Product_name" value="{{ old('product_name', $product->product_name) }}">
                    @if ($errors->has('product_name'))
                        <p>{{ $errors->first('product_name') }}</p>
                    @endif
                </div>

                <div class="form-group">
                    <label for="company_id">メーカー名<span style="color: red;">※</span></label>
                    <select name="company_id" id="company_id" class="form-control"
                        value="{{ old('company_id', $product->company_id) }}">
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
                        value="{{ old('price', $product->price) }}">
                    @if ($errors->has('price'))
                        <p>{{ $errors->first('price') }}</p>
                    @endif
                </div>

                <div class="form-group">
                    <label for="stock">在庫<span style="color: red;">※</span></label>
                    <input type="number" class="form-control" id="stock" name="stock" placeholder="Stock"
                        value="{{ old('stock', $product->stock) }}">
                    @if ($errors->has('stock'))
                        <p>{{ $errors->first('stock') }}</p>
                    @endif
                </div>

                <div class="form-group">
                    <label for="comment">コメント</label>
                    <textarea name="comment" class="form-control" id="comment" placeholder="Comment">{{ old('comment', $product->comment) }}</textarea>
                    @if ($errors->has('comment'))
                        <p>{{ $errors->first('comment') }}</p>
                    @endif
                </div>

                <div class="form-group">
                    <label for="image">商品画像</label>
                    @if ($product->image_path)
                        <img src="{{ asset($product->image_path) }}" width="150">
                    @else
                        <p>画像なし</p>
                    @endif
                    <input type="file" class="form-control" id="image" name="image">
                </div>

                <button type="submit" class="btn btn-primary">更新</button>
                <a href="{{ route('show', $product->id) }}" class="btn btn-secondary">戻る</a>

            </form>
        </div>
    </div>
@endsection
