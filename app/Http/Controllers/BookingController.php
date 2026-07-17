<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Concerns\LoadsSeoData;
use App\Models\Booking;
use App\Models\Service;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class BookingController extends Controller
{
    use LoadsSeoData;

    public function index(): View
    {
        $services = Service::query()
            ->where('is_active', true)
            ->orderBy('sort_order')
            ->get();

        return view('booking.index', [
            'services' => $services,
            'seo' => $this->seoFor('/konsultacija'),
        ]);
    }

    public function manage(string $token): View
    {
        $booking = $this->findBookingByToken($token);

        return view('booking.manage', [
            'booking' => $booking,
            'seo' => $this->seoFor('/konsultacija'),
        ]);
    }

    public function cancel(Request $request, string $token): RedirectResponse
    {
        $booking = $this->findBookingByToken($token);

        if (! $booking->isCancellable()) {
            return back()->with('error', 'Šo rezervāciju nevar atcelt.');
        }

        $booking->update([
            'status' => 'cancelled',
            'cancelled_at' => now(),
        ]);

        return redirect()
            ->route('booking.manage', ['token' => $token])
            ->with('success', 'Konsultācija ir atcelta.');
    }

    public function reschedule(Request $request, string $token): View|RedirectResponse
    {
        $booking = $this->findBookingByToken($token);

        if (! $booking->isCancellable()) {
            return redirect()
                ->route('booking.manage', ['token' => $token])
                ->with('error', 'Šo rezervāciju nevar pārcelt.');
        }

        if ($request->isMethod('post')) {
            $validated = $request->validate([
                'date' => ['required', 'date', 'after_or_equal:today'],
                'time' => ['required', 'date_format:H:i'],
            ], [
                'date.required' => 'Izvēlieties datumu.',
                'date.after_or_equal' => 'Datums nevar būt pagātnē.',
                'time.required' => 'Izvēlieties laiku.',
                'time.date_format' => 'Nederīgs laika formāts.',
            ]);

            $booking->update([
                'date' => $validated['date'],
                'time' => $validated['time'],
                'status' => 'rescheduled',
            ]);

            return redirect()
                ->route('booking.manage', ['token' => $token])
                ->with('success', 'Konsultācija ir pārcelta.');
        }

        $services = Service::query()
            ->where('is_active', true)
            ->orderBy('sort_order')
            ->get();

        return view('booking.reschedule', [
            'booking' => $booking,
            'services' => $services,
            'seo' => $this->seoFor('/konsultacija'),
        ]);
    }

    protected function findBookingByToken(string $token): Booking
    {
        return Booking::query()
            ->with('service')
            ->where('management_token', $token)
            ->firstOrFail();
    }
}
