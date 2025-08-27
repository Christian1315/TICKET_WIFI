<?php

namespace App\Http\Controllers;

use App\Models\Billing;
use App\Models\Package;
use App\Models\Payment;
use App\Models\Ticket;
use App\Models\User;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function __invoke()
    {
        // if (auth()->user()->isUser()) {
        //     $user = User::with('detail')->where('id', auth()->id())->firstOrFail();
        //     return view('dashboard2', compact('user'));
        // }

        if (auth()->user()->isAdmin()) {
            $totalPackages = Package::count();
            $totalBills = Billing::with("package")->get()
                ->sum(fn($billing) => $billing->price ?? 0);
            $totalPayments  = Payment::sum('package_price');
            $totalUsers = User::where('role', 'user')->count();
            $openTickets = Ticket::where('status', 'Open')->count();
            $recentUsers = User::with('detail')->where('role', 'user')->with(['billing', 'detail'])->latest()->take(5)->get();
            $recentPayments = Payment::with('user')->latest()->take(5)->get();
            $recentTickets = Ticket::latest()->take(5)->get();
            $paymentsThisMonth = Payment::whereMonth('created_at', now()->month)->sum('package_price');
            $billsThisMonth = Billing::whereMonth('created_at', now()->month)->get()
                ->sum(fn($billing) => $billing->price ?? 0);

            $paymentsThisYear = Payment::whereYear('created_at', now()->year)->get()
                ->sum(fn($billing) => $billing->price ?? 0);

            $billsThisYear = Billing::whereYear('created_at', now()->year)->get()
                ->sum(fn($billing) => $billing->price ?? 0);

            $usersWithDueCount = User::with('detail')->where('role', 'user')->get()
                ->filter(function ($user) {
                    return $user->due_amount($user->id) > 0;
                })->count();

            $usersWithDueList = User::with('detail')->where('role', 'user')->get()
                ->filter(function ($user) {
                    return $user->due_amount($user->id) > 0;
                });

            // Fetch the monthly billing and payment data
            $billingData = Billing::whereYear('created_at', Carbon::now()->year)
                ->get()->groupBy(function ($billing) {
                    return $billing->created_at->format('F');
                })->map(function ($billings) {
                    return $billings->sum(fn($billing) => $billing->price ?? 0);
                });

            $paymentData = Payment::whereYear('created_at', Carbon::now()->year)
                ->get()->groupBy(function ($payment) {
                    return $payment->created_at->format('F');
                })->map(function ($payments) {
                    return $payments->sum(fn($billing) => $billing->price ?? 0);
                });

            // Fetch the daily billing and payment data for the current month
            $daysInMonth = Carbon::now()->daysInMonth;
            $dailyBillingData = [];
            $dailyPaymentData = [];

            for ($day = 1; $day <= $daysInMonth; $day++) {
                $dailyBillingAmount = Billing::whereDate('created_at', Carbon::now()->year . '-' . Carbon::now()->month . '-' . $day)->get()
                    ->sum(fn($billing) => $billing->price ?? 0);

                $dailyPaymentAmount = Payment::whereDate('created_at', Carbon::now()->year . '-' . Carbon::now()->month . '-' . $day)->get()
                    ->sum(fn($billing) => $billing->price ?? 0);

                $dailyBillingData[] = $dailyBillingAmount;
                $dailyPaymentData[] = $dailyPaymentAmount;
            }
        } else {
            $user = auth()->user()->load([
                'detail',
                "billing",
                "routers",
                "tickets"
            ]);

            $totalPackages = $user->packages->count(); // Package::count();

            $totalBills = $user->billing
                ->sum(fn($billing) => $billing->package?->price ?? 0);
            $totalPayments  = $user->payment->sum('package_price');
            $totalUsers = [];
            $openTickets = $user->tickets->count(); // Ticket::where('status', 'Open')->count();
            $recentUsers = [];
            $recentPayments = []; //Payment::with('user')->latest()->take(5)->get();
            $recentTickets = []; //Ticket::latest()->take(5)->get();
            $paymentsThisMonth = $user->payment()->whereMonth('created_at', now()->month)->sum('package_price'); // Payment::whereMonth('created_at', now()->month)->sum('package_price');
            $billsThisMonth = $user->billing()->whereMonth('created_at', now()->month)->get()
                ->sum(fn($billing) => $billing->package?->price ?? 0); //Billing::whereMonth('created_at', now()->month)->get()->sum(fn($billing) => $billing->package?->price ?? 0);

            $paymentsThisYear = $user->payment()->whereYear('created_at', now()->year)->sum("package_price"); //Payment::whereYear('created_at', now()->year)->get()->sum(fn($billing) => $billing->package?->price ?? 0);

            $billsThisYear = $user->billing()->whereYear('created_at', now()->year)->get()->sum(fn($billing) => $billing->package?->price ?? 0); //Billing::whereYear('created_at', now()->year)->get()->sum(fn($billing) => $billing->package?->price ?? 0);

            $usersWithDueCount = 0;

            $usersWithDueList = 0;

            // Fetch the monthly billing and payment data
            $billingData = $user->billing()->whereYear('created_at', Carbon::now()->year)
                ->get()->groupBy(function ($billing) {
                    return $billing->created_at->format('F');
                })->map(function ($billings) {
                    return $billings->sum(fn($billing) => $billing->package?->price ?? 0);
                });

            $paymentData = $user->payment()->whereYear('created_at', Carbon::now()->year)
                ->get()->groupBy(function ($payment) {
                    return $payment->created_at->format('F');
                })->map(function ($payments) {
                    return $payments->sum(fn($billing) => $billing->package?->price ?? 0);
                });

            // Fetch the daily billing and payment data for the current month
            $daysInMonth = Carbon::now()->daysInMonth;
            $dailyBillingData = [];
            $dailyPaymentData = [];

            for ($day = 1; $day <= $daysInMonth; $day++) {
                $dailyBillingAmount = $user->billing()->whereDate('created_at', Carbon::now()->year . '-' . Carbon::now()->month . '-' . $day)->get()
                    ->sum(fn($billing) => $billing->package?->price ?? 0);

                $dailyPaymentAmount = $user->payment()->whereDate('created_at', Carbon::now()->year . '-' . Carbon::now()->month . '-' . $day)->get()
                    ->sum(fn($billing) => $billing->package?->price ?? 0);

                $dailyBillingData[] = $dailyBillingAmount;
                $dailyPaymentData[] = $dailyPaymentAmount;
            }
        }

        return view('dashboard', compact(
            'totalUsers',
            'totalBills',
            'totalPayments',
            'paymentsThisMonth',
            'billsThisMonth',
            'recentPayments',
            'recentUsers',
            'totalPackages',
            'paymentsThisYear',
            'billsThisYear',
            'usersWithDueCount',
            'usersWithDueList',
            'openTickets',
            'billingData',
            'paymentData',
            'dailyBillingData',
            'dailyPaymentData',
            'recentTickets'
        ));
    }
}
