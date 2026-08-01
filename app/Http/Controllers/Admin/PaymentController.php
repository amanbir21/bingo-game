<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Payment;
use Inertia\Inertia;

class PaymentController extends Controller
{

    public function index()
    {

        $payments = Payment::with('user')
            ->latest()
            ->get();


        return Inertia::render(
            'Admin/Payments/Index',
            [
                'payments' => $payments
            ]
        );

    }

}