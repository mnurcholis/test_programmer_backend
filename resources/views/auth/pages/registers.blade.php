@extends('auth.layout.master_auth')

@section('content')
    <div class="pt-4 pb-2">
        <h5 class="card-title text-center pb-0 fs-4">Create an Account</h5>
        <p class="text-center small">Enter your personal details to create account</p>
    </div>
    @if ($errors->any())
        @foreach ($errors->all() as $err)
            <p class="alert alert-danger">{{ $err }}</p>
        @endforeach
    @endif

    <form class="row g-3 needs-validation" action="{{ route('register.action') }}" method="POST" novalidate>
        @csrf
        <div class="col-12">
            <label for="name" class="form-label">Your Name</label>
            <input type="text" name="name" class="form-control" id="name" required value="{{ old('name') }}">
            <div class="invalid-feedback">Please, enter your name!</div>
        </div>

        <div class="col-12">
            <label for="email" class="form-label">Your Email</label>
            <input type="email" name="email" class="form-control" id="email" required value="{{ old('email') }}">
            <div class="invalid-feedback">Please enter a valid Email adddress!</div>
        </div>

        <div class="col-12">
            <label for="username" class="form-label">Username</label>
            <div class="input-group has-validation">
                <input type="text" name="username" class="form-control" id="username" required value="{{ old('username') }}">
                <div class="invalid-feedback">Please choose a username.</div>
            </div>
        </div>
        <div class="col-12">
            <label for="password" class="form-label">Password</label>
            <input type="password" name="password" class="form-control" id="password" required>
            <div class="invalid-feedback">Please enter your password!</div>
        </div>
        <div class="col-12">
            <label for="password_confirm" class="form-label">Confrim Password</label>
            <input type="password" name="password_confirm" class="form-control" id="password_confirm" required>
            <div class="invalid-feedback">Please enter your password!</div>
        </div>
        <div class="col-12">
            <button class="btn btn-primary w-100" type="submit">Create Account</button>
        </div>
        <div class="col-12">
            <p class="small mb-0">Already have an account? <a href="login">Log in</a>
            </p>
        </div>
    </form>
@endsection
