@extends('layouts.app')

@section('title', 'Dashboard')
@section('dashboard', 'active')
@section('content')

    @php
        $hour = (int) now()->format('G');
        $greeting = $hour < 12 ? 'Good morning' : ($hour < 17 ? 'Good afternoon' : 'Good evening');
        $todayNet = $todayReceivedAmount - $todayExpenses;
    @endphp

    <div class="container-fluid">
        <!-- Page heading -->
        <div class="pp-page-head">
            <div>
                <span class="pp-eyebrow">{{ now()->format('l, d F Y') }}</span>
                <h1>{{ $greeting }}, {{ explode(' ', trim(Auth::user()->name))[0] }}</h1>
                <p>Here's how the press is doing today.</p>
            </div>
            <div class="pp-page-actions">
                <a href="{{ route('sale.create') }}" class="btn btn-default">
                    <i class="fas fa-cash-register mr-1"></i> New Sale
                </a>
                <a href="{{ route('orders.create') }}" class="btn btn-primary">
                    <i class="fas fa-plus mr-1"></i> New Order
                </a>
            </div>
        </div>

        <!-- Today -->
        <div class="pp-section-title">Today</div>
        <div class="row">
            <div class="col-lg-4 col-md-6">
                <div class="pp-hero">
                    <div>
                        <span class="pp-eyebrow">Net collection</span>
                        <h3>Received minus expenses</h3>
                        <div class="pp-hero-value {{ $todayNet < 0 ? 'is-negative' : '' }}">{{ money($todayNet) }}
                        </div>
                    </div>
                    <div class="pp-hero-meta">
                        <div>Received<strong>{{ money($todayReceivedAmount) }}</strong></div>
                        <div>Expenses<strong>{{ money($todayExpenses) }}</strong></div>
                        <div>Orders<strong>{{ $todayOrder }}</strong></div>
                    </div>
                </div>
            </div>

            <div class="col-lg-4 col-md-6">
                <div class="pp-panel">
                    <div class="pp-panel-head">
                        <span class="pp-stat-icon pp-tone-success"
                            style="background:var(--pp-success-50);color:var(--pp-success)"><i
                                class="fas fa-arrow-down"></i></span>
                        <div>
                            <h3>Received today</h3>
                            <small>Cash and online, by account</small>
                        </div>
                    </div>
                    <div class="pp-panel-body">
                        <div class="pp-row">
                            <span><i class="pp-dot" style="background:var(--pp-success)"></i> Cash</span>
                            <strong>{{ money($todayCashAmount) }}</strong>
                        </div>
                        @forelse ($todayOnlineAmount as $item)
                            <div class="pp-row">
                                <span><i class="pp-dot" style="background:var(--pp-info)"></i> Online &middot;
                                    {{ getUserName($item['in_account']) }}</span>
                                <strong>{{ money($item['amount']) }}</strong>
                            </div>
                        @empty
                            <div class="pp-empty">No online payments yet today.</div>
                        @endforelse
                    </div>
                    <div class="pp-panel-foot">
                        <span>Total</span>
                        <strong style="color:var(--pp-success)">{{ money($todayReceivedAmount) }}</strong>
                    </div>
                </div>
            </div>

            <div class="col-lg-4 col-md-12">
                <div class="pp-panel">
                    <div class="pp-panel-head">
                        <span class="pp-stat-icon" style="background:var(--pp-danger-50);color:var(--pp-danger)"><i
                                class="fas fa-arrow-up"></i></span>
                        <div>
                            <h3>Expenses today</h3>
                            <small>Cash and online, by account</small>
                        </div>
                    </div>
                    <div class="pp-panel-body">
                        <div class="pp-row">
                            <span><i class="pp-dot" style="background:var(--pp-danger)"></i> Cash</span>
                            <strong>{{ money($todayCashExpenses) }}</strong>
                        </div>
                        @forelse ($todayOnlineExpenses as $item)
                            <div class="pp-row">
                                <span><i class="pp-dot" style="background:#d97706"></i> Online &middot;
                                    {{ getUserName($item['from_account']) }}</span>
                                <strong>{{ money($item['amount']) }}</strong>
                            </div>
                        @empty
                            <div class="pp-empty">No online expenses yet today.</div>
                        @endforelse
                    </div>
                    <div class="pp-panel-foot">
                        <span>Total</span>
                        <strong style="color:var(--pp-danger)">{{ money($todayExpenses) }}</strong>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-4 col-md-6">
                <a href="{{ route('orders.index') }}" class="pp-stat pp-tone-info">
                    <div class="pp-stat-top">
                        <span class="pp-stat-label">Orders booked today</span>
                        <span class="pp-stat-icon"><i class="fas fa-calendar-day"></i></span>
                    </div>
                    <div class="pp-stat-value">{{ $todayOrder }}</div>
                    <span class="pp-stat-link">View orders <i class="fas fa-arrow-right"></i></span>
                </a>
            </div>
            <div class="col-lg-4 col-md-6">
                <div class="pp-stat pp-tone-gold">
                    <div class="pp-stat-top">
                        <span class="pp-stat-label">Order value today</span>
                        <span class="pp-stat-icon"><i class="fas fa-rupee-sign"></i></span>
                    </div>
                    <div class="pp-stat-value">{{ money($todayOrderAmount) }}</div>
                    <span class="pp-stat-link">After discounts</span>
                </div>
            </div>
            <div class="col-lg-4 col-md-12">
                <a href="{{ route('orders.index', ['pending-amount' => '2']) }}" class="pp-stat pp-tone-danger">
                    <div class="pp-stat-top">
                        <span class="pp-stat-label">Pending amount</span>
                        <span class="pp-stat-icon"><i class="fas fa-hourglass-half"></i></span>
                    </div>
                    <div class="pp-stat-value">{{ money($borrowAmount) }}</div>
                    <span class="pp-stat-link">Delivered but unpaid <i class="fas fa-arrow-right"></i></span>
                </a>
            </div>
        </div>

        <!-- Orders pipeline -->
        <div class="pp-section-title">All orders</div>
        <div class="row">
            <div class="col-lg-3 col-6">
                <a href="{{ route('orders.index') }}" class="pp-stat pp-tone-primary">
                    <div class="pp-stat-top">
                        <span class="pp-stat-label">Total orders</span>
                        <span class="pp-stat-icon"><i class="fas fa-layer-group"></i></span>
                    </div>
                    <div class="pp-stat-value">{{ number_format($totalOrder) }}</div>
                    <span class="pp-stat-link">View all <i class="fas fa-arrow-right"></i></span>
                </a>
            </div>
            <div class="col-lg-3 col-6">
                <a href="{{ route('orders.index', ['status' => 'Pending']) }}" class="pp-stat pp-tone-danger">
                    <div class="pp-stat-top">
                        <span class="pp-stat-label">Pending</span>
                        <span class="pp-stat-icon"><i class="fas fa-clock"></i></span>
                    </div>
                    <div class="pp-stat-value">{{ number_format($totalOrderPending) }}</div>
                    <span class="pp-stat-link">View pending <i class="fas fa-arrow-right"></i></span>
                </a>
            </div>
            <div class="col-lg-3 col-6">
                <a href="{{ route('orders.index', ['status' => 'Completed']) }}" class="pp-stat pp-tone-warning">
                    <div class="pp-stat-top">
                        <span class="pp-stat-label">Completed</span>
                        <span class="pp-stat-icon"><i class="fas fa-check-double"></i></span>
                    </div>
                    <div class="pp-stat-value">{{ number_format($totalOrderComplete) }}</div>
                    <span class="pp-stat-link">Ready to deliver <i class="fas fa-arrow-right"></i></span>
                </a>
            </div>
            <div class="col-lg-3 col-6">
                <a href="{{ route('orders.index', ['status' => 'Delivered']) }}" class="pp-stat pp-tone-success">
                    <div class="pp-stat-top">
                        <span class="pp-stat-label">Delivered</span>
                        <span class="pp-stat-icon"><i class="fas fa-truck-loading"></i></span>
                    </div>
                    <div class="pp-stat-value">{{ number_format($totalOrderDelivered) }}</div>
                    <span class="pp-stat-link">View delivered <i class="fas fa-arrow-right"></i></span>
                </a>
            </div>
        </div>
    </div>

@endsection

@section('script')
@endsection
