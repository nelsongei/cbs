@extends('layouts.main')
@section('title','Loan Products')
@section('content')
    <div class="page-header card">
        <div class="row align-items-end">
            <div class="col-lg-12">
                <div class="page-header-title">
                    <i class="feather icon-pie-chart bg-c-purple"></i>
                    <div class="d-inline">
                        <h5>Loan Products</h5>
                    </div>
                </div>
            </div>
            <div class="col-lg-12">
                <div class="page-header-breadcrumb float-left">
                    <ul class=" breadcrumb breadcrumb-title">
                        <li class="breadcrumb-item">
                            <a href="{{ url('/home')}}"><i class="feather icon-home"></i></a>
                        </li>
                        <li class="breadcrumb-item active"><a href="#">Loan Products</a></li>
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
                            <button class="btn btn-outline-success btn-round" data-toggle="modal" data-target="#loanProduct">
                                Add Product
                            </button>
                            <table class="table table-striped table-bordered mt-2">
                                <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Product Name</th>
                                    <th>Short Name</th>
                                    <th>Formula</th>
                                    <th>Interest Rate</th>
                                    <th>Period</th>
                                    <th>Currency</th>
                                    <th>Action</th>
                                </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="loanProduct">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="">
                    <div id="page1">
                        <div class="modal-body">
                            <div class="form-group">
                                <label for="name">Product Name</label>
                                <input type="text" name="name" class="form-control" id="name">
                            </div>
                            <div class="form-group">
                                <label for="short_name">Short Name</label>
                                <input type="text" name="short_name" class="form-control" id="short_name">
                            </div>
                            <div class="form-group">
                                <label for="currency">Currency</label>
                                <input type="text" name="currency" class="form-control" id="currency">
                            </div>
                            <div class="form-group">
                                <label for="interest_rate">Interest Rate (Monthly)</label>
                                <input type="text" name="interest_rate" class="form-control" id="interest_rate">
                            </div>
                            <div class="form-group">
                                <label for="period">Period Months</label>
                                <input type="text" name="period" class="form-control" id="period">
                            </div>
                            <div class="form-group">
                                <label for="formula">Interest Formula</label>
                                <select class="form-control" id="formula" name="formula" required>
                                    <option value="SL"> Straight Line (SL)</option>
                                    <option value="RB"> Reducing Balance (RB)</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="amortization">Amortization Method</label>
                                <select class="form-control" name="amortization" id="amortization" required>
                                    <option value="EI"> Equal Instalments</option>
                                    <option value="EP"> Equal Principals</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="membership_duration">Duration For Membership to be eligible</label>
                                <input type="text" name="membership_duration" class="form-control" id="membership_duration">
                            </div>
                        </div>
                        <div class="modal-footer justify-content-center">
                            <button class="btn-sm btn btn-outline-warning btn-round" type="button" data-dismiss="modal">
                                Close
                            </button>
                            <button class="btn-sm btn btn-outline-success btn-round" type="button" onclick="nexts(1)">
                                Next
                            </button>
                        </div>
                    </div>
                    <div id="page2" style="display: none">
                        <div class="modal-body">
                        </div>
                        <div class="modal-footer justify-content-center">
                            <button class="btn-sm btn btn-outline-warning btn-round" type="button" onclick="nexts(2)">
                                Previous
                            </button>
                            <button class="btn-sm btn btn-outline-success btn-round" type="button" onclick="nexts(3)">
                                Next
                            </button>
                        </div>
                    </div>
                    <div id="page3" style="display: none">
                        3
                        <div class="modal-body"></div>
                        <div class="modal-footer justify-content-center">
                            <button class="btn-sm btn btn-outline-warning btn-round" type="button" onclick="nexts(4)">
                                Previous
                            </button>
                            <button class="btn-sm btn btn-outline-success btn-round" type="submit">
                                Submit
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script>
        function nexts(id) {
            if (id===1)
            {
                $("#page1").hide()
                $("#page2").show()
                $("#page3").hide()
            }
            if (id===2)
            {
                $("#page1").show()
                $("#page2").hide()
                $("#page3").hide()
            }
            if (id===3)
            {
                $("#page1").hide()
                $("#page2").hide()
                $("#page3").show()
            }
            if (id===4)
            {
                $("#page1").hide()
                $("#page2").show()
                $("#page3").hide()
            }
        }
    </script>
@endsection
