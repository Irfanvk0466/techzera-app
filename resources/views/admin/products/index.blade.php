@extends('layout.navigation.master')

@section('title', 'products List')

@section('content-header')
<div class="row mb-2">
    <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item active">Products</li>
        </ol>
    </div>
</div>
@endsection

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Products</h3>

                @if (session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                <div class="card-tools d-flex">
                    <a href="{{ route('admin.products.create') }}" class="btn btn-primary mr-3">
                        <i class="fas fa-plus"></i> Add
                    </a>
                </div>
            </div>

            <div class="card-body table-responsive p-0">
                <table class="table table-hover text-nowrap">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Product Name</th>
                            <th>Description</th>
                            <th>Images</th>
                            <th>Variants</th>
                            <th>price</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                    @foreach ($products as $index => $product)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $product->name }}</td>
                            <td>{{ $product->description }}</td>
                            <td>
                            <div class="d-flex flex-wrap" style="gap: 8px;">
                                    @foreach($product->images as $image)
                                        <a href="{{ asset('storage/products/' . $image->image_path) }}" target="_blank">
                                            <img src="{{ asset('storage/products/' . $image->image_path) }}" width="60px" height="60px" style="object-fit: cover; border-radius: 4px; border: 1px solid #ccc;">
                                        </a>
                                    @endforeach
                            </div>
                            </td>
                            <td>
                                <div class="d-flex flex-wrap" style="gap: 6px;">
                                    @foreach($product->variants as $variant)
                                        <span style="background-color: #eef2ff; color: #3730a3; padding: 5px 10px; border-radius: 15px; font-size: 13px; border: 1px solid #c7d2fe; font-weight: 600;">
                                            {{ $variant->variant_name }}
                                        </span>
                                    @endforeach
                                </div>
                            </td>

                            <td>
                                @foreach($product->variants as $variant)
                                    <span class="badge bg-success">{{ $variant->price }}</span>
                                @endforeach
                            </td>
                            <td>
                                <a href="{{ route('admin.products.edit', $product->id) }}" class="btn btn-warning btn-sm">
                                    <i class="fas fa-edit"></i> Edit
                                </a>
                                <form action="{{ route('admin.products.destroy', $product->id) }}" method="POST" style="display:inline-block;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure?')">
                                        <i class="fas fa-trash"></i> Delete
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>

            <div class="card-footer">
                {{ $products->links() }}
            </div>
        </div>
    </div>
</div>
@endsection
