@php
    $oldIndustry = data_get(old('industries', []), (string) $industry->id, []);
    $value = fn (string $field) => array_key_exists($field, $oldIndustry)
        ? $oldIndustry[$field]
        : $industry->{$field};
    $facts = $value('facts') ?? [];
@endphp

<section class="cms-section-card industry-editor-card" data-industry-card>
    <header class="cms-section-header">
        <div>
            <span class="cms-section-type">industry</span>
            <h2>{{ $value('name') }}</h2>
        </div>

        <div class="cms-section-controls">
            <label class="cms-check">
                <input name="industries[{{ $industry->id }}][is_enabled]" type="hidden" value="0">
                <input
                    name="industries[{{ $industry->id }}][is_enabled]"
                    type="checkbox"
                    value="1"
                    @checked((bool) ($oldIndustry['is_enabled'] ?? $industry->is_enabled))
                >
                Visible
            </label>

            <label class="cms-order">
                Order
                <input
                    name="industries[{{ $industry->id }}][sort_order]"
                    type="number"
                    min="0"
                    max="10000"
                    value="{{ $oldIndustry['sort_order'] ?? $industry->sort_order }}"
                >
            </label>

            <button class="cms-collapse" type="button" data-industry-move-up aria-label="Move industry up">↑</button>
            <button class="cms-collapse" type="button" data-industry-move-down aria-label="Move industry down">↓</button>
            <button class="cms-collapse" type="button" data-industry-toggle aria-expanded="false">Expand</button>
            <button
                class="cms-button cms-button-danger"
                type="submit"
                form="delete-industry-{{ $industry->id }}"
                onclick="return confirm('Delete {{ addslashes($industry->name) }}?')"
            >Delete</button>
        </div>
    </header>

    <div class="cms-section-body" data-industry-body hidden>
        <div class="cms-fields-grid">
            <div class="cms-field">
                <label for="industry-{{ $industry->id }}-name">Name</label>
                <input id="industry-{{ $industry->id }}-name" name="industries[{{ $industry->id }}][name]" type="text" maxlength="160" value="{{ $value('name') }}" required>
            </div>

            <div class="cms-field">
                <label for="industry-{{ $industry->id }}-tag">Tag line</label>
                <input id="industry-{{ $industry->id }}-tag" name="industries[{{ $industry->id }}][tag]" type="text" maxlength="220" value="{{ $value('tag') }}" required>
            </div>

            <div class="cms-field cms-field-wide">
                <label for="industry-{{ $industry->id }}-body-before">Thesis before gold accent</label>
                <textarea id="industry-{{ $industry->id }}-body-before" name="industries[{{ $industry->id }}][body_before]" rows="5" maxlength="3000" required>{{ $value('body_before') }}</textarea>
            </div>

            <div class="cms-field">
                <label for="industry-{{ $industry->id }}-body-accent">Gold accent phrase</label>
                <input id="industry-{{ $industry->id }}-body-accent" name="industries[{{ $industry->id }}][body_accent]" type="text" maxlength="300" value="{{ $value('body_accent') }}">
            </div>

            <div class="cms-field">
                <label for="industry-{{ $industry->id }}-body-after">Thesis after gold accent</label>
                <textarea id="industry-{{ $industry->id }}-body-after" name="industries[{{ $industry->id }}][body_after]" rows="3" maxlength="3000">{{ $value('body_after') }}</textarea>
            </div>

            <div class="cms-field cms-field-wide">
                <label for="industry-{{ $industry->id }}-pull">Pull quote</label>
                <textarea id="industry-{{ $industry->id }}-pull" name="industries[{{ $industry->id }}][pull_quote]" rows="3" maxlength="600" required>{{ $value('pull_quote') }}</textarea>
            </div>

            <div class="cms-field cms-field-wide">
                <label>Fact chips</label>
                <div class="industry-facts-editor">
                    @for ($factIndex = 0; $factIndex < 8; $factIndex++)
                        <input
                            name="industries[{{ $industry->id }}][facts][{{ $factIndex }}]"
                            type="text"
                            maxlength="180"
                            value="{{ $facts[$factIndex] ?? '' }}"
                            placeholder="Fact {{ $factIndex + 1 }}"
                        >
                    @endfor
                </div>
                <small>Leave unused fact fields blank.</small>
            </div>

            <div class="cms-field cms-field-wide cms-image-field">
                <label for="industry-{{ $industry->id }}-image">Industry image</label>
                <div class="cms-image-control">
                    @if ($industry->image)
                        <img src="{{ $media->url($industry->image) }}" alt="">
                    @else
                        <div class="cms-image-empty">No image selected</div>
                    @endif

                    <div class="cms-image-actions">
                        <input
                            id="industry-{{ $industry->id }}-image"
                            name="industries[{{ $industry->id }}][image_upload]"
                            type="file"
                            accept=".jpg,.jpeg,.png,.webp,image/jpeg,image/png,image/webp"
                            data-image-input
                        >
                        <small>JPG, PNG or WebP. Maximum 8 MB.</small>

                        @if ($industry->image)
                            <label class="cms-check cms-check-danger">
                                <input name="industries[{{ $industry->id }}][remove_image]" type="hidden" value="0">
                                <input name="industries[{{ $industry->id }}][remove_image]" type="checkbox" value="1">
                                Remove current image
                            </label>
                        @endif
                    </div>
                </div>
            </div>

            <div class="cms-field cms-field-wide">
                <label for="industry-{{ $industry->id }}-alt">Image alt text</label>
                <input id="industry-{{ $industry->id }}-alt" name="industries[{{ $industry->id }}][image_alt]" type="text" maxlength="180" value="{{ $value('image_alt') }}">
            </div>
        </div>
    </div>
</section>
