@extends('layouts.main')
@section('title', 'Loan Reports')
@section('content')
    <div class="page-header card">
        <div class="row align-items-end">
            <div class="col-lg-12">
                <div class="page-header-title">
                    <i class="feather icon-cpu bg-success"></i>
                    <div class="d-inline">
                        <h5>Loan Reports</h5>
                    </div>
                </div>
            </div>
            <div class="col-lg-12">
                <div class="page-header-breadcrumb float-left">
                    <ul class=" breadcrumb breadcrumb-title">
                        <li class="breadcrumb-item">
                            <a href="{{ url('/home') }}"><i class="feather icon-home"></i></a>
                        </li>
                        <li class="breadcrumb-item"><a href="#">Loan Reports</a></li>
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
                                <button class="btn btn-sm btn-round btn-outline-success" data-toggle="modal"
                                    data-target="#loanReport">
                                    Export Report
                                </button>
                                &nbsp;
                                <button class="btn btn-sm btn-round btn-outline-danger" data-toggle="modal"
                                    data-target="#interestReport">
                                    Interest Report
                                </button>
                                <div class="col-sm-3">
                                    <div class="form-inline">
                                        <div class="form-group">
                                            <input type="text" class="form-control year" placeholder="Filter By Year"
                                                style="border-top-left-radius: 4px;border-bottom-left-radius: 4px;">
                                            <button type="button" class="btn btn-sm btn-outline-primary"
                                                style="height: 35px;border-top-right-radius: 4px;border-bottom-right-radius: 4px;">
                                                <i class="fas fa-search"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row mt-2">
                                <div class="col-sm-4">
                                    <div class="card">
                                        <div class="card-body">
                                            <canvas id="expenses" height="150px" width="400vw"></canvas>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="card">
                                        <div class="card-body">
                                            <canvas id="loanReleased" height="150px" width="400vw"></canvas>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="card">
                                        <div class="card-body">
                                            <canvas id="loanCollection" height="150px" width="400vw"></canvas>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="card">
                                        <div class="card-body" style="justify-content: center;display: flex;">
                                            <canvas id="gender" height="250vw" width="400vw"></canvas>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="card">
                                        <div class="card-body">
                                            <canvas id="fullyPaid" height="150px" width="400vw"></canvas>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="interestReport">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <form action="">
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-sm-6 text-center">
                                <img src="{{ asset('images/load-balancer.gif') }}">
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="report">Report</label>
                                    <select class="form-control" name="report" id="report">
                                        <option value="listing">Loan Listing Report</option>
                                        <option value="arrears">Loan Arrears Report</option>
                                        @foreach ($products as $product)
                                            <option value="{{ $product->id }}">{{ $product->name . ' Report' }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="">Period</label>
                                    <select class="form-control" name="period" id="periods" onclick="selectInDate()">
                                        <option value="asatdate">As At Date</option>
                                        <option value="custom">Custom</option>
                                    </select>
                                </div>
                                <div id="customInperiod" style="display: none">
                                    <div class="form-group">
                                        <label for="username">From <span style="color:red">*</span></label>
                                        <div class="right-inner-addon ">
                                            <i class="glyphicon glyphicon-calendar"></i>
                                            <input class="form-control datepicker" readonly="readonly" placeholder=""
                                                type="text" name="from" id="from">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="username">To <span style="color:red">*</span></label>
                                        <div class="right-inner-addon ">
                                            <i class="glyphicon glyphicon-calendar"></i>
                                            <input class="form-control datepicker" readonly="readonly" placeholder=""
                                                type="text" name="to" id="to">
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group" id="dates" style="display: none">
                                    <label for="username">Date <span style="color:red">*</span></label>
                                    <div class="right-inner-addon ">
                                        <i class="glyphicon glyphicon-calendar"></i>
                                        <input class="form-control datepicker" readonly="readonly" placeholder=""
                                            type="text" name="date" id="dateq" value="{{ date('Y-m-d') }}">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="">Format</label>
                                    <select class="form-control" name="format" id="format">
                                        <option>PDF</option>
                                        <option>Excel</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">

                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="modal fade" id="loanReport">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <form action="{{ url('reports/loans/download') }}" method="post">
                    @csrf
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-sm-6">
                                <img src="{{ asset('images/giphy.gif') }}">
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="report">Report</label>
                                    <select class="form-control" name="report" id="loanreport" onclick="getProducts()">
                                        <option value="listing">Loan Listing Report</option>
                                        <option value="arrears">Loan Arrears Report</option>
                                        @foreach ($products as $product)
                                            <option value="{{ $product->id }}">{{ $product->name . ' Report' }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div id="loanProducts" style="display: none">
                                    <label>Select Loan Product</label>
                                    <select class="form-control" name="loan_products" id="loan_products">
                                        @foreach ($products as $product)
                                            <option value="{{ $product->id }}">{{ $product->name . ' Report' }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="">Period</label>
                                    <select class="form-control" name="period" id="period" onclick="selectDate()">
                                        <option value="asatdate">As At Date</option>
                                        <option value="custom">Custom</option>
                                    </select>
                                </div>
                                <div id="customperiod" style="display: none">
                                    <div class="form-group">
                                        <label for="username">From <span style="color:red">*</span></label>
                                        <div class="right-inner-addon ">
                                            <i class="glyphicon glyphicon-calendar"></i>
                                            <input class="form-control datepicker" readonly="readonly" placeholder=""
                                                type="text" name="from" id="from">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="username">To <span style="color:red">*</span></label>
                                        <div class="right-inner-addon ">
                                            <i class="glyphicon glyphicon-calendar"></i>
                                            <input class="form-control datepicker" readonly="readonly" placeholder=""
                                                type="text" name="to" id="to">
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group" id="date" style="display: none">
                                    <label for="username">Date <span style="color:red">*</span></label>
                                    <div class="right-inner-addon ">
                                        <i class="glyphicon glyphicon-calendar"></i>
                                        <input class="form-control datepicker" readonly="readonly" placeholder=""
                                            type="text" name="date" id="dateq" value="{{ date('Y-m-d') }}">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="">Format</label>
                                    <select class="form-control" name="format" id="format">
                                        <option>PDF</option>
                                        <option>Excel</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer justify-content-center">
                        <button class="btn btn-sm btn-outline-warning btn-round" data-dismiss="modal">
                            Close
                        </button>
                        <button class="btn btn-sm btn-outline-success btn-round">
                            Download
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="{{ asset('charts/loanreports.js') }}"></script>
    <script>
        function getProducts() {
            var product = document.getElementById('loanreport').value;
            if(product =='arrears')
            {
                $("#loanProducts").show();
            }
            else{
                $("#loanProducts").hide();
            }
        }
    </script>
    <script>
        function selectDate() {
            var value = document.getElementById('period').value;
            if (value == 'custom') {
                $("#customperiod").show();
                $("#date").hide();
            }
            if (value == 'asatdate') {
                $("#date").show();
                $("#customperiod").hide();
            }
        }
    </script>
        <script>
            function selectInDate() {
                var value = document.getElementById('periods').value;
                if (value == 'custom') {
                    $("#customInperiod").show();
                    $("#dates").hide();
                }
                if (value == 'asatdate') {
                    $("#dates").show();
                    $("#customInperiod").hide();
                }
            }
        </script>
@endsection
