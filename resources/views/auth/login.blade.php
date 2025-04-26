@extends('layouts.app')

@section('content')
<style>
  html, body {
    margin: 0;
    padding: 0;
    width: 100%;
    height: 100%;
    overflow: hidden;
  }

  .fullscreen-bg {
    position: absolute;
    top: 0;
    left: 0;
    width: 100vw;
    height: 100vh;
    background-image: url('{{ asset('images/LOGO IT DEL.jpg') }}');
    background-size: cover;
    background-position: center;
  }

  .overlay {
    background-color: rgba(255, 255, 255, 0.85);
    width: 100vw;
    height: 100vh;
  }

  .login-wrapper {
    max-width: 400px;
    margin: auto;
  }
</style>

<div class="fullscreen-bg">
  <div class="overlay d-flex align-items-center justify-content-center">
    <div class="card shadow-lg border-0 w-50 mx-3 login-wrapper">
      <div class="card-body p-5">

        <!-- Logo -->
        <div class="text-center mb-4">
          <a href="{{ route('login') }}">
            <img src="{{ asset('images/LOGO IT DEL.png') }}" alt="Logo" class="img-fluid" style="max-width: 100px;">
          </a>
        </div>

        <!-- Judul -->
        <h3 class="text-center mb-3">Delschedule</h3>
        <p class="text-center text-muted mb-4">Login to access your account</p>

        @if(session('message'))
          <div class="alert alert-info" role="alert">
            {{ session('message') }}
          </div>
        @endif

        <!-- Login Form -->
        <form method="POST" action="{{ route('login') }}">
          @csrf

          <!-- Username -->
          <div class="mb-3">
            <input id="email" name="email" type="text"
                   class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}"
                   placeholder="Enter your username" value="{{ old('email') }}" required autofocus>
            @if($errors->has('email'))
              <div class="invalid-feedback">
                {{ $errors->first('email') }}
              </div>
            @endif
          </div>

          <!-- Password -->
          <div class="mb-3">
            <input id="password" name="password" type="password"
                   class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}"
                   placeholder="Password" required>
            @if($errors->has('password'))
              <div class="invalid-feedback">
                {{ $errors->first('password') }}
              </div>
            @endif
          </div>

          <!-- Remember Me -->
          <div class="form-check mb-4">
            <input class="form-check-input" name="remember" type="checkbox" id="remember">
            <label class="form-check-label" for="remember">Remember me</label>
          </div>

          <!-- Submit -->
          <button type="submit" class="btn btn-dark w-100">Login</button>

          <!-- Forgot Password -->
          @if (Route::has('password.request'))
            <div class="text-center mt-3">
              <a class="text-muted" href="{{ route('password.request') }}">Forgot password?</a>
            </div>
          @endif
        </form>
      </div>
    </div>
  </div>
</div>
@endsection