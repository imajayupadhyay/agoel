@php
    $uploadName = "sections[{$section->id}][uploads][{$fieldName}]";
    $removeName = "sections[{$section->id}][remove_images][{$fieldName}]";
    $inputId = "section-{$section->id}-{$fieldName}";
@endphp

<div class="cms-field cms-field-wide cms-image-field">
    <label for="{{ $inputId }}">{{ $field['label'] }}</label>

    <div class="cms-image-control">
        @if ($value)
            <img src="{{ $media->url($value) }}" alt="">
        @else
            <div class="cms-image-empty">No image selected</div>
        @endif

        <div class="cms-image-actions">
            <input
                id="{{ $inputId }}"
                name="{{ $uploadName }}"
                type="file"
                accept=".jpg,.jpeg,.png,.webp,image/jpeg,image/png,image/webp"
                data-image-input
            >
            <small>JPG, PNG or WebP. Maximum 8 MB.</small>

            @if ($value)
                <label class="cms-check cms-check-danger">
                    <input name="{{ $removeName }}" type="hidden" value="0">
                    <input name="{{ $removeName }}" type="checkbox" value="1">
                    Remove current image
                </label>
            @endif
        </div>
    </div>
</div>
