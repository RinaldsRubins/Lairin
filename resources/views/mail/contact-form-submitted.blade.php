<x-mail::message>
# Jauna kontaktformas ziņa

**Vārds:** {{ $contactMessage->name }}  
**E-pasts:** {{ $contactMessage->email }}  
@if ($contactMessage->phone)
**Tālrunis:** {{ $contactMessage->phone }}  
@endif
**Temats:** {{ $contactMessage->subject }}

---

{{ $contactMessage->message }}

<x-mail::button :url="'mailto:'.$contactMessage->email">
Atbildēt uz {{ $contactMessage->email }}
</x-mail::button>
</x-mail::message>
