<!-- resources/views/emails/family-invitation.blade.php -->
@component('mail::layout')
    {{-- Header --}}
    @slot('header')
        @component('mail::header', ['url' => config('app.url')])
            {{ config('app.name') }}
        @endcomponent
    @endslot

    {{-- Body --}}
    # Bonjour !

    Vous avez été invité à rejoindre l'arbre généalogique de la famille {{ $person->last_name }}.

    **Message personnel :**  
    {{ $message ?? "Vous avez été invité à gérer votre profil familial." }}

    **Profil concerné :**  
    {{ $person->first_name }} {{ $person->last_name }}

    @component('mail::button', ['url' => $url])
        Accepter l'invitation
    @endcomponent

    {{-- Footer --}}
    @slot('footer')
        @component('mail::footer')
            © {{ date('Y') }} {{ config('app.name') }}. Tous droits réservés.
        @endcomponent
    @endslot
@endcomponent