@php
    $oldPublication = data_get(old('publications', []), (string) $publication->id, []);
    $value = fn (string $field) => array_key_exists($field, $oldPublication)
        ? $oldPublication[$field]
        : $publication->{$field};
    $tags = $value('tags') ?? [];
@endphp

<section class="cms-section-card industry-editor-card">
    <header class="cms-section-header">
        <div>
            <span class="cms-section-type">publication</span>
            <h2>{{ $value('title') }}</h2>
        </div>

        <div class="cms-section-controls">
            <label class="cms-check">
                <input name="publications[{{ $publication->id }}][is_enabled]" type="hidden" value="0">
                <input
                    name="publications[{{ $publication->id }}][is_enabled]"
                    type="checkbox"
                    value="1"
                    @checked((bool) ($oldPublication['is_enabled'] ?? $publication->is_enabled))
                >
                Visible
            </label>

            <label class="cms-order">
                Order
                <input
                    name="publications[{{ $publication->id }}][sort_order]"
                    type="number"
                    min="0"
                    max="10000"
                    value="{{ $oldPublication['sort_order'] ?? $publication->sort_order }}"
                >
            </label>

            <button
                class="cms-button cms-button-danger"
                type="submit"
                form="delete-publication-{{ $publication->id }}"
                onclick="return confirm('Delete {{ addslashes($publication->title) }}?')"
            >Delete</button>
        </div>
    </header>

    <div class="cms-section-body">
        <div class="cms-fields-grid">
            <div class="cms-field cms-field-wide">
                <label for="publication-{{ $publication->id }}-title">Title</label>
                <input id="publication-{{ $publication->id }}-title" name="publications[{{ $publication->id }}][title]" type="text" maxlength="220" value="{{ $value('title') }}" required>
            </div>

            <div class="cms-field">
                <label for="publication-{{ $publication->id }}-category">Category</label>
                <select id="publication-{{ $publication->id }}-category" name="publications[{{ $publication->id }}][research_category_id]" required>
                    @foreach ($categories as $category)
                        <option value="{{ $category->id }}" @selected((int) $value('research_category_id') === $category->id)>
                            {{ $category->label }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="cms-field">
                <label for="publication-{{ $publication->id }}-venue">Venue</label>
                <input id="publication-{{ $publication->id }}-venue" name="publications[{{ $publication->id }}][venue]" type="text" maxlength="220" value="{{ $value('venue') }}">
            </div>

            <div class="cms-field">
                <label for="publication-{{ $publication->id }}-year">Year</label>
                <input id="publication-{{ $publication->id }}-year" name="publications[{{ $publication->id }}][year]" type="number" min="1" max="2200" value="{{ $value('year') }}">
            </div>

            <div class="cms-field">
                <label for="publication-{{ $publication->id }}-status">Status label</label>
                <input id="publication-{{ $publication->id }}-status" name="publications[{{ $publication->id }}][status]" type="text" maxlength="120" value="{{ $value('status') }}">
            </div>

            <div class="cms-field cms-field-wide">
                <label for="publication-{{ $publication->id }}-url">URL</label>
                <input id="publication-{{ $publication->id }}-url" name="publications[{{ $publication->id }}][url]" type="text" maxlength="2048" value="{{ $value('url') }}">
            </div>

            <div class="cms-field cms-field-wide">
                <label for="publication-{{ $publication->id }}-summary">Summary</label>
                <textarea id="publication-{{ $publication->id }}-summary" name="publications[{{ $publication->id }}][summary]" rows="4" maxlength="2000">{{ $value('summary') }}</textarea>
            </div>

            <div class="cms-field cms-field-wide">
                <label>Tags</label>
                <div class="industry-facts-editor">
                    @for ($tagIndex = 0; $tagIndex < 12; $tagIndex++)
                        <input
                            name="publications[{{ $publication->id }}][tags][{{ $tagIndex }}]"
                            type="text"
                            maxlength="80"
                            value="{{ $tags[$tagIndex] ?? '' }}"
                            placeholder="Tag {{ $tagIndex + 1 }}"
                        >
                    @endfor
                </div>
                <small>Leave unused tag fields blank.</small>
            </div>
        </div>
    </div>
</section>
