@extends('layouts.main')
@section('title', $saving->type)
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
                        <h5>{{ $saving->type }}</h5>
                    </div>
                </div>
            </div>
            <div class="col-lg-12">
                <div class="page-header-breadcrumb float-left">
                    <ul class=" breadcrumb breadcrumb-title">
                        <li class="breadcrumb-item">
                            <a href="{{ url('/home') }}"><i class="feather icon-home"></i></a>
                        </li>
                        <li class="breadcrumb-item"><a href="{{ url('saving/savings') }}">Savings</a></li>
                        <li class="breadcrumb-item active"><a href="#">Savings</a></li>
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
                                        src="{{ asset('images/savings.gif') }}" alt="img">
                                    <h4 class="text-c-green mt-2">
                                        {{ $saving->member->firstname . ' ' . $saving->member->lastname }}</h4>
                                </div>
                            </div>
                            <div class="card">
                                <div class="card-body">
                                    <strong class="text-c-orenge">
                                        <i class="fa fa-percent"></i>Interest Rate
                                    </strong>
                                    <p class="text-muted">
                                        {{ $saving->account->product->interest_rate }}<i class="fa fa-percent"></i>
                                    </p>
                                    <hr />
                                    <strong class="text-success">
                                        <i class="fa fa-check"></i>Principal
                                    </strong>
                                    <p class="text-muted">
                                        {{ asMoney($saving->saving_amount) }}
                                    </p>
                                    <hr />
                                    <strong class="text-success">
                                        <i class="fa fa-check"></i>Months
                                    </strong>
                                    <p class="text-muted">
                                        {{ ($month) }}
                                    </p>
                                    <hr />
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-9">
                            <div class="card">
                                <div class="card-body">
                                    <table class="table table-striped table-bordered">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Month</th>
                                                <th>Interest</th>
                                                <th>Principal</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $count = 1;
                                            ?>
                                            @foreach ($period as $dt)
                                                @php
                                                    $total = $principal * $rate * 1;
                                                    $principal += $total;
                                                @endphp
                                                <tr>
                                                    <td>{{ $count++ }}</td>
                                                    <td>{{ $dt->format('M-Y') }}</td>
                                                    <td>{{ $total }}</td>
                                                    <td>{{ $principal }}</td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
