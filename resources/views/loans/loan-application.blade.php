@extends('layouts.main')
@section('title','Loan Application')
@section('content')
    <div class="page-header card">
        <div class="row align-items-end">
            <div class="col-lg-12">
                <div class="page-header-title">
                    <i class="feather icon-pie-chart bg-c-purple"></i>
                    <div class="d-inline">
                        <h5>Loan Applications</h5>
                    </div>
                </div>
            </div>
            <div class="col-lg-12">
                <div class="page-header-breadcrumb float-left">
                    <ul class=" breadcrumb breadcrumb-title">
                        <li class="breadcrumb-item">
                            <a href="{{ url('/home')}}"><i class="feather icon-home"></i></a>
                        </li>
                        <li class="breadcrumb-item active"><a href="#">Loan Application</a></li>
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
                        <div class="card-header">
                            <ul class="nav nav-pills">
                                <li class="nav-item">
                                    <a href="#new" class="nav-link active" data-toggle="tab">
                                        New Applications
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="#disbursed" class="nav-link" data-toggle="tab">
                                        Disbursed Loans
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="#rejected" class="nav-link" data-toggle="tab">
                                        Rejected Loans
                                    </a>
                                </li>
                            </ul>
                        </div>
                        <div class="card-body">
                            <div class="tab-content">
                                <div id="new" class="tab-pane active">
                                    <button class="btn btn-sm btn-outline-success btn-round" data-toggle="modal" data-target="#applyLoan">
                                        Apply
                                    </button>
                                    <button class="btn btn-sm btn-outline-warning btn-round" data-toggle="modal" data-target="#importRepayments">
                                        Import Repayments
                                    </button>
                                    <button class="btn btn-sm btn-outline-danger btn-round">
                                        Download Template
                                    </button>
                                    <button class="btn btn-sm btn-outline-info btn-round">
                                        Filter
                                    </button>
                                    <div class="float-right">
                                        <form action="">
                                            <div class="form-group">
                                                <input type="text" name="search" placeholder="Search" class="form-control">
                                            </div>
                                        </form>
                                    </div>
                                    <table class="table table-striped table-bordered mt-2">
                                        <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Member</th>
                                            <th>Loan Type</th>
                                            <th>Application Date</th>
                                            <th>Amount Applied</th>
                                            <th>Period Months</th>
                                            <th>Interest Rates</th>
                                            <th>Months</th>
                                        </tr>
                                        </thead>
                                    </table>
                                </div>
                                <div id="disbursed" class="tab-pane"></div>
                                <div id="rejected" class="tab-pane"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="applyLoan">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="">
                    <div id="page1">
                        <div class="modal-header">
                            Loan Details
                        </div>
                        <div class="modal-body">
                            <div class="form-group">
                                <label for="member_id">Member</label>
                                <select name="member_id" class="form-control" onclick="getGuarantors()" id="member_id">
                                    @forelse($members as $member)
                                        <option value="{{$member->id}}">{{$member->firstname.' '.$member->lastname}}</option>
                                    @empty
                                        <option disabled>Add Loan Products</option>
                                    @endforelse
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="loan_product_id">Loan Product</label>
                                <select name="loan_product_id" class="form-control" onclick="getDuration()" id="loan_product_id">
                                    @forelse($products as $product)
                                        <option value="{{$product->id}}">{{$product->name}}</option>
                                    @empty
                                        <option disabled>Add Loan Products</option>
                                    @endforelse
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="application_date">Application Date</label>
                                <input type="text" class="form-control datepicker" name="application_date" id="application_date">
                            </div>
                            <div class="form-group">
                                <label for="application_date">Maximum Amount</label>
                                <input type="text" class="form-control datepicker" name="application_date" id="application_date">
                            </div>
                            <div class="form-group">
                                <label for="amount_applied">Amount Applied</label>
                                <input type="text" name="amount_applied" id="amount_applied">
                            </div>
                            <div class="form-group">
                                <label for="">Repayment Period(Months)</label>
                                <input type="text" name="period" class="form-control" id="period">
                            </div>
                        </div>
                        <div class="modal-footer justify-content-center">
                            <button class="btn btn-sm btn-round btn-outline-warning" data-dismiss="modal" >
                                Close
                            </button>
                            <button class="btn btn-sm btn-round btn-outline-success" type="button" onclick="nexts(1)">
                                Next
                            </button>
                        </div>
                    </div>
                    <div id="page2" style="display: none">
                        <div class="modal-header">
                            Guarantor Details
                        </div>
                        <div class="modal-body">
                            <div class="form-group">
                                <label for="">Guarantor</label>

                            </div>
                        </div>
                        <div class="modal-footer justify-content-center">
                            <button class="btn btn-sm btn-round btn-outline-warning" type="button" onclick="nexts(2)">
                                Previous
                            </button>
                            <button class="btn btn-sm btn-round btn-outline-success" type="button" onclick="nexts(3)">
                                Next
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="modal fade" id="importRepayments">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="">
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-sm-6">
                                <img src="{{asset('images/down.gif')}}" alt="upload" height="200" width="350">
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="select">Select File</label>
                                    <input type="file" name="file" class="form-control">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer justify-content-center">
                        <button class="btn btn-sm btn-outline-warning btn-round" data-dismiss="modal" type="button">
                            Close
                        </button>
                        <button class="btn btn-sm btn-outline-success btn-round" type="submit">
                            Upload
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script>
        function getDuration() {
            var loan_product = document.getElementById('loan_product_id').value;
            $.ajax({
                type: "GET",
                url: "../loan/duration/"+loan_product,
                success: function (response) {
                    console.log(response)
                }
            })
        }
        function getGuarantors() {
            var member_id = document.getElementById('member_id').value;
            $.ajax({
                type: "GET",
                url:"../members/guarantor/"+member_id,
                success: function (response) {
                    console.log(response);
                }
            })
        }
    </script>
    <script>
        function nexts(id) {
            if (id===1)
            {
                $("#page1").hide();
                $("#page2").show();
            }
            if(id===2)
            {
                $("#page1").show();
                $("#page2").hide();
            }
        }
    </script>
@endsection
