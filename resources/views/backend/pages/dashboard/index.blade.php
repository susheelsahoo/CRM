@extends('backend.layouts.master')

@section('title', 'Dashboard - Admin Panel')

@section('admin-content')

<!-- Page Title Area Start -->
<div class="page-title-area">
    <div class="row align-items-center">
        <div class="col-md-6">
            <div class="breadcrumbs-area">
                <h4 class="page-title">Dashboard</h4>
                <ul class="breadcrumbs">
                    <li><a href="{{ route('admin.dashboard') }}">Home</a></li>
                    <li><span>Dashboard</span></li>
                </ul>
            </div>
        </div>
        <div class="col-md-6 text-right">
            @include('backend.layouts.partials.logout')
        </div>
    </div>
</div>
<!-- Page Title Area End -->

<div class="main-content-inner">
    <div class="row">
        <!-- Total Today Sales -->
        <div class="col-md-6 col-lg-4 mb-4">
            <div class="card shadow-sm">
                <div class="seo-fact sbg1">
                    <a href="{{ route('admin.sales.today') }}">
                        <div class="p-4 d-flex justify-content-between align-items-center">
                            <div class="seofct-icon"><i class="fa fa-shopping-cart"></i> Today's Sales</div>
                            <h2 class="text-white">{{ $total_today_sell }}</h2>
                        </div>
                    </a>
                </div>
            </div>
        </div>

        <!-- Total Sales -->
        <div class="col-md-6 col-lg-4 mb-4">
            <div class="card shadow-sm">
                <div class="seo-fact sbg2">
                    <a href="{{ route('admin.sales.index') }}">
                        <div class="p-4 d-flex justify-content-between align-items-center">
                            <div class="seofct-icon"><i class="fa fa-chart-line"></i> Total Sales</div>
                            <h2 class="text-white">{{ $total_sells }}</h2>
                        </div>
                    </a>
                </div>
            </div>
        </div>

        <!-- Monthly Sales -->
        <div class="col-md-6 col-lg-4 mb-4">
            <div class="card shadow-sm">
                <div class="seo-fact sbg3">
                    <a href="{{ route('admin.sales.monthly') }}">
                        <div class="p-4 d-flex justify-content-between align-items-center">
                            <div class="seofct-icon"><i class="fa fa-calendar-alt"></i> Month's Sales</div>
                            <h2 class="text-white">{{ $this_month_sell }}</h2>
                        </div>
                    </a>
                </div>
            </div>
        </div>

        <!-- Charge Back -->
        <div class="col-md-6 col-lg-4 mb-4">
            <div class="card shadow-sm">
                <div class="seo-fact sbg4">
                    <a href="{{ route('admin.sales.chargeback') }}">
                        <div class="p-4 d-flex justify-content-between align-items-center">
                            <div class="seofct-icon"><i class="fa fa-exclamation-triangle"></i> Chargebacks</div>
                            <h2 class="text-white">{{ $total_charge_back }}</h2>
                        </div>
                    </a>
                </div>
            </div>
        </div>

    </div>
</div>
@endsection