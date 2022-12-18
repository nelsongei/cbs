@extends('layouts.main')
@section('title',$product->name)
@section('content')
    <?php

    function asMoney($value)
    {
        return number_format($value, 2);
    }
    ?>
    <div class="page-header card">
        <div class="row align-items-end">
            <div class="col-lg-12">
                <div class="page-header-title">
                    <i class="feather icon-target bg-c-green"></i>
                    <div class="d-inline">
                        <h5>{{$product->name}}</h5>
                    </div>
                </div>
            </div>
            <div class="col-lg-12">
                <div class="page-header-breadcrumb float-left">
                    <ul class=" breadcrumb breadcrumb-title">
                        <li class="breadcrumb-item">
                            <a href="{{ url('/home')}}"><i class="feather icon-home"></i></a>
                        </li>
                        <li class="breadcrumb-item"><a href="{{url('/saving/products')}}">Saving Product</a></li>
                        <li class="breadcrumb-item active"><a href="#">{{$product->name}}</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <div class="pcoded-inner-content">
        <div class="main-page">
            <div class="page-wrapper">
                <div class="page-body">
                    <div class="row">
                        <div class="col-sm-3">
                            <div class="card">
                                <div class="card-body text-center">
                                    <img class="img-fluid img-rounded img-circle img-150"
                                         src="{{asset('images/graph.gif')}}" alt="img">
                                    <h4 class="text-c-blue mt-2">{{$product->name}}</h4>
                                    <h4 class="text-c-green mt-2">{{$product->shortname}}</h4>
                                </div>
                            </div>
                            <div class="card">
                                <div class="card-body">
                                    <strong class="text-c-orenge">
                                        <i class="fa fa-check-circle mr-1"></i>Savings
                                    </strong>
                                    <p class="text-muted">
                                        {{count($product->accounts)}}
                                    </p>
                                    <hr/>
                                    <strong class="text-c-blue">
                                        <i class="fa fa-crosshairs"></i>Total Savings
                                    </strong>
                                    <p class="text-muted">
                                        {{asMoney($product->accounts->sum('saving_amount'))}}
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-9">
                            <div class="card">
                                <div class="card-body">
                                    <div>
                                        {!! $savingChart->container() !!}
                                        {!! $savingChart->script() !!}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

@endsection

