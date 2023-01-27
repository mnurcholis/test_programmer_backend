@extends('auth.layout.master_auth')

@section('content')
    <div class="pt-4 pb-2">
        <h5 class="card-title text-center pb-0 fs-4">Reset Password</h5>
    </div>
    @if ($errors->any())
        @foreach ($errors->all() as $err)
            <p class="alert alert-danger">{{ $err }}</p>
        @endforeach
    @endif

    <form class="row g-3 needs-validation" action="{{ route('resetpassword.action') }}" method="POST" novalidate>
        @csrf
        <div class="col-12">
            <input type="hidden" name="email" class="form-control" id="email" value="{{ $email }}" required
                readonly>
            <label for="password" class="form-label"> New Password</label>
            <input type="password" name="password" class="form-control" id="password" required>
            <div class="invalid-feedback">Please enter your password!</div>
        </div>
        <div class="col-12">
            <label for="password_confirm" class="form-label">Confrim Password</label>
            <input type="password" name="password_confirm" class="form-control" id="password_confirm" required>
            <div class="invalid-feedback">Please enter your password!</div>
        </div>
        <div class="col-12">
            <button class="btn btn-primary w-100" type="submit">Create new Password</button>
        </div>
    </form>
@endsection
