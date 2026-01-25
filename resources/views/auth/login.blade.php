@extends('layouts.kids')

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-6 col-lg-4">
            <div class="card card-kid p-4">
                <h3 class="fw-bold mb-3 text-center">Admin kirish</h3>
                @if($errors->any())
                    <div class="alert alert-danger">Email yoki parol noto'g'ri.</div>
                @endif
                <form method="POST" action="{{ route('login.post') }}">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label">Email</label>
                        <input type="email" name="email" class="form-control" required value="{{ old('email') }}">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Parol</label>
                        <input type="password" name="password" class="form-control" required>
                    </div>
                    <div class="mb-3 form-check">
                        <input type="checkbox" name="remember" class="form-check-input" id="remember">
                        <label for="remember" class="form-check-label">Eslab qolish</label>
                    </div>
                    <button class="btn btn-cta w-100 py-2">Kirish</button>
                </form>
            </div>
        </div>
    </div>
@endsection
