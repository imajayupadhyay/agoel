@php
    $existingItems = collect($section->content[$fieldName] ?? [])->keyBy('_key');
@endphp

<div class="cms-field cms-field-wide cms-repeater" data-repeater>
    <div class="cms-repeater-heading">
        <div>
            <label>{{ $field['label'] }}</label>
            <small>Drag-free ordering controls are provided on every item.</small>
        </div>
        <button class="cms-button cms-button-secondary" type="button" data-add-item>Add item</button>
    </div>

    <div class="cms-repeater-list" data-repeater-list>
        @foreach ($items as $index => $item)
            @php
                $existingItem = $existingItems->get($item['_key'] ?? '', []);
                $item = array_merge($existingItem, $item);
            @endphp
            @include('admin.homepage.partials.repeater-item')
        @endforeach
    </div>

    <template data-repeater-template>
        @include('admin.homepage.partials.repeater-item', [
            'index' => '__INDEX__',
            'item' => ['_key' => '__KEY__'],
        ])
    </template>
</div>
