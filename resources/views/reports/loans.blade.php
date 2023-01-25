@extends('layouts.main')
@section('title', 'Loan Reports')
@section('content')
    <div class="page-header card">
        <div class="row align-items-end">
            <div class="col-lg-12">
                <div class="page-header-title">
                    <i class="feather icon-cpu bg-success"></i>
                    <div class="d-inline">
                        <h5>Loan Reports</h5>
                    </div>
                </div>
            </div>
            <div class="col-lg-12">
                <div class="page-header-breadcrumb float-left">
                    <ul class=" breadcrumb breadcrumb-title">
                        <li class="breadcrumb-item">
                            <a href="{{ url('/home') }}"><i class="feather icon-home"></i></a>
                        </li>
                        <li class="breadcrumb-item"><a href="#">Loan Reports</a></li>
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
                                <div class="col-sm-1">
                                    <button class="btn btn-sm btn-round btn-outline-success">
                                        Export Report
                                    </button>
                                </div>
                                <div class="col-sm-3">
                                    <div class="form-inline">
                                        <div class="form-group">
                                            <input type="text" class="form-control datepicker42" placeholder="Filter By Year" style="border-top-left-radius: 4px;border-bottom-left-radius: 4px;">
                                            <button type="button" class="btn btn-sm btn-outline-primary" style="height: 35px;border-top-right-radius: 4px;border-bottom-right-radius: 4px;">
                                                <i class="fas fa-search"></i>
                                            </button>
                                        </div>
                                    </div>                                    
                                </div>
                            </div>

                            {{-- <div class="row">
                                <div class="form-group float-right">
                                    <div class="form-outline">
                                        <input type="search" id="form1" class="form-control" />
                                        <label class="form-label" for="form1">Search</label>
                                    </div>
                                    <button type="button" class="btn btn-outline-primary">
                                        <i class="fas fa-search"></i>
                                    </button>
                                </div>
                            </div> --}}
                            <div class="row mt-2">
                                <div class="col-sm-4">
                                    <div class="card">
                                        <div class="card-body">
                                            <canvas id="expenses" height="150px" width="400vw"></canvas>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="card">
                                        <div class="card-body">
                                            <canvas id="loanReleased" height="150px" width="400vw"></canvas>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="card">
                                        <div class="card-body">
                                            <canvas id="loanCollection" height="150px" width="400vw"></canvas>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="card">
                                        <div class="card-body" style="justify-content: center;display: flex;">
                                            <canvas id="gender" height="250vw" width="400vw"></canvas>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="card">
                                        <div class="card-body">
                                            <canvas id="fullyPaid" height="150px" width="400vw"></canvas>
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
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        const fullyPaid = document.getElementById('fullyPaid');

        new Chart(fullyPaid, {
            type: 'line',
            data: {
                labels: ['January', 'Feb', 'March', 'April', 'May', 'June', 'July'],
                datasets: [{
                    label: '# Fully Paid',
                    data: [12000, 19000, 5000, 7000, 18900, 1820, 10000],
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
        const ctx = document.getElementById('gender');

        new Chart(ctx, {
            type: 'doughnut',
            data: {
                labels: ['Apprived', 'Rejected', ],
                datasets: [{
                    label: '# Gender Count',
                    data: [12, 19],
                    backgroundColor: [
                        '#6dd144',
                        '#ff8d34',
                    ],
                    borderColor: [
                        '#6dd144',
                        '#ff8d34',
                    ],
                    borderWidth: 2
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
        const expenses = document.getElementById('expenses');
        new Chart(expenses, {
            // type: 'line',
            data: {
                labels: ['January', 'Feb', 'March', 'April', 'May', 'June', 'July'],
                datasets: [{
                        type: 'line',
                        label: 'Repayment',
                        data: [12000, 19000, 5000, 7000, 18900, 1820, 10000],
                        backgroundColor: [
                            '#6dd144'
                        ],
                        borderColor: [
                            '#6dd144'
                        ],
                        borderWidth: 2
                    },
                    {
                        type: 'line',
                        label: 'Borrowing',
                        data: [1000, 1000, 50000, 70000, 1800, 11820, 1000],
                        backgroundColor: [
                            '#ff8d34',
                        ],
                        borderColor: [
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
    <script>
        const loanReleased = document.getElementById('loanReleased');

        new Chart(loanReleased, {
            type: 'line',
            data: {
                labels: ['January', 'Feb', 'March', 'April', 'May', 'June', 'July'],
                datasets: [{
                    label: '# Loans Approved',
                    data: [12000, 19000, 5000, 7000, 18900, 1820, 10000],
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
                labels: ['January', 'Feb', 'March', 'April', 'May', 'June', 'July'],
                datasets: [{
                    label: '# Loans Collection',
                    data: [12000, 19000, 5000, 7000, 18900, 1820, 10000],
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
@endsection
