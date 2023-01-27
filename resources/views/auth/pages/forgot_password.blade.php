@extends('auth.layout.master_auth')

@section('content')
    <div class="pt-4 pb-2">
        <h5 class="card-title text-center pb-0 fs-4">Forgot Password an Account</h5>
    </div>
    @if (session('success'))
        {!! session('success') !!}
    @endif
    @if ($errors->any())
        @foreach ($errors->all() as $err)
            <p class="alert alert-danger">{{ $err }}</p>
        @endforeach
    @endif

    <form class="row g-3 needs-validation" action="{{ route('forgot.send') }}" method="POST" novalidate>
        @csrf

        <div class="col-12">
            <label for="email" class="form-label">Enter Your Email</label>
            <input type="email" name="email" class="form-control" id="email" required>
            <div class="invalid-feedback">Please enter a valid Email adddress!</div>
        </div>

        <div class="col-12">
            <button class="btn btn-primary w-100" type="submit">Reset Your
                Account</button>
        </div>
        <div class="col-12">
            <p class="small mb-0">Already have an account? <a href="login">Log in</a>
            </p>
        </div>
    </form>
@endsection
