@extends('layouts.main')
@section('title','Members')
@section('content')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
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
                        <h5>Members</h5>
                    </div>
                </div>
            </div>
            <div class="col-lg-12">
                <div class="page-header-breadcrumb float-left">
                    <ul class=" breadcrumb breadcrumb-title">
                        <li class="breadcrumb-item">
                            <a href="{{ url('/home')}}"><i class="feather icon-home"></i></a>
                        </li>
                        <li class="breadcrumb-item"><a href="#">Members</a></li>
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
                            <button class="btn btn-sm btn-outline-primary btn-round" data-toggle="modal"
                                    data-target="#addMember">
                                Register Member
                            </button>
                            <table class="table table-striped table-bordered mt-2">
                                <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Title</th>
                                    <th>Name</th>
                                    <th>Membership No</th>
                                    <th>Email</th>
                                    <th>Phone</th>
                                    <th>Branch</th>
                                    <th>Group</th>
                                    <th>Address</th>
                                    <th>Active</th>
                                    <th>Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php

                                $count = 1;
                                ?>
                                @forelse($members as $member)
                                    <tr>
                                        <td>{{$count++}}</td>
                                        <td>{{$member->title}}</td>
                                        <td>
                                            <a href="{{url('members/view/'.$member->id)}}">
                                                {{$member->firstname.' '.$member->lastname}}
                                            </a>
                                        </td>
                                        <td>
                                            <a href="{{url('members/view/'.$member->id)}}">
                                                {{$member->membership_no}}
                                            </a>
                                        </td>
                                        <td>{{$member->contact->email}}</td>
                                        <td>{{$member->contact->phone}}</td>
                                        <td>{{$member->branch->name}}</td>
                                        <td>{{$member->group->name}}</td>
                                        <td>{{$member->contact->address}}</td>
                                        <td>
                                            @if($member->is_active ==1)
                                                <button class="btn btn-sm btn-outline-success btn-round">
                                                    Active
                                                </button>
                                            @else
                                                <button class="btn btn-sm btn-outline-secondary btn-round">
                                                    InActive
                                                </button>
                                            @endif
                                        </td>
                                        <td>
                                            <div class="dropdown">
                                                <button class="btn btn-outline-success btn-round dropdown-toggle"
                                                        type="button" id="dropdownMenuButton" data-toggle="dropdown"
                                                        aria-haspopup="true" aria-expanded="false">
                                                    action
                                                </button>
                                                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                                    <a class="dropdown-item text-success"
                                                       href="{{url('members/view/'.$member->id)}}">View</a>
                                                    <a class="dropdown-item text-info" href="#">Edit</a>
                                                    <a class="dropdown-item text-danger" href="#">Delete</a>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="11" align="center">
                                            <i class="fa fa-users fa-5x text-success"></i>
                                            <p>Add Members</p>
                                        </td>
                                    </tr>
                                @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="addMember">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h1>Member Registration</h1>
                </div>
                <form id="formData">
                    <div id="page1">
                        <div class="modal-body">
                            <h3 class="text-info">Bio Data</h3>
                            <div class="row">
                                <div class="form-group col-md-4">
                                    <label for="title">Title</label>
                                    <select name="title" class="form-control" id="title">
                                        <option>Mr</option>
                                        <option>Mrs</option>
                                        <option>Miss</option>
                                        <option>Ms</option>
                                    </select>
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="membership_no">Membership No</label>
                                    <input type="text" id="membership_no" name="membership_no" class="form-control"
                                           readonly value="{{'Lixnet -- '.rand(1,10000)}}">
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="id_no">ID No</label>
                                    <input type="text" id="id_no" name="id_no" class="form-control">
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="firstname">Firstnane</label>
                                    <input type="text" name="firstname" id="firstname" class="form-control">
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="middlename">Middlename</label>
                                    <input type="text" name="middlename" id="middlename" class="form-control">
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="lastname">Lastname</label>
                                    <input type="text" name="lastname" id="lastname" class="form-control">
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="gender">Gender</label>
                                    <select name="gender" class="form-control" id="gender">
                                        <option>Male</option>
                                        <option>Female</option>
                                    </select>
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="nationality">Nationality</label>
                                    <input type="text" name="nationality" id="nationality" class="form-control">
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="dob">DOB</label>
                                    <input type="date" name="dob" id="dob" class="form-control" max="{{$today}}">
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="marital_status">Marital Status</label>
                                    <select name="marital_status" class="form-control" id="marital_status">
                                        <option>Married</option>
                                        <option>Single</option>
                                        <option>Windowed</option>
                                    </select>
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="group_id">Member Group</label>
                                    <select name="group_id" class="form-control" id="group_id">
                                        @foreach($groups as $group)
                                            <option value="{{$group->id}}">{{$group->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="branch_id">Member Branch</label>
                                    <select name="branch_id" class="form-control" id="branch_id">
                                        @foreach($branches as $branch)
                                            <option value="{{$branch->id}}">{{$branch->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer justify-content-center">
                            <button class="btn btn-sm btn-outline-warning btn-round" data-dismiss="modal">
                                Close
                            </button>
                            <button class="btn btn-sm btn-outline-success btn-round" type="button" onclick="nexts(1)">
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
                                    <input type="email" id="email" name="email" class="form-control">
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="phone">Phone Number</label>
                                    <input type="text" id="phone" name="phone" class="form-control">
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="address">Address</label>
                                    <input type="text" id="address" name="address" class="form-control">
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="postal">Postal Code</label>
                                    <input type="text" id="postal" name="postal" class="form-control">
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer justify-content-center">
                            <button class="btn btn-sm btn-outline-warning btn-round" type="button" onclick="nexts(2)">
                                previous
                            </button>
                            <button class="btn btn-sm btn-outline-success btn-round" type="button" onclick="nexts(3)">
                                Next
                            </button>
                        </div>
                    </div>
                    <div id="kin" style="display: none">
                        <div class="modal-body">
                            <h3 class="text-info">Kin Data</h3>
                            <div class="row">
                                <div class="form-group col-md-6">
                                    <label for="kin_name">Name</label>
                                    <input type="text" id="kin_name" name="kin_name" class="form-control">
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="kin_email">Email</label>
                                    <input type="text" id="kin_email" name="kin_email" class="form-control">
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="kin_phone">Phone Number</label>
                                    <input type="text" id="kin_phone" name="kin_phone" class="form-control">
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="relationship">Relationship</label>
                                    <select name="relationship" class="form-control" id="relationship">
                                        <option>Mother</option>
                                        <option>Father</option>
                                        <option>Wife</option>
                                        <option>Brother</option>
                                        <option>Sister</option>
                                        <option>Son</option>
                                        <option>Daughter</option>
                                    </select>
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="kin_id">ID Number</label>
                                    <input type="text" name="kin_id" id="kin_id" class="form-control">
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="goodwill">Goodwill %</label>
                                    <input type="text" name="goodwill" class="form-control" id="goodwill">
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer justify-content-center">
                            <button class="btn btn-sm btn-outline-warning btn-round" type="button" onclick="nexts(4)">
                                previous
                            </button>
                            <button class="btn btn-sm btn-outline-success btn-round" type="button" onclick="nexts(5)">
                                Next
                            </button>
                        </div>
                    </div>
                    <div id="employment" style="display: none">
                        <div class="modal-body">
                            <h3 class="text-info">Employment Data</h3>
                            <div class="row">
                                <div class="form-group col-md-4">
                                    <label for="is_employed">Employed</label>
                                    <input type="checkbox" id="is_employed" name="is_employed" class="form-control">
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="employer_name">Employer Name</label>
                                    <input type="text" id="employer_name" name="employer_name" class="form-control">
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="employment_type">Employment Type</label>
                                    <select name="employment_type" class="form-control" id="employment_type">
                                        <option>Contract</option>
                                        <option>Permanent</option>
                                        <option>Internship</option>
                                    </select>
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="designation">Designation</label>
                                    <input type="text" id="designation" name="designation" class="form-control">
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="employment_date">Employment Date</label>
                                    <input type="date" id="employment_date" name="employment_date" class="form-control">
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="employer_address">Employer Address</label>
                                    <input type="text" id="employer_address" name="employer_address"
                                           class="form-control">
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer justify-content-center">
                            <button class="btn btn-sm btn-outline-warning btn-round" type="button" onclick="nexts(6)">
                                previous
                            </button>
                            <button class="btn btn-sm btn-outline-success btn-round" type="submit">
                                Submit
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <script>
        function SearchEmployees() {
        }

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
    <script>
        document.getElementById('formData').addEventListener('submit', (event) => {
            event.preventDefault();
            const memberData = {
                firstname: document.getElementById('firstname').value,
                middlename: document.getElementById('middlename').value,
                lastname: document.getElementById('lastname').value,
                gender: document.getElementById('gender').value,
                nationality: document.getElementById('nationality').value,
                title: document.getElementById('title').value,
                membership_no: document.getElementById('membership_no').value,
                id_no: document.getElementById('id_no').value,
                marital_status: document.getElementById('marital_status').value,
                group_id: document.getElementById('group_id').value,
                branch_id: document.getElementById('branch_id').value,
                email: document.getElementById('email').value,
                phone: document.getElementById('phone').value,
                address: document.getElementById('address').value,
                postal: document.getElementById('postal').value,
                kin_name: document.getElementById('kin_name').value,
                kin_email: document.getElementById('kin_email').value,
                relationship: document.getElementById('relationship').value,
                is_employed: document.getElementById('is_employed').value,
                employer_name: document.getElementById('employer_name').value,
                employment_type: document.getElementById('employment_type').value,
                designation: document.getElementById('designation').value,
                employment_date: document.getElementById('employment_date').value,
                employer_address: document.getElementById('employer_address').value,
                dob: document.getElementById('dob').value,
                kin_phone: document.getElementById('kin_phone').value,
                kin_id: document.getElementById('kin_id').value,
                goodwill: document.getElementById('goodwill').value,
            };
            $.ajax({
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                type: "POST",
                url: "members/store",
                data: memberData,
                success: function (response) {
                    if ($.isEmptyObject(response.failed)) {
                        toastr.success(response.success)
                        window.location.reload();
                    } else {
                        $.each(response.failed, function (key, value) {
                            toastr.warning(value);
                        })
                    }
                }
            })
        })
    </script>
@endsection
