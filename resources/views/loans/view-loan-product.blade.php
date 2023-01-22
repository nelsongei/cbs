@extends('layouts.main')
@section('title', $product->name)
@section('content')
    <?php
    function asMoney($value)
    {
        return number_format($value, 0);
    }
    ?>
    <div class="page-header card">
        <div class="row align-items-end">
            <div class="col-lg-12">
                <div class="page-header-title">
                    <i class="feather icon-pie-chart bg-c-purple"></i>
                    <div class="d-inline">
                        <h5>{{ $product->name }}</h5>
                    </div>
                </div>
            </div>
            <div class="col-lg-12">
                <div class="page-header-breadcrumb float-left">
                    <ul class=" breadcrumb breadcrumb-title">
                        <li class="breadcrumb-item">
                            <a href="{{ url('/home') }}"><i class="feather icon-home"></i></a>
                        </li>
                        <li class="breadcrumb-item"><a href="{{ url('loan/products') }}">Loan Products</a></li>
                        <li class="breadcrumb-item active"><a href="#">{{ $product->name }}</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <div class="pcoded-inner-content">
        <div class="main-page">
            <div class="page-wrapper">
                <div class="page-body">
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-sm-3">
                                    <div class="card">
                                        <div class="card-body text-center">
                                            <img class="img-fluid img-rounded img-circle w-100"
                                                src="{{ asset('images/56.gif') }}" alt="img">
                                            <h4 class="text-info">{{ $product->name }}</h4>
                                        </div>
                                    </div>
                                    <div class="card">
                                        <div class="card-body">
                                            <strong class="text-info">
                                                <i class="fa fa-book mr-1"></i>Loans
                                            </strong>
                                            <p class="text-muted">
                                                {{ count($product->loans) }}
                                            </p>
                                            <hr />
                                            <strong class="text-success">
                                                <i class="fa fa-book mr-1"></i>Total Loan Amount
                                            </strong>
                                            <p class="text-muted">
                                                {{ asMoney($product->loans->sum('amount_applied'),1) }}
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-9">
                                    <div class="card">
                                        <div class="card-body"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
