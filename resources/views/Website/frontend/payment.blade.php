@extends('welcome')

@section('content')
<main class="pt-90">
  <section class="container">
    <div class="max-w-xl mx-auto bg-white shadow rounded-2xl p-4 p-md-5 text-center">
      <h2 class="page-title mb-4">Checkout</h2>

      <p class="lead">Pay <strong>₹{{ number_format($total, 2) }}</strong> securely via Razorpay</p>

      <button type="button" id="rzp-button1" class="btn btn-outline-dark btn-lg mt-4">
        <i class="fas fa-money-bill"></i> Pay Now
      </button>
    </div>
  </section>
</main>
@endsection

@push('scripts')
<script src="https://checkout.razorpay.com/v1/checkout.js"></script>
<script>
  console.log("Razorpay Key:", "{{ env('RAZORPAY_KEY') }}");

  document.addEventListener("DOMContentLoaded", function () {
    const button = document.getElementById('rzp-button1');

    if (!button) {
      return;
    }

    const options = {
      key: "{{ env('RAZORPAY_KEY') }}",
      amount: "{{ $total * 100 }}",
      currency: "INR",
      name: "E-commerce App",
      description: "Order Payment",
      image: "{{ asset('logo.png') }}",
      prefill: {
        name: "{{ session('shipping_details.name') ?? 'Customer Name' }}",
        email: "customer@example.com",
        contact: "{{ session('shipping_details.phone') ?? '9876543210' }}"
      },
      handler: function (response) {
        alert("✅ Payment successful! ID: " + response.razorpay_payment_id);
        window.location.href = "{{ route('order.confirmation') }}";
      },

      theme: {
        color: "#3399cc"
      },
      modal: {
        ondismiss: function () {
          console.log("⚠️ Razorpay checkout closed by user.");
        }
      }
    };

    const rzp = new Razorpay(options);

    button.addEventListener("click", function (e) {
      rzp.open();
      e.preventDefault();
    });
  });
</script>
@endpush
