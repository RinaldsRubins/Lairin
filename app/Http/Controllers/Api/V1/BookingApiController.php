<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class BookingApiController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $bookings = Booking::query()
            ->with('service')
            ->when($request->filled('status'), fn ($query) => $query->where('status', $request->string('status')))
            ->when($request->filled('date'), fn ($query) => $query->whereDate('date', $request->string('date')))
            ->orderByDesc('date')
            ->orderByDesc('time')
            ->paginate($request->integer('per_page', 15));

        return response()->json($bookings);
    }

    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'company' => ['nullable', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255'],
            'phone' => ['required', 'string', 'max:50'],
            'service_id' => ['required', 'exists:services,id'],
            'meeting_type' => ['required', Rule::in(['online', 'onsite'])],
            'date' => ['required', 'date', 'after_or_equal:today'],
            'time' => ['required', 'date_format:H:i'],
            'comments' => ['nullable', 'string', 'max:2000'],
        ]);

        $booking = Booking::query()->create($validated);
        $booking->load('service');

        return response()->json([
            'message' => 'Rezervācija izveidota.',
            'data' => $booking,
            'management_url' => $booking->managementUrl(),
        ], 201);
    }

    public function show(Booking $booking): JsonResponse
    {
        $booking->load('service');

        return response()->json(['data' => $booking]);
    }

    public function cancel(Booking $booking): JsonResponse
    {
        if (! $booking->isCancellable()) {
            return response()->json([
                'message' => 'Šo rezervāciju nevar atcelt.',
            ], 422);
        }

        $booking->update([
            'status' => 'cancelled',
            'cancelled_at' => now(),
        ]);

        $booking->load('service');

        return response()->json([
            'message' => 'Rezervācija atcelta.',
            'data' => $booking,
        ]);
    }
}
