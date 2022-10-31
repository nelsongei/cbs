@extends('layouts.main')
@section('title',$member->firstname.' '.$member->lastname)
@section('content')
    <?php
    $currentDate = new DateTime();
    $newDate = $currentDate->sub(new DateInterval('P18Y'));
    $today = $newDate->format('Y-m-d');
    ?>
    <div class="page-header card">
        <div class="row align-items-end">
            <div class="col-lg-12">
                <div class="page-header-title">
                    <i class="feather icon-home bg-c-blue"></i>
                    <div class="d-inline">
                        <h5>{{$member->firstname.' '.$member->lastname}}</h5>
                    </div>
                </div>
            </div>
            <div class="col-lg-12">
                <div class="page-header-breadcrumb float-left">
                    <ul class=" breadcrumb breadcrumb-title">
                        <li class="breadcrumb-item">
                            <a href="{{ url('/home')}}"><i class="feather icon-home"></i></a>
                        </li>
                        <li class="breadcrumb-item"><a href="{{url('members')}}">Members</a></li>
                        <li class="breadcrumb-item active"><a href="#">{{$member->firstname.' '.$member->lastname}}</a>
                        </li>
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
                                            <img src="{{asset($member->photo)}}" alt="profile"
                                                 class="img-fluid img-rounded img-circle img-100">
                                            <h4 class="text-info">{{$member->title.' '.$member->firstname.' '.$member->middlename.' '.$member->lastname}}</h4>
                                        </div>
                                    </div>
                                    <div class="card">
                                        <div class="card-body">
                                            <strong class="text-success">
                                                <i class="fa fa-book mr-1"></i>Loans
                                            </strong>
                                            <p class="text-muted">
                                                10
                                            </p>
                                            <hr>
                                            <strong class="text-c-blue">
                                                <i class="fa fa-check-circle mr-1"></i>Dividends
                                            </strong>
                                            <p class="text-muted">
                                                100
                                            </p>
                                            <hr/>
                                            <strong class="text-info">
                                                <i class="fa fa-file-alt mr-1"></i>Loan Amount
                                            </strong>
                                            <p class="text-muted">
                                                10,000
                                            </p>
                                            <hr/>
                                            <strong class="text-info">
                                                <i class="fa fa-file mr-1"></i>Savings
                                            </strong>
                                            <p class="text-muted">
                                                100,000
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-9">
                                    <div class="card">
                                        <div class="card-header">
                                            <ul class="nav nav-pills">
                                                <li class="nav-item">
                                                    <a href="#update" class="active nav-link"
                                                       data-toggle="tab">Update</a>
                                                </li>
                                                <li>
                                                    <a href="#loans" class="nav-link" data-toggle="tab">Loan Account</a>
                                                </li>
                                                <li>
                                                    <a href="#savings" class="nav-link" data-toggle="tab">Saving
                                                        Account</a>
                                                </li>
                                                <li>
                                                    <a href="#share" class="nav-link" data-toggle="tab">Share
                                                        Accounts</a>
                                                </li>
                                                <li>
                                                    <a href="#next_kin" class="nav-link" data-toggle="tab">Next Of
                                                        Kins</a>
                                                </li>
                                                <li>
                                                    <a href="#docs" class="nav-link" data-toggle="tab">Documents</a>
                                                </li>
                                            </ul>
                                        </div>
                                        <div class="card-body">
                                            <div class="tab-content">
                                                <div id="update" class="tab-pane active">
                                                    <div class="card">
                                                        <form id="formData">
                                                            <div id="page1">
                                                                <div class="">
                                                                    <h3 class="text-info">Bio Data</h3>
                                                                    <div class="row">
                                                                        <input type="hidden" name="id"
                                                                               value="{{$member->id}}">
                                                                        <div class="form-group col-md-4">
                                                                            <label for="title">Title</label>
                                                                            <select name="title"
                                                                                    class="form-control"
                                                                                    id="title">
                                                                                <option>Mr</option>
                                                                                <option>Mrs</option>
                                                                                <option>Miss</option>
                                                                                <option>Ms</option>
                                                                            </select>
                                                                        </div>
                                                                        <div class="form-group col-md-4">
                                                                            <label for="membership_no">Membership
                                                                                No</label>
                                                                            <input type="text"
                                                                                   id="membership_no"
                                                                                   name="membership_no"
                                                                                   class="form-control"
                                                                                   readonly
                                                                                   value="{{$member->membership_no}}">
                                                                        </div>
                                                                        <div class="form-group col-md-4">
                                                                            <label for="id_no">ID No</label>
                                                                            <input type="text" id="id_no"
                                                                                   name="id_no"
                                                                                   class="form-control"
                                                                                   value="{{$member->id_no}}">
                                                                        </div>
                                                                        <div class="form-group col-md-4">
                                                                            <label
                                                                                for="firstname">Firstnane</label>
                                                                            <input type="text"
                                                                                   name="firstname"
                                                                                   id="firstname"
                                                                                   class="form-control"
                                                                                   value="{{$member->firstname}}">
                                                                        </div>
                                                                        <div class="form-group col-md-4">
                                                                            <label for="middlename">Middlename</label>
                                                                            <input type="text"
                                                                                   name="middlename"
                                                                                   id="middlename"
                                                                                   class="form-control"
                                                                                   value="{{$member->middlename}}">
                                                                        </div>
                                                                        <div class="form-group col-md-4">
                                                                            <label
                                                                                for="lastname">Lastname</label>
                                                                            <input type="text"
                                                                                   name="lastname"
                                                                                   id="lastname"
                                                                                   class="form-control"
                                                                                   value="{{$member->lastname}}">
                                                                        </div>
                                                                        <div class="form-group col-md-4">
                                                                            <label
                                                                                for="gender">Gender</label>
                                                                            <select name="gender"
                                                                                    class="form-control"
                                                                                    id="gender">
                                                                                <option>Male</option>
                                                                                <option>Female</option>
                                                                            </select>
                                                                        </div>
                                                                        <div class="form-group col-md-4">
                                                                            <label for="nationality">Nationality</label>
                                                                            <input type="text"
                                                                                   name="nationality"
                                                                                   id="nationality"
                                                                                   class="form-control"
                                                                                   value="{{$member->nationality}}">
                                                                        </div>
                                                                        <div class="form-group col-md-4">
                                                                            <label for="dob">DOB</label>
                                                                            <input type="date" name="dob"
                                                                                   id="dob"
                                                                                   class="form-control"
                                                                                   max="{{$today}}">
                                                                        </div>
                                                                        <div class="form-group col-md-4">
                                                                            <label for="marital_status">Marital
                                                                                Status</label>
                                                                            <select name="marital_status"
                                                                                    class="form-control"
                                                                                    id="marital_status">
                                                                                <option>Married</option>
                                                                                <option>Single</option>
                                                                                <option>Windowed</option>
                                                                            </select>
                                                                        </div>
                                                                        <div class="form-group col-md-4">
                                                                            <label for="group_id">Member
                                                                                Group</label>
                                                                            <select name="group_id"
                                                                                    class="form-control"
                                                                                    id="group_id">
                                                                                @foreach($groups as $group)
                                                                                    <option
                                                                                        value="{{$group->id}}">{{$group->name}}</option>
                                                                                @endforeach
                                                                            </select>
                                                                        </div>
                                                                        <div class="form-group col-md-4">
                                                                            <label for="branch_id">Member
                                                                                Branch</label>
                                                                            <select name="branch_id"
                                                                                    class="form-control"
                                                                                    id="branch_id">
                                                                                @foreach($branches as $branch)
                                                                                    <option
                                                                                        value="{{$branch->id}}">{{$branch->name}}</option>
                                                                                @endforeach
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div
                                                                    class="modal-footer justify-content-center">
                                                                    <button
                                                                        class="btn btn-sm btn-outline-success btn-round"
                                                                        type="button" onclick="nexts(1)">
                                                                        Next
                                                                    </button>
                                                                </div>
                                                            </div>
                                                            <div id="contact" style="display: none">
                                                                <div class="modal-body">
                                                                    <h3 class="text-info">Contact Data</h3>
                                                                    <div class="row">
                                                                        <div class="form-group col-md-6">
                                                                            <label for="email">Email</label>
                                                                            <input type="email" id="email" name="email"
                                                                                   class="form-control">
                                                                        </div>
                                                                        <div class="form-group col-md-6">
                                                                            <label for="phone">Phone Number</label>
                                                                            <input type="text" id="phone" name="phone"
                                                                                   class="form-control">
                                                                        </div>
                                                                        <div class="form-group col-md-6">
                                                                            <label for="address">Address</label>
                                                                            <input type="text" id="address"
                                                                                   name="address" class="form-control">
                                                                        </div>
                                                                        <div class="form-group col-md-6">
                                                                            <label for="postal">Postal Code</label>
                                                                            <input type="text" id="postal" name="postal"
                                                                                   class="form-control">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="modal-footer justify-content-center">
                                                                    <button
                                                                        class="btn btn-sm btn-outline-warning btn-round"
                                                                        type="button" onclick="nexts(2)">
                                                                        previous
                                                                    </button>
                                                                    <button
                                                                        class="btn btn-sm btn-outline-success btn-round"
                                                                        type="button" onclick="nexts(3)">
                                                                        Next
                                                                    </button>
                                                                </div>
                                                            </div>
                                                            <div id="kin" style="display: none">
                                                                <div class="">
                                                                    <h3 class="text-info">Kin Data</h3>
                                                                    <div class="row">
                                                                        <div class="form-group col-md-6">
                                                                            <label
                                                                                for="kin_name">Name</label>
                                                                            <input type="text" id="kin_name"
                                                                                   name="kin_name"
                                                                                   class="form-control">
                                                                        </div>
                                                                        <div class="form-group col-md-6">
                                                                            <label
                                                                                for="kin_email">Email</label>
                                                                            <input type="text"
                                                                                   id="kin_email"
                                                                                   name="kin_email"
                                                                                   class="form-control">
                                                                        </div>
                                                                        <div class="form-group col-md-6">
                                                                            <label for="kin_phone">Phone
                                                                                Number</label>
                                                                            <input type="text"
                                                                                   id="kin_phone"
                                                                                   name="kin_phone"
                                                                                   class="form-control">
                                                                        </div>
                                                                        <div class="form-group col-md-6">
                                                                            <label
                                                                                for="relationship">Relationship</label>
                                                                            <select name="relationship"
                                                                                    class="form-control"
                                                                                    id="relationship">
                                                                                <option>Mother</option>
                                                                                <option>Father</option>
                                                                                <option>Wife</option>
                                                                                <option>Brother</option>
                                                                                <option>Sister</option>
                                                                                <option>Son</option>
                                                                                <option>Daughter</option>
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div
                                                                    class="modal-footer justify-content-center">
                                                                    <button
                                                                        class="btn btn-sm btn-outline-warning btn-round"
                                                                        type="button" onclick="nexts(4)">
                                                                        previous
                                                                    </button>
                                                                    <button
                                                                        class="btn btn-sm btn-outline-success btn-round"
                                                                        type="button" onclick="nexts(5)">
                                                                        Next
                                                                    </button>
                                                                </div>
                                                            </div>
                                                            <div id="employment" style="display: none">
                                                                <div class="">
                                                                    <h3 class="text-info">Employment
                                                                        Data</h3>
                                                                    <div class="row">
                                                                        <div class="form-group col-md-4">
                                                                            <label for="is_employed">Employed</label>
                                                                            <input type="checkbox"
                                                                                   id="is_employed"
                                                                                   name="is_employed"
                                                                                   class="form-control">
                                                                        </div>
                                                                        <div class="form-group col-md-4">
                                                                            <label for="employer_name">Employer
                                                                                Name</label>
                                                                            <input type="text"
                                                                                   id="employer_name"
                                                                                   name="employer_name"
                                                                                   class="form-control">
                                                                        </div>
                                                                        <div class="form-group col-md-4">
                                                                            <label for="employment_type">Employment
                                                                                Type</label>
                                                                            <select name="employment_type"
                                                                                    class="form-control"
                                                                                    id="employment_type">
                                                                                <option>Contract</option>
                                                                                <option>Permanent</option>
                                                                                <option>Internship</option>
                                                                            </select>
                                                                        </div>
                                                                        <div class="form-group col-md-4">
                                                                            <label for="designation">Designation</label>
                                                                            <input type="text"
                                                                                   id="designation"
                                                                                   name="designation"
                                                                                   class="form-control">
                                                                        </div>
                                                                        <div class="form-group col-md-4">
                                                                            <label for="employment_date">Employment
                                                                                Date</label>
                                                                            <input type="date"
                                                                                   id="employment_date"
                                                                                   name="employment_date"
                                                                                   class="form-control">
                                                                        </div>
                                                                        <div class="form-group col-md-4">
                                                                            <label for="employer_address">Employer
                                                                                Address</label>
                                                                            <input type="text"
                                                                                   id="employer_address"
                                                                                   name="employer_address"
                                                                                   class="form-control">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div
                                                                    class="modal-footer justify-content-center">
                                                                    <button
                                                                        class="btn btn-sm btn-outline-warning btn-round"
                                                                        type="button" onclick="nexts(6)">
                                                                        previous
                                                                    </button>
                                                                    <button
                                                                        class="btn btn-sm btn-outline-success btn-round"
                                                                        type="submit">
                                                                        Update
                                                                    </button>
                                                                </div>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                                <div id="loans" class="tab-pane">
                                                    Loans
                                                </div>
                                                <div id="savings" class="tab-pane">
                                                    <div class="card">
                                                        <div class="card-body">
                                                            <table class="table table-bordered table-striped">
                                                                <thead>
                                                                <tr>
                                                                    <th>#</th>
                                                                    <th>Saving Product</th>
                                                                    <th>Account</th>
                                                                    <th>Action</th>
                                                                </tr>
                                                                </thead>
                                                                <?php $count = 1 ?>
                                                                @forelse($member->accounts as $account)
                                                                    <tr>
                                                                        <td>{{$count++}}</td>
                                                                        <td>{{$account->product->name}}</td>
                                                                        <td>{{$account->account_number}}</td>
                                                                        <td>
                                                                            <div class="dropdown">
                                                                                <button
                                                                                    class="btn btn-outline-success btn-round dropdown-toggle"
                                                                                    type="button"
                                                                                    id="dropdownMenuButton"
                                                                                    data-toggle="dropdown"
                                                                                    aria-haspopup="true"
                                                                                    aria-expanded="false">
                                                                                    Action
                                                                                </button>
                                                                                <div class="dropdown-menu"
                                                                                     aria-labelledby="dropdownMenuButton">
                                                                                    <a class="dropdown-item text-info"
                                                                                       href="{{url('saving/account/view/'.$account->id)}}">View</a>
                                                                                    <a class="dropdown-item text-info"
                                                                                       href="#">Edit</a>
                                                                                    <a class="dropdown-item text-danger"
                                                                                       href="#">Delete</a>
                                                                                </div>
                                                                            </div>
                                                                        </td>
                                                                    </tr>
                                                                @empty
                                                                    <tr>
                                                                        <td colspan="4" align="center">
                                                                            <i class="fa fa-check-circle fa-5x text-info"></i>
                                                                            <p>No Saving Account</p>
                                                                        </td>
                                                                    </tr>
                                                                @endforelse
                                                            </table>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div id="share" class="tab-pane">
                                                    <div class="card">
                                                        <div class="card-body">
                                                            <table class="table table-stripped table-bordered">
                                                                <thead>
                                                                <tr>
                                                                    <th>#</th>
                                                                    <th>Share Account</th>
                                                                    <th>Opening Date</th>
                                                                    <th>Action</th>
                                                                </tr>
                                                                </thead>
                                                                <tbody>
                                                                <?php $count = 1 ?>
                                                                @foreach($member->shares as $share)
                                                                    <tr>
                                                                        <td>{{$count++}}</td>
                                                                        <td>{{$share->account_number}}</td>
                                                                        <td>{{$share->opening_date}}</td>
                                                                        <td>
                                                                            <div class="dropdown">
                                                                                <button
                                                                                    class="btn btn-outline-success btn-round dropdown-toggle"
                                                                                    type="button"
                                                                                    id="dropdownMenuButton"
                                                                                    data-toggle="dropdown"
                                                                                    aria-haspopup="true"
                                                                                    aria-expanded="false">
                                                                                    Action
                                                                                </button>
                                                                                <div class="dropdown-menu"
                                                                                     aria-labelledby="dropdownMenuButton">
                                                                                    <a class="dropdown-item text-info"
                                                                                       href="{{url('saving/share/view/'.$share->id)}}">View</a>
                                                                                    <a class="dropdown-item text-info"
                                                                                       href="#">Edit</a>
                                                                                    <a class="dropdown-item text-danger"
                                                                                       href="#">Delete</a>
                                                                                </div>
                                                                            </div>
                                                                        </td>
                                                                    </tr>
                                                                @endforeach
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div id="next_kin" class="tab-pane">
                                                    <div class="card">
                                                        <div class="card-body">
                                                            <button
                                                                class="btn btn-sm btn-outline-success btn-round mb-2"
                                                                data-toggle="modal" data-target="#nextOfKin">
                                                                Add Next Of Kin
                                                            </button>
                                                            <table class="table table-bordered table-striped">
                                                                <thead>
                                                                <tr>
                                                                    <td>#</td>
                                                                    <td>Name</td>
                                                                    <td>Phone Number</td>
                                                                    <td>Email</td>
                                                                    <td>Relationship</td>
                                                                    <td>ID Number</td>
                                                                    <td>Action</td>
                                                                </tr>
                                                                </thead>
                                                                <?php $count = 1 ?>
                                                                @foreach($member->kins as $kin)
                                                                    <tr>
                                                                        <td>{{$count++}}</td>
                                                                        <td>{{$kin->kin_name}}</td>
                                                                        <td>{{$kin->kin_phone}}</td>
                                                                        <td>{{$kin->kin_email}}</td>
                                                                        <td>{{$kin->kin_relationship}}</td>
                                                                        <td>{{$kin->kin_relationship}}</td>
                                                                        <td>
                                                                            <div class="dropdown">
                                                                                <button
                                                                                    class="btn btn-outline-success btn-round dropdown-toggle"
                                                                                    type="button"
                                                                                    id="dropdownMenuButton"
                                                                                    data-toggle="dropdown"
                                                                                    aria-haspopup="true"
                                                                                    aria-expanded="false">
                                                                                    Action
                                                                                </button>
                                                                                <div class="dropdown-menu"
                                                                                     aria-labelledby="dropdownMenuButton">
                                                                                    <a class="dropdown-item text-info"
                                                                                       data-toggle="modal"
                                                                                       data-target="#editKin{{$kin->id}}">Edit</a>
                                                                                    <a class="dropdown-item text-danger"
                                                                                       data-toggle="modal" data-target="#deleteKin{{$kin->id}}">Delete</a>
                                                                                </div>
                                                                            </div>
                                                                        </td>
                                                                    </tr>
                                                                    <div class="modal fade" id="editKin{{$kin->id}}">
                                                                        <div class="modal-dialog">
                                                                            <div class="modal-content">
                                                                                <form
                                                                                    action="{{url('members/update/kin/'.$kin->id)}}"
                                                                                    method="post">
                                                                                    @csrf
                                                                                    <div class="modal-body">
                                                                                        <div class="form-group">
                                                                                            <label for="kin_name">Kin
                                                                                                Name</label>
                                                                                            <input type="text"
                                                                                                   name="kin_name"
                                                                                                   id="kin_name"
                                                                                                   class="form-control"
                                                                                                   value="{{$kin->kin_name}}">
                                                                                        </div>
                                                                                        <div class="form-group">
                                                                                            <label for="kin_id">ID
                                                                                                Number</label>
                                                                                            <input type="text"
                                                                                                   name="kin_id"
                                                                                                   id="kin_id"
                                                                                                   class="form-control"
                                                                                                   value="{{$kin->kin_id}}">
                                                                                        </div>
                                                                                        <div class="form-group">
                                                                                            <label
                                                                                                for="kin_relationship">Relationship</label>
                                                                                            <select
                                                                                                name="kin_relationship"
                                                                                                class="form-control"
                                                                                                id="kin_relationship">
                                                                                                <option>Brother</option>
                                                                                                <option>Sister</option>
                                                                                                <option>Mother</option>
                                                                                                <option>Father</option>
                                                                                                <option>Wife</option>
                                                                                                <option>Son</option>
                                                                                                <option>Daughter
                                                                                                </option>
                                                                                            </select>
                                                                                        </div>
                                                                                        <div class="form-group">
                                                                                            <label for="goodwill">Goodwill
                                                                                                %</label>
                                                                                            <input type="text"
                                                                                                   name="goodwill"
                                                                                                   class="form-control"
                                                                                                   id="goodwill"
                                                                                                   value="{{$kin->goodwill}}">
                                                                                        </div>
                                                                                        <div class="form-group">
                                                                                            <label
                                                                                                for="kin_email">Email</label>
                                                                                            <input type="email"
                                                                                                   name="kin_email"
                                                                                                   class="form-control"
                                                                                                   id="kin_email"
                                                                                                   value="{{$kin->kin_email}}">
                                                                                        </div>
                                                                                        <div class="form-group">
                                                                                            <label for="kin_phone">Phone
                                                                                                Number</label>
                                                                                            <input type="text"
                                                                                                   name="kin_phone"
                                                                                                   class="form-control"
                                                                                                   id="kin_phone"
                                                                                                   value="{{$kin->kin_phone}}">
                                                                                        </div>
                                                                                    </div>
                                                                                    <div
                                                                                        class="modal-footer justify-content-center">
                                                                                        <button
                                                                                            class="btn btn-sm btn-outline-warning btn-round"
                                                                                            data-dismiss="modal"
                                                                                            type="button">
                                                                                            Close
                                                                                        </button>
                                                                                        <button
                                                                                            class="btn btn-sm btn-outline-success btn-round"
                                                                                            type="submit">
                                                                                            Update
                                                                                        </button>
                                                                                    </div>
                                                                                </form>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="modal fade" id="deleteKin{{$kin->id}}">
                                                                        <div class="modal-dialog">
                                                                            <div class="modal-content">
                                                                                <form action="{{url('members/delete/kin/'.$kin->id)}}" method="post">
                                                                                    @csrf
                                                                                    <div class="modal-body text-center">
                                                                                        <img src="{{asset('images/delete.gif')}}" alt="delete" style="width: 200px; height: 200px">
                                                                                    </div>
                                                                                    <div class="modal-footer justify-content-center">
                                                                                        <button class="btn btn-sm btn-outline-warning btn-round">
                                                                                            Close
                                                                                        </button>
                                                                                        <button class="btn btn-sm btn-outline-danger btn-round">
                                                                                            Delete
                                                                                        </button>
                                                                                    </div>
                                                                                </form>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                @endforeach
                                                            </table>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div id="docs" class="tab-pane">
                                                    <div class="card">
                                                        <div class="card-body">

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
                </div>
            </div>
        </div>
        <div class="modal fade" id="nextOfKin">
            <div class="modal-dialog">
                <div class="modal-content">
                    <form action="{{url('/members/store/kin/'.$member->id)}}" method="post">
                        @csrf
                        <div class="modal-body">
                            <div class="form-group">
                                <label for="kin_name">Kin Name</label>
                                <input type="text" name="kin_name" id="kin_name" class="form-control">
                            </div>
                            <div class="form-group">
                                <label for="kin_id">ID Number</label>
                                <input type="text" name="kin_id" id="kin_id" class="form-control">
                            </div>
                            <div class="form-group">
                                <label for="kin_relationship">Relationship</label>
                                <select name="kin_relationship" class="form-control" id="kin_relationship">
                                    <option>Brother</option>
                                    <option>Sister</option>
                                    <option>Mother</option>
                                    <option>Father</option>
                                    <option>Wife</option>
                                    <option>Son</option>
                                    <option>Daughter</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="goodwill">Goodwill %</label>
                                <input type="text" name="goodwill" class="form-control" id="goodwill">
                            </div>
                            <div class="form-group">
                                <label for="kin_email">Email</label>
                                <input type="email" name="kin_email" class="form-control" id="kin_email">
                            </div>
                            <div class="form-group">
                                <label for="kin_phone">Phone Number</label>
                                <input type="text" name="kin_phone" class="form-control" id="kin_phone">
                            </div>
                        </div>
                        <div class="modal-footer justify-content-center">
                            <button class="btn btn-sm btn-outline-warning btn-round" data-dismiss="modal" type="button">
                                Close
                            </button>
                            <button class="btn btn-sm btn-outline-success btn-round" type="submit">
                                Submit
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script>
        function nexts(id) {
            if (id === 1) {
                $("#contact").show()
                $("#page1").hide()
                $("#kin").hide()
                $("#employment").hide()
            }
            if (id === 2) {
                $("#page1").show()
                $("#contact").hide()
                $("#kin").hide()
                $("#employment").hide()
            }
            if (id === 3) {
                $("#kin").show()
                $("#contact").hide()
                $("#page1").hide()
                $("#employment").hide()
            }
            if (id === 4) {
                $("#kin").hide()
                $("#contact").show()
                $("#page1").hide()
                $("#employment").hide()
            }
            if (id === 5) {
                $("#kin").hide()
                $("#contact").hide()
                $("#page1").hide()
                $("#employment").show()
            }
            if (id === 6) {
                $("#kin").show()
                $("#contact").hide()
                $("#page1").hide()
                $("#employment").hide()
            }
        }
    </script>
@endsection
