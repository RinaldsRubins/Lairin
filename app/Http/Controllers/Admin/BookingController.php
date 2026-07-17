<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class BookingController extends Controller
{
    public function index(Request $request): View
    {
        $bookings = Booking::query()
            ->with('service')
            ->when($request->filled('status'), fn ($query) => $query->where('status', $request->string('status')))
            ->when($request->filled('date'), fn ($query) => $query->whereDate('date', $request->string('date')))
            ->orderByDesc('date')
            ->orderByDesc('time')
            ->paginate(20);

        return view('admin.bookings.index', [
            'bookings' => $bookings,
            'statuses' => ['pending', 'confirmed', 'cancelled', 'rescheduled'],
            'filters' => $request->only(['status', 'date']),
        ]);
    }

    public function show(Booking $booking): View
    {
        $booking->load('service');

        return view('admin.bookings.show', compact('booking'));
    }

    public function updateStatus(Request $request, Booking $booking): RedirectResponse
    {
        $validated = $request->validate([
            'status' => ['required', Rule::in(['pending', 'confirmed', 'cancelled', 'rescheduled'])],
        ]);

        $data = ['status' => $validated['status']];

        if ($validated['status'] === 'cancelled') {
            $data['cancelled_at'] = now();
        }

        $booking->update($data);

        return redirect()
            ->route('admin.bookings.show', $booking)
            ->with('success', 'Rezervācijas statuss atjaunināts.');
    }
}
