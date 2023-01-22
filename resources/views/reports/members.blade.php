@extends('layouts.main')
@section('title', 'Member Reports')
@section('content')
    <div class="page-header card">
        <div class="row align-items-end">
            <div class="col-lg-12">
                <div class="page-header-title">
                    <i class="feather icon-users bg-success"></i>
                    <div class="d-inline">
                        <h5>Members Reports</h5>
                    </div>
                </div>
            </div>
            <div class="col-lg-12">
                <div class="page-header-breadcrumb float-left">
                    <ul class=" breadcrumb breadcrumb-title">
                        <li class="breadcrumb-item">
                            <a href="{{ url('/home') }}"><i class="feather icon-home"></i></a>
                        </li>
                        <li class="breadcrumb-item"><a href="#">Reports</a></li>
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
                                data-target="#memberlisting">
                                Member Listing
                            </button>
                            <button class="btn btn-sm btn-outline-info btn-round">
                                Member Comprehesive Statement
                            </button>
                            <button class="btn btn-sm btn-outline-warning btn-round">
                                Blank Report
                            </button>
                            <button class="btn btn-sm btn-outline-danger btn-round">
                                Monthly Deduction Report
                            </button>
                            <table class="table table-striped table-bordered mt-2">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Member Number</th>
                                        <th>Member Name</th>
                                        <th>Email</th>
                                        <th>Phone</th>
                                        <th>Member Group</th>
                                        <th>Member Branch</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $count = 1; ?>
                                    @forelse ($members as $member)
                                        <tr>
                                            <td>{{ $count++ }}</td>
                                            <td>{{ $member->membership_no }}</td>
                                            <td>{{ $member->firstname . ' ' . $member->lastname }}</td>
                                            <td>{{ $member->email }}</td>
                                            <td>{{ $member->phone }}</td>
                                            <td>{{ $member->group->name }}</td>
                                            <td>{{ $member->branch->name }}</td>
                                        </tr>
                                    @empty
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="memberlisting">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="">
                    <div class="modal-body"></div>
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
@endsection
