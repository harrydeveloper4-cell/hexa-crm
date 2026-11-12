@php
    $user = auth_staff();
@endphp
@extends('admin.layout.master')
@section('title', 'Dashboard')

@section('css')
    <style>
        .custom-way-h {
            overflow-y: scroll;
            height: 387px;
            overflow-x: hidden;
        }
    </style>
@endsection

@section('breadcrumb-title')
    <h3>{{ __('Dashboard') }}</h3>
@endsection

@section('breadcrumb-items')
    <li class="breadcrumb-item active">{{ __('Dashboard') }}</li>
@endsection
@section('content')
    <div class="row">
        <div class="col-12 col-lg-12 mt-3">
            <div class="row">
                <div class="col-12 col-lg-6">
                    <div class="row">
                        <div class="col-12 col-sm-6 mt-3">
                            <div class="card bg-primary">
                                <div class="card-body">
                                    <div class="d-flex px-0 px-lg-2 py-2 align-self-center">
                                        <i class="icon-basket icons card-liner-icon mt-2 text-white"></i>
                                        <div class="card-liner-content">
                                            <h2 class="card-liner-title text-white">$ {{ $data['all_dues'] }}</h2>
                                            <h6 class="card-liner-subtitle text-white">Total Orders
                                                ({{ $data['total_order_count'] }})</h6>
                                        </div>
                                    </div>
                                    <div id="apex_primary_chart"></div>
                                </div>
                            </div>
                        </div>

                        <div class="col-12 col-sm-6 mt-3">
                            <div class="card bg-primary">
                                <div class="card-body">
                                    <div class="d-flex px-0 px-lg-2 py-2 align-self-center">
                                        <i class="icon-basket icons card-liner-icon mt-2 text-white"></i>
                                        <div class="card-liner-content">
                                            <h2 class="card-liner-title text-white">$ {{ $data['today_dues'] }}</h2>
                                            <h6 class="card-liner-subtitle text-white">Today's Orders
                                                ({{ $data['today_order_count'] }})</h6>
                                        </div>
                                    </div>
                                    <div id="apex_primary_chart_2"></div>
                                </div>
                            </div>
                        </div>

                        <div class="col-12 col-sm-6 mt-3">
                            <div class="card">
                                <div class="card-body">
                                    <div class="d-flex px-0 px-lg-2 py-2 align-self-center">
                                        <i class="icon-bag icons card-liner-icon mt-2"></i>
                                        <div class="card-liner-content">
                                            <h2 class="card-liner-title">$ {{ $data['all_paid'] }}</h2>
                                            <h6 class="card-liner-subtitle">Total Sale
                                                ({{ $data['total_paid_count'] }})</h6>
                                        </div>
                                    </div>
                                    <div id="apex_today_profit"></div>
                                </div>
                            </div>
                        </div>

                        <div class="col-12 col-sm-6 mt-3">
                            <div class="card">
                                <div class="card-body">
                                    <div class="d-flex px-0 px-lg-2 py-2 align-self-center">
                                        <i class="icon-bag icons card-liner-icon mt-2"></i>
                                        <div class="card-liner-content">
                                            <h2 class="card-liner-title">$ {{ $data['today_paid'] }}</h2>
                                            <h6 class="card-liner-subtitle">Today's Sale
                                                ({{ $data['today_paidorder_count'] }})</h6>
                                        </div>
                                    </div>
                                    <div id="apex_today_profit_2"></div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
                <div class="col-12 col-lg-6 mt-3">
                    <div class="card">
                        <div class="card-content">
                            <div class="card-body">
                                <div id="apex_bar_chart" class="height-500"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        @if ($user->has_permission(5) || $user->role_id == 1)
            <div class="col-md-6 col-lg-6 mt-3">
                <div class="card overflow-hidden">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h6 class="card-title">New Users</h6>
                    </div>
                    <div class="card-content">
                        <div class="card-body p-0 custom-way-h">
                            <ul class="list-group list-unstyled">
                                @if (isset($all_users) && count($all_users) > 0)
                                    @foreach ($all_users as $user)
                                        <li class="p-2 border-bottom zoom">
                                            <div class="media d-flex w-100">
                                                <a href="#"><img src="https://w7.pngwing.com/pngs/81/570/png-transparent-profile-logo-computer-icons-user-user-blue-heroes-logo-thumbnail.png"
                                                        alt="" class="img-fluid ml-0 mt-2 rounded-circle"
                                                        width="40" />
                                                </a>
                                                <div class="media-body align-self-center pl-2">
                                                    <span class="mb-0 font-w-600">{{ $user->firstname }}
                                                        {{ $user->lastname }}</span><br />
                                                    <span class="mb-0 font-w-600">{{ $user->email }}</span><br />
                                                    <p class="mb-0 font-w-500 tx-s-12">{{ $user->city }},
                                                        {{ $user->state }}, {{ $user->country }}</p>
                                                </div>
                                                <div class="ml-auto my-auto">
                                                    <a href="#" data-toggle="dropdown">
                                                        <i class="icon-options icons h6 font-weight-bold"></i>
                                                    </a>
                                                    <div class="dropdown-menu dropdown-menu-right">
                                                        <!--<a href="" class="dropdown-item px-2 align-self-center d-flex"> <span class="icon-pencil mr-2 h6 mb-0"></span> Edit Profile</a>-->
                                                        <a href="{{ route('users.show', $user->id) }}"
                                                            class="dropdown-item px-2 align-self-center d-flex">
                                                            <span class="icon-user mr-2 h6 mb-0"></span> View
                                                            Profile</a>
                                                        <!--<a href="" class="dropdown-item px-2 text-danger align-self-center d-flex"> <span class="icon-trash mr-2 h6 mb-0"></span> Delete</a>-->
                                                    </div>
                                                </div>
                                            </div>
                                        </li>
                                    @endforeach
                                @endif

                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        @endif
        <div class="col-12 col-md-12 col-lg-6 mt-3">
            <div class="card">
                <div class="card-header justify-content-between align-items-center">
                    <h6 class="card-title">Sales per Brand</h6>
                </div>
                <div class="card-body table-responsive p-0">
                    <table class="table font-w-600 mb-0">
                        <thead>
                            <tr>
                                <th>Brand Name</th>
                                <th></th>
                                <th>Order</th>
                                <th>Total Sales</th>
                            </tr>
                        </thead>
                        <tbody>

                            @if ($brand_orders)
                                @foreach ($brand_orders as $temp)
                                    <tr class="zoom">
                                        <td>{{ $temp['brand_name'] }}</td>
                                        <td class="text-success"><i class="ion ion-arrow-graph-up-right"></i></td>
                                        <td class="text-danger">{{ $temp['order_status'] }} <i
                                                class="ion ion-arrow-graph-down-right"></i></td>
                                        <td class="text-info">$ {{ $temp['total_amount'] }}</td>
                                    </tr>
                                @endforeach
                            @endif

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        {{--
                <div class="col-12 col-md-12 col-lg-12 mt-3">
                    <div class="card border-bottom-0">
                        <div class="card-content border-bottom border-info border-w-5">
                            <div class="card-body">
                                <nav>
                                    <div class="nav nav-tabs font-weight-bold border-bottom" id="nav-tab" role="tablist">
                                        <a class="nav-item nav-link active" id="nav-home-tab" data-toggle="tab" href="#nav-home" role="tab" aria-controls="nav-home" aria-selected="true">Litecoin</a>
                                        <a class="nav-item nav-link" id="nav-profile-tab" data-toggle="tab" href="#nav-profile" role="tab" aria-controls="nav-profile" aria-selected="false">Stellar</a>
                                        <a class="nav-item nav-link" id="nav-contact-tab" data-toggle="tab" href="#nav-contact" role="tab" aria-controls="nav-contact" aria-selected="false">Chainlink</a>
                                    </div>
                                </nav>
                                <div class="tab-content" id="nav-tabContent">
                                    <div class="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">
                                        <div class="py-3 border-bottom border-primary">
                                            <span class="text-muted font-w-600">Litecoin Stats</span><br />
                                            <p class="mb-0 font-w-500 h3">$1,247.05</p>
                                        </div>
                                        <div class="table-responsive">
                                            <table class="table table-borderless pick-table mb-0">
                                                <thead>
                                                    <tr>
                                                        <th>Month</th>
                                                        <th class="text-right">Stats</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td>Jan</td>
                                                        <td class="text-right text-success">$80,200 <i class="ion ion-arrow-graph-up-right"></i></td>
                                                    </tr>
                                                    <tr>
                                                        <td>Fed</td>
                                                        <td class="text-right text-success">$78,410 <i class="ion ion-arrow-graph-up-right"></i></td>
                                                    </tr>
                                                    <tr>
                                                        <td>March</td>
                                                        <td class="text-right text-danger">$162,050 <i class="ion ion-arrow-graph-down-right"></i></td>
                                                    </tr>
                                                    <tr>
                                                        <td>April</td>
                                                        <td class="text-right text-success">$187,792 <i class="ion ion-arrow-graph-up-right"></i></td>
                                                    </tr>
                                                    <tr>
                                                        <td>March</td>
                                                        <td class="text-right text-danger">$13,087 <i class="ion ion-arrow-graph-down-right"></i></td>
                                                    </tr>
                                                    <tr>
                                                        <td>April</td>
                                                        <td class="text-right text-success">$23,087 <i class="ion ion-arrow-graph-up-right"></i></td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                    <div class="tab-pane fade" id="nav-profile" role="tabpanel" aria-labelledby="nav-profile-tab">
                                        <div class="py-3 border-bottom border-primary">
                                            <span class="text-muted font-w-600">Stellar Stats</span><br />
                                            <p class="mb-0 font-w-500 h3">$2,247.1205</p>
                                        </div>
                                        <div class="table-responsive">
                                            <table class="table table-borderless pick-table mb-0">
                                                <thead>
                                                    <tr>
                                                        <th>Month</th>
                                                        <th class="text-right">Stats</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td>Jan</td>
                                                        <td class="text-right text-success">$34,200 <i class="ion ion-arrow-graph-up-right"></i></td>
                                                    </tr>
                                                    <tr>
                                                        <td>Fed</td>
                                                        <td class="text-right text-success">$21,122 <i class="ion ion-arrow-graph-up-right"></i></td>
                                                    </tr>
                                                    <tr>
                                                        <td>March</td>
                                                        <td class="text-right text-danger">$12,456 <i class="ion ion-arrow-graph-down-right"></i></td>
                                                    </tr>
                                                    <tr>
                                                        <td>April</td>
                                                        <td class="text-right text-success">$44,234 <i class="ion ion-arrow-graph-up-right"></i></td>
                                                    </tr>
                                                    <tr>
                                                        <td>March</td>
                                                        <td class="text-right text-danger">$77,765 <i class="ion ion-arrow-graph-down-right"></i></td>
                                                    </tr>
                                                    <tr>
                                                        <td>April</td>
                                                        <td class="text-right text-success">$23,234 <i class="ion ion-arrow-graph-up-right"></i></td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                    <div class="tab-pane fade" id="nav-contact" role="tabpanel" aria-labelledby="nav-contact-tab">
                                        <div class="py-3 border-bottom border-primary">
                                            <span class="text-muted font-w-600">Chainlink Stats</span><br />
                                            <p class="mb-0 font-w-500 h3">$11,21,247.05</p>
                                        </div>
                                        <div class="table-responsive">
                                            <table class="table table-borderless pick-table mb-0">
                                                <thead>
                                                    <tr>
                                                        <th>Month</th>
                                                        <th class="text-right">Stats</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td>Jan</td>
                                                        <td class="text-right text-success">$20,200 <i class="ion ion-arrow-graph-up-right"></i></td>
                                                    </tr>
                                                    <tr>
                                                        <td>Fed</td>
                                                        <td class="text-right text-success">$58,410 <i class="ion ion-arrow-graph-up-right"></i></td>
                                                    </tr>
                                                    <tr>
                                                        <td>March</td>
                                                        <td class="text-right text-danger">$152,050 <i class="ion ion-arrow-graph-down-right"></i></td>
                                                    </tr>
                                                    <tr>
                                                        <td>April</td>
                                                        <td class="text-right text-success">$187,792 <i class="ion ion-arrow-graph-up-right"></i></td>
                                                    </tr>
                                                    <tr>
                                                        <td>March</td>
                                                        <td class="text-right text-danger">$13,087 <i class="ion ion-arrow-graph-down-right"></i></td>
                                                    </tr>
                                                    <tr>
                                                        <td>April</td>
                                                        <td class="text-right text-success">$23,087 <i class="ion ion-arrow-graph-up-right"></i></td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-12 col-md-6 col-lg-6 mt-3">
                    <div class="card border">
                        <div class="card-content">
                            <div class="card-body p-4">
                                <div class="d-md-flex">
                                    <div class="my-auto">
                                        <img src="{{asset('admin/dist/images/wallet.png')}}" alt="author" width="48" class="my-auto" />
                                    </div>
                                    <div class="content px-md-3 my-3 my-md-0">
                                        <span class="mb-0 font-w-600 h5">Lorem ipsum dolor sit</span><br />
                                        <p class="mb-0 font-w-500 tx-s-12">Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aenean commodo ligula eget dolor. Aenean massa. Cum sociis natoque penatibus et magnis.</p>
                                    </div>
                                    <div class="my-auto">
                                        <a href="#" class="btn btn-outline-primary font-w-600 my-auto text-nowrap">Get More</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-12 col-md-6 col-lg-6 mt-3">
                    <div class="card outline-badge-primary">
                        <div class="card-content">
                            <div class="card-body p-4">
                                <div class="d-md-flex">
                                    <div class="my-auto">
                                        <img src="{{asset('admin/dist/images/money.png')}}" alt="author" class="my-auto" />
                                    </div>
                                    <div class="content px-md-3 my-3 my-md-0">
                                        <span class="mb-0 font-w-600 h5">Lorem ipsum dolor sit</span><br />
                                        <p class="mb-0 font-w-500 tx-s-12">Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aenean commodo ligula eget dolor. Aenean massa. Cum sociis natoque penatibus et magnis.</p>
                                    </div>
                                    <div class="my-auto">
                                        <a href="#" class="btn btn-outline-primary font-w-600 my-auto text-nowrap">Get More</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                --}}

    </div>
@endsection
@section('scripts')
    <script src="{{ asset('admin/dist/vendors/apexcharts/apexcharts.min.js') }}"></script>
    <script>
        var theme = "light";
        if ($("#apex_bar_chart").length > 0) {
            options = {
                theme: {
                    mode: theme,
                },
                grid: {
                    yaxis: {
                        lines: {
                            show: false,
                        },
                    },
                },
                chart: {
                    height: 318,
                    type: "bar",
                },
                plotOptions: {
                    bar: {
                        horizontal: true,
                        columnWidth: "10",
                    },
                },
                dataLabels: {
                    enabled: false,
                },
                colors: ["#1e3d73"],
                series: [{
                    data: [{{ $data['months_report_amount'] }}],
                }, ],
                xaxis: {
                    categories: [<?= $data['months_report_name'] ?>],
                },
            };

            var chart = new ApexCharts(document.querySelector("#apex_bar_chart"), options);
            chart.render();
        }

        if ($("#apex_primary_chart").length > 0) {
            options = {
                chart: {
                    type: "line",
                    height: 80,
                    sparkline: {
                        enabled: true,
                    },
                    dropShadow: {
                        enabled: true,
                        top: 1,
                        left: 1,
                        blur: 2,
                        color: "#ef4336",
                        opacity: 0.7,
                    },
                },
                series: [{
                    data: [{{ $data['total_order_generated'] }}],
                }, ],
                stroke: {
                    curve: "smooth",
                    width: 2,
                },
                markers: {
                    size: 0,
                },
                grid: {
                    padding: {
                        top: 0,
                        bottom: 0,
                        left: 0,
                    },
                },
                colors: ["#ef4336"],
                tooltip: {
                    x: {
                        show: false,
                    },
                    y: {
                        title: {
                            formatter: function formatter(val) {
                                return "";
                            },
                        },
                    },
                },
                responsive: [{
                        breakpoint: 1351,
                        options: {
                            chart: {
                                height: 95,
                            },
                            grid: {
                                padding: {
                                    top: 35,
                                    bottom: 0,
                                    left: 0,
                                },
                            },
                        },
                    },
                    {
                        breakpoint: 1200,
                        options: {
                            chart: {
                                height: 80,
                            },
                            grid: {
                                padding: {
                                    top: 35,
                                    bottom: 0,
                                    left: 40,
                                },
                            },
                        },
                    },
                    {
                        breakpoint: 576,
                        options: {
                            chart: {
                                height: 95,
                            },
                            grid: {
                                padding: {
                                    top: 45,
                                    bottom: 0,
                                    left: 0,
                                },
                            },
                        },
                    },
                ],
            };

            var chart = new ApexCharts(document.querySelector("#apex_primary_chart"), options);
            chart.render();
        }
        if ($("#apex_primary_chart_2").length > 0) {
            options = {
                chart: {
                    type: "line",
                    height: 80,
                    sparkline: {
                        enabled: true,
                    },
                    dropShadow: {
                        enabled: true,
                        top: 1,
                        left: 1,
                        blur: 2,
                        color: "#d9f3fd",
                        opacity: 0.7,
                    },
                },
                series: [{
                    data: [{{ $data['today_order_generated'] }}],
                }, ],
                stroke: {
                    curve: "smooth",
                    width: 2,
                },
                markers: {
                    size: 0,
                },
                grid: {
                    padding: {
                        top: 0,
                        bottom: 0,
                        left: 0,
                    },
                },
                colors: ["#d9f3fd"],
                tooltip: {
                    x: {
                        show: false,
                    },
                    y: {
                        title: {
                            formatter: function formatter(val) {
                                return "";
                            },
                        },
                    },
                },
                responsive: [{
                        breakpoint: 1351,
                        options: {
                            chart: {
                                height: 95,
                            },
                            grid: {
                                padding: {
                                    top: 35,
                                    bottom: 0,
                                    left: 0,
                                },
                            },
                        },
                    },
                    {
                        breakpoint: 1200,
                        options: {
                            chart: {
                                height: 80,
                            },
                            grid: {
                                padding: {
                                    top: 35,
                                    bottom: 0,
                                    left: 40,
                                },
                            },
                        },
                    },
                    {
                        breakpoint: 576,
                        options: {
                            chart: {
                                height: 95,
                            },
                            grid: {
                                padding: {
                                    top: 45,
                                    bottom: 0,
                                    left: 0,
                                },
                            },
                        },
                    },
                ],
            };

            var chart = new ApexCharts(document.querySelector("#apex_primary_chart_2"), options);
            chart.render();
        }
        if ($("#apex_today_profit").length > 0) {
            options = {
                chart: {
                    type: "line",
                    height: 80,
                    sparkline: {
                        enabled: true,
                    },
                    dropShadow: {
                        enabled: true,
                        top: 1,
                        left: 1,
                        blur: 2,
                        color: "#f89938",
                        opacity: 0.7,
                    },
                },
                series: [{
                    data: [{{ $data['total_paid_generated'] }}],
                }, ],
                stroke: {
                    curve: "smooth",
                    width: 2,
                },
                markers: {
                    size: 0,
                },
                grid: {
                    padding: {
                        top: 0,
                        bottom: 0,
                        left: 0,
                    },
                },
                colors: ["#f89938"],
                tooltip: {
                    x: {
                        show: false,
                    },
                    y: {
                        title: {
                            formatter: function formatter(val) {
                                return "";
                            },
                        },
                    },
                },
                responsive: [{
                        breakpoint: 1351,
                        options: {
                            chart: {
                                height: 95,
                            },
                            grid: {
                                padding: {
                                    top: 35,
                                    bottom: 0,
                                    left: 0,
                                },
                            },
                        },
                    },
                    {
                        breakpoint: 1200,
                        options: {
                            chart: {
                                height: 80,
                            },
                            grid: {
                                padding: {
                                    top: 35,
                                    bottom: 0,
                                    left: 40,
                                },
                            },
                        },
                    },
                    {
                        breakpoint: 576,
                        options: {
                            chart: {
                                height: 95,
                            },
                            grid: {
                                padding: {
                                    top: 45,
                                    bottom: 0,
                                    left: 0,
                                },
                            },
                        },
                    },
                ],
            };

            var chart = new ApexCharts(document.querySelector("#apex_today_profit"), options);
            chart.render();
        }
        if ($("#apex_today_profit_2").length > 0) {
            options = {
                chart: {
                    type: "line",
                    height: 80,
                    sparkline: {
                        enabled: true,
                    },
                    dropShadow: {
                        enabled: true,
                        top: 1,
                        left: 1,
                        blur: 2,
                        color: "#ef4336",
                        opacity: 0.7,
                    },
                },
                series: [{
                    data: [{{ $data['today_paidorder_generated'] }}],
                }, ],
                stroke: {
                    curve: "smooth",
                    width: 2,
                },
                markers: {
                    size: 0,
                },
                grid: {
                    padding: {
                        top: 0,
                        bottom: 0,
                        left: 0,
                    },
                },
                colors: ["#ef4336"],
                tooltip: {
                    x: {
                        show: false,
                    },
                    y: {
                        title: {
                            formatter: function formatter(val) {
                                return "";
                            },
                        },
                    },
                },
                responsive: [{
                        breakpoint: 1351,
                        options: {
                            chart: {
                                height: 95,
                            },
                            grid: {
                                padding: {
                                    top: 35,
                                    bottom: 0,
                                    left: 0,
                                },
                            },
                        },
                    },
                    {
                        breakpoint: 1200,
                        options: {
                            chart: {
                                height: 80,
                            },
                            grid: {
                                padding: {
                                    top: 35,
                                    bottom: 0,
                                    left: 40,
                                },
                            },
                        },
                    },
                    {
                        breakpoint: 576,
                        options: {
                            chart: {
                                height: 95,
                            },
                            grid: {
                                padding: {
                                    top: 45,
                                    bottom: 0,
                                    left: 0,
                                },
                            },
                        },
                    },
                ],
            };

            var chart = new ApexCharts(document.querySelector("#apex_today_profit_2"), options);
            chart.render();
        }
    </script>
@endsection
