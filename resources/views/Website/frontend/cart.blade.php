@extends('welcome')

@section('content')
<main class="pt-90">

  {{-- Flash Messages --}}
  @if(session('success'))
    <div class="container mt-3">
      <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
      </div>
    </div>
  @endif

  @if(session('danger'))
    <div class="container mt-3">
      <div class="alert alert-danger alert-dismissible fade show" role="alert">
        {{ session('danger') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
      </div>
    </div>
  @endif

  <div class="mb-4 pb-4"></div>
  <section class="shop-checkout container">
    <h2 class="page-title">Cart</h2>
    <div class="checkout-steps">
      <a href="{{ route('cart.show') }}" class="checkout-steps__item active">
        <span class="checkout-steps__item-number">01</span>
        <span class="checkout-steps__item-title">
          <span>Shopping Bag</span>
          <em>Manage Your Items List</em>
        </span>
      </a>
    </div>

    <div class="shopping-cart">
      <div class="cart-table__wrapper">
        <table class="cart-table">
          <thead>
            <tr>
              <th>Product</th>
              <th></th>
              <th>Price</th>
              <th>Quantity</th>
              <th>Total</th>
              <th></th>
            </tr>
          </thead>
          <tbody>
            @php $total = 0; @endphp
            @forelse($cart as $key => $item)
              @php
                $itemTotal = $item['price'] * $item['quantity'];
                $total += $itemTotal;
              @endphp
              <tr>
                <td>
                  <div class="shopping-cart__product-item">
                    <img loading="lazy" src="{{ asset('storage/products/' . $item['image']) }}" width="120" height="120" alt="{{ $item['product_name'] }}" />
                  </div>
                </td>
                <td>
                  <div class="shopping-cart__product-item__detail">
                    <h4>{{ $item['product_name'] }}</h4>
                    <ul class="shopping-cart__product-item__options">
                      <li>Variant: {{ $item['variant_name'] }}</li>
                    </ul>
                  </div>
                </td>
                <td>
                  <span class="shopping-cart__product-price">₹{{ number_format($item['price'], 2) }}</span>
                </td>
                <td>
                  <form action="{{ route('cart.update') }}" method="POST" class="d-inline">
                    @csrf
                    <input type="hidden" name="key" value="{{ $key }}">
                    <div class="qty-control position-relative">
                      <input type="number" name="quantity" value="{{ $item['quantity'] }}" min="1" class="qty-control__number text-center">
                      <div class="qty-control__reduce">-</div>
                      <div class="qty-control__increase">+</div>
                    </div>
                    <button type="submit" class="btn btn-sm btn-light mt-2">Update</button>
                  </form>
                </td>
                <td>
                  <span class="shopping-cart__subtotal">₹{{ number_format($itemTotal, 2) }}</span>
                </td>
                <td>
                  <form action="{{ route('cart.remove') }}" method="POST">
                    @csrf
                    <input type="hidden" name="key" value="{{ $key }}">
                    <button type="submit" class="remove-cart bg-transparent border-0">
                      <svg width="10" height="10" viewBox="0 0 10 10" fill="#767676" xmlns="http://www.w3.org/2000/svg">
                        <path d="M0.259435 8.85506L9.11449 0L10 0.885506L1.14494 9.74056L0.259435 8.85506Z" />
                        <path d="M0.885506 0.0889838L9.74057 8.94404L8.85506 9.82955L0 0.97449L0.885506 0.0889838Z" />
                      </svg>
                    </button>
                  </form>
                </td>
              </tr>
            @empty
              <tr>
                <td colspan="6" class="text-center">Your cart is empty.</td>
              </tr>
            @endforelse
          </tbody>
        </table>

        <div class="cart-table-footer">
          <a href="{{ url('/') }}" class="btn btn-light">Continue Shopping</a>
        </div>
      </div>

      <div class="shopping-cart__totals-wrapper">
        <div class="sticky-content">
          <div class="shopping-cart__totals">
            <h3>Cart Totals</h3>
            <table class="cart-totals">
              <tbody>
                <tr>
                  <th>Total</th>
                  <td>₹{{ number_format($total, 2) }}</td>
                </tr>
              </tbody>
            </table>
          </div>

          <div class="mobile_fixed-btn_wrapper">
            <div class="button-wrapper container">
              <a href="{{ route('checkout') }}" class="btn btn-primary btn-checkout">PROCEED TO CHECKOUT</a>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
</main>
@push('scripts')
<script>
  setTimeout(() => {
    const alert = document.querySelector('.alert');
    if(alert) alert.remove();
  }, 3000);
</script>
@endpush
@endsection

