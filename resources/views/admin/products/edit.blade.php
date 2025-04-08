@extends('layout.navigation.master')

@section('title', 'Edit Product')

@section('content-header')
<div class="row mb-2">
    <div class="col-sm-12">
        <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="#">Home</a></li>
            <li class="breadcrumb-item active">Edit Product</li>
        </ol>
    </div>
</div>
@endsection

@section('content')
<div class="card card-primary">
    <div class="card-header">
        <h3 class="card-title">Edit Product</h3>
    </div>

    <form action="{{ route('admin.products.update', $product->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="card-body">

            <div class="form-group">
                <label for="name">Product Name</label>
                <input type="text" class="form-control" name="name" value="{{ $product->name }}" required>
            </div>

            <div class="form-group">
                <label for="description">Description</label>
                <textarea class="form-control" name="description" rows="3" required>{{ $product->description }}</textarea>
            </div>

            <div class="form-group">
                <label>Current Images</label>
                <div class="d-flex flex-wrap gap-2" id="existing-images">
                    @foreach ($product->images as $image)
                        <div class="image-box position-relative m-2" data-id="{{ $image->id }}">
                            <img src="{{ asset('storage/products/' . $image->image_path) }}" width="100" height="100"
                                 style="object-fit: cover; border: 1px solid #ccc; border-radius: 4px;">
                            <button type="button" class="btn btn-sm btn-danger remove-image"
                                    style="position: absolute; top: -5px; right: -5px; padding: 0 6px; border-radius: 50%;">
                                ×
                            </button>
                            <input type="hidden" name="existing_image_ids[]" value="{{ $image->id }}">
                        </div>
                    @endforeach
                </div>
            </div>

            <div class="form-group">
                <label for="images">Upload New Images</label>
                <input type="file" name="images[]" multiple class="form-control">
            </div>

            <div class="form-group">
                <label>Existing Variants</label>
                <div id="existing-variants">
                    @foreach ($product->variants as $variant)
                        <div class="row mb-2 existing-variant-row" data-id="{{ $variant->id }}">
                            <input type="hidden" name="variant_ids[]" value="{{ $variant->id }}">
                            <div class="col-md-5">
                                <input type="text" name="variant_name[]" value="{{ $variant->variant_name }}" class="form-control" required>
                            </div>
                            <div class="col-md-5">
                                <input type="number" name="variant_price[]" value="{{ $variant->price }}" class="form-control" step="0.01" required>
                            </div>
                            <div class="col-md-2 d-flex align-items-center">
                                <button type="button" class="btn btn-danger remove-existing-variant">X</button>
                            </div>
                        </div>
                    @endforeach
                </div>

                <div id="removed-variants-container"></div>

                <label class="mt-3">Add New Variant</label>
                <div class="row mb-2">
                    <div class="col-md-5">
                        <input type="text" id="temp_variant_name" class="form-control" placeholder="Variant Name">
                    </div>
                    <div class="col-md-5">
                        <input type="number" id="temp_variant_price" class="form-control" placeholder="Price" step="0.01">
                    </div>
                    <div class="col-md-2 d-flex align-items-center">
                        <button type="button" class="btn btn-success" id="add-variant">+</button>
                    </div>
                </div>

                <div id="variant-section"></div>
            </div>
        </div>

        <div class="card-footer">
            <button type="submit" class="btn btn-primary">Update Product</button>
        </div>
    </form>
</div>
@endsection

@push('scripts')
<script>
    $(document).ready(function () {
        $('#add-variant').click(function () {
            let name = $('#temp_variant_name').val().trim();
            let price = $('#temp_variant_price').val().trim();

            if (name && price) {
                $('#variant-section').append(`
                    <div class="row mb-2 variant-row">
                        <input type="hidden" name="new_variant[]" value="1">
                        <div class="col-md-5">
                            <input type="text" name="variant_name[]" class="form-control" value="${name}" required>
                        </div>
                        <div class="col-md-5">
                            <input type="number" name="variant_price[]" class="form-control" value="${price}" step="0.01" required>
                        </div>
                        <div class="col-md-2 d-flex align-items-center">
                            <button type="button" class="btn btn-danger remove-variant">X</button>
                        </div>
                    </div>
                `);
                $('#temp_variant_name').val('');
                $('#temp_variant_price').val('');
            } else {
                alert("Enter both name and price");
            }
        });

        $(document).on('click', '.remove-variant', function () {
            $(this).closest('.variant-row').remove();
        });

        $(document).on('click', '.remove-existing-variant', function () {
            const row = $(this).closest('.existing-variant-row');
            const variantId = row.data('id');
            $('#removed-variants-container').append(`
                <input type="hidden" name="removed_variant_ids[]" value="${variantId}">
            `);
            row.remove();
        });
        $(document).on('click', '.remove-image', function () {
            $(this).closest('.image-box').remove();
        });
    });
</script>
@endpush
