@extends('layouts.app')
@section('title','Register')
@section('content')
    <div class="col-md-6 col-12 fxt-bg-color">
        <div class="fxt-content">
            <div class="fxt-header">
                <a href="{{ url('/login') }}" class="fxt-logo"><img src="images/logo.jpg" alt="Logo"></a>
            </div>
            <div class="fxt-form">
                <div class="fxt-transformY-50 fxt-transition-delay-1">
                    <h2>Register</h2>
                </div>
                <div class="fxt-transformY-50 fxt-transition-delay-2">
                    <p>Create an account free and enjoy it</p>
                </div>
                <form method="POST">
                    <div class="form-group">
                        <div class="fxt-transformY-50 fxt-transition-delay-1">
                            <input type="text" class="form-control" name="name" placeholder="Name"
                                required="required">
                            <i class="flaticon-user"></i>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="fxt-transformY-50 fxt-transition-delay-1">
                            <input type="email" class="form-control" name="email" placeholder="Email Address"
                                required="required">
                            <i class="flaticon-envelope"></i>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="fxt-transformY-50 fxt-transition-delay-2">
                            <input type="password" class="form-control" name="password" placeholder="Password"
                                required="required">
                            <i class="flaticon-padlock"></i>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="fxt-transformY-50 fxt-transition-delay-3">
                            <button type="submit" class="fxt-btn-fill">Register</button>
                        </div>
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
