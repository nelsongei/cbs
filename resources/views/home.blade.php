@extends('layouts.main')
@section('title','Dashboard')
@section('content')
    <div class="page-header card">
        <div class="row align-items-end">
            <div class="col-lg-12">
                <div class="page-header-title">
                    <i class="feather icon-home bg-c-blue"></i>
                    <div class="d-inline">
                        <h5>{{Auth::user()->organization->name}}</h5>
                        <span>Dashboard</span>
                    </div>
                </div>
            </div>
            <div class="col-lg-12">
                <div class="page-header-breadcrumb float-left">
                    <ul class=" breadcrumb breadcrumb-title">
                        <li class="breadcrumb-item">
                            <a href="{{ url('/home')}}"><i class="feather icon-home"></i></a>
                        </li>
                        <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <div class="pcoded-inner-content">
        <div class="main-page">
            <div class="page-wrapper">
                <div class="page-body">
                    <div class="col-xl-12">
                        <div class="row">
                            <div class="col-xl-3 col-md-6">
                                <div class="card prod-p-card" style="background-color: #6dd144">
                                    <div class="card-body">
                                        <div class="row align-items-center m-b-30">
                                            <div class="col">
                                                <h6 class="m-b-5 text-white">Members</h6>
                                                <h3 class="m-b-0 f-w-700 text-white">0</h3>
                                            </div>
                                            <div class="col-auto">
                                                <i class="fas fa-users f-18" style="color: #6dd144"></i>
                                            </div>
                                        </div>
                                        <p class="m-b-0 text-white"><span class="label m-r-10" style="">+12%</span>From
                                            Previous Month</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-3 col-md-6">
                                <div class="card prod-p-card" style="background-color: #644ec5">
                                    <div class="card-body">
                                        <div class="row align-items-center m-b-30">
                                            <div class="col">
                                                <h6 class="m-b-5 text-white">Loans</h6>
                                                <h3 class="m-b-0 f-w-700 text-white">0</h3>
                                            </div>
                                            <div class="col-auto">
                                                <i class="fas fa-copy f-18" style="color: #644ec5"></i>
                                            </div>
                                        </div>
                                        <p class="m-b-0 text-white"><span class="label m-r-10">+12%</span>From
                                            Previous Month</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-3 col-md-6">
                                <div class="card prod-p-card card-primary">
                                    <div class="card-body">
                                        <div class="row align-items-center m-b-30">
                                            <div class="col">
                                                <h6 class="m-b-5 text-white">Dividends</h6>
                                                <h3 class="m-b-0 f-w-700 text-white">0</h3>
                                            </div>
                                            <div class="col-auto">
                                                <i class="fas fa-print text-c-blue f-18"></i>
                                            </div>
                                        </div>
                                        <p class="m-b-0 text-white"><span class="label label-primary m-r-10">+12%</span>From
                                            Previous Month</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-3 col-md-6">
                                <div class="card prod-p-card" style="background-color: #ff8d34">
                                    <div class="card-body">
                                        <div class="row align-items-center m-b-30">
                                            <div class="col">
                                                <h6 class="m-b-5 text-white">Users</h6>
                                                <h3 class="m-b-0 f-w-700 text-white">0</h3>
                                            </div>
                                            <div class="col-auto">
                                                <i class="fas fa-user f-18" style="color: #ff8d34"></i>
                                            </div>
                                        </div>
                                        <p class="m-b-0 text-white"><span class="label m-r-10">+12%</span>From
                                            Previous Month</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xl-4 col-md-12">
                                <div class="card">
                                    <div class="card-header">
                                        <h3 class="title">Gender Count</h3>
                                    </div>
                                    <div class="card-body" style="justify-content: center;display: flex;">
                                        <canvas id="gender" height="400vw" width="400vw"></canvas>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-4 col-md-12">
                                <div class="card">
                                    <div class="card-header">
                                        Loan Released
                                    </div>
                                    <div class="card-body" style="justify-content: center;display: flex;">
                                        <canvas id="loanReleased" height="150px" width="400vw"></canvas>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-4 col-md-12">
                                <div class="card">
                                    <div class="card-header">
                                        Loan Collections
                                    </div>
                                    <div class="card-body">
                                        <div class="card-body" style="justify-content: center;display: flex;">
                                            <canvas id="loanCollection" height="150px" width="400vw"></canvas>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-4 col-md-12">
                                <div class="card">
                                    <div class="card-body">
                                        <canvas id="fullyPaid" height="150px" width="400vw"></canvas>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-4 col-md-12">
                                <div class="card">
                                    <div class="card-body">
                                        <canvas id="expenses" height="150px" width="400vw"></canvas>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="{{asset('js/pureknob.js')}}" type="text/javascript"></script>
    <script>
        const ctx = document.getElementById('gender');

        new Chart(ctx, {
            type: 'doughnut',
            data: {
                labels: ['Male', 'Female',],
                datasets: [{
                    label: '# Gender Count',
                    data: [12, 19],
                    borderWidth: 1
                }]
            },
            options: {
                responsive: false,
                scales: {
                    y: {
                        beginAtZero: true,
                        display: false,
                    }
                }
            }
        });
    </script>
    <script>
        const loanReleased = document.getElementById('loanReleased');

        new Chart(loanReleased, {
            type: 'line',
            data: {
                labels: ['January', 'Feb','March','April','May','June','July'],
                datasets: [{
                    label: '# Loans Released',
                    data: [12000, 19000,5000,7000,18900,1820,10000],
                    backgroundColor: [
                        '#6dd144',
                        // 'rgba(255, 159, 64, 0.2)'
                    ],
                    borderColor: [
                        '#6dd144',
                    ],
                    borderWidth: 2
                }]
            },
            options: {
             //   responsive: false,
                scales: {
                    y: {
                        beginAtZero: true
                    }
                },
                elements: {
                    line: {
                        tension: 0.5
                    }
                }
            }
        });
    </script>
    <script>
        const loanCollection = document.getElementById('loanCollection');

        new Chart(loanCollection, {
            type: 'line',
            data: {
                labels: ['January', 'Feb','March','April','May','June','July'],
                datasets: [{
                    label: '# Loans Collection',
                    data: [12000, 19000,5000,7000,18900,1820,10000],
                    backgroundColor: [
                        '#644ec5',
                        // 'rgba(255, 159, 64, 0.2)'
                    ],
                    borderColor: [
                        '#644ec5',
                    ],
                    borderWidth: 2
                }]
            },
            options: {
             //   responsive: false,
                scales: {
                    y: {
                        beginAtZero: true
                    }
                },
                elements: {
                    line: {
                        tension: 0.5
                    }
                }
            }
        });
    </script>
    <script>
        const fullyPaid = document.getElementById('fullyPaid');

        new Chart(fullyPaid, {
            type: 'line',
            data: {
                labels: ['January', 'Feb','March','April','May','June','July'],
                datasets: [{
                    label: '# Fully Paid',
                    data: [12000, 19000,5000,7000,18900,1820,10000],
                    backgroundColor: [
                        '#ff8d34',
                        // 'rgba(255, 159, 64, 0.2)'
                    ],
                    borderColor: [
                        '#ff8d34',
                    ],
                    borderWidth: 2
                }]
            },
            options: {
             //   responsive: false,
                scales: {
                    y: {
                        beginAtZero: true
                    }
                },
                elements: {
                    line: {
                        tension: 0.5
                    }
                }
            }
        });
    </script>
        <script>
            const expenses = document.getElementById('expenses');
            new Chart(expenses, {
                // type: 'line',
                data: {
                    labels: ['January', 'Feb','March','April','May','June','July'],
                    datasets:[{
                        type: 'line',
                        label:'Expenses',
                        data: [12000, 19000,5000,7000,18900,1820,10000],
                        backgroundColor:[
                            '#6dd144'
                        ],
                        borderColor:[
                            '#6dd144'
                        ],
                        borderWidth: 2
                    },
                    {
                        type: 'line',
                        label:'Income',
                        data: [1000, 1000,50000,70000,1800,11820,1000],
                        backgroundColor:[
                            '#ff8d34',
                        ],
                        borderColor:[
                            '#ff8d34',
                        ],
                        borderWidth: 2
                    }
                ]
                },
                options: {
                 //   responsive: false,
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    },
                    elements: {
                        line: {
                            tension: 0.5
                        }
                    }
                }
            });
        </script>
@endsection
