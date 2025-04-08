@extends('welcome')

@section('content')
<main>

<div class="mb-3 mb-xl-5 pt-1 pb-4"></div>

  <section class="products-grid container">
    <h2 class="section-title text-center mb-3 pb-xl-3 mb-xl-4">Featured Products</h2>

    <div class="row">
      @foreach($productList as $product)
        @foreach($product->variants as $variant)
          <div class="col-6 col-md-4 col-lg-3">
            <div class="product-card product-card_style3 mb-3 mb-md-4 mb-xxl-5">
              <div class="pc__img-wrapper">
              <a href="{{ route('product.details', ['product' => $product->id, 'variant' => $variant->id]) }}">
              <img 
                    loading="lazy" 
                    src="{{ asset('storage/products/' . ($product->images->first()->image_path ?? 'default.png')) }}" 
                    width="330" height="400"
                    alt="{{ $product->name }}" 
                    class="pc__img"
                  >
                </a>
              </div>

              <div class="pc__info position-relative">
                <h6 class="pc__title">
                  <a href="#">{{ $product->name }}</a>
                </h6>
                <div class="product-card__price d-flex flex-column align-items-start">
                  <span class="fw-semibold">{{ $variant->variant_name }}</span>
                  <span class="money price text-secondary">₹{{ number_format($variant->price, 2) }}</span>
                </div>
              </div>
            </div>
          </div>
        @endforeach
      @endforeach
    </div><!-- /.row -->
  </section>

  <div class="mb-3 mb-xl-5 pt-1 pb-4"></div>
</main>
@endsection
