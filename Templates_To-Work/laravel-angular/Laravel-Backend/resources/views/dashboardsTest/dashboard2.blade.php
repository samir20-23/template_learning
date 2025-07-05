{{-- resources/views/dashboard.blade.php --}}
@extends('layouts.stylepages')

@section('title', auth()->user()->isAdmin() ? 'Dashboard' : config('app.name'))

@section('content_header')
    @if (auth()->check() && auth()->user()->isAdmin())
        <h1 class="font-weight-bold text-dark">Dashboard</h1>
    @endif
@stop

@section('content')
    @if (auth()->check() && auth()->user()->isAdmin())
        {{-- Welcome Section --}}
        <div class="row mb-4">
            <div class="col-12">
                <div class="welcome-card">
                    <div class="welcome-content">
                        <h1 class="welcome-title">Welcome back, {{ Auth::user()->name }}! 👋</h1>
                        <p class="welcome-subtitle">Here's what's happening with your dashboard today.</p>
                    </div>
                    <div class="welcome-stats">
                        <div class="stat-item">
                            <span class="stat-number">{{ $totalDocuments }}</span>
                            <span class="stat-label">Documents</span>
                        </div>
                        <div class="stat-item">
                            <span class="stat-number">{{ $totalUsers }}</span>
                            <span class="stat-label">Users</span>
                        </div>
                        <div class="stat-item">
                            <span class="stat-number">{{ $pendingValidations }}</span>
                            <span class="stat-label">Pending</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Dashboard Cards --}}
        <div class="row g-4 mb-5">
            <div class="col-xl-3 col-md-6">
                <div class="stats-card stats-card-primary">
                    <div class="stats-icon">
                        <i class="bi bi-file-earmark-text"></i>
                    </div>
                    <div class="stats-content">
                        <h3 class="stats-number">{{ $totalDocuments }}</h3>
                        <p class="stats-label">Total Documents</p>
                        <div class="stats-trend">
                            <i class="bi bi-arrow-up"></i>
                            <span>+12% from last month</span>
                        </div>
                    </div>
                    <a href="{{ route('documents.index') }}" class="stats-link">
                        View Documents <i class="bi bi-arrow-right"></i>
                    </a>
                </div>
            </div>

            <div class="col-xl-3 col-md-6">
                <div class="stats-card stats-card-success">
                    <div class="stats-icon">
                        <i class="bi bi-grid-3x3-gap"></i>
                    </div>
                    <div class="stats-content">
                        <h3 class="stats-number">{{ $totalCategories }}</h3>
                        <p class="stats-label">Total Categories</p>
                        <div class="stats-trend">
                            <i class="bi bi-arrow-up"></i>
                            <span>+8% from last month</span>
                        </div>
                    </div>
                    <a href="{{ route('categories.index') }}" class="stats-link">
                        View Categories <i class="bi bi-arrow-right"></i>
                    </a>
                </div>
            </div>

            <div class="col-xl-3 col-md-6">
                <div class="stats-card stats-card-warning">
                    <div class="stats-icon">
                        <i class="bi bi-people"></i>
                    </div>
                    <div class="stats-content">
                        <h3 class="stats-number">{{ $totalUsers }}</h3>
                        <p class="stats-label">Total Users</p>
                        <div class="stats-trend">
                            <i class="bi bi-arrow-up"></i>
                            <span>+15% from last month</span>
                        </div>
                    </div>
                    <a href="{{ route('users.index') }}" class="stats-link">
                        View Users <i class="bi bi-arrow-right"></i>
                    </a>
                </div>
            </div>

            <div class="col-xl-3 col-md-6">
                <div class="stats-card stats-card-info">
                    <div class="stats-icon">
                        <i class="bi bi-check-circle"></i>
                    </div>
                    <div class="stats-content">
                        <h3 class="stats-number">{{ $totalValidations }}</h3>
                        <p class="stats-label">Total Validations</p>
                        <div class="stats-trend">
                            <i class="bi bi-arrow-up"></i>
                            <span>+5% from last month</span>
                        </div>
                    </div>
                    <a href="{{ route('validations.index') }}" class="stats-link">
                        View Validations <i class="bi bi-arrow-right"></i>
                    </a>
                </div>
            </div>
        </div>

        {{-- Charts Section --}}
        <div class="row g-4 mb-4">
            <div class="col-xl-8">
                <div class="chart-card">
                    <div class="chart-header">
                        <h3 class="chart-title">Analytics Overview</h3>
                        <div class="chart-actions">
                            <button class="btn btn-sm btn-outline-primary">
                                <i class="bi bi-download"></i> Export
                            </button>
                        </div>
                    </div>
                    <div class="chart-container">
                        <canvas id="overviewChart"></canvas>
                    </div>
                </div>
            </div>

            <div class="col-xl-4">
                <div class="chart-card">
                    <div class="chart-header">
                        <h3 class="chart-title">Document Types</h3>
                    </div>
                    <div class="chart-container">
                        <canvas id="documentTypesChart"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <div class="row g-4 mb-4">
            <div class="col-xl-6">
                <div class="chart-card">
                    <div class="chart-header">
                        <h3 class="chart-title">Growth Trends</h3>
                        <div class="chart-period">
                            <select class="form-select form-select-sm">
                                <option>Last 6 months</option>
                                <option>Last year</option>
                            </select>
                        </div>
                    </div>
                    <div class="chart-container">
                        <canvas id="growthChart"></canvas>
                    </div>
                </div>
            </div>

            <div class="col-xl-6">
                <div class="chart-card">
                    <div class="chart-header">
                        <h3 class="chart-title">Validation Status</h3>
                    </div>
                    <div class="chart-container">
                        <canvas id="validationChart"></canvas>
                    </div>
                </div>
            </div>
        </div>

        {{-- Recent Activity --}}
        <div class="row g-4">
            <div class="col-xl-8">
                <div class="activity-card">
                    <div class="activity-header">
                        <h3 class="activity-title">Recent Activity</h3>
                        <a href="#" class="activity-link">View All</a>
                    </div>
                    <div class="activity-list">
                        <div class="activity-item">
                            <div class="activity-icon activity-icon-success">
                                <i class="bi bi-file-plus"></i>
                            </div>
                            <div class="activity-content">
                                <p class="activity-text">New document uploaded: <strong>Project Report.pdf</strong></p>
                                <span class="activity-time">2 minutes ago</span>
                            </div>
                        </div>
                        <div class="activity-item">
                            <div class="activity-icon activity-icon-info">
                                <i class="bi bi-person-plus"></i>
                            </div>
                            <div class="activity-content">
                                <p class="activity-text">New user registered: <strong>John Doe</strong></p>
                                <span class="activity-time">15 minutes ago</span>
                            </div>
                        </div>
                        <div class="activity-item">
                            <div class="activity-icon activity-icon-warning">
                                <i class="bi bi-exclamation-triangle"></i>
                            </div>
                            <div class="activity-content">
                                <p class="activity-text">Validation pending for <strong>Financial Report</strong></p>
                                <span class="activity-time">1 hour ago</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-4">
                <div class="quick-actions-card">
                    <div class="quick-actions-header">
                        <h3 class="quick-actions-title">Quick Actions</h3>
                    </div>
                    <div class="quick-actions-list">
                        <a href="#" class="quick-action-item">
                            <div class="quick-action-icon">
                                <i class="bi bi-file-plus"></i>
                            </div>
                            <span>Add Document</span>
                        </a>
                        <a href="#" class="quick-action-item">
                            <div class="quick-action-icon">
                                <i class="bi bi-person-plus"></i>
                            </div>
                            <span>Add User</span>
                        </a>
                        <a href="#" class="quick-action-item">
                            <div class="quick-action-icon">
                                <i class="bi bi-gear"></i>
                            </div>
                            <span>Settings</span>
                        </a>
                        <a href="#" class="quick-action-item">
                            <div class="quick-action-icon">
                                <i class="bi bi-download"></i>
                            </div>
                            <span>Export Data</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>

    @else
        {{-- Access Denied --}}
        <div class="access-denied">
            <div class="access-denied-content">
                <div class="access-denied-icon">
                    <i class="bi bi-shield-exclamation"></i>
                </div>
                <h2 class="access-denied-title">Access Restricted</h2>
                <p class="access-denied-text">This dashboard is only available to administrators.</p>
                <a href="{{ route('home') }}" class="btn btn-primary-custom">
                    <i class="bi bi-house me-2"></i>Go to Home
                </a>
            </div>
        </div>
    @endif
@stop

@push('styles')
<style>
    /* Welcome Card */
    .welcome-card {
        background: var(--gradient-card);
        border-radius: 20px;
        padding: 2rem;
        border: 1px solid var(--border-color);
        box-shadow: var(--shadow-lg);
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 2rem;
        transition: all 0.3s ease;
    }

    .welcome-card:hover {
        transform: translateY(-2px);
        box-shadow: var(--shadow-xl);
    }

    .welcome-title {
        font-size: 2rem;
        font-weight: 800;
        color: var(--text-primary);
        margin-bottom: 0.5rem;
    }

    .welcome-subtitle {
        color: var(--text-secondary);
        font-size: 1.1rem;
        margin: 0;
    }

    .welcome-stats {
        display: flex;
        gap: 2rem;
    }

    .stat-item {
        text-align: center;
    }

    .stat-number {
        display: block;
        font-size: 1.5rem;
        font-weight: 700;
        color: var(--primary-color);
    }

    .stat-label {
        font-size: 0.875rem;
        color: var(--text-muted);
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    /* Stats Cards */
    .stats-card {
        background: var(--bg-card);
        border-radius: 20px;
        padding: 2rem;
        border: 1px solid var(--border-color);
        box-shadow: var(--shadow-md);
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        position: relative;
        overflow: hidden;
        height: 100%;
    }

    .stats-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 4px;
        background: var(--gradient-primary);
    }

    .stats-card:hover {
        transform: translateY(-8px);
        box-shadow: var(--shadow-xl);
    }

    .stats-card-primary::before { background: linear-gradient(135deg, #6366f1, #4f46e5); }
    .stats-card-success::before { background: linear-gradient(135deg, #10b981, #059669); }
    .stats-card-warning::before { background: linear-gradient(135deg, #f59e0b, #d97706); }
    .stats-card-info::before { background: linear-gradient(135deg, #3b82f6, #2563eb); }

    .stats-icon {
        width: 60px;
        height: 60px;
        border-radius: 16px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.5rem;
        margin-bottom: 1.5rem;
        background: var(--gradient-primary);
        color: white;
    }

    .stats-card-primary .stats-icon { background: linear-gradient(135deg, #6366f1, #4f46e5); }
    .stats-card-success .stats-icon { background: linear-gradient(135deg, #10b981, #059669); }
    .stats-card-warning .stats-icon { background: linear-gradient(135deg, #f59e0b, #d97706); }
    .stats-card-info .stats-icon { background: linear-gradient(135deg, #3b82f6, #2563eb); }

    .stats-number {
        font-size: 2.5rem;
        font-weight: 800;
        color: var(--text-primary);
        margin-bottom: 0.5rem;
        display: block;
    }

    .stats-label {
        color: var(--text-secondary);
        font-weight: 600;
        margin-bottom: 1rem;
    }

    .stats-trend {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        color: var(--accent-color);
        font-size: 0.875rem;
        font-weight: 600;
        margin-bottom: 1.5rem;
    }

    .stats-link {
        color: var(--primary-color);
        text-decoration: none;
        font-weight: 600;
        display: flex;
        align-items: center;
        gap: 0.5rem;
        transition: all 0.3s ease;
    }

    .stats-link:hover {
        color: var(--primary-dark);
        transform: translateX(4px);
    }

    /* Chart Cards */
    .chart-card {
        background: var(--bg-card);
        border-radius: 20px;
        border: 1px solid var(--border-color);
        box-shadow: var(--shadow-md);
        transition: all 0.3s ease;
        height: 100%;
    }

    .chart-card:hover {
        box-shadow: var(--shadow-lg);
    }

    .chart-header {
        padding: 1.5rem 2rem 1rem;
        border-bottom: 1px solid var(--border-light);
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .chart-title {
        font-size: 1.25rem;
        font-weight: 700;
        color: var(--text-primary);
        margin: 0;
    }

    .chart-actions .btn {
        border-radius: 8px;
        font-weight: 600;
    }

    .chart-period .form-select {
        border-radius: 8px;
        border: 1px solid var(--border-color);
        background: var(--bg-secondary);
    }

    .chart-container {
        padding: 1.5rem 2rem 2rem;
        height: 350px;
        position: relative;
    }

    /* Activity Card */
    .activity-card {
        background: var(--bg-card);
        border-radius: 20px;
        border: 1px solid var(--border-color);
        box-shadow: var(--shadow-md);
        height: 100%;
    }

    .activity-header {
        padding: 1.5rem 2rem 1rem;
        border-bottom: 1px solid var(--border-light);
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .activity-title {
        font-size: 1.25rem;
        font-weight: 700;
        color: var(--text-primary);
        margin: 0;
    }

    .activity-link {
        color: var(--primary-color);
        text-decoration: none;
        font-weight: 600;
        font-size: 0.875rem;
    }

    .activity-list {
        padding: 1.5rem 2rem 2rem;
    }

    .activity-item {
        display: flex;
        align-items: flex-start;
        gap: 1rem;
        padding: 1rem 0;
        border-bottom: 1px solid var(--border-light);
    }

    .activity-item:last-child {
        border-bottom: none;
    }

    .activity-icon {
        width: 40px;
        height: 40px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1rem;
        flex-shrink: 0;
    }

    .activity-icon-success {
        background: rgba(16, 185, 129, 0.1);
        color: var(--accent-color);
    }

    .activity-icon-info {
        background: rgba(59, 130, 246, 0.1);
        color: var(--info-color);
    }

    .activity-icon-warning {
        background: rgba(245, 158, 11, 0.1);
        color: var(--warning-color);
    }

    .activity-text {
        color: var(--text-primary);
        margin-bottom: 0.25rem;
        font-weight: 500;
    }

    .activity-time {
        color: var(--text-muted);
        font-size: 0.875rem;
    }

    /* Quick Actions */
    .quick-actions-card {
        background: var(--bg-card);
        border-radius: 20px;
        border: 1px solid var(--border-color);
        box-shadow: var(--shadow-md);
        height: 100%;
    }

    .quick-actions-header {
        padding: 1.5rem 2rem 1rem;
        border-bottom: 1px solid var(--border-light);
    }

    .quick-actions-title {
        font-size: 1.25rem;
        font-weight: 700;
        color: var(--text-primary);
        margin: 0;
    }

    .quick-actions-list {
        padding: 1.5rem 2rem 2rem;
        display: grid;
        gap: 1rem;
    }

    .quick-action-item {
        display: flex;
        align-items: center;
        gap: 1rem;
        padding: 1rem;
        border-radius: 12px;
        background: var(--bg-secondary);
        color: var(--text-primary);
        text-decoration: none;
        font-weight: 600;
        transition: all 0.3s ease;
        border: 1px solid var(--border-light);
    }

    .quick-action-item:hover {
        background: var(--gradient-primary);
        color: white;
        transform: translateX(4px);
        box-shadow: var(--shadow-md);
    }

    .quick-action-icon {
        width: 40px;
        height: 40px;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        background: var(--bg-card);
        color: var(--primary-color);
        font-size: 1.1rem;
        transition: all 0.3s ease;
    }

    .quick-action-item:hover .quick-action-icon {
        background: rgba(255, 255, 255, 0.2);
        color: white;
    }

    /* Access Denied */
    .access-denied {
        display: flex;
        align-items: center;
        justify-content: center;
        min-height: 60vh;
    }

    .access-denied-content {
        text-align: center;
        max-width: 400px;
    }

    .access-denied-icon {
        font-size: 4rem;
        color: var(--danger-color);
        margin-bottom: 1.5rem;
    }

    .access-denied-title {
        font-size: 2rem;
        font-weight: 700;
        color: var(--text-primary);
        margin-bottom: 1rem;
    }

    .access-denied-text {
        color: var(--text-secondary);
        margin-bottom: 2rem;
        font-size: 1.1rem;
    }

    /* Responsive Design */
    @media (max-width: 768px) {
        .welcome-card {
            flex-direction: column;
            text-align: center;
            gap: 1.5rem;
        }

        .welcome-stats {
            justify-content: center;
        }

        .chart-container {
            height: 300px;
            padding: 1rem;
        }

        .stats-card {
            margin-bottom: 1rem;
        }
    }
</style>
@endpush

@push('scripts')
<script>
document.addEventListener("DOMContentLoaded", function() {
    // Get data from Laravel backend
    var totalDocuments = @json($totalDocuments);
    var totalCategories = @json($totalCategories);
    var totalUsers = @json($totalUsers);
    var totalValidations = @json($totalValidations);
    var pendingValidations = @json($pendingValidations);

    // Chart color schemes
    const lightColors = {
        primary: '#6366f1',
        success: '#10b981',
        warning: '#f59e0b',
        info: '#3b82f6',
        danger: '#ef4444',
        text: '#1e293b',
        grid: 'rgba(0,0,0,0.1)'
    };

    const darkColors = {
        primary: '#818cf8',
        success: '#34d399',
        warning: '#fbbf24',
        info: '#60a5fa',
        danger: '#f87171',
        text: '#f1f5f9',
        grid: 'rgba(255,255,255,0.1)'
    };

    let currentColors = lightColors;

    // Chart configurations
    const chartOptions = {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
            legend: {
                position: 'top',
                labels: {
                    usePointStyle: true,
                    padding: 20,
                    color: currentColors.text,
                    font: {
                        family: 'Inter',
                        weight: '600'
                    }
                }
            },
            tooltip: {
                backgroundColor: 'rgba(0,0,0,0.9)',
                titleColor: '#fff',
                bodyColor: '#fff',
                borderColor: currentColors.primary,
                borderWidth: 1,
                cornerRadius: 12,
                displayColors: true,
                titleFont: {
                    family: 'Inter',
                    weight: '600'
                },
                bodyFont: {
                    family: 'Inter'
                }
            }
        },
        animation: {
            duration: 1500,
            easing: 'easeInOutCubic'
        }
    };

    // 1. Overview Chart (Bar Chart)
    const ctxOverview = document.getElementById('overviewChart').getContext('2d');
    const overviewChart = new Chart(ctxOverview, {
        type: 'bar',
        data: {
            labels: ['Documents', 'Categories', 'Users', 'Validations'],
            datasets: [{
                label: 'Total Counts',
                data: [totalDocuments, totalCategories, totalUsers, totalValidations],
                backgroundColor: [
                    currentColors.primary + '20',
                    currentColors.success + '20',
                    currentColors.warning + '20',
                    currentColors.info + '20'
                ],
                borderColor: [
                    currentColors.primary,
                    currentColors.success,
                    currentColors.warning,
                    currentColors.info
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
                        color: currentColors.grid
                    },
                    ticks: {
                        color: currentColors.text,
                        font: {
                            family: 'Inter'
                        }
                    }
                },
                x: {
                    grid: {
                        display: false
                    },
                    ticks: {
                        color: currentColors.text,
                        font: {
                            family: 'Inter',
                            weight: '600'
                        }
                    }
                }
            }
        }
    });

    // 2. Document Types Chart (Doughnut)
    const ctxDocTypes = document.getElementById('documentTypesChart').getContext('2d');
    const documentTypesChart = new Chart(ctxDocTypes, {
        type: 'doughnut',
        data: {
            labels: ['PDF Documents', 'Word Documents', 'Excel Files', 'PowerPoint'],
            datasets: [{
                data: [
                    Math.floor(totalDocuments * 0.45),
                    Math.floor(totalDocuments * 0.30),
                    Math.floor(totalDocuments * 0.15),
                    Math.floor(totalDocuments * 0.10)
                ],
                backgroundColor: [
                    currentColors.primary + '80',
                    currentColors.success + '80',
                    currentColors.warning + '80',
                    currentColors.info + '80'
                ],
                borderColor: [
                    currentColors.primary,
                    currentColors.success,
                    currentColors.warning,
                    currentColors.info
                ],
                borderWidth: 2,
                hoverOffset: 10
            }]
        },
        options: {
            ...chartOptions,
            cutout: '60%'
        }
    });

    // 3. Growth Chart (Line Chart)
    const ctxGrowth = document.getElementById('growthChart').getContext('2d');
    const months = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun'];
    const growthChart = new Chart(ctxGrowth, {
        type: 'line',
        data: {
            labels: months,
            datasets: [{
                label: 'Documents',
                data: months.map((_, index) => Math.floor(totalDocuments * (0.6 + index * 0.08))),
                borderColor: currentColors.primary,
                backgroundColor: currentColors.primary + '20',
                fill: true,
                tension: 0.4,
                pointRadius: 6,
                pointHoverRadius: 8,
                borderWidth: 3
            }, {
                label: 'Users',
                data: months.map((_, index) => Math.floor(totalUsers * (0.5 + index * 0.1))),
                borderColor: currentColors.success,
                backgroundColor: currentColors.success + '20',
                fill: true,
                tension: 0.4,
                pointRadius: 6,
                pointHoverRadius: 8,
                borderWidth: 3
            }]
        },
        options: {
            ...chartOptions,
            scales: {
                y: {
                    beginAtZero: true,
                    grid: {
                        color: currentColors.grid
                    },
                    ticks: {
                        color: currentColors.text,
                        font: {
                            family: 'Inter'
                        }
                    }
                },
                x: {
                    grid: {
                        color: currentColors.grid
                    },
                    ticks: {
                        color: currentColors.text,
                        font: {
                            family: 'Inter'
                        }
                    }
                }
            },
            interaction: {
                intersect: false,
                mode: 'index'
            }
        }
    });

    // 4. Validation Chart (Polar Area)
    const ctxValidation = document.getElementById('validationChart').getContext('2d');
    const validationChart = new Chart(ctxValidation, {
        type: 'polarArea',
        data: {
            labels: ['Approved', 'Pending', 'Under Review', 'Rejected'],
            datasets: [{
                data: [
                    totalValidations - pendingValidations - Math.floor(totalValidations * 0.05),
                    Math.floor(pendingValidations * 0.4),
                    Math.floor(pendingValidations * 0.6),
                    Math.floor(totalValidations * 0.05)
                ],
                backgroundColor: [
                    currentColors.success + '70',
                    currentColors.warning + '70',
                    currentColors.info + '70',
                    currentColors.danger + '70'
                ],
                borderColor: [
                    currentColors.success,
                    currentColors.warning,
                    currentColors.info,
                    currentColors.danger
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
                        color: currentColors.grid
                    },
                    pointLabels: {
                        color: currentColors.text,
                        font: {
                            family: 'Inter',
                            weight: '600'
                        }
                    },
                    ticks: {
                        color: currentColors.text,
                        backdropColor: 'transparent'
                    }
                }
            }
        }
    });

    // Theme change handler
    function updateChartsTheme(isDark) {
        currentColors = isDark ? darkColors : lightColors;
        
        const charts = [overviewChart, documentTypesChart, growthChart, validationChart];
        
        charts.forEach(chart => {
            // Update legend colors
            if (chart.options.plugins && chart.options.plugins.legend) {
                chart.options.plugins.legend.labels.color = currentColors.text;
            }
            
            // Update tooltip colors
            if (chart.options.plugins && chart.options.plugins.tooltip) {
                chart.options.plugins.tooltip.borderColor = currentColors.primary;
            }
            
            // Update scale colors
            if (chart.options.scales) {
                Object.keys(chart.options.scales).forEach(scaleKey => {
                    const scale = chart.options.scales[scaleKey];
                    if (scale.ticks) {
                        scale.ticks.color = currentColors.text;
                    }
                    if (scale.grid) {
                        scale.grid.color = currentColors.grid;
                    }
                    if (scale.pointLabels) {
                        scale.pointLabels.color = currentColors.text;
                    }
                });
            }
            
            chart.update('none');
        });
    }

    // Listen for theme changes
    window.addEventListener('themeChanged', function(e) {
        updateChartsTheme(e.detail.theme === 'dark');
    });

    // Set initial theme
    const currentTheme = document.body.getAttribute('data-theme');
    updateChartsTheme(currentTheme === 'dark');

    // Export functionality
    document.getElementById('exportData').addEventListener('click', function() {
        const data = {
            summary: {
                totalDocuments,
                totalCategories,
                totalUsers,
                totalValidations,
                pendingValidations
            },
            exportDate: new Date().toISOString(),
            exportedBy: '{{ Auth::user()->name }}'
        };

        const dataStr = JSON.stringify(data, null, 2);
        const dataBlob = new Blob([dataStr], { type: 'application/json' });
        const url = URL.createObjectURL(dataBlob);
        const link = document.createElement('a');
        link.href = url;
        link.download = `dashboard-data-${new Date().toISOString().split('T')[0]}.json`;
        link.click();
        URL.revokeObjectURL(url);
    });

    // Add resize handler for responsive charts
    window.addEventListener('resize', function() {
        [overviewChart, documentTypesChart, growthChart, validationChart].forEach(chart => {
            chart.resize();
        });
    });
});
</script>
@endpush
