<?php

namespace App\Http\Controllers;

use App\Mail\LaunchList;
use App\Models\PreSignupEmail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class PreSignupEmailController extends Controller
{
    public function index()
    {
        // TODO authz for super user
        $emails = PreSignupEmail::all();
        return view('pre-signup-emails.index', compact('emails'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'email' => 'required|email|unique:pre_signup_emails,email',
        ]);

        Mail::to($validated['email'])->send(new LaunchList());
        PreSignupEmail::create($validated);

        return redirect()->back()->with('success', 'Email added successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(PreSignupEmail $preSignupEmail)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(PreSignupEmail $preSignupEmail)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, PreSignupEmail $preSignupEmail)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(PreSignupEmail $preSignupEmail)
    {
        //
    }
}
