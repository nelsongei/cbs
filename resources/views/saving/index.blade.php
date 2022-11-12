@extends('layouts.main')
@section('title','Savings')
@section('content')
    <div class="page-header card">
        <div class="row align-items-end">
            <div class="col-lg-12">
                <div class="page-header-title">
                    <i class="feather icon-target bg-c-green"></i>
                    <div class="d-inline">
                        <h5>Savings</h5>
                    </div>
                </div>
            </div>
            <div class="col-lg-12">
                <div class="page-header-breadcrumb float-left">
                    <ul class=" breadcrumb breadcrumb-title">
                        <li class="breadcrumb-item">
                            <a href="{{ url('/home')}}"><i class="feather icon-home"></i></a>
                        </li>
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
                    <div class="">
                        <div class="card">
                            <div class="card-body">
                                <button class="btn btn-sm btn-outline-success btn-round" data-toggle="modal"
                                        data-target="#addSaving">
                                    Add Saving
                                </button>
                                <button class="btn btn-sm btn-outline-warning btn-round" data-toggle="modal"
                                        data-target="#upload-savings">
                                    Upload Savings
                                </button>
                                <a href="{{url('saving/export')}}" class="btn btn-sm btn-outline-danger btn-round">
                                    Download Template
                                </a>
                                <button class="btn btn-sm btn-outline-secondary btn-round" data-toggle="modal"
                                        data-target="#export-saving">
                                    Export Savings
                                </button>
                                <button type="button" data-toggle="modal" data-target="#export-saving" id="assign" class="btn btn-sm btn-outline-primary btn-round">
                                    Export Selected
                                </button>
                                <table class="table table-bordered table-striped mt-2">
                                    <thead>
                                    <tr>
                                        <td><input type="checkbox" id="checkAll"></td>
                                        <th>Member Name</th>
                                        <th>Member Number</th>
                                        <th>Account Number</th>
                                        <th>Payment Method</th>
                                        <th>Saving Product</th>
                                        <th>Amount</th>
                                        <th>Date</th>
                                        <th>Action</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php
                                    $count = 1;
                                    ?>
                                    @forelse($savings as $saving)
                                        <tr>
                                            <td><input type="checkbox" name="id[]" class="checkbox" id="checkItem{{$saving->id}}"
                                                       value="{{$saving->id}}"></td>
                                            <td>{{$saving->member->firstname.' '.$saving->member->middlename.' '.$saving->member->lastname}}</td>
                                            <td>{{$saving->member->membership_no}}</td>
                                            <td>{{$saving->account->account_number}}</td>
                                            <td>{{$saving->payment_method}}</td>
                                            <td>{{$saving->account->product->name}}</td>
                                            <td>{{$saving->saving_amount}}</td>
                                            <td>{{$saving->date}}</td>
                                            <td>
                                                <div class="dropdown">
                                                    <button class="btn btn-outline-success btn-round dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                        Action
                                                    </button>
                                                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                                        <a class="dropdown-item text-success" href="{{url('saving/view/'.$saving->id)}}">View</a>
                                                        <a class="dropdown-item text-info" href="#">Edit</a>
                                                        <a class="dropdown-item text-danger" href="#">Delete</a>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="9" class="text-center">
                                                <i class="fa fa-file-archive fa-5x text-c-orenge"></i>
                                                <p>No Savings</p>
                                            </td>
                                        </tr>
                                    @endforelse
                                    </tbody>
                                </table>
                                <div class="float-right mt-2">
                                    {{$savings->links()}}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="addSaving">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="{{url('saving/store')}}" method="post">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="account">Saving Account</label>
                            <select class="form-control" id="account" name="account">
                                @for($i=0;$i<count($savingaccounts);$i++)
                                    @php
                                        $member  = \App\Models\Member::find($savingaccounts[$i]->member_id);
                                    @endphp
                                    <option>{{$member->firstname.' '.$member->lastname.':'.$savingaccounts[$i]->account_number}}</option>
                                @endfor
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="saving_amount">Saving Amount</label>
                            <input type="number" min="0" id="saving_amount" name="saving_amount" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="date">Date</label>
                            <input type="date" min="0" id="date" name="date" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="type">Type</label>
                            <select class="form-control" id="type" name="type">
                                <option>Credit</option>
                                <option>Debit</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="payment_method">Payment Method</label>
                            <select class="form-control" id="payment_method" name="payment_method"
                                    onclick="bankDetails()">
                                <option>Cash</option>
                                <option>Bank</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="description">Description</label>
                            <textarea class="form-control" name="description" id="description"></textarea>
                        </div>
                        <div class="form-group" id="detais" style="display: none">
                            <label for="bank_sadetails">Bank Details</label>
                            <input type="text" class="form-control" name="bank_sadetails" id="bank_sadetails">
                        </div>
                    </div>
                    <div class="modal-footer justify-content-center">
                        <button class="btn btn-sm btn-outline-warning btn-round" data-dismiss="modal" type="button">
                            Close
                        </button>
                        <button class="btn btn-sm btn-outline-success btn-round" type="submit">
                            Add Saving
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="modal fade" id="export-saving">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <form action="">
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-sm-6">
                                <img src="{{asset('images/print.gif')}}" alt="print" height="200" width="200">
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="period">Period</label>
                                    <select name="period" id="period" class="form-control">
                                        <option value="">select period</option>
                                        <option value="custom">Custom range</option>
                                        <option value="As at date">As at Date</option>
                                        <option value="year">Year</option>
                                        <option value="month">Month</option>
                                    </select>
                                </div>
                                <div class="form-group" id="year">
                                    <label for="username">Select Year <span style="color:red">*</span></label>
                                    <div class="right-inner-addon ">
                                        <i class="glyphicon glyphicon-calendar"></i>
                                        <input class="form-control datepicker42" readonly="readonly" placeholder=""
                                               type="text"
                                               name="year" id="dropper_default" value="{{date('Y')}}">
                                    </div>
                                </div>
                                <div id="custom">
                                    <div class="form-group">
                                        <label for="username">From <span style="color:red">*</span></label>
                                        <div class="right-inner-addon ">
                                            <i class="glyphicon glyphicon-calendar"></i>
                                            <input required class="form-control datepicker" readonly="readonly"
                                                   placeholder="" type="text" name="from" id="from"
                                                   value="{{{ old('from') }}}">
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="username">To <span style="color:red">*</span></label>
                                        <div class="right-inner-addon ">
                                            <i class="glyphicon glyphicon-calendar"></i>
                                            <input required class="form-control datepicker" readonly="readonly"
                                                   placeholder="" type="text" name="to" id="to"
                                                   value="{{{ old('to') }}}">
                                        </div>

                                    </div>
                                </div>
                                <div class="form-group" id="select_date">
                                    <label for="username">Date <span style="color:red">*</span></label>
                                    <div class="right-inner-addon ">
                                        <i class="glyphicon glyphicon-calendar"></i>
                                        <input class="form-control datepicker" readonly="readonly" placeholder=""
                                               type="text"
                                               name="date" id="date" value="{{date('Y-m-d')}}">
                                    </div>
                                </div>
                                <div class="form-group" id="month">
                                    <label for="username">Select month <span style="color:red">*</span></label>
                                    <div class="right-inner-addon ">
                                        <i class="glyphicon glyphicon-calendar"></i>
                                        <input class="form-control datepicker2" readonly="readonly" placeholder=""
                                               type="text"
                                               name="month" id="date" value="{{date('m-Y')}}">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="username">Format</label>
                                    <select class="form-control" name="format" id="format" required>
                                        <option value="">Select format</option>
                                        <option value="pdf">PDF</option>
                                        <option value="excel">Excel</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer justify-content-center">
                        <button class="btn btn-sm btn-outline-warning btn-round" data-dismiss="modal" type="button">
                            Close
                        </button>
                        <button class="btn btn-sm btn-outline-success btn-round" type="submit">
                            Export
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="modal fade" id="upload-savings">
        <div class="modal-dialog modal-lg">
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
@endsection
