@extends('layouts.app')

@section('title', 'Register')

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-6">
            <h2 class="text-center mb-4">Register</h2>
            <form method="POST" action="{{ route('register') }}">
                @csrf
                
                <div class="mb-3">
                    <input type="text" name="name" class="form-control" placeholder="Name" value="{{ old('name') }}" required pattern="[A-Za-z\s]+" title="Name should only contain letters and spaces">
                    @error('name')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>
                <div class="mb-3">
                    <input type="email" name="email" class="form-control" placeholder="Email" value="{{ old('email') }}" required>
                    @error('email')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>
                <div class="mb-3">
                    <input type="password" name="password" class="form-control" placeholder="Password" required maxlength="20">
                    @error('password')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>
                <div class="mb-3">
                    <input type="password" name="password_confirmation" class="form-control" placeholder="Confirm Password" required maxlength="20">
                </div>
                <button type="submit" class="btn btn-primary w-100">Register</button>
            </form>
            <div class="text-center mt-4">
                <a href="{{ route('login') }}">Already have an account? Login</a>
            </div>
        </div>
    </div>
@endsection
