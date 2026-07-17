<?php

namespace App\Livewire;

use App\Jobs\CreateGoogleCalendarEvent;
use App\Models\Booking;
use App\Models\Service;
use App\Services\GoogleCalendarService;
use Carbon\Carbon;
use Illuminate\Validation\Rule;
use Livewire\Component;
use RuntimeException;

class BookingForm extends Component
{
    public string $first_name = '';

    public string $last_name = '';

    public string $company = '';

    public string $email = '';

    public string $phone = '';

    public ?int $service_id = null;

    public string $meeting_type = 'online';

    public string $date = '';

    public string $time = '';

    public string $comments = '';

    /** @var array<int, string> */
    public array $availableTimes = [];

    public bool $submitted = false;

    public function mount(): void
    {
        $this->date = now(config('services.google.timezone', 'Europe/Riga'))
            ->addDay()
            ->format('Y-m-d');
        $this->loadAvailableTimes();
    }

    public function updatedDate(): void
    {
        $this->time = '';
        $this->loadAvailableTimes();
    }

    public function updatedServiceId(): void
    {
        $this->loadAvailableTimes();
    }

    public function loadAvailableTimes(): void
    {
        if (empty($this->date)) {
            $this->availableTimes = [];

            return;
        }

        try {
            $duration = $this->selectedService()?->duration_minutes;
            $this->availableTimes = app(GoogleCalendarService::class)
                ->getAvailableSlots($this->date, $duration);
        } catch (RuntimeException) {
            $this->availableTimes = [];
        }
    }

    public function submit(): void
    {
        $validated = $this->validate($this->rules(), $this->messages());

        if (! in_array($validated['time'], $this->availableTimes, true)) {
            $this->addError('time', 'Izvēlētais laiks vairs nav pieejams. Lūdzu, izvēlieties citu laiku.');

            return;
        }

        $booking = Booking::create([
            ...$validated,
            'status' => 'pending',
        ]);

        CreateGoogleCalendarEvent::dispatch($booking);

        $this->submitted = true;
        $this->reset([
            'first_name',
            'last_name',
            'company',
            'email',
            'phone',
            'comments',
            'time',
        ]);
        $this->meeting_type = 'online';
        $this->loadAvailableTimes();

        session()->flash('booking_success', 'Paldies! Jūsu rezervācija ir saņemta. Apstiprinājumu nosūtīsim uz e-pastu.');
    }

    /**
     * @return array<string, mixed>
     */
    protected function rules(): array
    {
        return [
            'first_name' => ['required', 'string', 'max:100'],
            'last_name' => ['required', 'string', 'max:100'],
            'company' => ['nullable', 'string', 'max:200'],
            'email' => ['required', 'email', 'max:255'],
            'phone' => ['required', 'string', 'max:30'],
            'service_id' => ['required', 'integer', Rule::exists('services', 'id')->where('is_active', true)],
            'meeting_type' => ['required', Rule::in(['online', 'onsite'])],
            'date' => ['required', 'date', 'after_or_equal:today'],
            'time' => ['required', 'date_format:H:i'],
            'comments' => ['nullable', 'string', 'max:2000'],
        ];
    }

    /**
     * @return array<string, string>
     */
    protected function messages(): array
    {
        return [
            'first_name.required' => 'Vārds ir obligāts.',
            'first_name.max' => 'Vārds nedrīkst būt garāks par 100 rakstzīmēm.',
            'last_name.required' => 'Uzvārds ir obligāts.',
            'last_name.max' => 'Uzvārds nedrīkst būt garāks par 100 rakstzīmēm.',
            'company.max' => 'Uzņēmuma nosaukums nedrīkst būt garāks par 200 rakstzīmēm.',
            'email.required' => 'E-pasts ir obligāts.',
            'email.email' => 'Lūdzu, ievadiet derīgu e-pasta adresi.',
            'phone.required' => 'Tālruņa numurs ir obligāts.',
            'phone.max' => 'Tālruņa numurs nedrīkst būt garāks par 30 rakstzīmēm.',
            'service_id.required' => 'Lūdzu, izvēlieties pakalpojumu.',
            'service_id.exists' => 'Izvēlētais pakalpojums nav pieejams.',
            'meeting_type.required' => 'Lūdzu, izvēlieties tikšanās veidu.',
            'meeting_type.in' => 'Izvēlētais tikšanās veids nav derīgs.',
            'date.required' => 'Datums ir obligāts.',
            'date.date' => 'Lūdzu, ievadiet derīgu datumu.',
            'date.after_or_equal' => 'Rezervāciju var veikt tikai šodienai vai nākotnei.',
            'time.required' => 'Laiks ir obligāts.',
            'time.date_format' => 'Lūdzu, izvēlieties derīgu laiku.',
            'comments.max' => 'Komentāri nedrīkst būt garāki par 2000 rakstzīmēm.',
        ];
    }

    protected function selectedService(): ?Service
    {
        if ($this->service_id === null) {
            return null;
        }

        return Service::query()->find($this->service_id);
    }

    public function render()
    {
        return view('livewire.booking-form', [
            'services' => Service::query()->active()->get(),
            'minDate' => Carbon::today(config('services.google.timezone', 'Europe/Riga'))->format('Y-m-d'),
        ]);
    }
}
