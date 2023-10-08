<div @class([
    'mt-6',
    'text-white' => auth()->check() && auth()->user()->temaoscuro,
    'text-gray-700' => auth()->guest() || !auth()->user()->temaoscuro,
])>
    <p class="text-xl text-center mb-6">
        No se han encontrado resultados
    </p>
    <img src="{{ Storage::url('logo.png') }}" class="h-96 mx-auto" alt="logo Ofiuco">
</div>
