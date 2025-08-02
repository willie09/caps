<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Member;
use Illuminate\Support\Facades\Log;

class MemberController extends Controller
{
    public function index()
    {
        $members = \App\Models\Member::all();
        $membershipPrices = [
            'basic' => 500,
            'premium' => 700,
            'vip' => 1000,
        ];
        return view('member-list', ['members' => $members, 'membershipPrices' => $membershipPrices]);
    }

    public function notifyExpiryForm()
    {
        return view('members.notify-expiry');
    }

    public function sendExpiryNotifications()
    {
        $today = now()->startOfDay();
        $thresholdDate = $today->copy()->addDays(7);

        $members = \App\Models\Member::whereBetween('expiry_date', [$today, $thresholdDate])->get();

        foreach ($members as $member) {
            $member->notify(new \App\Notifications\MembershipExpiryNotification($member));
        }

        return redirect()->route('members.notifyExpiryForm')->with('success', 'Notification emails sent successfully.');
    }

    public function create()
    {
        return view('members.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:members,email',
            'membership_type' => 'required|in:basic,premium,vip',
            'expiry_date' => 'required|date|after:today'
        ]);

        Log::debug('Form submission received', $request->all());
        try {
            $member = Member::create([
                'name' => $validated['name'],
                'email' => $validated['email'],
                'membership_type' => $validated['membership_type'],
                'expiry_date' => $validated['expiry_date'],
                'join_date' => now()
            ]);
            Log::debug('Member created', $member->toArray());

            return redirect()->route('members.list')
                ->with('success', 'Member created successfully!');
                
        } catch (\Exception $e) {
            return back()->withInput()
                ->with('error', 'Error creating member: ' . $e->getMessage());
        }
    }

    public function edit($id)
    {
        return view('members.edit', compact('id'));
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:members,email,'.$id,
            'membership_type' => 'required|in:basic,premium,vip',
            'expiry_date' => 'required|date|after:today'
        ]);

        try {
            $member = Member::findOrFail($id);
            $member->update([
                'name' => $validated['name'],
                'email' => $validated['email'],
                'membership_type' => $validated['membership_type'],
                'expiry_date' => $validated['expiry_date']
            ]);

            return redirect()->route('members.list')
                ->with('success', 'Member updated successfully!');
                
        } catch (\Exception $e) {
            return redirect()->route('members.list')
                ->with('error', 'Error updating member: ' . $e->getMessage());
        }
    }

    public function destroy($id)
    {
        try {
            $member = Member::findOrFail($id);
            $member->delete();

            return redirect()->route('members.list')
                ->with('success', 'Member deleted successfully!');
                
        } catch (\Exception $e) {
            return redirect()->route('members.list')
                ->with('error', 'Error deleting member: ' . $e->getMessage());
        }
    }

    public function finance()
    {
        $members = \App\Models\Member::all();
        $walkInLogs = \App\Models\WalkInLog::all();
        $expenses = \App\Models\Expense::all();
        $membershipPrices = [
            'basic' => 500,
            'premium' => 700,
            'vip' => 1000,
        ];
        return view('finance', [
            'members' => $members,
            'walkInLogs' => $walkInLogs,
            'expenses' => $expenses,
            'membershipPrices' => $membershipPrices
        ]);
    }

    public function notifyMember($id)
    {
        try {
            $member = Member::findOrFail($id);
            \Log::info('Sending notification to member: ' . $member->email);
            $member->notify(new \App\Notifications\MembershipExpiryNotification($member));
            \Log::info('Notification sent successfully to: ' . $member->email);
            return redirect()->route('members.list')->with('success', 'Notification email sent successfully to ' . $member->name);
        } catch (\Exception $e) {
            \Log::error('Failed to send notification to member ID ' . $id . ': ' . $e->getMessage());
            return redirect()->route('members.list')->with('error', 'Failed to send notification: ' . $e->getMessage());
        }
    }
}
