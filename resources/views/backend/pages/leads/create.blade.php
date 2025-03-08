@extends('backend.layouts.master')

@section('title')
Create Lead - Admin Panel
@endsection

@section('styles')
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/css/select2.min.css" rel="stylesheet" />

<style>
    .form-check-label {
        text-transform: capitalize;
    }
</style>
@endsection

@section('admin-content')

<!-- Page Title Area Start -->
<div class="page-title-area">
    <div class="row align-items-center">
        <div class="col-sm-6">
            <div class="breadcrumbs-area clearfix">
                <h4 class="page-title pull-left">Create Lead</h4>
                <ul class="breadcrumbs pull-left">
                    <li><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                    <li><a href="{{ route('admin.leads.index') }}">All Leads</a></li>
                    <li><span>Create Lead</span></li>
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
        <!-- Form Start -->
        <div class="col-12 mt-5">
            <div class="card">
                <div class="card-body">
                    <h4 class="header-title">Create New Lead</h4>
                    @include('backend.layouts.partials.messages')

                    <form action="{{ route('admin.leads.store') }}" method="POST">
                        @csrf
                        <div class="form-row">
                            <div class="form-group col-md-6 col-sm-12">
                                <label for="name">Customer Name</label>
                                <input type="text" class="form-control" id="name" name="name" placeholder="Enter Lead Name" required>
                            </div>
                            <div class="form-group col-md-6 col-sm-12">
                                <label for="email">Email</label>
                                <input type="email" class="form-control" id="email" name="email" placeholder="Enter Email" required>
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group col-md-6 col-sm-12">
                                <label for="phone">Phone</label>
                                <input type="number" class="form-control" id="phone" name="phone" placeholder="Enter Phone Number">
                            </div>
                            <div class="form-group col-md-6 col-sm-12">
                                <label for="address">Address</label>
                                <input type="text" class="form-control" id="address" name="address" placeholder="Enter Address">
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group col-md-6 col-sm-12">
                                <label for="company">Company</label>
                                <input type="text" class="form-control" id="company" name="company" placeholder="Enter Company Name">
                            </div>
                            <div class="form-group col-md-6 col-sm-12">
                                <label for="status">Lead Status</label>
                                <select name="status" id="status" class="form-control select2">
                                    <option value="new">New</option>
                                    <option value="contacted">Contacted</option>
                                    <option value="qualified">Qualified</option>
                                    <option value="lost">Lost</option>
                                </select>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="message">Message</label>
                            <textarea class="form-control" id="message" name="message" rows="3" placeholder="Enter Message"></textarea>
                        </div>

                        <div class="form-row">
                            <div class="form-group col-md-6 col-sm-12">
                                <label for="date_of_purchase">Date of Purchase</label>
                                <input type="date" class="form-control" id="date_of_purchase" name="date_of_purchase">
                            </div>
                            <div class="form-group col-md-6 col-sm-12">
                                <label for="amount">Amount ($)</label>
                                <input type="number" class="form-control" id="amount" name="amount" step="0.01" placeholder="Enter Amount">
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group col-md-4 col-sm-12">
                                <label for="card_number">Card Number</label>
                                <input type="number" class="form-control" id="card_number" name="card_number" placeholder="Enter Card Number">
                            </div>
                            <div class="form-group col-md-4 col-sm-12">
                                <label for="expiry_date">Expiry Date (MM/YY)</label>
                                <input type="text" class="form-control" id="expiry_date" name="expiry_date" placeholder="MM/YY">
                            </div>
                            <div class="form-group col-md-4 col-sm-12">
                                <label for="cvv">CVV</label>
                                <input type="number" class="form-control" id="cvv" name="cvv" placeholder="Enter CVV">
                            </div>
                        </div>

                        <button type="submit" class="btn btn-primary mt-4 pr-4 pl-4">Save Lead</button>
                    </form>
                </div>
            </div>
        </div>
        <!-- Form End -->
    </div>
</div>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script>
<script>
    $(document).ready(function() {
        $('.select2').select2();
    })
</script>
@endsection