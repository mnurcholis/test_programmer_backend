@extends('auth.layout.master_auth')

@section('content')
    <div class="pt-4 pb-2">
        <h5 class="card-title text-center pb-0 fs-4">Login to Your Account</h5>
        <p class="text-center small">Enter your username & password to login</p>
    </div>
    @if (session('success'))
        {!! session('success') !!}
    @endif
    @if ($errors->any())
        @foreach ($errors->all() as $err)
            <p class="alert alert-danger">{{ $err }}</p>
        @endforeach
    @endif

    <form class="row g-3 needs-validation" action="{{ route('login.action') }}" method="POST" novalidate>
        @csrf
        <div class="col-12">
            <label for="email" class="form-label">Email</label>
            <div class="input-group has-validation">
                <input type="text" name="email" class="form-control" id="email" required>
                <div class="invalid-feedback">Please enter your Email.</div>
            </div>
        </div>

        <div class="col-12">
            <label for="yourPassword" class="form-label">Password</label>
            <input type="password" name="password" class="form-control" id="yourPassword" required>
            <div class="invalid-feedback">Please enter your password!</div>
        </div>

        <div class="col-12">
            <button class="btn btn-primary w-100" type="submit">Login</button>
        </div>
        <div class="col-12">
            <p class="small mb-0"><a href="forgot">Forgot the password ?</a></p>
        </div>
        <div class="col-12">
            <p class="small mb-0">Don't have account? <a href="register">Create an
                    account</a></p>
        </div>
    </form>
@endsection
