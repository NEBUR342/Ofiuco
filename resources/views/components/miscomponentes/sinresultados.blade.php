<div @class([
    'text-white' => auth()->check() && auth()->user()->temaoscuro,
    'text-gray-700' => auth()->guest() || !auth()->user()->temaoscuro,
])>
    <p class="text-xl text-center mb-6">
        No se han encontrado resultados
    </p>
    @if (auth()->guest() || !auth()->user()->temaoscuro)
        <img src="{{ Storage::url('fantasmagrisclaro.jpg') }}" class="h-96 mx-auto" alt="logo Ofiuco">
    @else
        <img src="{{ Storage::url('fantasmagrisoscuro.jpg') }}" class="h-96 mx-auto" alt="logo Ofiuco">
    @endif
</div>
