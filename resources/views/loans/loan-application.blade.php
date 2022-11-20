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
                                    <button class="btn btn-sm btn-outline-success btn-round" data-toggle="modal"
                                            data-target="#applyLoan">
                                        Apply
                                    </button>
                                    <button class="btn btn-sm btn-outline-warning btn-round" data-toggle="modal"
                                            data-target="#importRepayments">
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
                                                <input type="text" name="search" placeholder="Search"
                                                       class="form-control">
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
                                        <tbody>
                                        <?php
                                        $count = 1;
                                        ?>
                                        @foreach($loans as $loan)
                                            <tr>
                                                <td>{{$count++}}</td>
                                                <td>{{$loan->member->firstname.' '.$loan->member->lastname}}</td>
                                                <td>{{$loan->loanType->name}}</td>
                                                <td>{{$loan->application_date}}</td>
                                                <td>{{$loan->amount_applied}}</td>
                                                <td>{{$loan->period}} Months</td>
                                                <td>{{$loan->interest_rate}} %</td>
                                                <td>{{$loan->period}} Months</td>
                                            </tr>
                                        @endforeach
                                        </tbody>
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
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <form action="{{url('loan/apply')}}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div id="page1">
                        <div class="modal-header">
                            Loan Details
                        </div>
                        <div class="modal-body">
                            <div class="form-group">
                                <label for="member_id">Member</label>
                                <select name="member_id" class="form-control" onclick="getGuarantors()" id="member_id">
                                    @forelse($members as $member)
                                        <option
                                            value="{{$member->id}}">{{$member->firstname.' '.$member->lastname}}</option>
                                    @empty
                                        <option disabled>Add Loan Products</option>
                                    @endforelse
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="loan_product_id">Loan Product</label>
                                <select name="loan_product_id" class="form-control" onclick="getDuration()"
                                        id="loan_product_id">
                                    @forelse($products as $product)
                                        <option value="{{$product->id}}">{{$product->name}}</option>
                                    @empty
                                        <option disabled>Add Loan Products</option>
                                    @endforelse
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="application_date">Application Date</label>
                                <input type="text" class="form-control datepicker" name="application_date"
                                       id="application_date">
                            </div>
                            <div class="form-group">
                                <label for="maximum_amount">Maximum Amount</label>
                                <input type="text" class="form-control" name="maximum_amount" id="maximum_amount">
                            </div>
                            <div class="form-group">
                                <label for="amount_applied">Amount Applied</label>
                                <input type="text" name="amount_applied" id="amount_applied" class="form-control">
                            </div>
                            <div class="form-group">
                                <label for="period">Repayment Period(Months)</label>
                                <input type="text" name="period" class="form-control" id="period">
                            </div>
                        </div>
                        <div class="modal-footer justify-content-center">
                            <button class="btn btn-sm btn-round btn-outline-warning" data-dismiss="modal">
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
                            <div class="row">
                                <div class="form-group col-sm-4">
                                    <button class="btn btn-sm btn-outline-success btn-round add_guarantor" type="button"
                                            title="Add Guarantor">
                                        <i class="fa fa-plus fa-2x"></i>
                                    </button>
                                    <button class="btn btn-sm btn-outline-danger btn-round add_guarantor" type="button"
                                            title="Remove Guarantor">
                                        <i class="fa fa-minus fa-2x"></i>
                                    </button>
                                </div>
                                <div class="form-group col-sm-4">
                                    <label for="">Guarantor</label>
                                    <div id="guarantors"></div>
                                </div>
                                <div class="form-group col-sm-4">
                                    <label for="guarantee_amount">Guarantor amount</label>
                                    <input type="text" name="guarantee_amount" value="" class="form-control"
                                           id="guarantee_amount" readonly>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="matrix_id">Guarantor Matrix</label>
                                <select name="matrix_id" class="form-control" id="matrix_id">
                                    @forelse($matrices as $matrix)
                                        <option value="{{$matrix->id}}">{{$matrix->name}}</option>
                                    @empty
                                        <option disabled>Add Guarantor Matrix</option>
                                    @endforelse
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="disbursement_option_id">Disbursement Options</label>
                                <select name="disbursement_option_id" class="form-control" id="disbursement_option_id">
                                    @forelse($options as $option)
                                        <option value="{{$option->id}}">{{$option->name}}</option>
                                    @empty
                                        <option disabled>Add Disbursement Option</option>
                                    @endforelse
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="file">Guarantor Matrix Copy</label>
                                <input type="file" class="form-control" id="file" name="file">
                            </div>
                        </div>
                        <div class="modal-footer justify-content-center">
                            <button class="btn btn-sm btn-round btn-outline-warning" type="button" onclick="nexts(2)">
                                Previous
                            </button>
                            <button class="btn btn-sm btn-round btn-outline-success" type="submit">
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
                url: "../loan/duration/" + loan_product,
                success: function (response) {
                    console.log(response)
                }
            })
        }

        function getGuarantors() {
            var member_id = document.getElementById('member_id').value;
            $.ajax({
                type: "GET",
                url: "../members/guarantor/" + member_id,
                success: function (response) {
                    //   console.log(response[0]);
                    var output = '<select name="guarantor_id" class="form-control" onclick="getGuarantorAmount()" id="guarantor_id">'
                    for (var i = 0; i < response.length; i++) {
                        output += '<option value="' + response[i].member.id + '">' + response[i].member.firstname + ' --- ' + response[i].member.lastname + '</option>'
                    }
                    output += '</select>';
                    document.getElementById('guarantors').innerHTML = output;
                }
            })
        }

        function getGuarantorAmount() {
            var guarantor_id = document.getElementById('guarantor_id').value;
            var member_id = document.getElementById('member_id').value;
            console.log(member_id);
            $.ajax({
                type: "GET",
                url: "../members/guarantor/amount/" + guarantor_id + "/" + member_id,
                success: function (response) {
                    console.log(response);
                    document.getElementById('guarantee_amount').value = response;
                }
            })
        }
    </script>
    <script>
        function nexts(id) {
            if (id === 1) {
                $("#page1").hide();
                $("#page2").show();
            }
            if (id === 2) {
                $("#page1").show();
                $("#page2").hide();
            }
        }
    </script>
@endsection
