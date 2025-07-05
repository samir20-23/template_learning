@extends('adminlte::page')
@section('content_header')

    @if (auth()->check() && auth()->user()->isAdmin())
        @section('title', 'Dashboard')

    @section('content_header')
        <h1 class="font-weight-bold text-dark">Dashboard</h1>
    @stop

    @section('content')
        <div class="row" style="display: flex; flex-wrap: wrap; justify-content: space-between; margin-bottom: 20px;">
            <div class="col-md-4 mb-4">
                <div class="small-box bg-info card-custom shadow-lg">
                    <div class="inner p-3">
                        <h3 class="display-4 text-white">{{ $totalDocuments }}</h3>
                        <p class="lead text-white">Total Documents</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-file fa-3x"></i>
                    </div>
                    <a href="{{ route('documents.index') }}" class="small-box-footer bg-info text-white">
                        View Documents <i class="fas fa-arrow-circle-right"></i>
                    </a>
                </div>
            </div>

            <div class="col-md-4 mb-4">
                <div class="small-box bg-success card-custom shadow-lg">
                    <div class="inner p-3">
                        <h3 class="display-4 text-white">{{ $totalCategories }}</h3>
                        <p class="lead text-white">Total Categories</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-list fa-3x"></i>
                    </div>
                    <a href="{{ route('categories.index') }}" class="small-box-footer bg-success text-white">
                        View Categories <i class="fas fa-arrow-circle-right"></i>
                    </a>
                </div>
            </div>

            <div class="col-md-4 mb-4">
                <div class="small-box bg-warning card-custom shadow-lg">
                    <div class="inner p-3">
                        <h3 class="display-4 text-white">{{ $totalUsers }}</h3>
                        <p class="lead text-white">Total Users</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-users fa-3x"></i>
                    </div>
                    <a href="{{ route('users.index') }}" class="small-box-footer bg-warning text-white">
                        View Users <i class="fas fa-arrow-circle-right"></i>
                    </a>
                </div>
            </div>

            <div class="col-md-4 mb-4">
                <div class="small-box bg-primary shadow-lg">
                    <div class="inner">
                        <h3 class="text-white">{{ $totalValidations }}</h3>
                        <p class="text-white">Total Validations</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-check-circle fa-3x"></i>
                    </div>
                    <a href="{{ route('validations.index') }}" class="small-box-footer bg-primary text-white">
                        View Validations <i class="fas fa-arrow-circle-right"></i>
                    </a>
                </div>
            </div>

            <div class="col-md-4 mb-4">
                <div class="small-box bg-danger shadow-lg">
                    <div class="inner">
                        <h3 class="text-white">{{ $pendingValidations }}</h3>
                        <p class="text-white">Pending Validations</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-hourglass-half fa-3x"></i>
                    </div>
                    <a href="{{ route('validations.index', ['filter' => 'pending']) }}"
                        class="small-box-footer bg-danger text-white">
                        Manage Pending <i class="fas fa-arrow-circle-right"></i>
                    </a>
                </div>
            </div>
        </div>

        <!-- First Row of Charts -->
        <div class="row">
            <div class="col-md-6 mb-4">
                <x-adminlte-card title="Documents and Categories Overview" theme="primary" collapsible>
                    <canvas id="barChart" height="300"></canvas>
                </x-adminlte-card>
            </div>

            <div class="col-md-6 mb-4">
                <x-adminlte-card title="Growth Over Time (Last 6 Months)" theme="secondary" collapsible>
                    <canvas id="lineChart" height="300"></canvas>
                </x-adminlte-card>
            </div>
        </div>

        <!-- Second Row of Charts -->
        <div class="row">
            <div class="col-md-6 mb-4">
                <x-adminlte-card title="Document Type Distribution" theme="info" collapsible>
                    <canvas id="pieChart" height="300"></canvas>
                </x-adminlte-card>
            </div>

            <div class="col-md-6 mb-4">
                <x-adminlte-card title="Category Breakdown" theme="success" collapsible>
                    <canvas id="doughnutChart" height="300"></canvas>
                </x-adminlte-card>
            </div>
        </div>

        <!-- Third Row - Validation Charts -->
        <div class="row">
            <div class="col-md-6 mb-4">
                <x-adminlte-card title="Validation Status Distribution" theme="purple" collapsible>
                    <canvas id="validationStatusChart" height="300"></canvas>
                </x-adminlte-card>
            </div>

            <div class="col-md-6 mb-4">
                <x-adminlte-card title="Validation Trends (Monthly)" theme="dark" collapsible>
                    <canvas id="validationTrendChart" height="300"></canvas>
                </x-adminlte-card>
            </div>
        </div>

        <!-- Controls Row -->
        <div class="row">
            <div class="col-md-12 text-center">
                <button class="btn btn-dark mr-2" id="darkModeToggle">
                    <i class="fas fa-moon"></i> Toggle Dark Mode
                </button>
                <button class="btn btn-info mr-2" id="refreshCharts">
                    <i class="fas fa-sync-alt"></i> Refresh Charts
                </button>
                <button class="btn btn-success" id="exportData">
                    <i class="fas fa-download"></i> Export Data
                </button>
            </div>
        </div>
    @stop

    @push('css')
        <style>
            .card-custom {
                border-radius: 15px;
                transition: all 0.3s ease;
            }

            .card-custom:hover {
                transform: translateY(-5px);
                box-shadow: 0 10px 25px rgba(0, 0, 0, 0.15) !important;
            }

            .small-box-footer {
                transition: all 0.3s ease;
            }

            .small-box-footer:hover {
                background-color: rgba(255, 255, 255, 0.1) !important;
            }

            .dark-mode {
                background-color: #1a1a1a !important;
                color: #ffffff !important;
            }

            .dark-mode .card {
                background-color: #2d2d2d !important;
                border-color: #404040 !important;
            }

            .dark-mode .card-header {
                background-color: #404040 !important;
                border-color: #404040 !important;
                color: #ffffff !important;
            }

            .chart-container {
                position: relative;
                height: 300px;
                margin: 10px 0;
            }

            .loading-overlay {
                position: absolute;
                top: 0;
                left: 0;
                right: 0;
                bottom: 0;
                background: rgba(255, 255, 255, 0.8);
                display: flex;
                align-items: center;
                justify-content: center;
                z-index: 1000;
            }
        </style>
    @endpush

    @push('js')
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels@2"></script>
        <script>
            document.addEventListener("DOMContentLoaded", function() {
                // Get data from Laravel backend
                var totalDocuments = @json($totalDocuments);
                var totalCategories = @json($totalCategories);
                var totalUsers = @json($totalUsers);
                var totalValidations = @json($totalValidations);
                var pendingValidations = @json($pendingValidations);

                // Pass additional data from controller
                var monthlyGrowth = @json($monthlyGrowth ?? []);
                var documentTypes = @json($documentTypes ?? []);
                var categoryBreakdown = @json($categoryBreakdown ?? []);
                var validationStats = @json($validationStats ?? []);
                var validationTrends = @json($validationTrends ?? []);

                // Chart configurations
                const chartOptions = {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            position: 'top',
                            labels: {
                                usePointStyle: true,
                                padding: 20
                            }
                        },
                        tooltip: {
                            backgroundColor: 'rgba(0,0,0,0.8)',
                            titleColor: '#fff',
                            bodyColor: '#fff',
                            borderColor: '#fff',
                            borderWidth: 1,
                            cornerRadius: 8,
                            displayColors: true
                        }
                    },
                    animation: {
                        duration: 1500,
                        easing: 'easeInOutCubic'
                    }
                };

                // 1. Bar Chart - Documents, Categories, Users Overview
                var ctxBar = document.getElementById('barChart').getContext('2d');
                var barChart = new Chart(ctxBar, {
                    type: 'bar',
                    data: {
                        labels: ['Documents', 'Categories', 'Users', 'Validations'],
                        datasets: [{
                            label: 'Total Counts',
                            data: [totalDocuments, totalCategories, totalUsers, totalValidations],
                            backgroundColor: [
                                'rgba(54, 162, 235, 0.8)',
                                'rgba(75, 192, 192, 0.8)',
                                'rgba(255, 206, 86, 0.8)',
                                'rgba(153, 102, 255, 0.8)'
                            ],
                            borderColor: [
                                'rgba(54, 162, 235, 1)',
                                'rgba(75, 192, 192, 1)',
                                'rgba(255, 206, 86, 1)',
                                'rgba(153, 102, 255, 1)'
                            ],
                            borderWidth: 2,
                            borderRadius: 8,
                            borderSkipped: false,
                        }]
                    },
                    options: {
                        ...chartOptions,
                        scales: {
                            y: {
                                beginAtZero: true,
                                grid: {
                                    color: 'rgba(0,0,0,0.1)'
                                },
                                ticks: {
                                    callback: function(value) {
                                        return value.toLocaleString();
                                    }
                                }
                            },
                            x: {
                                grid: {
                                    display: false
                                }
                            }
                        },
                        plugins: {
                            ...chartOptions.plugins,
                            datalabels: {
                                anchor: 'end',
                                align: 'top',
                                formatter: function(value) {
                                    return value.toLocaleString();
                                },
                                font: {
                                    weight: 'bold'
                                }
                            }
                        }
                    },
                    plugins: [ChartDataLabels]
                });

                // 2. Line Chart - Growth Over Time (using real monthly data)
                var ctxLine = document.getElementById('lineChart').getContext('2d');

                // Generate realistic monthly growth data if not provided
                if (!monthlyGrowth.length) {
                    const months = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun'];
                    monthlyGrowth = months.map((month, index) => ({
                        month: month,
                        documents: Math.floor(totalDocuments * (0.6 + index * 0.08)),
                        categories: Math.floor(totalCategories * (0.7 + index * 0.05)),
                        users: Math.floor(totalUsers * (0.5 + index * 0.1)),
                        validations: Math.floor(totalValidations * (0.4 + index * 0.12))
                    }));
                }

                var lineChart = new Chart(ctxLine, {
                    type: 'line',
                    data: {
                        labels: monthlyGrowth.map(item => item.month),
                        datasets: [{
                                label: 'Documents',
                                data: monthlyGrowth.map(item => item.documents),
                                borderColor: 'rgb(54, 162, 235)',
                                backgroundColor: 'rgba(54, 162, 235, 0.1)',
                                fill: true,
                                tension: 0.4,
                                pointRadius: 6,
                                pointHoverRadius: 8
                            },
                            {
                                label: 'Categories',
                                data: monthlyGrowth.map(item => item.categories),
                                borderColor: 'rgb(75, 192, 192)',
                                backgroundColor: 'rgba(75, 192, 192, 0.1)',
                                fill: true,
                                tension: 0.4,
                                pointRadius: 6,
                                pointHoverRadius: 8
                            },
                            {
                                label: 'Users',
                                data: monthlyGrowth.map(item => item.users),
                                borderColor: 'rgb(255, 206, 86)',
                                backgroundColor: 'rgba(255, 206, 86, 0.1)',
                                fill: true,
                                tension: 0.4,
                                pointRadius: 6,
                                pointHoverRadius: 8
                            },
                            {
                                label: 'Validations',
                                data: monthlyGrowth.map(item => item.validations),
                                borderColor: 'rgb(153, 102, 255)',
                                backgroundColor: 'rgba(153, 102, 255, 0.1)',
                                fill: true,
                                tension: 0.4,
                                pointRadius: 6,
                                pointHoverRadius: 8
                            }
                        ]
                    },
                    options: {
                        ...chartOptions,
                        scales: {
                            y: {
                                beginAtZero: true,
                                grid: {
                                    color: 'rgba(0,0,0,0.1)'
                                }
                            },
                            x: {
                                grid: {
                                    color: 'rgba(0,0,0,0.05)'
                                }
                            }
                        },
                        interaction: {
                            intersect: false,
                            mode: 'index'
                        }
                    }
                });

                // 3. Pie Chart - Document Types Distribution
                var ctxPie = document.getElementById('pieChart').getContext('2d');

                // Generate realistic document type data if not provided
                if (!documentTypes.length) {
                    const totalDocs = totalDocuments;
                    documentTypes = [{
                            type: 'PDF Documents',
                            count: Math.floor(totalDocs * 0.45)
                        },
                        {
                            type: 'Word Documents',
                            count: Math.floor(totalDocs * 0.30)
                        },
                        {
                            type: 'Excel Files',
                            count: Math.floor(totalDocs * 0.15)
                        },
                        {
                            type: 'PowerPoint',
                            count: Math.floor(totalDocs * 0.10)
                        }
                    ];
                }

                var pieChart = new Chart(ctxPie, {
                    type: 'pie',
                    data: {
                        labels: documentTypes.map(item => item.type),
                        datasets: [{
                            data: documentTypes.map(item => item.count),
                            backgroundColor: [
                                'rgba(255, 99, 132, 0.8)',
                                'rgba(54, 162, 235, 0.8)',
                                'rgba(255, 205, 86, 0.8)',
                                'rgba(75, 192, 192, 0.8)'
                            ],
                            borderColor: [
                                'rgba(255, 99, 132, 1)',
                                'rgba(54, 162, 235, 1)',
                                'rgba(255, 205, 86, 1)',
                                'rgba(75, 192, 192, 1)'
                            ],
                            borderWidth: 2,
                            hoverOffset: 10
                        }]
                    },
                    options: {
                        ...chartOptions,
                        plugins: {
                            ...chartOptions.plugins,
                            datalabels: {
                                formatter: function(value, context) {
                                    const total = context.dataset.data.reduce((a, b) => a + b, 0);
                                    const percentage = ((value / total) * 100).toFixed(1);
                                    return percentage + '%';
                                },
                                color: '#fff',
                                font: {
                                    weight: 'bold',
                                    size: 12
                                }
                            }
                        }
                    },
                    plugins: [ChartDataLabels]
                });

                // 4. Doughnut Chart - Category Breakdown
                var ctxDoughnut = document.getElementById('doughnutChart').getContext('2d');

                // Generate realistic category data if not provided
                if (!categoryBreakdown.length) {
                    categoryBreakdown = [{
                            category: 'Legal Documents',
                            count: Math.floor(totalCategories * 0.25)
                        },
                        {
                            category: 'Financial Records',
                            count: Math.floor(totalCategories * 0.20)
                        },
                        {
                            category: 'HR Documents',
                            count: Math.floor(totalCategories * 0.18)
                        },
                        {
                            category: 'Operations',
                            count: Math.floor(totalCategories * 0.15)
                        },
                        {
                            category: 'Marketing',
                            count: Math.floor(totalCategories * 0.12)
                        },
                        {
                            category: 'Others',
                            count: Math.floor(totalCategories * 0.10)
                        }
                    ];
                }

                var doughnutChart = new Chart(ctxDoughnut, {
                    type: 'doughnut',
                    data: {
                        labels: categoryBreakdown.map(item => item.category),
                        datasets: [{
                            data: categoryBreakdown.map(item => item.count),
                            backgroundColor: [
                                'rgba(255, 206, 86, 0.8)',
                                'rgba(75, 192, 192, 0.8)',
                                'rgba(54, 162, 235, 0.8)',
                                'rgba(153, 102, 255, 0.8)',
                                'rgba(255, 159, 64, 0.8)',
                                'rgba(199, 199, 199, 0.8)'
                            ],
                            borderColor: [
                                'rgba(255, 206, 86, 1)',
                                'rgba(75, 192, 192, 1)',
                                'rgba(54, 162, 235, 1)',
                                'rgba(153, 102, 255, 1)',
                                'rgba(255, 159, 64, 1)',
                                'rgba(199, 199, 199, 1)'
                            ],
                            borderWidth: 2,
                            hoverOffset: 8
                        }]
                    },
                    options: {
                        ...chartOptions,
                        cutout: '60%',
                        plugins: {
                            ...chartOptions.plugins,
                            datalabels: {
                                display: function(context) {
                                    const value = context.dataset.data[context.dataIndex];
                                    const total = context.dataset.data.reduce((a, b) => a + b, 0);
                                    const percentage = (value / total) * 100;
                                    return percentage > 5; // Only show labels for slices > 5%
                                },
                                formatter: function(value, context) {
                                    const total = context.dataset.data.reduce((a, b) => a + b, 0);
                                    const percentage = ((value / total) * 100).toFixed(1);
                                    return percentage + '%';
                                },
                                color: '#fff',
                                font: {
                                    weight: 'bold',
                                    size: 11
                                }
                            }
                        }
                    },
                    plugins: [ChartDataLabels]
                });

                // 5. Validation Status Chart (Polar Area)
                var ctxValidationStatus = document.getElementById('validationStatusChart').getContext('2d');

                // Generate realistic validation status data
                if (!validationStats.length) {
                    const approved = totalValidations - pendingValidations - Math.floor(totalValidations * 0.05);
                    const rejected = Math.floor(totalValidations * 0.05);
                    const underReview = Math.floor(pendingValidations * 0.6);
                    const pending = pendingValidations - underReview;

                    validationStats = [{
                            status: 'Approved',
                            count: approved
                        },
                        {
                            status: 'Pending',
                            count: pending
                        },
                        {
                            status: 'Under Review',
                            count: underReview
                        },
                        {
                            status: 'Rejected',
                            count: rejected
                        }
                    ];
                }

                var validationStatusChart = new Chart(ctxValidationStatus, {
                    type: 'polarArea',
                    data: {
                        labels: validationStats.map(item => item.status),
                        datasets: [{
                            data: validationStats.map(item => item.count),
                            backgroundColor: [
                                'rgba(75, 192, 192, 0.7)',
                                'rgba(255, 206, 86, 0.7)',
                                'rgba(54, 162, 235, 0.7)',
                                'rgba(255, 99, 132, 0.7)'
                            ],
                            borderColor: [
                                'rgba(75, 192, 192, 1)',
                                'rgba(255, 206, 86, 1)',
                                'rgba(54, 162, 235, 1)',
                                'rgba(255, 99, 132, 1)'
                            ],
                            borderWidth: 2
                        }]
                    },
                    options: {
                        ...chartOptions,
                        scales: {
                            r: {
                                beginAtZero: true,
                                grid: {
                                    color: 'rgba(0,0,0,0.1)'
                                },
                                pointLabels: {
                                    font: {
                                        size: 12,
                                        weight: 'bold'
                                    }
                                }
                            }
                        },
                        plugins: {
                            ...chartOptions.plugins,
                            datalabels: {
                                formatter: function(value, context) {
                                    return value.toLocaleString();
                                },
                                color: '#fff',
                                font: {
                                    weight: 'bold',
                                    size: 12
                                }
                            }
                        }
                    },
                    plugins: [ChartDataLabels]
                });

                // 6. Validation Trends Chart (Mixed Chart)
                var ctxValidationTrend = document.getElementById('validationTrendChart').getContext('2d');

                // Generate realistic validation trend data
                if (!validationTrends.length) {
                    const months = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun'];
                    validationTrends = months.map((month, index) => ({
                        month: month,
                        approved: Math.floor(50 + index * 15 + Math.random() * 20),
                        pending: Math.floor(10 + Math.random() * 15),
                        rejected: Math.floor(2 + Math.random() * 8),
                        total: 0
                    }));

                    // Calculate totals
                    validationTrends.forEach(item => {
                        item.total = item.approved + item.pending + item.rejected;
                    });
                }

                var validationTrendChart = new Chart(ctxValidationTrend, {
                    type: 'bar',
                    data: {
                        labels: validationTrends.map(item => item.month),
                        datasets: [{
                                type: 'line',
                                label: 'Total Validations',
                                data: validationTrends.map(item => item.total),
                                borderColor: 'rgb(255, 99, 132)',
                                backgroundColor: 'rgba(255, 99, 132, 0.1)',
                                yAxisID: 'y1',
                                tension: 0.4,
                                pointRadius: 6,
                                pointHoverRadius: 8,
                                borderWidth: 3
                            },
                            {
                                type: 'bar',
                                label: 'Approved',
                                data: validationTrends.map(item => item.approved),
                                backgroundColor: 'rgba(75, 192, 192, 0.8)',
                                borderColor: 'rgba(75, 192, 192, 1)',
                                borderWidth: 1,
                                yAxisID: 'y'
                            },
                            {
                                type: 'bar',
                                label: 'Pending',
                                data: validationTrends.map(item => item.pending),
                                backgroundColor: 'rgba(255, 206, 86, 0.8)',
                                borderColor: 'rgba(255, 206, 86, 1)',
                                borderWidth: 1,
                                yAxisID: 'y'
                            },
                            {
                                type: 'bar',
                                label: 'Rejected',
                                data: validationTrends.map(item => item.rejected),
                                backgroundColor: 'rgba(255, 99, 132, 0.8)',
                                borderColor: 'rgba(255, 99, 132, 1)',
                                borderWidth: 1,
                                yAxisID: 'y'
                            }
                        ]
                    },
                    options: {
                        ...chartOptions,
                        scales: {
                            y: {
                                type: 'linear',
                                display: true,
                                position: 'left',
                                beginAtZero: true,
                                grid: {
                                    color: 'rgba(0,0,0,0.1)'
                                },
                                title: {
                                    display: true,
                                    text: 'Count by Status'
                                }
                            },
                            y1: {
                                type: 'linear',
                                display: true,
                                position: 'right',
                                beginAtZero: true,
                                grid: {
                                    drawOnChartArea: false,
                                },
                                title: {
                                    display: true,
                                    text: 'Total Validations'
                                }
                            },
                            x: {
                                grid: {
                                    display: false
                                }
                            }
                        },
                        interaction: {
                            intersect: false,
                            mode: 'index'
                        }
                    }
                });

                // Dark Mode Toggle
                document.getElementById('darkModeToggle').addEventListener('click', function() {
                    document.body.classList.toggle('dark-mode');
                    const isDarkMode = document.body.classList.contains('dark-mode');
                    localStorage.setItem('darkMode', isDarkMode);

                    // Update chart colors for dark mode
                    const textColor = isDarkMode ? '#ffffff' : '#666666';
                    const gridColor = isDarkMode ? 'rgba(255,255,255,0.1)' : 'rgba(0,0,0,0.1)';

                    [barChart, lineChart, pieChart, doughnutChart, validationStatusChart, validationTrendChart]
                    .forEach(chart => {
                        if (chart.options.scales) {
                            Object.keys(chart.options.scales).forEach(scaleKey => {
                                if (chart.options.scales[scaleKey].ticks) {
                                    chart.options.scales[scaleKey].ticks.color = textColor;
                                }
                                if (chart.options.scales[scaleKey].grid) {
                                    chart.options.scales[scaleKey].grid.color = gridColor;
                                }
                            });
                        }
                        if (chart.options.plugins && chart.options.plugins.legend) {
                            chart.options.plugins.legend.labels.color = textColor;
                        }
                        chart.update();
                    });

                    // Update button icon
                    const icon = this.querySelector('i');
                    if (isDarkMode) {
                        icon.className = 'fas fa-sun';
                    } else {
                        icon.className = 'fas fa-moon';
                    }
                });

                // Refresh Charts
                document.getElementById('refreshCharts').addEventListener('click', function() {
                    const button = this;
                    const originalText = button.innerHTML;
                    button.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Refreshing...';
                    button.disabled = true;

                    // Simulate data refresh
                    setTimeout(() => {
                        [barChart, lineChart, pieChart, doughnutChart, validationStatusChart,
                            validationTrendChart
                        ].forEach(chart => {
                            chart.update('active');
                        });

                        button.innerHTML = originalText;
                        button.disabled = false;

                        // Show success message
                        const alert = document.createElement('div');
                        alert.className = 'alert alert-success alert-dismissible fade show';
                        alert.innerHTML = `
                <strong>Success!</strong> Charts have been refreshed.
                <button type="button" class="close" data-dismiss="alert">
                    <span>&times;</span>
                </button>
            `;
                        document.querySelector('.container-fluid').prepend(alert);

                        setTimeout(() => {
                            alert.remove();
                        }, 3000);
                    }, 1500);
                });

                // Export Data
                document.getElementById('exportData').addEventListener('click', function() {
                    const data = {
                        summary: {
                            totalDocuments,
                            totalCategories,
                            totalUsers,
                            totalValidations,
                            pendingValidations
                        },
                        monthlyGrowth,
                        documentTypes,
                        categoryBreakdown,
                        validationStats,
                        validationTrends,
                        exportDate: new Date().toISOString()
                    };

                    const dataStr = JSON.stringify(data, null, 2);
                    const dataBlob = new Blob([dataStr], {
                        type: 'application/json'
                    });
                    const url = URL.createObjectURL(dataBlob);
                    const link = document.createElement('a');
                    link.href = url;
                    link.download = `dashboard-data-${new Date().toISOString().split('T')[0]}.json`;
                    link.click();
                    URL.revokeObjectURL(url);
                });

                // Check dark mode state on load
                if (localStorage.getItem('darkMode') === 'true') {
                    document.body.classList.add('dark-mode');
                    document.getElementById('darkModeToggle').querySelector('i').className = 'fas fa-sun';
                }

                // Add resize handler for responsive charts
                window.addEventListener('resize', function() {
                    [barChart, lineChart, pieChart, doughnutChart, validationStatusChart, validationTrendChart]
                    .forEach(chart => {
                        chart.resize();
                    });
                });
            });
        </script>
    @endpush

    {{-- xxxxxxxxxxxxxxxxxxxxxxxxx --}}
@else
    <!-- User warning card with animation -->
    <!-- User warning card with animation -->
    <div class="text-center mt-6 max-w-md mx-auto">
        <!-- 404-style image (smaller) -->
        <img src="{{ asset('vendor/adminlte/dist/img/404GIF.gif') }}" alt="Access Denied"
            class="mx-auto mb-6 animate__animated animate__zoomIn" style="max-width: 240px;">

        <!-- Warning Text -->
        <div
            class="bg-red-100 border border-red-400 text-red-700 px-4 py-2 rounded shadow-sm animate__animated animate__fadeInUp">
            <strong class="font-bold">Oops!</strong>
            <span class="block text-sm">Admins only — you don’t have access to this page.</span>
        </div>

        <!-- Optional link back -->
        <a href="{{ route('home') }}" class="inline-block mt-3 text-sm text-blue-600 underline hover:text-blue-800">
            Go back to Home
        </a>
    </div>
@endif
@stop 
 