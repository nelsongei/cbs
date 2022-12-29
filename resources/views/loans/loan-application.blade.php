@extends('layouts.main')
@section('title', 'Loan Application')
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
                            <a href="{{ url('/home') }}"><i class="feather icon-home"></i></a>
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
                                    <a href="#approved" class="nav-link" data-toggle="tab">
                                        Approved Loans
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
                                    <button class="btn btn-sm btn-outline-secondary btn-round" data-toggle="modal"
                                        data-target="#loanCalculator">
                                        Loan Calculator
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
                                                <th>Status</th>
                                                <th>Amount Applied</th>
                                                <th>Period Months</th>
                                                <th>Interest Rates</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $count = 1;
                                            ?>
                                            @forelse($loans as $loan)
                                                <tr>
                                                    <td>{{ $count++ }}</td>
                                                    <td>
                                                        {{--                                                    <a href="{{url('loan/view/'.$loan->id)}}"> --}}
                                                        {{ $loan->member->firstname . ' ' . $loan->member->lastname }}
                                                        {{--                                                    </a> --}}
                                                    </td>
                                                    <td>{{ $loan->loanType->name }}</td>
                                                    <td>{{ $loan->application_date }}</td>
                                                    <td>{{ $loan->loan_status }}</td>
                                                    <td>{{ $loan->amount_applied }}</td>
                                                    <td>{{ $loan->period }} Months</td>
                                                    <td>{{ $loan->interest_rate }} %</td>
                                                    <td>
                                                        <div class="dropdown">
                                                            <button
                                                                class="btn btn-outline-success btn-round dropdown-toggle"
                                                                type="button" id="dropdownMenuButton"
                                                                data-toggle="dropdown" aria-haspopup="true"
                                                                aria-expanded="false">
                                                                Action
                                                            </button>
                                                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                                                <a class="dropdown-item text-info" data-toggle="modal"
                                                                    data-target="#approve{{ $loan->id }}">Approve</a>
                                                                <a class="dropdown-item text-danger" data-toggle="modal"
                                                                    data-target="#reject{{ $loan->id }}">Reject</a>
                                                            </div>
                                                        </div>
                                                    </td>
                                                </tr>
                                                <div class="modal fade" id="approve{{ $loan->id }}">
                                                    <div class="modal-dialog">
                                                        <div class="modal-content">
                                                            <form action="{{ url('/loan/approve/' . $loan->id) }}"
                                                                method="post">
                                                                @csrf
                                                                <div class="modal-body">
                                                                    <input type="hidden" name="id"
                                                                        value="{{ $loan->id }}">
                                                                    <div class="form-group">
                                                                        <label for="approved_date">Amount Date</label>
                                                                        <input type="text" name="approved_date"
                                                                            class="form-control datepicker"
                                                                            id="approved_date">
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label for="amount_applied">Amount Approved</label>
                                                                        <input type="text" name="amount_applied"
                                                                            class="form-control"
                                                                            value="{{ $loan->amount_applied }}"
                                                                            id="amount_applied">
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label for="period">Loan Period (Months)</label>
                                                                        <input type="text" name="period"
                                                                            class="form-control"
                                                                            value="{{ $loan->period }}" id="period">
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label for="interest_rate">Interest Rate
                                                                            (%)
                                                                        </label>
                                                                        <input type="text" name="interest_rate"
                                                                            class="form-control"
                                                                            value="{{ $loan->interest_rate }}"
                                                                            id="interest_rate">
                                                                    </div>
                                                                </div>
                                                                <div class="modal-footer justify-content-center">
                                                                    <button
                                                                        class="btn btn-sm btn-outline-warning btn-round"
                                                                        data-dismiss="modal">
                                                                        Close
                                                                    </button>
                                                                    <button
                                                                        class="btn btn-sm btn-outline-success btn-round">
                                                                        Approve
                                                                    </button>
                                                                </div>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                            @empty
                                                <tr>
                                                    <td colspan="9" align="center">
                                                        <i class="fa fa-file fa-5x text-info"></i>
                                                        <p>Loan Applications</p>
                                                    </td>
                                                </tr>
                                            @endforelse
                                        </tbody>
                                    </table>
                                </div>
                                <div id="approved" class="tab-pane">
                                    <div class="card">
                                        <div class="card-body">
                                            <table class="table table-striped table-bordered">
                                                <thead>
                                                    <tr>
                                                        <th>#</th>
                                                        <th>Member</th>
                                                        <th>Loan Type</th>
                                                        <th>Approved Date</th>
                                                        <th>Status</th>
                                                        <th>Amount Approved</th>
                                                        <th>Period (Months)</th>
                                                        <th>Interest Rates</th>
                                                        <th>Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php $count = 1; ?>
                                                    @forelse($approved as $approve)
                                                        <tr>
                                                            <td>{{ $count++ }}</td>
                                                            <td>
                                                                <a href="{{ url('loan/view/' . $approve->loan->id) }}">
                                                                    {{ $approve->loan->member->firstname . ' ' . $approve->loan->member->lastname }}
                                                                </a>
                                                            </td>
                                                            <td>{{ $approve->loan->loanType->name }}</td>
                                                            <td>{{ $approve->date_approved }}</td>
                                                            <td>{{ $approve->loan->loan_status }}</td>
                                                            <td>{{ $approve->amount_approved }}</td>
                                                            <td>{{ $approve->loan->period }}</td>
                                                            <td>{{ $approve->interest_rate }}</td>
                                                            <td></td>
                                                        </tr>
                                                    @empty
                                                    <tr>
                                                        <td colspan="9">
                                                            <i class="fa fa-print fa-5x text-success"></i>
                                                            <p>Approved Loans</p>
                                                        </td>
                                                    </tr>
                                                    @endforelse
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
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
    <div class="modal fade" id="loanCalculator">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <form action="">
                    <div class="row">
                        <div class="col-sm-6 text-center">
                            <img src="{{ asset('images/calculator.gif') }}" style="height: 470px;width:500px">
                        </div>
                        <div class="col-sm-6">
                            <div class="modal-body">
                                <div class="form-group">
                                    <label for="loan_amount">Loan Amount</label>
                                    <input type="number" class="form-control" id="loan_amount" name="loan_amount"
                                        >
                                </div>
                                <div class="form-group">
                                    <label for="loan_length">Loan length In Months</label>
                                    <input type="number" class="form-control" id="loan_length" name="loan_length"
                                        >
                                </div>
                                <div class="form-group">
                                    <label for="">Loan Type</label>
                                    <select name="loan_products_id" id="loan_product_id" class="form-control"
                                        onclick="calculateLoan()">
                                        @foreach ($products as $product)
                                            <option value="{{ $product->id }}">{{ $product->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="principal_payment">Principal Payment</label>
                                    <input type="number" class="form-control" id="principal_payment" name="principal_payment"
                                        readonly>
                                </div>
                                <div class="form-group">
                                    <label for="interest_paid">Interest Paid</label>
                                    <input type="number" class="form-control" id="interest_paid" name="interest_paid" readonly>
                                </div>
                                <div class="form-group">
                                    <label for="interest_rate">Interest Rate(%)</label>
                                    <input type="number" class="form-control" id="interest_rate" name="interest_rate" readonly>
                                </div>
                                <div class="form-group">
                                    <label for="total_paid">Total</label>
                                    <input type="number" class="form-control" id="total_paid" name="total_paid" readonly>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer justify-content-center"></div>
                </form>
            </div>
        </div>
    </div>
    <div class="modal fade" id="applyLoan">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <form action="{{ url('loan/apply') }}" method="post" enctype="multipart/form-data">
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
                                        <option value="{{ $member->id }}">
                                            {{ $member->firstname . ' ' . $member->lastname }}</option>
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
                                        <option value="{{ $product->id }}">{{ $product->name }}</option>
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
                                <label for="period">Repayment Period(Months)</label>
                                <input type="text" name="period" class="form-control" id="period" readonly>
                            </div>
                            <div class="form-group">
                                <label for="saving_product_id">Saving Product</label>
                                <select name="saving_product_id" class="form-control" id="saving_product_id">
                                    @foreach ($savings as $saving)
                                        <option value="{{ $saving->id }}">{{ $saving->name }}</option>
                                    @endforeach
                                </select>
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
                            Guarantor & Amount Details
                        </div>
                        <div class="modal-body">
                            <div class="row" id="addMoreGuarantors">
                                <div class="form-group col-sm-12">
                                    <button class="btn btn-sm btn-outline-success btn-round add_guarantor" type="button"
                                        title="Add Guarantor">
                                        <i class="fa fa-plus fa-2x"></i>
                                    </button>
                                    <button class="btn btn-sm btn-outline-danger btn-round remove_guarantor"
                                        type="button" title="Remove Guarantor">
                                        <i class="fa fa-minus fa-2x"></i>
                                    </button>
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="">Guarantor</label>
                                    <div id="guarantors1"></div>
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="guarantee_amount">Guarantor amount</label>
                                    <input type="text" name="guarantee_amount[]" value=""
                                        class="form-control guarantor" id="guarantee_amount1" readonly>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="maximum_amount">Maximum Amount</label>
                                <input type="text" class="form-control" name="maximum_amount" id="maximum_amount"
                                    readonly>
                            </div>
                            <div class="form-group">
                                <label for="amount_applied">Amount Applied <span class="text-primary">(Maximum Amount you
                                        can apply is <span id="maximum_applied"></span>)</span></label>
                                <input type="text" name="amount_applied" id="amount_applied" class="form-control">
                            </div>
                            <div class="form-group">
                                <label for="matrix_id">Guarantor Matrix</label>
                                <select name="matrix_id" class="form-control" id="matrix_id">
                                    @forelse($matrices as $matrix)
                                        <option value="{{ $matrix->id }}">{{ $matrix->name }}</option>
                                    @empty
                                        <option disabled>Add Guarantor Matrix</option>
                                    @endforelse
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="disbursement_option_id">Disbursement Options</label>
                                <select name="disbursement_option_id" class="form-control" id="disbursement_option_id">
                                    @forelse($options as $option)
                                        <option value="{{ $option->id }}">{{ $option->name }}</option>
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
                                <img src="{{ asset('images/down.gif') }}" alt="upload" height="200" width="350">
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
    <script src="https://code.jquery.com/jquery-3.6.1.min.js"
        integrity="sha256-o88AwQnZB+VDvE9tvIXrMQaPlFFSUTR+nldQm1LuPXQ=" crossorigin="anonymous"></script>
    <script>
        function calculateLoan() {
            const loanData = {
                principal: document.getElementById('loan_amount').value,
                period: document.getElementById('loan_length').value,
            }
            var productId = document.getElementById('loan_product_id').value;
            $.ajax({
                type: "GET",
                url: "../loan/calculator/" + productId,
                data: loanData,
                success: function(response) {
                    console.log(response.total);
                    document.getElementById("total_paid").value = response.total;
                    document.getElementById("interest_paid").value = response.interest;
                    document.getElementById("interest_rate").value = response.rate;
                    document.getElementById("principal_payment").value = response.totalPrincipal;
                }
            });
        }
    </script>
    <script>
        var x = 2;
        var member_id = document.getElementById('member_id').value;
        $(".add_guarantor").on('click', function() {
            count = $("#addMoreGuarantors").length;
            var data = '<div class="form-group col-sm-6"><label>Guarantor</label><div id="guarantors' + x +
                '"></div><select name="guarantor_id[]" class="form-control" onclick="getGuarantorAmount()" id="guarantor_id' +
                x + '">'
            $.ajax({
                type: "GET",
                url: "../members/guarantor/" + member_id,
                success: function(response) {
                    // console.log(response[0]);
                    for (var i = 0; i < response.length; i++) {
                        var output = '<option value="' + response[i].member.id + '">' + response[i]
                            .member.firstname + ' --- ' + response[i].member.lastname + '</option>'
                    }
                    document.getElementById('guarantor_id' + (x - 1)).innerHTML = output;
                }
            })
            data += '</select>';
            data += '</div>';
            data += '<div class="form-group col-sm-6"><label for="">Guarantee Amount</label>' +
                '<input type="text" name="guarantee_amount[]" class="form-control guarantor" oninput="maximumAmount()" id="guarantee_amount' +
                (x) + '">'
            '</div>'
            $("#addMoreGuarantors").append(data);
            x++;
        });
    </script>
    <script>
        function maximumAmount() {
            var inps = document.querySelectorAll('.guarantor');
            var totals = {};
            for (var i = 0; i < inps.length; i++) {
                totals[inps[i].name] = (totals[inps[i].name] || 0) + Number(inps[i].value)
            }
            for (var key in totals) {
                if (totals.hasOwnProperty(key)) {
                    document.getElementById('maximum_amount').value = totals[key];
                    document.getElementById('maximum_applied').innerText = totals[key];
                }
            }
        }
    </script>
    <script>
        function getDuration() {
            var loan_product = document.getElementById('loan_product_id').value;
            $.ajax({
                type: "GET",
                url: "../loan/duration/" + loan_product,
                success: function(response) {
                    //console.log('months is '+response)
                    document.getElementById('period').value = response;
                }
            })
        }

        function getGuarantors() {
            var member_id = document.getElementById('member_id').value;
            var x = 0;
            $.ajax({
                type: "GET",
                url: "../members/guarantor/" + member_id,
                success: function(response) {
                    //   console.log(response[0]);
                    var output =
                        '<select name="guarantor_id[]" class="form-control" onclick="getGuarantorAmount()"  id="guarantor_id">'
                    for (var i = 0; i < response.length; i++) {
                        output += '<option value="' + response[i].member.id + '">' + response[i].member
                            .firstname + ' --- ' + response[i].member.lastname + '</option>'
                    }
                    output += '</select>';
                    document.getElementById('guarantors' + x).innerHTML = output;
                }
            })
            x++;
            console.log(x)
        }

        function getGuarantorAmount() {
            var x = 1;
            var guarantor_id = document.getElementById('guarantor_id').value;
            var member_id = document.getElementById('member_id').value;
            console.log(member_id);
            $.ajax({
                type: "GET",
                url: "../members/guarantor/amount/" + guarantor_id + "/" + member_id,
                success: function(response) {
                    document.getElementById('guarantee_amount' + (x - 1)).value = response;
                    maximumAmount()
                }
            })
            x++;
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
