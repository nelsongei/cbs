@extends('layouts.main')
@section('title', 'Projection')
@section('content')
    <?php
    function asMoney($value)
    {
        return number_format($value, 2);
    }
    ?>
    <div class="page-header card">
        <div class="row align-items-end">
            <div class="col-lg-12">
                <div class="page-header-title">
                    <i class="fa fa-futbol bg-behance"></i>
                    <div class="d-inline">
                        <h5>Projection</h5>
                    </div>
                </div>
            </div>
            <div class="col-lg-12">
                <div class="page-header-breadcrumb float-left">
                    <ul class=" breadcrumb breadcrumb-title">
                        <li class="breadcrumb-item">
                            <a href="{{ url('/home') }}"><i class="feather icon-home"></i></a>
                        </li>
                        <li class="breadcrumb-item"><a href="#">Projection</a></li>
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
                                    <a href="#projection" class="active nav-link" data-toggle="tab">Projections</a>
                                </li>
                                <li class="nav-item">
                                    <a href="#category" class="nav-link" data-toggle="tab">Categories</a>
                                </li>
                            </ul>
                        </div>
                        <div class="card-body">
                            <div class="tab-content">
                                <div id="projection" class="tab-pane active">
                                    <div class="card">
                                        <div class="card-body">
                                            <button class="btn btn-sm btn-outline-success btn-round" data-toggle="modal"
                                                data-target="#projections">
                                                New Projection
                                            </button>
                                            <button class="btn btn-sm btn-round btn-outline-warning" data-toggle="modal"
                                                data-target="#projectionYear">
                                                Change Year
                                            </button>
                                            <table class="table table-striped table-bordered mt-2">
                                                <thead>
                                                    <tr>
                                                        <th></th>
                                                        <th>1<sup>st</sup> Quarter</th>
                                                        <th>2<sup>nd</sup> Quarter</th>
                                                        <th>3<sup>rd</sup> Quarter</th>
                                                        <th>4<sup>th</sup> Quarter</th>
                                                        <th>Proposed {{ $set_year }}</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @forelse($projections as $title => $values)
                                                        @if (count($values) > 0)
                                                            <tr>
                                                                <td style="font-weight: bold; text-transform: uppercase;">
                                                                    {{ $title }}</td>
                                                            </tr>
                                                            <?php
                                                            $first_q = 0;
                                                            $second_q = 0;
                                                            $third_q = 0;
                                                            $fourth_q = 0;
                                                            $total = 0;
                                                            ?>
                                                            @foreach ($values as $projection)
                                                                <tr>
                                                                    <td>{{ $projection->name }}</td>
                                                                    <td>{{ asMoney((float) $projection->first_quarter) }}
                                                                    </td>
                                                                    <td>{{ asMoney((float) $projection->second_quarter) }}
                                                                    </td>
                                                                    <td>{{ asMoney((float) $projection->third_quarter) }}
                                                                    </td>
                                                                    <td>{{ asMoney((float) $projection->fourth_quarter) }}
                                                                    </td>
                                                                    <td>{{ asMoney((int) $projection->first_quarter + (int) $projection->second_quarter + (int) $projection->third_quarter + (int) $projection->fourth_quarter) }}
                                                                    </td>
                                                                    <?php
                                                                    $first_q += (int) $projection->first_quarter;
                                                                    $second_q += (int) $projection->second_quarter;
                                                                    $third_q += (int) $projection->third_quarter;
                                                                    $fourth_q += (int) $projection->fourth_quarter;
                                                                    $total += (int) $projection->first_quarter + (int) $projection->second_quarter + (int) $projection->third_quarter + (int) $projection->fourth_quarter;
                                                                    ?>
                                                                </tr>
                                                            @endforeach
                                                            {{-- <tr>
                                                                <td></td>
                                                                <td><strong>{{ asMoney($first_q) }}</strong></td>
                                                                <td><strong>{{ asMoney($second_q) }}</strong></td>
                                                                <td><strong>{{ asMoney($third_q) }}</strong></td>
                                                                <td><strong>{{ asMoney($fourth_q) }}</strong></td>
                                                                <td><strong>{{ asMoney($total) }}</strong></td>
                                                            </tr> --}}
                                                        @endif
                                                    @empty
                                                        <tr>
                                                            <td colspan="6" align="center">
                                                                <i class="fa fa-certificate fa-5x text-success"></i>
                                                                <p>Add Projections</p>
                                                            </td>
                                                        </tr>
                                                    @endforelse
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                                <div id="category" class="tab-pane">
                                    <div class="card">
                                        <div class="card-body">
                                            <button class="btn btn-sm btn-outline-success btn-round" data-toggle="modal"
                                                data-target="#category">
                                                Add Category
                                            </button>
                                            <table class="table table-striped table-bordered mt-2">
                                                <thead>
                                                    <tr>
                                                        <th>#</th>
                                                        <th>Name</th>
                                                        <th>Type</th>
                                                        <th>Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php $count=1?>
                                                    @forelse ($categories as $category)
                                                    <tr>
                                                        <td>{{ $count++ }}</td>
                                                        <td>{{ $category->name }}</td>
                                                        <td>{{ $category->type }}</td>
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
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="projectionYear">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="{{ url('budget/projections') }}" method="get">
                    <div class="modal-body">
                        <div class="form-group col-xs-offset-1">
                            <label for="years">Year:</label>
                            <select name="year" id="years" class="form-control">
                                @foreach ($years as $t_year)
                                    <option value="{{ $t_year }}"
                                        @if ($set_year == $t_year) selected="selected" @endif>
                                        {{ $t_year }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer justify-content-center">
                        <button type="submit" class="btn btn-sm btn-round btn-outline-warning" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-sm btn-round btn-outline-success">Change</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div id="projections" class="modal fade">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <form action="{{ url('budget/projections/store') }}" method="post">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="year">Years</label>
                            <select class="form-control input-sm selectable" name="year" required>
                                @foreach ($years as $t_year)
                                    <option value="{{ $t_year }}"
                                        @if ($year == $t_year) selected="selected" @endif>{{ $t_year }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        @foreach ($projections1 as $title => $projection)
                            @if (count($projection) > 0)
                                <div class="form-group">
                                    <div class="panel-heading">
                                        <h4>{{ $title }}</h4>
                                    </div>
                                    <div class="panel-body">
                                        @foreach ($projection as $category)
                                            <h5 class="text-success">{{ $category->name }}</h5>
                                            @for ($i = 1; $i <= 4; $i++)
                                                <div class="form-group col-md-12">
                                                    <input type="number" placeholder="{{ $i }} Quarter"
                                                        class="form-control"
                                                        name="{{ $title }}[{{ $category->name }}][{{ $i }}]"
                                                        required
                                                        value="{{ old($title . '.' . $category->name . '.' . $i) }}">
                                                </div>
                                            @endfor
                                        @endforeach
                                    </div>
                                </div>
                            @endif
                        @endforeach
                    </div>
                    <div class="modal-footer justify-content-center">
                        <button class="btn btn-sm btn-outline-warning btn-round" data-dismiss="modal">
                            Close
                        </button>
                        <button class="btn btn-sm btn-outline-success btn-round">
                            Submit
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="modal fade" id="category">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="{{ url('budget/category/store') }}" method="post">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="">Type</label>
                            <select name="type" class="form-control">
                                <option>Interest</option>
                                <option>Other Income</option>
                                <option>Expenditure</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="">Name</label>
                            <input type="text" class="form-control" name="name" placeholder="Name">
                        </div>
                    </div>
                    <div class="modal-footer justify-content-center">
                        <button class="btn btn-outline-warning btn-sm btn-round" data-dismiss="modal">
                            Close
                        </button>
                        <button class="btn btn-outline-success btn-sm btn-round">
                            Add Category
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
