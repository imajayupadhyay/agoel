@extends('layouts.admin')

@section('title', 'Header')
@section('page-title', 'Header')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/admin-homepage.css') }}">
@endpush

@section('content')
    @php
        $oldItems = old('nav_items');
        $formItems = is_array($oldItems)
            ? collect($oldItems)
            : $items->map(fn ($item) => [
                'id' => $item->id,
                'label' => $item->label,
                'url' => $item->url,
                'sort_order' => $item->sort_order,
                'is_enabled' => $item->is_enabled ? 1 : 0,
                'opens_new_tab' => $item->opens_new_tab ? 1 : 0,
            ]);
    @endphp

    <div class="cms-page">
        <header class="cms-page-header">
            <div>
                <p class="cms-eyebrow">Global site chrome</p>
                <h2>Manage the public header</h2>
                <p>Edit the brand mark, brand name, brand link, and the full public navigation used across every public page.</p>
            </div>

            <a class="cms-button cms-button-secondary" href="{{ route('home') }}" target="_blank" rel="noopener">
                View website ↗
            </a>
        </header>

        @if (session('status'))
            <div class="cms-alert cms-alert-success">{{ session('status') }}</div>
        @endif

        @if ($errors->any())
            <div class="cms-alert cms-alert-error">
                <strong>The header was not saved.</strong>
                <span>Review the highlighted fields. {{ $errors->count() }} validation error(s) were found.</span>
            </div>
        @endif

        <form class="cms-editor" data-header-form method="POST" action="{{ route('admin.header.update') }}">
            @csrf
            @method('PUT')

            <section class="cms-section-card">
                <header class="cms-section-header">
                    <div>
                        <span class="cms-section-type">brand</span>
                        <h2>Brand</h2>
                    </div>
                </header>

                <div class="cms-section-body">
                    <div class="cms-fields-grid">
                        <div class="cms-field">
                            <label for="brand-mark">Brand mark</label>
                            <input id="brand-mark" name="settings[brand_mark]" type="text" maxlength="8" value="{{ old('settings.brand_mark', $settings->brand_mark) }}" required>
                            @error('settings.brand_mark')
                                <span class="cms-error">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="cms-field">
                            <label for="brand-name">Brand name</label>
                            <input id="brand-name" name="settings[brand_name]" type="text" maxlength="160" value="{{ old('settings.brand_name', $settings->brand_name) }}" required>
                            @error('settings.brand_name')
                                <span class="cms-error">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="cms-field cms-field-wide">
                            <label for="brand-url">Brand link</label>
                            <input id="brand-url" name="settings[brand_url]" type="text" maxlength="2048" value="{{ old('settings.brand_url', $settings->brand_url) }}" required>
                            <small>Use a relative URL like <code>/</code>, an anchor, mail link, or full URL.</small>
                            @error('settings.brand_url')
                                <span class="cms-error">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="cms-field cms-field-wide">
                            <label class="cms-check">
                                <input name="settings[is_enabled]" type="hidden" value="0">
                                <input name="settings[is_enabled]" type="checkbox" value="1" @checked(old('settings.is_enabled', $settings->is_enabled))>
                                Show the public header
                            </label>
                        </div>
                    </div>
                </div>
            </section>

            <section class="cms-section-card">
                <header class="cms-section-header">
                    <div>
                        <span class="cms-section-type">navigation</span>
                        <h2>Navigation items</h2>
                    </div>
                    <button class="cms-button cms-button-secondary" type="button" data-add-header-item>Add nav item</button>
                </header>

                <div class="cms-section-body">
                    <div class="cms-repeater">
                        <div class="cms-repeater-list" data-header-items>
                            @foreach ($formItems as $index => $item)
                                @include('admin.header.item', ['index' => $index, 'item' => $item])
                            @endforeach
                        </div>
                    </div>
                </div>
            </section>

            <div class="cms-savebar">
                <span>Header changes affect every public page after saving.</span>
                <button class="cms-button cms-button-primary" type="submit">Save Header</button>
            </div>
        </form>

        <template data-header-template>
            @include('admin.header.item', [
                'index' => '__INDEX__',
                'item' => [
                    'id' => '',
                    'label' => '',
                    'url' => '/',
                    'sort_order' => 10,
                    'is_enabled' => 1,
                    'opens_new_tab' => 0,
                ],
            ])
        </template>
    </div>
@endsection

@push('scripts')
    <script src="{{ asset('js/admin-header.js') }}"></script>
@endpush
