@extends('layout/common-layout')

@section('space-work')

<section class="vh-100 d-flex align-items-center justify-content-center" style="background-color: #f1f5f9;">
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-md-8 col-lg-6">
        <div class="card shadow-lg border-0" style="border-radius: 1rem; background: rgba(255, 255, 255, 0.95);">
          <div class="card-body p-5">
            
            <h3 class="text-center text-primary fw-bold mb-4">Create an Account</h3>

            @if(Session::has('success'))
              <div class="alert alert-success alert-dismissible fade show" role="alert">
                <p class="mb-0">{{ Session::get('success') }}</p>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
              </div>
            @endif

            <form action="{{ route('registration') }}" method="POST">
              @csrf

              <!-- Username -->
              <div class="form-floating mb-3">
                <input type="text" name="name" id="name" class="form-control" placeholder="Username" value="{{ old('name') }}" required />
                <label for="name">Username</label>
                @error('name')
                  <p class="text-danger small mt-1">{{ $message }}</p>
                @enderror
              </div>

              <!-- Email -->
              <div class="form-floating mb-3">
                <input type="email" name="email" id="email" class="form-control" placeholder="Email" value="{{ old('email') }}" required />
                <label for="email">Your Email</label>
                @error('email')
                  <p class="text-danger small mt-1">{{ $message }}</p>
                @enderror
              </div>

              <!-- Password -->
              <div class="form-floating mb-3">
                <input type="password" name="password" id="password" class="form-control" placeholder="Password" required />
                <label for="password">Password</label>
                @error('password')
                  <p class="text-danger small mt-1">{{ $message }}</p>
                @enderror
              </div>

              <!-- Confirm Password -->
              <div class="form-floating mb-3">
                <input type="password" name="password_confirmation" id="password_confirmation" class="form-control" placeholder="Confirm Password" required />
                <label for="password_confirmation">Confirm Password</label>
                @error('password_confirmation')
                  <p class="text-danger small mt-1">{{ $message }}</p>
                @enderror
              </div>

              <!-- Submit Button -->
              <button class="btn btn-primary btn-lg w-100" type="submit">
                Register
              </button>

              <!-- Already have an account? -->
              <div class="mt-3 text-center">
                <p class="small text-muted">Already have an account? 
                  <a href="{{ route('login') }}" class="text-primary">Login here</a>
                </p>
              </div>

            </form>

          </div>
        </div>
      </div>
    </div>
  </div>
</section>

@endsection
