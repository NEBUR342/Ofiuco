@props(['url'])
<tr>
    <td class="header">
        <a href="{{ $url }}" style="display: inline-block;">
            @if (trim($slot) === 'Laravel')
                <img src="{{ Storage::url('fantasmaclaro.jpg') }}" class="logo" alt="logo Ofiuco">
            @else
                {{ $slot }}
            @endif
        </a>
    </td>
</tr>
