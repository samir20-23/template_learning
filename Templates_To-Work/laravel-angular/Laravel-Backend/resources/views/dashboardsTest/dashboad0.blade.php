 @extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <h1 class="font-weight-bold text-dark">Dashboard Overview</h1>
@stop

@section('css')
    <style>
        .card-custom {
            border-radius: 15px;
            overflow: hidden;
            transition: all 0.3s ease;
            position: relative;
        }

        .card-custom:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2) !important;
        }

        .small-box {
            position: relative;
            overflow: hidden;
        }

        .chart-overlay {
            position: absolute;
            bottom: 0;
            right: 0;
            width: 100%;
            height: 60px;
            opacity: 0.3;
            z-index: 1;
        }

        .inner {
            position: relative;
            z-index: 2;
        }

        .icon {
            position: absolute;
            top: 15px;
            right: 15px;
            z-index: 2;
            opacity: 0.3;
        }

        .progress-ring {
            position: absolute;
            top: 10px;
            right: 10px;
            width: 50px;
            height: 50px;
        }

        .dark-mode {
            background-color: #2c3e50;
            color: #ecf0f1;
        }

        .dark-mode .card {
            background-color: #34495e;
            border-color: #34495e;
        }

        .stats-trend {
            font-size: 0.8rem;
            margin-top: 5px;
        }

        .trend-up {
            color: #28a745;
        }

        .trend-down {
            color: #dc3545;
        }

        .mini-chart-container {
            height: 80px;
            width: 100%;
            position: absolute;
            bottom: 0;
            left: 0;
            opacity: 0.2;
        }
    </style>
@stop

@section('content')
    <!-- Statistics Cards Row -->
    <div class="row mb-4">
        <!-- Documents Card -->
        <div class="col-lg-3 col-md-6 mb-4">
            <div class="small-box bg-info card-custom shadow-lg">
                <div class="inner p-3">
                    <h3 class="display-4 text-white">{{ $totalDocuments }}</h3>
                    <p class="lead text-white">Total Documents</p>
                    <div class="stats-trend text-white">
                        <i class="fas fa-arrow-up trend-up"></i> +12% from last month
                    </div>
                </div>
                <div class="icon">
                    <i class="fas fa-file fa-3x"></i>
                </div>
                <div class="mini-chart-container">
                    <canvas id="docTrendChart"></canvas>
                </div>
                <a href="{{ route('documents.index') }}" class="small-box-footer bg-info text-white">
                    View Documents <i class="fas fa-arrow-circle-right"></i>
                </a>
            </div>
        </div>

        <!-- Categories Card -->
        <div class="col-lg-3 col-md-6 mb-4">
            <div class="small-box bg-success card-custom shadow-lg">
                <div class="inner p-3">
                    <h3 class="display-4 text-white">{{ $totalCategories }}</h3>
                    <p class="lead text-white">Total Categories</p>
                    <div class="stats-trend text-white">
                        <i class="fas fa-arrow-up trend-up"></i> +5% from last month
                    </div>
                </div>
                <div class="icon">
                    <i class="fas fa-list fa-3x"></i>
                </div>
                <div class="mini-chart-container">
                    <canvas id="catDistributionChart"></canvas>
                </div>
                <a href="{{ route('categories.index') }}" class="small-box-footer bg-success text-white">
                    View Categories <i class="fas fa-arrow-circle-right"></i>
                </a>
            </div>
        </div>

        <!-- Users Card -->
        <div class="col-lg-3 col-md-6 mb-4">
            <div class="small-box bg-warning card-custom shadow-lg">
                <div class="inner p-3">
                    <h3 class="display-4 text-white">{{ $totalUsers }}</h3>
                    <p class="lead text-white">Total Users</p>
                    <div class="stats-trend text-white">
                        <i class="fas fa-arrow-up trend-up"></i> +8% from last month
                    </div>
                </div>
                <div class="icon">
                    <i class="fas fa-users fa-3x"></i>
                </div>
                <div class="mini-chart-container">
                    <canvas id="userActivityChart"></canvas>
                </div>
                 <a href="{{ route('categories.index') }}" class="small-box-footer bg-warning text-white">
                    View Users <i class="fas fa-arrow-circle-right"></i>
                </a>
            </div>
        </div>

        <!-- Validations Card -->
        <div class="col-lg-3 col-md-6 mb-4">
            <div class="small-box bg-primary card-custom shadow-lg">
                <div class="inner p-3">
                    <h3 class="display-4 text-white">{{ $totalValidations }}</h3>
                    <p class="lead text-white">Total Validations</p>
                    <div class="stats-trend text-white">
                        <i class="fas fa-arrow-down trend-down"></i> -3% from last month
                    </div>
                </div>
                <div class="icon">
                    <i class="fas fa-check-circle fa-3x"></i>
                </div>
                <div class="mini-chart-container">
                    <canvas id="validationProgressChart"></canvas>
                </div>
                <a href="{{ route('validations.index') }}" class="small-box-footer bg-primary text-white">
                    View Validations <i class="fas fa-arrow-circle-right"></i>
                </a>
            </div>
        </div>
    </div>

    <!-- Pending Validations Alert Card -->
    <div class="row mb-4">
        <div class="col-md-12">
            <div class="alert alert-warning shadow-lg" style="border-radius: 15px;">
                <div class="row align-items-center">
                    <div class="col-md-8">
                        <h4><i class="fas fa-exclamation-triangle"></i> Pending Validations</h4>
                        <p class="mb-0">You have <strong>{{ $pendingValidations }}</strong> validations waiting for
                            review.</p>
                    </div>
                    <div class="col-md-4 text-right">
                        <canvas id="pendingChart" style="max-height: 80px;"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Charts Row -->
    <div class="row mb-4">
        <div class="col-lg-8 mb-4">
            <x-adminlte-card title="System Growth Overview" theme="primary" collapsible>
                <canvas id="mainGrowthChart" style="height: 400px;"></canvas>
            </x-adminlte-card>
        </div>

        <div class="col-lg-4 mb-4">
            <x-adminlte-card title="Document Status Distribution" theme="info" collapsible>
                <canvas id="documentStatusChart" style="height: 400px;"></canvas>
            </x-adminlte-card>
        </div>
    </div>

    <!-- Secondary Charts Row -->
    <div class="row mb-4">
        <div class="col-lg-6 mb-4">
            <x-adminlte-card title="Category Performance" theme="success" collapsible>
                <canvas id="categoryPerformanceChart" style="height: 300px;"></canvas>
            </x-adminlte-card>
        </div>

        <div class="col-lg-6 mb-4">
            <x-adminlte-card title="User Activity Heatmap" theme="secondary" collapsible>
                <canvas id="userHeatmapChart" style="height: 300px;"></canvas>
            </x-adminlte-card>
        </div>
    </div>

    <!-- Bottom Charts Row -->
    <div class="row mb-4">
        <div class="col-lg-4 mb-4">
            <x-adminlte-card title="Validation Efficiency" theme="warning" collapsible>
                <canvas id="validationEfficiencyChart" style="height: 250px;"></canvas>
            </x-adminlte-card>
        </div>

        <div class="col-lg-8 mb-4">
            <x-adminlte-card title="Monthly Trends Comparison" theme="dark" collapsible>
                <canvas id="monthlyTrendsChart" style="height: 250px;"></canvas>
            </x-adminlte-card>
        </div>
    </div>

    <!-- Controls Row -->
    <div class="row">
        <div class="col-md-12 text-center">
            <button class="btn btn-dark btn-lg shadow" id="darkModeToggle">
                <i class="fas fa-moon"></i> Toggle Dark Mode
            </button>
            <button class="btn btn-info btn-lg shadow ml-2" id="refreshCharts">
                <i class="fas fa-sync-alt"></i> Refresh Charts
            </button>
        </div>
    </div>
@stop

@push('js')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            // Server-side data
            const totalDocuments = @json($totalDocuments);
            const totalCategories = @json($totalCategories);
            const totalUsers = @json($totalUsers);
            const totalValidations = @json($totalValidations);
            const pendingValidations = @json($pendingValidations);
            const completedValidations = totalValidations - pendingValidations;

            // Chart.js default configurations
            Chart.defaults.responsive = true;
            Chart.defaults.maintainAspectRatio = false;
            Chart.defaults.animation.duration = 1000;

            // 1. Document Trend Mini Chart (Line)
            new Chart(document.getElementById('docTrendChart'), {
                type: 'line',
                data: {
                    labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun'],
                    datasets: [{
                        data: [
                            Math.floor(totalDocuments * 0.6),
                            Math.floor(totalDocuments * 0.7),
                            Math.floor(totalDocuments * 0.8),
                            Math.floor(totalDocuments * 0.85),
                            Math.floor(totalDocuments * 0.92),
                            totalDocuments
                        ],
                        borderColor: 'rgba(255,255,255,0.8)',
                        backgroundColor: 'rgba(255,255,255,0.1)',
                        borderWidth: 2,
                        fill: true,
                        tension: 0.4
                    }]
                },
                options: {
                    plugins: {
                        legend: {
                            display: false
                        }
                    },
                    scales: {
                        x: {
                            display: false
                        },
                        y: {
                            display: false
                        }
                    },
                    elements: {
                        point: {
                            radius: 0
                        }
                    }
                }
            });

            // 2. Category Distribution Mini Chart (Bar)
            new Chart(document.getElementById('catDistributionChart'), {
                type: 'bar',
                data: {
                    labels: ['Q1', 'Q2', 'Q3', 'Q4'],
                    datasets: [{
                        data: [
                            Math.floor(totalCategories * 0.2),
                            Math.floor(totalCategories * 0.3),
                            Math.floor(totalCategories * 0.25),
                            Math.floor(totalCategories * 0.25)
                        ],
                        backgroundColor: 'rgba(255,255,255,0.6)',
                        borderColor: 'rgba(255,255,255,0.8)',
                        borderWidth: 1
                    }]
                },
                options: {
                    plugins: {
                        legend: {
                            display: false
                        }
                    },
                    scales: {
                        x: {
                            display: false
                        },
                        y: {
                            display: false
                        }
                    }
                }
            });

            // 3. User Activity Mini Chart (Area)
            new Chart(document.getElementById('userActivityChart'), {
                type: 'line',
                data: {
                    labels: ['Week 1', 'Week 2', 'Week 3', 'Week 4'],
                    datasets: [{
                        data: [
                            Math.floor(totalUsers * 0.7),
                            Math.floor(totalUsers * 0.85),
                            Math.floor(totalUsers * 0.95),
                            totalUsers
                        ],
                        borderColor: 'rgba(255,255,255,0.8)',
                        backgroundColor: 'rgba(255,255,255,0.2)',
                        borderWidth: 2,
                        fill: true,
                        tension: 0.3
                    }]
                },
                options: {
                    plugins: {
                        legend: {
                            display: false
                        }
                    },
                    scales: {
                        x: {
                            display: false
                        },
                        y: {
                            display: false
                        }
                    },
                    elements: {
                        point: {
                            radius: 0
                        }
                    }
                }
            });

            // 4. Validation Progress Mini Chart (Doughnut)
            new Chart(document.getElementById('validationProgressChart'), {
                type: 'doughnut',
                data: {
                    datasets: [{
                        data: [completedValidations, pendingValidations],
                        backgroundColor: ['rgba(255,255,255,0.8)', 'rgba(255,255,255,0.3)'],
                        borderWidth: 0
                    }]
                },
                options: {
                    plugins: {
                        legend: {
                            display: false
                        }
                    },
                    cutout: '70%'
                }
            });

            // 5. Pending Validations Alert Chart
            new Chart(document.getElementById('pendingChart'), {
                type: 'doughnut',
                data: {
                    datasets: [{
                        data: [pendingValidations, completedValidations],
                        backgroundColor: ['#dc3545', '#28a745'],
                        borderWidth: 2,
                        borderColor: '#fff'
                    }]
                },
                options: {
                    plugins: {
                        legend: {
                            display: false
                        },
                        tooltip: {
                            callbacks: {
                                label: function(context) {
                                    const label = context.dataIndex === 0 ? 'Pending' : 'Completed';
                                    const value = context.raw;
                                    const percentage = ((value / totalValidations) * 100).toFixed(1);
                                    return `${label}: ${value} (${percentage}%)`;
                                }
                            }
                        }
                    },
                    cutout: '60%'
                }
            });

            // 6. Main Growth Chart
            new Chart(document.getElementById('mainGrowthChart'), {
                type: 'line',
                data: {
                    labels: ['January', 'February', 'March', 'April', 'May', 'June'],
                    datasets: [{
                            label: 'Documents',
                            data: [
                                Math.floor(totalDocuments * 0.5),
                                Math.floor(totalDocuments * 0.6),
                                Math.floor(totalDocuments * 0.75),
                                Math.floor(totalDocuments * 0.85),
                                Math.floor(totalDocuments * 0.92),
                                totalDocuments
                            ],
                            borderColor: '#007bff',
                            backgroundColor: 'rgba(0, 123, 255, 0.1)',
                            fill: true,
                            tension: 0.4
                        },
                        {
                            label: 'Users',
                            data: [
                                Math.floor(totalUsers * 0.4),
                                Math.floor(totalUsers * 0.55),
                                Math.floor(totalUsers * 0.7),
                                Math.floor(totalUsers * 0.8),
                                Math.floor(totalUsers * 0.9),
                                totalUsers
                            ],
                            borderColor: '#28a745',
                            backgroundColor: 'rgba(40, 167, 69, 0.1)',
                            fill: true,
                            tension: 0.4
                        },
                        {
                            label: 'Categories',
                            data: [
                                Math.floor(totalCategories * 0.6),
                                Math.floor(totalCategories * 0.7),
                                Math.floor(totalCategories * 0.8),
                                Math.floor(totalCategories * 0.85),
                                Math.floor(totalCategories * 0.9),
                                totalCategories
                            ],
                            borderColor: '#ffc107',
                            backgroundColor: 'rgba(255, 193, 7, 0.1)',
                            fill: true,
                            tension: 0.4
                        }
                    ]
                },
                options: {
                    interaction: {
                        intersect: false,
                        mode: 'index'
                    },
                    plugins: {
                        legend: {
                            position: 'top'
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            grid: {
                                display: true,
                                color: 'rgba(0,0,0,0.1)'
                            }
                        },
                        x: {
                            grid: {
                                display: false
                            }
                        }
                    }
                }
            });

            // 7. Document Status Distribution
            new Chart(document.getElementById('documentStatusChart'), {
                type: 'doughnut',
                data: {
                    labels: ['Published', 'Draft', 'Under Review', 'Archived'],
                    datasets: [{
                        data: [
                            Math.floor(totalDocuments * 0.6),
                            Math.floor(totalDocuments * 0.2),
                            Math.floor(totalDocuments * 0.15),
                            Math.floor(totalDocuments * 0.05)
                        ],
                        backgroundColor: ['#28a745', '#6c757d', '#ffc107', '#dc3545'],
                        borderWidth: 3,
                        borderColor: '#fff'
                    }]
                },
                options: {
                    plugins: {
                        legend: {
                            position: 'bottom'
                        },
                        tooltip: {
                            callbacks: {
                                label: function(context) {
                                    const value = context.raw;
                                    const percentage = ((value / totalDocuments) * 100).toFixed(1);
                                    return `${context.label}: ${value} (${percentage}%)`;
                                }
                            }
                        }
                    }
                }
            });

            // 8. Category Performance (Horizontal Bar)
            new Chart(document.getElementById('categoryPerformanceChart'), {
                type: 'bar',
                data: {
                    labels: ['Technology', 'Business', 'Health', 'Education', 'Finance'],
                    datasets: [{
                        label: 'Documents per Category',
                        data: [
                            Math.floor(totalDocuments * 0.3),
                            Math.floor(totalDocuments * 0.25),
                            Math.floor(totalDocuments * 0.2),
                            Math.floor(totalDocuments * 0.15),
                            Math.floor(totalDocuments * 0.1)
                        ],
                        backgroundColor: [
                            'rgba(54, 162, 235, 0.8)',
                            'rgba(255, 99, 132, 0.8)',
                            'rgba(255, 205, 86, 0.8)',
                            'rgba(75, 192, 192, 0.8)',
                            'rgba(153, 102, 255, 0.8)'
                        ],
                        borderColor: [
                            'rgba(54, 162, 235, 1)',
                            'rgba(255, 99, 132, 1)',
                            'rgba(255, 205, 86, 1)',
                            'rgba(75, 192, 192, 1)',
                            'rgba(153, 102, 255, 1)'
                        ],
                        borderWidth: 2
                    }]
                },
                options: {
                    indexAxis: 'y',
                    plugins: {
                        legend: {
                            display: false
                        }
                    },
                    scales: {
                        x: {
                            beginAtZero: true
                        }
                    }
                }
            });

            // 9. User Activity Heatmap (simulated with bar chart)
            new Chart(document.getElementById('userHeatmapChart'), {
                type: 'bar',
                data: {
                    labels: ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'],
                    datasets: [{
                        label: 'Active Users',
                        data: [
                            Math.floor(totalUsers * 0.8),
                            Math.floor(totalUsers * 0.9),
                            Math.floor(totalUsers * 0.85),
                            Math.floor(totalUsers * 0.95),
                            Math.floor(totalUsers * 0.7),
                            Math.floor(totalUsers * 0.4),
                            Math.floor(totalUsers * 0.3)
                        ],
                        backgroundColor: function(context) {
                            const value = context.raw;
                            const max = Math.max(...context.dataset.data);
                            const intensity = value / max;
                            return `rgba(54, 162, 235, ${intensity})`;
                        },
                        borderColor: 'rgba(54, 162, 235, 1)',
                        borderWidth: 1
                    }]
                },
                options: {
                    plugins: {
                        legend: {
                            display: false
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });

            // 10. Validation Efficiency (Polar Area)
            new Chart(document.getElementById('validationEfficiencyChart'), {
                type: 'polarArea',
                data: {
                    labels: ['Fast', 'Medium', 'Slow', 'Pending'],
                    datasets: [{
                        data: [
                            Math.floor(totalValidations * 0.4),
                            Math.floor(totalValidations * 0.3),
                            Math.floor(totalValidations * 0.2),
                            pendingValidations
                        ],
                        backgroundColor: [
                            'rgba(75, 192, 192, 0.8)',
                            'rgba(255, 205, 86, 0.8)',
                            'rgba(255, 99, 132, 0.8)',
                            'rgba(201, 203, 207, 0.8)'
                        ]
                    }]
                },
                options: {
                    plugins: {
                        legend: {
                            position: 'bottom'
                        }
                    }
                }
            });

            // 11. Monthly Trends Comparison (Mixed Chart)
            new Chart(document.getElementById('monthlyTrendsChart'), {
                type: 'bar',
                data: {
                    labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun'],
                    datasets: [{
                            type: 'line',
                            label: 'Validation Rate',
                            data: [78, 82, 85, 88, 84, 90],
                            borderColor: 'rgb(255, 99, 132)',
                            backgroundColor: 'rgba(255, 99, 132, 0.2)',
                            yAxisID: 'y1'
                        },
                        {
                            type: 'bar',
                            label: 'New Documents',
                            data: [
                                Math.floor(totalDocuments * 0.1),
                                Math.floor(totalDocuments * 0.12),
                                Math.floor(totalDocuments * 0.15),
                                Math.floor(totalDocuments * 0.18),
                                Math.floor(totalDocuments * 0.2),
                                Math.floor(totalDocuments * 0.25)
                            ],
                            backgroundColor: 'rgba(54, 162, 235, 0.8)',
                            yAxisID: 'y'
                        }
                    ]
                },
                options: {
                    scales: {
                        y: {
                            type: 'linear',
                            display: true,
                            position: 'left',
                            beginAtZero: true
                        },
                        y1: {
                            type: 'linear',
                            display: true,
                            position: 'right',
                            beginAtZero: true,
                            max: 100,
                            grid: {
                                drawOnChartArea: false,
                            },
                        }
                    }
                }
            });

            // Dark Mode Toggle
            document.getElementById('darkModeToggle').addEventListener('click', function() {
                document.body.classList.toggle('dark-mode');
                localStorage.setItem('darkMode', document.body.classList.contains('dark-mode'));
            });

            // Check dark mode state on load
            if (localStorage.getItem('darkMode') === 'true') {
                document.body.classList.add('dark-mode');
            }

            // Refresh Charts
            document.getElementById('refreshCharts').addEventListener('click', function() {
                location.reload();
            });
        });
    </script>
@endpush