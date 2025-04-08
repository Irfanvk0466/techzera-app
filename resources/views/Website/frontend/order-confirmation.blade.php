@extends('welcome')

@section('content')
<main class="pt-90">
  <section class="shop-checkout container">
    <h2 class="page-title">Order Received</h2>

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
      <a href="#" class="checkout-steps__item active">
        <span class="checkout-steps__item-number">03</span>
        <span class="checkout-steps__item-title">
          <span>Confirmation</span>
          <em>Review And Submit Your Order</em>
        </span>
      </a>
    </div>

    <div class="order-complete text-center">
    <div class="order-complete__message mb-4">
        <svg width="80" height="80" viewBox="0 0 80 80" fill="none" xmlns="http://www.w3.org/2000/svg">
            <circle cx="40" cy="40" r="40" fill="#B9A16B" />
            <path d="M30 40.5L37 47.5L50 34.5" stroke="white" stroke-width="5" stroke-linecap="round" stroke-linejoin="round"/>
        </svg>
        <h3 class="mt-3">Your order is completed!</h3>
        <p>Thank you, <strong>{{ $shipping['name'] ?? 'Customer' }}</strong>. Your order has been successfully placed.</p>
    </div>

      <div class="order-info row justify-content-center mb-5">
        <div class="col-md-6">
          <div class="order-info__item"><label>Order Number</label><span>{{ $orderId }}</span></div>
          <div class="order-info__item"><label>Payment ID</label><span>{{ $paymentId }}</span></div>
          <div class="order-info__item"><label>Phone</label><span>{{ $shipping['phone'] }}</span></div>
          <div class="order-info__item"><label>Address</label><span>{{ $shipping['address'] }}, {{ $shipping['locality'] }}, {{ $shipping['city'] }} - {{ $shipping['zip'] }}, {{ $shipping['state'] }}</span></div>
          <div class="order-info__item"><label>Total Paid</label><span>₹{{ number_format($total, 2) }}</span></div>
        </div>
      </div>

      <div class="checkout__totals-wrapper">
        <div class="checkout__totals">
          <h3 class="text-start">Order Details</h3>
          <table class="checkout-cart-items mb-4">
            <thead>
              <tr>
                <th>Product</th>
                <th>Variant</th>
                <th>Qty</th>
                <th>Total</th>
              </tr>
            </thead>
            <tbody>
              @foreach($items as $item)
                @php $itemTotal = $item['price'] * $item['quantity']; @endphp
                <tr>
                  <td>{{ $item['product_name'] }}</td>
                  <td>{{ $item['variant_name'] }}</td>
                  <td>{{ $item['quantity'] }}</td>
                  <td>₹{{ number_format($itemTotal, 2) }}</td>
                </tr>
              @endforeach
            </tbody>
          </table>

          <table class="checkout-totals">
            <tbody>
              <tr>
                <th>Total</th>
                <td>₹{{ number_format($total, 2) }}</td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </section>
</main>
@endsection
