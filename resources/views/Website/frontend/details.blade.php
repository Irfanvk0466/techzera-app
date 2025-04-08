@extends('welcome')

@section('content')
<main class="pt-90">
  @if(session('success'))
    <div class="container mt-3">
      <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
      </div>
    </div>
  @endif

  <div class="mb-md-1 pb-md-3"></div>
  <section class="product-single container">
    <div class="row">
      <div class="col-lg-7">
        <div class="product-single__media" data-media-type="vertical-thumbnail">
          <div class="product-single__image">
            <div class="swiper-container">
              <div class="swiper-wrapper">
                @foreach($product->images as $image)
                  <div class="swiper-slide product-single__image-item">
                    <img loading="lazy" class="h-auto" src="{{ asset('storage/products/' . $image->image_path) }}" width="674" height="674" alt="{{ $product->name }}" />
                    <a data-fancybox="gallery" href="{{ asset('storage/products/' . $image->image_path) }}" data-bs-toggle="tooltip" data-bs-placement="left" title="Zoom">
                      <svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <use href="#icon_zoom" />
                      </svg>
                    </a>
                  </div>
                @endforeach
              </div>
              <div class="swiper-button-prev">
                <svg width="7" height="11" viewBox="0 0 7 11" xmlns="http://www.w3.org/2000/svg">
                  <use href="#icon_prev_sm" />
                </svg>
              </div>
              <div class="swiper-button-next">
                <svg width="7" height="11" viewBox="0 0 7 11" xmlns="http://www.w3.org/2000/svg">
                  <use href="#icon_next_sm" />
                </svg>
              </div>
            </div>
          </div>
          <div class="product-single__thumbnail">
            <div class="swiper-container">
              <div class="swiper-wrapper">
                @foreach($product->images as $image)
                  <div class="swiper-slide product-single__image-item">
                    <img loading="lazy" class="h-auto" src="{{ asset('storage/products/' . $image->image_path) }}" width="104" height="104" alt="{{ $product->name }}" />
                  </div>
                @endforeach
              </div>
            </div>
          </div>
        </div>
      </div>

      <div class="col-lg-5">
        <div class="d-flex justify-content-between mb-4 pb-md-2">
          <div class="breadcrumb mb-0 d-none d-md-block flex-grow-1">
            <a href="{{ url('/') }}" class="menu-link menu-link_us-s text-uppercase fw-medium">Home</a>
            <span class="breadcrumb-separator menu-link fw-medium ps-1 pe-1">/</span>
            <span class="text-muted">{{ $product->name }}</span>
          </div>
        </div>

        <h1 class="product-single__name">{{ $product->name }}</h1>

        <div class="product-single__price mb-3">
          <span class="current-price" id="priceDisplay">₹{{ number_format($variant->price, 2) }}</span>
        </div>

        <div class="product-single__short-desc mb-4">
          <p>{{ $product->description }}</p>
        </div>

        <form method="POST" action="{{ route('cart.add') }}">
          @csrf
          <input type="hidden" name="product_id" value="{{ $product->id }}">
          <input type="hidden" name="variant_id" id="selectedVariantId" value="{{ $variant->id }}">

          <div class="mb-3">
            <label for="variantSelect" class="form-label">Select Variant</label>
            <select class="form-select" id="variantSelect" name="variant_id">
              @foreach($product->variants as $variantOption)
                <option 
                  value="{{ $variantOption->id }}" 
                  data-price="{{ $variantOption->price }}" 
                  {{ $variantOption->id == $variant->id ? 'selected' : '' }}>
                  {{ $variantOption->variant_name }} - ₹{{ number_format($variantOption->price, 2) }}
                </option>
              @endforeach
            </select>
          </div>

          <div class="product-single__addtocart mb-4">
            <div class="qty-control position-relative me-3">
              <input type="number" name="quantity" value="1" min="1" class="qty-control__number text-center">
              <div class="qty-control__reduce">-</div>
              <div class="qty-control__increase">+</div>
            </div>
            <button type="submit" class="btn btn-primary btn-addtocart" data-aside="cartDrawer">
              Add to Cart
            </button>
          </div>
        </form>
      </div>
    </div>
  </section>
</main>

@push('scripts')
<script>
  document.getElementById('variantSelect')?.addEventListener('change', function () {
    const selected = this.options[this.selectedIndex];
    const newPrice = selected.getAttribute('data-price');
    const newVariantId = selected.value;

    document.getElementById('priceDisplay').innerText = '₹' + parseFloat(newPrice).toFixed(2);
    document.getElementById('selectedVariantId').value = newVariantId;
  });

  setTimeout(() => {
    const alert = document.querySelector('.alert');
    if(alert) alert.remove();
  }, 3000);
</script>
@endpush
@endsection
