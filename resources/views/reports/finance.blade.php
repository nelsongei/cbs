@extends('layouts.main')
@section('title', 'Finance')
@section('content')
    <div class="page-header card">
        <div class="row align-items-end">
            <div class="col-lg-12">
                <div class="page-header-title">
                    <i class="feather icon-shield bg-primary"></i>
                    <div class="d-inline">
                        <h5>Finance Reports</h5>
                    </div>
                </div>
            </div>
            <div class="col-lg-12">
                <div class="page-header-breadcrumb float-left">
                    <ul class=" breadcrumb breadcrumb-title">
                        <li class="breadcrumb-item">
                            <a href="{{ url('/home') }}"><i class="feather icon-home"></i></a>
                        </li>
                        <li class="breadcrumb-item"><a href="#">Finance Reports</a></li>
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
                            <button class="btn btn-sm btn-outline-success btn-round" data-toggle="modal"
                                data-target="#reports">
                                Export Reports
                            </button>
                            <div class="row">
                                <div class="col-sm-3">
                                    <div class="card">
                                        <div class="card-body">

                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="card">
                                        <div class="card-body"></div>
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="card">
                                        <div class="card-body"></div>
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="card">
                                        <div class="card-body">
                                            <canvas id="profitLoss" height="150px" width="400vw"></canvas>
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
    <div class="modal fade" id="reports">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <form action="{{ url('reports/finance/download') }}" method="post">
                    @csrf
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-sm-6">
                                <img src="{{ asset('images/excel.gif') }}" class="w-100 h-100">
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="report">Report</label>
                                    <select class="form-control" name="report" id="report">
                                        <option value="balancesheet">Balance Sheet</option>
                                        <option value="income">Profit & Loss</option>
                                        <option value="trialbalance">Trial Balance</option>
                                        <option value="cashbook">Cash Book</option>
                                        <option value="income_reports">Income Report</option>
                                        <option value="expenses_reports">Expense Report</option>
                                        <option value="journal_reports">Journal Report</option>
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
                        <button class="btn btn-outline-warning btn-round btn-sm" data-dismiss="modal">
                            Close
                        </button>
                        <button class="btn btn-outline-success btn-round btn-sm" type="submit">
                            Download
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
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
        const profitLoss = document.getElementById('profitLoss');

        new Chart(profitLoss, {
            type: 'bar',
            data: {
                labels: ['Profit', 'Loss'],
                datasets: [{
                    label: " Profit & Loss",
                    data: [10000, 1000],
                    backgroundColor: [
                        '#6dd144',
                        '#ff8d34',
                    ],
                    borderColor: [
                        '#6dd144',
                        '#ff8d34',
                    ],
                    borderWidth: 2,
                    borderRadius: 20,
                    borderSkipped: false,
                }]
            },
            options: {
                responsive: true,
                indexAxis: 'y',
                plugins: {
                    legend: {
                        position: 'right',
                    },
                    title: {
                        display: true,
                        text: 'Profit & Loss'
                    }
                }
            },
        })
    </script>
@endsection
