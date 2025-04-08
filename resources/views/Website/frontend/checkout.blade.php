@extends('welcome')

@section('content')
<main class="pt-90">
  <section class="shop-checkout container">
    <h2 class="page-title">Shipping and Checkout</h2>

    <div class="checkout-steps">
      <a href="{{ route('cart.show') }}" class="checkout-steps__item active">
        <span class="checkout-steps__item-number">01</span>
        <span class="checkout-steps__item-title">
          <span>Shopping Bag</span>
          <em>Manage Your Items List</em>
        </span>
      </a>
      <a href="{{ route('checkout') }}" class="checkout-steps__item active">
        <span class="checkout-steps__item-number">02</span>
        <span class="checkout-steps__item-title">
          <span>Shipping and Checkout</span>
          <em>Checkout Your Items List</em>
        </span>
      </a>
    </div>

    <form method="POST" action="{{ route('checkout.store') }}" id="checkout-form">
      @csrf
      <div class="checkout-form">
        <div class="billing-info__wrapper">
          <div class="row">
            <div class="col-6">
              <h4>SHIPPING DETAILS</h4>
            </div>
          </div>

          <div class="row mt-5">
            <div class="col-md-6">
              <div class="form-floating my-3">
                <input type="text" class="form-control" name="name" required>
                <label for="name">Full Name *</label>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-floating my-3">
                <input type="text" class="form-control" name="phone" required>
                <label for="phone">Phone Number *</label>
              </div>
            </div>
            <div class="col-md-4">
              <div class="form-floating my-3">
                <input type="text" class="form-control" name="zip" required>
                <label for="zip">Pincode *</label>
              </div>
            </div>
            <div class="col-md-4">
              <div class="form-floating mt-3 mb-3">
                <input type="text" class="form-control" name="state" required>
                <label for="state">State *</label>
              </div>
            </div>
            <div class="col-md-4">
              <div class="form-floating my-3">
                <input type="text" class="form-control" name="city" required>
                <label for="city">Town / City *</label>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-floating my-3">
                <input type="text" class="form-control" name="address" required>
                <label for="address">House no, Building Name *</label>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-floating my-3">
                <input type="text" class="form-control" name="locality" required>
                <label for="locality">Road Name, Area, Colony *</label>
              </div>
            </div>
            <div class="col-md-12">
              <div class="form-floating my-3">
                <input type="text" class="form-control" name="landmark" required>
                <label for="landmark">Landmark *</label>
              </div>
            </div>
          </div>
        </div>

        <div class="checkout__totals-wrapper">
          <div class="sticky-content">
            <div class="checkout__totals">
              <h3>Your Order</h3>
              <table class="checkout-cart-items">
                <thead>
                  <tr>
                    <th>PRODUCT</th>
                    <th class="text-end">TOTAL</th>
                  </tr>
                </thead>
                <tbody>
                  @php $total = 0; @endphp
                  @foreach($selectedItems as $item)
                    @php
                      $itemTotal = $item['price'] * $item['quantity'];
                      $total += $itemTotal;
                    @endphp
                    <tr>
                      <td>{{ $item['product_name'] }} ({{ $item['variant_name'] }}) x {{ $item['quantity'] }}</td>
                      <td class="text-end">₹{{ number_format($itemTotal, 2) }}</td>
                    </tr>
                  @endforeach
                </tbody>
              </table>
              <table class="checkout-totals mt-3">
                <tbody>
                  <tr>
                    <th>Total</th>
                    <td class="text-end">₹{{ number_format($total, 2) }}</td>
                  </tr>
                </tbody>
              </table>
            </div>

            <div class="checkout__payment-methods mt-4">
              <h4>Payment Method</h4>
              <div class="form-check my-2">
                <input class="form-check-input" type="radio" name="payment_method" value="razorpay" id="razorpayOption" checked>
                <label class="form-check-label" for="razorpayOption">Razorpay</label>
              </div>
            </div>

            <button type="submit" id="place-order" class="btn btn-primary btn-checkout mt-3">
              PLACE ORDER
            </button>
          </div>
        </div>
      </div>
    </form>
  </section>
</main>
@endsection
