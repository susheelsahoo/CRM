@extends('layouts.app')

@section('content')
<h1>Leads</h1>
<a href="{{ route('leads.create') }}" class="btn btn-primary">Create Lead</a>

@if(session('success'))
<div class="alert alert-success">{{ session('success') }}</div>
@endif

<table class="table">
    <thead>
        <tr>
            <th>Name</th>
            <th>Email</th>
            <th>Phone</th>
            <th>Address</th>
            <th>Company</th>
            <th>Amount</th>
            <th>Status</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        @foreach($leads as $lead)
        <tr>
            <td>{{ $lead->name }}</td>
            <td>{{ $lead->email }}</td>
            <td>{{ $lead->phone }}</td>
            <td>{{ $lead->address }}</td>
            <td>{{ $lead->company }}</td>
            <td>${{ number_format($lead->amount, 2) }}</td>
            <td>{{ ucfirst($lead->status) }}</td>
            <td>
                <a href="{{ route('leads.show', $lead) }}" class="btn btn-info">View</a>
                <a href="{{ route('leads.edit', $lead) }}" class="btn btn-warning">Edit</a>
                <form action="{{ route('leads.destroy', $lead) }}" method="POST" style="display:inline;">
                    @csrf @method('DELETE')
                    <button class="btn btn-danger" onclick="return confirm('Are you sure?')">Delete</button>
                </form>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>

{{ $leads->links() }}
@endsection