<!DOCTYPE html>
<html>
<head>
    <title>Test Razorpay</title>
</head>
<body>

    <div style="text-align: center; margin-top: 100px;">
        <h1>Simple Razorpay Test</h1>
        <p>Amount: ₹100</p>
        <button id="rzp-button1">Pay with Razorpay</button>
    </div>

    <script src="https://checkout.razorpay.com/v1/checkout.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            var options = {
                "key": "{{ env('RAZORPAY_KEY') }}", // Replace with your test/live key
                "amount": 10000, // 100 = ₹1.00
                "currency": "INR",
                "name": "Test Payment",
                "description": "Test Transaction",
                "image": "https://yourdomain.com/logo.png",
                "handler": function (response) {
                    alert("Payment Successful! ID: " + response.razorpay_payment_id);
                },
                "theme": {
                    "color": "#3399cc"
                }
            };

            var rzp1 = new Razorpay(options);
            document.getElementById('rzp-button1').onclick = function (e) {
                rzp1.open();
                e.preventDefault();
            };
        });
    </script>

</body>
</html>
