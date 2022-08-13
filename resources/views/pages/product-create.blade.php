@extends('layouts.master')

@section('content')
    <section>
        <div class="container px-4 px-lg-5 mb-5">
            <h3>{{ request()->is('product/*/edit') ? 'Edit' : 'Create' }} Product</h3>
            <div class="row">
                <div class="col-12">
                    <form method="POST"
                        action="{{ isset($product) ? route('product.update', $product->id) : route('product.store') }}" enctype="multipart/form-data">
                        @csrf
                        @if (isset($product))
                            @method('PATCH')
                        @endif
                        <div class="row">
                            <div class="col-12">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="mb-3">
                                            <label for="name" class="form-label">Product name</label>
                                            <input type="text" class="form-control" name="name" id="name"
                                                value="{{ isset($product) ? $product->name : old('name') }}">
                                        </div>

                                        <div class="mb-3">
                                            <label for="price" class="form-label">Product image</label>
                                            <input type="file" class="form-control" name="img_thumbnail"
                                                id="img_thumbnail">
                                        </div>

                                        <div class="mb-3">
                                            <label for="price" class="form-label">Product price</label>
                                            <input type="number" class="form-control" name="price" id="price"
                                                value="{{ isset($product) ? $product->price : old('price') }}">
                                        </div>

                                        <div class="mb-3">
                                            <label for="category" class="form-label">Product category</label>
                                            <select type="text" class="form-select" name="category_id" id="category">
                                                @foreach ($categories as $category)
                                                    <option value="{{ $category->id }}"
                                                        {{ isset($product) && $product->category_id == $category->id ? 'selected' : null }}>
                                                        {{ $category->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <div class="mb-3">
                                            <label for="price" class="form-label">Product description</label>
                                            <textarea type="text" class="form-control" name="description" id="description">{{ isset($product) ? $product->description : old('description') }}</textarea>
                                        </div>

                                        <div class="mb-3 text-center">
                                            <button type="submit" class="btn btn-outline-primary">
                                                {{ isset($product) ? 'Update' : 'Create' }}
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
@endsection
