@php
    $itemId = data_get($item, 'id', '');
    $label = data_get($item, 'label', '');
    $url = data_get($item, 'url', '/');
    $defaultSortOrder = is_numeric($index) ? (((int) $index + 1) * 10) : 10;
    $sortOrder = data_get($item, 'sort_order', $defaultSortOrder);
    $isEnabled = (bool) data_get($item, 'is_enabled', true);
    $opensNewTab = (bool) data_get($item, 'opens_new_tab', false);
@endphp

<div class="cms-repeater-item" data-header-item>
    <input data-header-field="id" name="nav_items[{{ $index }}][id]" type="hidden" value="{{ $itemId }}">
    <input data-header-field="sort_order" name="nav_items[{{ $index }}][sort_order]" type="hidden" value="{{ $sortOrder }}">

    <div class="cms-repeater-toolbar">
        <span data-item-label>Item</span>
        <div>
            <button type="button" data-header-move-up aria-label="Move item up">↑</button>
            <button type="button" data-header-move-down aria-label="Move item down">↓</button>
            <button class="danger" type="button" data-header-remove>Remove</button>
        </div>
    </div>

    <div class="cms-fields-grid">
        <div class="cms-field">
            <label>Label</label>
            <input data-header-field="label" name="nav_items[{{ $index }}][label]" type="text" maxlength="120" value="{{ $label }}" required>
            @error("nav_items.{$index}.label")
                <span class="cms-error">{{ $message }}</span>
            @enderror
        </div>

        <div class="cms-field">
            <label>URL</label>
            <input data-header-field="url" name="nav_items[{{ $index }}][url]" type="text" maxlength="2048" value="{{ $url }}" required>
            @error("nav_items.{$index}.url")
                <span class="cms-error">{{ $message }}</span>
            @enderror
        </div>

        <div class="cms-field cms-field-wide">
            <label class="cms-check">
                <input data-header-field="is_enabled_hidden" name="nav_items[{{ $index }}][is_enabled]" type="hidden" value="0">
                <input data-header-field="is_enabled" name="nav_items[{{ $index }}][is_enabled]" type="checkbox" value="1" @checked($isEnabled)>
                Show this item
            </label>

            <label class="cms-check">
                <input data-header-field="opens_new_tab_hidden" name="nav_items[{{ $index }}][opens_new_tab]" type="hidden" value="0">
                <input data-header-field="opens_new_tab" name="nav_items[{{ $index }}][opens_new_tab]" type="checkbox" value="1" @checked($opensNewTab)>
                Open in a new tab
            </label>
        </div>
    </div>
</div>
