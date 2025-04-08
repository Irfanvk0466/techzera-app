@extends('layout.navigation.master')

@section('title', 'Create Products')

@section('content-header')
<div class="row mb-2">
    <div class="col-sm-12">
        <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="{{ route('admin.products.index') }}">Home</a></li>
            <li class="breadcrumb-item active">Add Product</li>
        </ol>
    </div>
</div>
@endsection

@section('content')
<div class="card card-primary">
    <div class="card-header">
        <h3 class="card-title">Add Product</h3>
    </div>

    <form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="card-body">

            {{-- Product Name --}}
            <div class="form-group">
                <label for="name">Product Name</label>
                <input type="text" class="form-control" id="name" name="name" placeholder="Enter Product Name" required>
            </div>

            {{-- Product Description --}}
            <div class="form-group">
                <label for="description">Description</label>
                <textarea class="form-control" id="description" name="description" placeholder="Enter Description" rows="3" required></textarea>
            </div>

            {{-- Product Images --}}
            <div class="form-group">
                <label for="images">Product Images</label>
                <input type="file" id="images" name="images[]" multiple class="form-control" required>
                <small class="text-muted">You can upload multiple images.</small>
            </div>

            {{-- Product Variants --}}
            <div class="form-group">
                <label>Product Variants</label>

                {{-- Fixed Entry Row --}}
                <div class="row mb-2">
                    <div class="col-md-5">
                        <input type="text" id="temp_variant_name" class="form-control" placeholder="Variant Name (e.g., Small)">
                    </div>
                    <div class="col-md-5">
                        <input type="number" id="temp_variant_price" class="form-control" placeholder="Price" step="0.01">
                    </div>
                    <div class="col-md-2 d-flex align-items-center">
                        <button type="button" class="btn btn-success" id="add-variant">+</button>
                    </div>
                </div>

                {{-- Where the added variants will appear --}}
                <div id="variant-section"></div>
            </div>

        </div>

        <div class="card-footer">
            <button type="submit" class="btn btn-primary">Save Product</button>
        </div>

    </form>
</div>
@endsection

@push('scripts')
<script>
    $(document).ready(function() {
        $('#add-variant').click(function() {
            let name = $('#temp_variant_name').val().trim();
            let price = $('#temp_variant_price').val().trim();

            if(name && price) {
                let variantRow = `
                    <div class="row mb-2 variant-row">
                        <div class="col-md-5">
                            <input type="text" name="variant_name[]" class="form-control" value="${name}" readonly>
                        </div>
                        <div class="col-md-5">
                            <input type="number" name="variant_price[]" class="form-control" value="${price}" readonly>
                        </div>
                        <div class="col-md-2 d-flex align-items-center">
                            <button type="button" class="btn btn-danger remove-variant">X</button>
                        </div>
                    </div>
                `;
                $('#variant-section').append(variantRow);

                // Clear the input fields
                $('#temp_variant_name').val('');
                $('#temp_variant_price').val('');
            } else {
                alert("Please enter both variant name and price.");
            }
        });

        $(document).on('click', '.remove-variant', function() {
            $(this).closest('.variant-row').remove();
        });
    });
</script>
@endpush
