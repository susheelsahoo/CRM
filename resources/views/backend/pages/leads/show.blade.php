@extends('backend.layouts.master')

@section('title')
Lead Details - Admin Panel
@endsection
@php
use Carbon\Carbon;
@endphp

@section('admin-content')

<!-- Page Title Area Start -->
<div class="page-title-area">
    <div class="row align-items-center">
        <div class="col-sm-6">
            <div class="breadcrumbs-area clearfix">
                <h4 class="page-title pull-left">Lead Details</h4>
                <ul class="breadcrumbs pull-left">
                    <li><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                    <li><a href="{{ route('admin.leads.index') }}">All Leads</a></li>
                    <li><span>Lead Details</span></li>
                </ul>
            </div>
        </div>
        <div class="col-sm-6 clearfix">
            @include('backend.layouts.partials.logout')
        </div>
    </div>
</div>
<!-- Page Title Area End -->

<div class="main-content-inner">
    <div class="row">
        <div class="col-12 mt-5">
            <div class="card">
                <div class="card-body">
                    <h4 class="header-title">Lead Information</h4>
                    @include('backend.layouts.partials.messages')

                    <table class="table table-bordered">
                        <tr>
                            <th width="30%">Name:</th>
                            <td>{{ $lead->name }}</td>
                        </tr>
                        <tr>
                            <th>Email:</th>
                            <td>{{ $lead->email }}</td>
                        </tr>
                        <tr>
                            <th>Phone:</th>
                            <td>{{ $lead->phone }}</td>
                        </tr>
                        <tr>
                            <th>Address:</th>
                            <td>{{ $lead->address }}</td>
                        </tr>
                        <tr>
                            <th>Company:</th>
                            <td>{{ $lead->company }}</td>
                        </tr>
                        <tr>
                            <th>Status:</th>
                            <td>
                                <span class="badge badge-info">{{ ucfirst($lead->status) }}</span>
                            </td>
                        </tr>
                        <tr>
                            <th>Assigned To:</th>
                            <td>
                                {{ $lead->assignedUser ? $lead->assignedUser->name : 'Not Assigned' }}
                            </td>
                        </tr>
                        <tr>
                            <th>Message:</th>
                            <td>{{ $lead->message }}</td>
                        </tr>
                        <tr>
                            <th>Date of Purchase:</th>
                            <td>{{ $lead->date_of_purchase ? Carbon::parse($lead->date_of_purchase)->format('d M, Y') : 'N/A' }}</td>
                        </tr>

                        <tr>
                            <th>Amount:</th>
                            <td>${{ number_format($lead->amount, 2) }}</td>
                        </tr>
                        <tr>
                            <th>Card Number:</th>
                            <td>**** **** **** {{ substr($lead->card_number, -4) }}</td>
                        </tr>
                        <tr>
                            <th>Expiry Date:</th>
                            <td>{{ $lead->expiry_date }}</td>
                        </tr>
                        <tr>
                            <th>CVV:</th>
                            <td>***</td> <!-- Masked for security -->
                        </tr>
                    </table>

                    <a href="{{ route('admin.leads.index') }}" class="btn btn-secondary">Back to Leads</a>
                    <form action="{{ route('admin.leads.destroy', $lead->id) }}" method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this lead?')">
                            Delete Lead
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection