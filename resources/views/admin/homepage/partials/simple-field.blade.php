@php
    $inputName = "{$prefix}[{$fieldName}]";
    $inputId = 'field-'.str_replace(['[', ']', '.'], '-', $inputName);
@endphp

<div class="cms-field {{ $field['type'] === 'textarea' ? 'cms-field-wide' : '' }}">
    <label for="{{ $inputId }}">{{ $field['label'] }}</label>

    @if ($field['type'] === 'textarea')
        <textarea
            id="{{ $inputId }}"
            name="{{ $inputName }}"
            rows="5"
            maxlength="{{ $field['max'] ?? 4000 }}"
        >{{ $value }}</textarea>
    @elseif ($field['type'] === 'select')
        <select id="{{ $inputId }}" name="{{ $inputName }}">
            @foreach ($field['options'] as $optionValue => $optionLabel)
                <option value="{{ $optionValue }}" @selected($value === $optionValue)>{{ $optionLabel }}</option>
            @endforeach
        </select>
    @else
        <input
            id="{{ $inputId }}"
            name="{{ $inputName }}"
            type="{{ $field['type'] === 'email' ? 'email' : 'text' }}"
            value="{{ $value }}"
            maxlength="{{ $field['max'] ?? 1000 }}"
        >
    @endif

    @error(str_replace(['[', ']'], ['.', ''], $inputName))
        <span class="cms-error">{{ $message }}</span>
    @enderror
</div>
