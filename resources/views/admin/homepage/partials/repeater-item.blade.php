@php
    $itemKey = $item['_key'] ?? ('item-'.\Illuminate\Support\Str::random(10));
    $itemPrefix = "sections[{$section->id}][content][{$fieldName}][{$index}]";
@endphp

<div class="cms-repeater-item" data-repeater-item>
    <input name="{{ $itemPrefix }}[_key]" type="hidden" value="{{ $itemKey }}">

    <div class="cms-repeater-toolbar">
        <span data-item-label>Item</span>
        <div>
            <button type="button" data-move-up aria-label="Move item up">↑</button>
            <button type="button" data-move-down aria-label="Move item down">↓</button>
            <button class="danger" type="button" data-remove-item>Remove</button>
        </div>
    </div>

    <div class="cms-fields-grid">
        @foreach ($field['fields'] as $itemFieldName => $itemField)
            @if ($itemField['type'] === 'image')
                @php
                    $existingImage = $item[$itemFieldName] ?? null;
                    $uploadName = "{$itemPrefix}[{$itemFieldName}_upload]";
                    $removeName = "{$itemPrefix}[remove_{$itemFieldName}]";
                @endphp

                <div class="cms-field cms-field-wide cms-image-field">
                    <label>{{ $itemField['label'] }}</label>
                    <div class="cms-image-control cms-image-control-small">
                        @if ($existingImage)
                            <img src="{{ $media->url($existingImage) }}" alt="">
                        @else
                            <div class="cms-image-empty">No image</div>
                        @endif

                        <div class="cms-image-actions">
                            <input
                                name="{{ $uploadName }}"
                                type="file"
                                accept=".jpg,.jpeg,.png,.webp,image/jpeg,image/png,image/webp"
                                data-image-input
                            >

                            @if ($existingImage)
                                <label class="cms-check cms-check-danger">
                                    <input name="{{ $removeName }}" type="hidden" value="0">
                                    <input name="{{ $removeName }}" type="checkbox" value="1">
                                    Remove current image
                                </label>
                            @endif
                        </div>
                    </div>
                </div>
            @else
                @include('admin.homepage.partials.simple-field', [
                    'prefix' => $itemPrefix,
                    'fieldName' => $itemFieldName,
                    'field' => $itemField,
                    'value' => $item[$itemFieldName] ?? '',
                ])
            @endif
        @endforeach
    </div>
</div>
