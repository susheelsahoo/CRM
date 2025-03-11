<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Models\Lead;
use App\Models\Admin;

class LeadController extends Controller
{
    protected $currentUser;

    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            $this->currentUser = Auth::guard('admin')->user();
            return $next($request);
        });
    }

    public function index()
    {
        $leads = Lead::where('assigned_to', $this->currentUser->id)
            ->latest()
            ->paginate(10);

        return view('backend.pages.leads.index', compact('leads'));
    }

    public function create()
    {
        $users = Admin::all();
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
            'date_of_purchase' => 'nullable|date',
            'amount' => 'nullable|numeric|min:0',
            'card_number' => 'nullable|string|max:16',
            'expiry_date' => 'nullable|string|max:5',
            'cvv' => 'nullable|string|max:4',
        ]);

        $currentUser = Auth::guard('admin')->user();

        $lead = Lead::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'address' => $request->address,
            'company' => $request->company,
            'message' => $request->message,
            'status' => $request->status,
            'date_of_purchase' => $request->date_of_purchase,
            'amount' => $request->amount,
            'card_number' => $request->card_number,
            'expiry_date' => $request->expiry_date,
            'cvv' => $request->cvv,
            'assigned_to' => $currentUser ? $currentUser->id : null,
        ]);

        return redirect()->route('admin.leads.index')->with('success', 'Lead created successfully!');
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
