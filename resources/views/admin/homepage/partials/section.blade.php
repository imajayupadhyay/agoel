@php
    $sectionSchema = $schema->forSection($section);
    $content = $section->content ?? [];
    $oldSection = data_get(old('sections', []), (string) $section->id, []);
    $oldContent = $oldSection['content'] ?? [];
@endphp

<section class="cms-section-card" id="section-{{ $section->id }}" data-section-card>
    <header class="cms-section-header">
        <div>
            <span class="cms-section-type">{{ $sectionSchema['type'] }}</span>
            <h2>{{ $section->name }}</h2>
        </div>

        <div class="cms-section-controls">
            <label class="cms-check">
                <input name="sections[{{ $section->id }}][is_enabled]" type="hidden" value="0">
                <input
                    name="sections[{{ $section->id }}][is_enabled]"
                    type="checkbox"
                    value="1"
                    @checked((bool) ($oldSection['is_enabled'] ?? $section->is_enabled))
                >
                Visible
            </label>

            <label class="cms-order">
                Order
                <input
                    name="sections[{{ $section->id }}][sort_order]"
                    type="number"
                    min="0"
                    max="10000"
                    value="{{ $oldSection['sort_order'] ?? $section->sort_order }}"
                >
            </label>

            <button class="cms-collapse" type="button" data-section-move-up aria-label="Move section up">↑</button>
            <button class="cms-collapse" type="button" data-section-move-down aria-label="Move section down">↓</button>
            <button class="cms-collapse" type="button" data-section-toggle aria-expanded="true">Collapse</button>

            @if ($section->is_custom)
                <button
                    class="cms-button cms-button-danger"
                    type="submit"
                    form="delete-section-{{ $section->id }}"
                    onclick="return confirm('Delete this custom section?')"
                >Delete</button>
            @endif
        </div>
    </header>

    <div class="cms-section-body" data-section-body>
        @if ($section->is_custom)
            <div class="cms-fields-grid cms-custom-name">
                <div class="cms-field">
                    <label for="section-name-{{ $section->id }}">Admin section name</label>
                    <input
                        id="section-name-{{ $section->id }}"
                        name="sections[{{ $section->id }}][name]"
                        type="text"
                        value="{{ $oldSection['name'] ?? $section->name }}"
                        maxlength="120"
                        required
                    >
                </div>
            </div>
        @endif

        <div class="cms-fields-grid">
            @foreach ($sectionSchema['fields'] as $fieldName => $field)
                @php
                    $value = array_key_exists($fieldName, $oldContent)
                        ? $oldContent[$fieldName]
                        : ($content[$fieldName] ?? null);
                @endphp

                @if ($field['type'] === 'image')
                    @include('admin.homepage.partials.image-field')
                @elseif ($field['type'] === 'repeater')
                    @include('admin.homepage.partials.repeater-field', [
                        'items' => is_array($value) ? $value : [],
                    ])
                @else
                    @include('admin.homepage.partials.simple-field', [
                        'prefix' => "sections[{$section->id}][content]",
                    ])
                @endif
            @endforeach
        </div>
    </div>
</section>
