<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Lead;
use App\Models\User;

class LeadController extends Controller
{
    public function index()
    {
        $leads = Lead::latest()->paginate(10);
        return view('backend.pages.leads.index', compact('leads'));
    }

    public function create()
    {
        $users = User::all();
        return view('backend.pages.leads.create', compact('users'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:leads,email',
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:255',
            'company' => 'nullable|string|max:255',
            'message' => 'nullable|string',
            'status' => 'required|in:new,contacted,qualified,lost',
            'assigned_to' => 'nullable|exists:users,id',
            'date_of_purchase' => 'nullable|date',
            'amount' => 'nullable|numeric|min:0',
            'card_number' => 'nullable|string|max:16',
            'expiry_date' => 'nullable|string|max:5',
            'cvv' => 'nullable|string|max:4',
        ]);

        Lead::create($request->all());
        return redirect()->route('leads.index')->with('success', 'Lead created successfully!');
    }

    public function show(Lead $lead)
    {
        return view('backend.pages.leads.show', compact('lead'));
    }

    public function edit(Lead $lead)
    {
        $users = User::all();
        return view('backend.pages.leads.edit', compact('lead', 'users'));
    }

    public function update(Request $request, Lead $lead)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:leads,email,' . $lead->id,
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:255',
            'company' => 'nullable|string|max:255',
            'message' => 'nullable|string',
            'status' => 'required|in:new,contacted,qualified,lost',
            'assigned_to' => 'nullable|exists:users,id',
            'date_of_purchase' => 'nullable|date',
            'amount' => 'nullable|numeric|min:0',
            'card_number' => 'nullable|string|max:16',
            'expiry_date' => 'nullable|string|max:5',
            'cvv' => 'nullable|string|max:4',
        ]);

        $lead->update($request->all());
        return redirect()->route('leads.index')->with('success', 'Lead updated successfully!');
    }

    public function destroy(Lead $lead)
    {
        $lead->delete();
        return redirect()->route('leads.index')->with('success', 'Lead deleted successfully!');
    }
}
