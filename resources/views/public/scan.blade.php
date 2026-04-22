@php
    $branding = $station->getEffectiveBranding();
@endphp

<x-layouts.scanning :station="$station" :branding="$branding" :title="$station->name">
    @livewire('public-scanning-page', ['station' => $station])
</x-layouts.scanning>
