@extends('layouts.app')
@section('title', 'Login')
@section('content')
    <div class="col-md-6 col-12 fxt-bg-color">
        <div class="fxt-content">
            <div class="fxt-header">
                <a href="login-29.html" class="fxt-logo"><img src="images/logo.jpg" alt="Logo"></a>
            </div>
            <div class="fxt-form">
                <div class="fxt-transformY-50 fxt-transition-delay-1">
                    <h2>Log In</h2>
                </div>
                <div class="fxt-transformY-50 fxt-transition-delay-2">
                    <p>Log in to continue in our website</p>
                </div>
                <form method="POST" action="{{ route('login') }}">
                    @csrf
                    <div class="form-group">
                        <div class="fxt-transformY-50 fxt-transition-delay-4">
                            <input type="email" class="form-control" name="email" placeholder="Email Address"
                                value="{{ old('email') }}" required="required">
                            <i class="flaticon-envelope"></i>
                            @error('email')
                            <span>
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="fxt-transformY-50 fxt-transition-delay-5">
                            <input type="password" class="form-control" name="password" placeholder="Password"
                                required="required">
                            <i class="flaticon-padlock"></i>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="fxt-transformY-50 fxt-transition-delay-6">
                            <div class="fxt-content-between">
                                <button type="submit" class="fxt-btn-fill">Log in</button>
                                <a href="#" class="switcher-text2">Forgot Password</a>
                            </div>
                        </div>
                        @error('password')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </form>
            </div>
            <div class="fxt-footer">
                <div class="fxt-transformY-50 fxt-transition-delay-8">
                    <h3>Or Login With:</h3>
                </div>
                <ul class="fxt-socials">
                    <li class="fxt-facebook fxt-transformY-50 fxt-transition-delay-9">
                        <a href="#" title="Facebook"><i class="fab fa-facebook-f"></i></a>
                    </li>
                    <li class="fxt-twitter fxt-transformY-50 fxt-transition-delay-10">
                        <a href="#" title="twitter"><i class="fab fa-twitter"></i></a>
                    </li>
                    <li class="fxt-google fxt-transformY-50 fxt-transition-delay-11">
                        <a href="#" title="google"><i class="fab fa-google-plus-g"></i></a>
                    </li>
                    <li class="fxt-linkedin fxt-transformY-50 fxt-transition-delay-12">
                        <a href="#" title="linkedin"><i class="fab fa-linkedin-in"></i></a>
                    </li>
                    <li class="fxt-pinterest fxt-transformY-50 fxt-transition-delay-13">
                        <a href="#" title="pinterest"><i class="fab fa-pinterest-p"></i></a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
@endsection
