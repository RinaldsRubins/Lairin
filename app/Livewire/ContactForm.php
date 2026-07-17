<?php

namespace App\Livewire;

use App\Mail\ContactFormSubmitted;
use App\Models\ContactMessage;
use Illuminate\Support\Facades\Mail;
use Livewire\Component;

class ContactForm extends Component
{
    public string $name = '';

    public string $email = '';

    public string $phone = '';

    public string $subject = '';

    public string $message = '';

    public bool $submitted = false;

    public function submit(): void
    {
        $validated = $this->validate($this->rules(), $this->messages());

        $contactMessage = ContactMessage::create($validated);

        $adminEmail = config('services.google.admin_email');

        if ($adminEmail) {
            Mail::to($adminEmail)->send(new ContactFormSubmitted($contactMessage));
        }

        $this->submitted = true;
        $this->reset();

        session()->flash('contact_success', 'Paldies! Jūsu ziņa ir nosūtīta. Atbildēsim drīzumā.');
    }

    /**
     * @return array<string, mixed>
     */
    protected function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:150'],
            'email' => ['required', 'email', 'max:255'],
            'phone' => ['nullable', 'string', 'max:30'],
            'subject' => ['required', 'string', 'max:200'],
            'message' => ['required', 'string', 'max:5000'],
        ];
    }

    /**
     * @return array<string, string>
     */
    protected function messages(): array
    {
        return [
            'name.required' => 'Vārds ir obligāts.',
            'name.max' => 'Vārds nedrīkst būt garāks par 150 rakstzīmēm.',
            'email.required' => 'E-pasts ir obligāts.',
            'email.email' => 'Lūdzu, ievadiet derīgu e-pasta adresi.',
            'phone.max' => 'Tālruņa numurs nedrīkst būt garāks par 30 rakstzīmēm.',
            'subject.required' => 'Temats ir obligāts.',
            'subject.max' => 'Temats nedrīkst būt garāks par 200 rakstzīmēm.',
            'message.required' => 'Ziņa ir obligāta.',
            'message.max' => 'Ziņa nedrīkst būt garāka par 5000 rakstzīmēm.',
        ];
    }

    public function render()
    {
        return view('livewire.contact-form');
    }
}
