@extends('layout.common-layout')

@section('space-work')

<section class="vh-100 d-flex align-items-center justify-content-center" 
style="background-color: #f1f5f9;">

<div class="container py-5">
    <div class="row d-flex justify-content-center align-items-center">
      <div class="col-md-8 col-lg-6 col-xl-5">
        <div class="card shadow-lg border-0" style="border-radius: 1rem; background: rgba(255, 255, 255, 0.9);">
          <div class="card-body p-5 text-center">
            
            <h3 class="mb-4 text-primary fw-bold">Sign In</h3>
              
            @if(Session::has('error'))
              <div class="alert alert-danger alert-dismissible fade show" role="alert" id="errorMessage">
                <p class="mb-0">{{ Session::get('error') }}</p>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
              </div>
            @endif
              
            <form action="{{ route('verify') }}" method="POST">
              @csrf

              <!-- Username input field -->
              <div class="form-floating mb-4">
                <input type="email" name="email" id="email" class="form-control" placeholder="Email" required />
                <label for="email">Email</label>
                @error('email')
                  <p class="text-danger small mt-1">{{ $message }}</p>
                @enderror
              </div>

              <!-- Password input field -->
              <div class="form-floating mb-4">
                <input type="password" name="password" id="password" class="form-control" placeholder="Password" required />
                <label for="password">Password</label>
                @error('password')
                  <p class="text-danger small mt-1">{{ $message }}</p>
                @enderror
              </div>

              <button class="btn btn-primary btn-lg w-100" type="submit">
                Login
              </button>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

@endsection
