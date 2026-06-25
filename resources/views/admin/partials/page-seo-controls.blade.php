<div class="cms-field cms-field-wide">
    <label for="page-canonical-url">Canonical URL override</label>
    <input
        id="page-canonical-url"
        name="page[canonical_url]"
        type="url"
        maxlength="2048"
        placeholder="Leave blank to use the page URL automatically"
        value="{{ old('page.canonical_url', $page->canonical_url) }}"
    >
    <small>Use only when this page should declare a different absolute canonical URL.</small>
    @error('page.canonical_url')<span class="cms-error">{{ $message }}</span>@enderror
</div>

<div class="cms-field">
    <label class="cms-check">
        <input name="page[robots_index]" type="hidden" value="0">
        <input name="page[robots_index]" type="checkbox" value="1" @checked(old('page.robots_index', $page->robots_index))>
        Allow search engines to index this page
    </label>
</div>

<div class="cms-field">
    <label class="cms-check">
        <input name="page[robots_follow]" type="hidden" value="0">
        <input name="page[robots_follow]" type="checkbox" value="1" @checked(old('page.robots_follow', $page->robots_follow))>
        Allow search engines to follow links
    </label>
</div>

<div class="cms-field cms-field-wide">
    <label class="cms-check">
        <input name="page[schema_override_enabled]" type="hidden" value="0">
        <input name="page[schema_override_enabled]" type="checkbox" value="1" @checked(old('page.schema_override_enabled', $page->schema_override_enabled))>
        Override the automatically generated JSON-LD schema
    </label>
    <small>Keep this disabled to receive automatic schema updates from the page content.</small>
</div>

<div class="cms-field cms-field-wide">
    <label for="page-schema-markup">JSON-LD schema</label>
    <textarea
        id="page-schema-markup"
        name="page[schema_markup]"
        rows="18"
        maxlength="100000"
        spellcheck="false"
    >{{ old('page.schema_markup', $page->schema_markup ?: $defaultSchemaJson) }}</textarea>
    <small>Must contain https://schema.org as @@context and an @@type or @@graph property.</small>
    @error('page.schema_markup')<span class="cms-error">{{ $message }}</span>@enderror
</div>

<div class="cms-field cms-field-wide">
    <label class="cms-check">
        <input name="page[sitemap_included]" type="hidden" value="0">
        <input name="page[sitemap_included]" type="checkbox" value="1" @checked(old('page.sitemap_included', $page->sitemap_included))>
        Include this page in the automatic sitemap
    </label>
</div>

<div class="cms-field">
    <label for="page-sitemap-frequency">Sitemap change frequency</label>
    <select id="page-sitemap-frequency" name="page[sitemap_change_frequency]">
        @foreach (['always', 'hourly', 'daily', 'weekly', 'monthly', 'yearly', 'never'] as $frequency)
            <option value="{{ $frequency }}" @selected(old('page.sitemap_change_frequency', $page->sitemap_change_frequency) === $frequency)>
                {{ ucfirst($frequency) }}
            </option>
        @endforeach
    </select>
</div>

<div class="cms-field">
    <label for="page-sitemap-priority">Sitemap priority</label>
    <input
        id="page-sitemap-priority"
        name="page[sitemap_priority]"
        type="number"
        min="0"
        max="1"
        step="0.1"
        value="{{ old('page.sitemap_priority', $page->sitemap_priority) }}"
        required
    >
    <small>Relative priority from 0.0 to 1.0.</small>
</div>
