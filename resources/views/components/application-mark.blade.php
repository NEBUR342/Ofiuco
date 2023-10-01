@if (auth()->guest() || !auth()->user()->temaoscuro)
    <img src="{{ Storage::url('fantasmaclaro.jpg') }}" class="h-16" alt="logo Ofiuco">
@else
    <img src="{{ Storage::url('fantasmaoscuro.jpg') }}" class="h-16" alt="logo Ofiuco">
@endif
