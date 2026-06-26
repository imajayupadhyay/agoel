@extends('layouts.admin')

@section('title', 'Research Categories')
@section('page-title', 'Research Categories')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/admin-homepage.css') }}">
    <link rel="stylesheet" href="{{ asset('css/admin-industries.css') }}">
@endpush

@section('content')
    <div class="cms-page">
        <header class="cms-page-header">
            <div>
                <p class="cms-eyebrow">Research taxonomy</p>
                <h2>Research Categories</h2>
                <p>Control the public filter pills independently from the publications. Publications keep a database relationship to a category.</p>
            </div>

            <a class="cms-button cms-button-secondary" href="{{ route('admin.research.edit') }}">
                Back to Research page
            </a>
        </header>

        @if (session('status'))
            <div class="cms-alert cms-alert-success">{{ session('status') }}</div>
        @endif

        @if ($errors->any())
            <div class="cms-alert cms-alert-error">
                <strong>Research categories were not saved.</strong>
                <span>Review the highlighted fields. {{ $errors->count() }} validation error(s) were found.</span>
            </div>
        @endif

        <div class="cms-layout">
            <aside class="cms-section-index">
                <strong>Categories</strong>
                <nav>
                    @foreach ($categories as $category)
                        <a href="#category-{{ $category->id }}">{{ $category->label }}</a>
                    @endforeach
                </nav>

                <form class="cms-add-section" method="POST" action="{{ route('admin.research.categories.store') }}">
                    @csrf
                    <label for="new-category-name">Add category</label>
                    <input id="new-category-name" name="name" type="text" maxlength="120" placeholder="Category name" required>
                    <button class="cms-button cms-button-secondary" type="submit">Add category</button>
                </form>
            </aside>

            <div class="cms-editor">
                <form
                    id="research-categories-form"
                    data-cms-form
                    method="POST"
                    action="{{ route('admin.research.categories.update') }}"
                >
                    @csrf
                    @method('PUT')

                    @foreach ($categories as $category)
                        @php
                            $oldCategory = data_get(old('categories', []), (string) $category->id, []);
                            $value = fn (string $field) => array_key_exists($field, $oldCategory)
                                ? $oldCategory[$field]
                                : $category->{$field};
                        @endphp

                        <section class="cms-section-card" id="category-{{ $category->id }}">
                            <header class="cms-section-header">
                                <div>
                                    <span class="cms-section-type">category</span>
                                    <h2>{{ $value('label') }}</h2>
                                </div>

                                <div class="cms-section-controls">
                                    <label class="cms-check">
                                        <input name="categories[{{ $category->id }}][is_enabled]" type="hidden" value="0">
                                        <input
                                            name="categories[{{ $category->id }}][is_enabled]"
                                            type="checkbox"
                                            value="1"
                                            @checked((bool) ($oldCategory['is_enabled'] ?? $category->is_enabled))
                                        >
                                        Visible
                                    </label>

                                    <label class="cms-order">
                                        Order
                                        <input
                                            name="categories[{{ $category->id }}][sort_order]"
                                            type="number"
                                            min="0"
                                            max="10000"
                                            value="{{ $oldCategory['sort_order'] ?? $category->sort_order }}"
                                        >
                                    </label>

                                    <button
                                        class="cms-button cms-button-danger"
                                        type="submit"
                                        form="delete-category-{{ $category->id }}"
                                        @disabled($category->publications_count > 0)
                                        onclick="return confirm('Delete {{ addslashes($category->name) }}?')"
                                    >Delete</button>
                                </div>
                            </header>

                            <div class="cms-section-body">
                                <div class="cms-fields-grid">
                                    <div class="cms-field">
                                        <label for="category-{{ $category->id }}-name">Admin name</label>
                                        <input id="category-{{ $category->id }}-name" name="categories[{{ $category->id }}][name]" type="text" maxlength="120" value="{{ $value('name') }}" required>
                                    </div>

                                    <div class="cms-field">
                                        <label for="category-{{ $category->id }}-label">Public pill label</label>
                                        <input id="category-{{ $category->id }}-label" name="categories[{{ $category->id }}][label]" type="text" maxlength="120" value="{{ $value('label') }}" required>
                                    </div>

                                    <div class="cms-field">
                                        <label for="category-{{ $category->id }}-slug">Slug</label>
                                        <input id="category-{{ $category->id }}-slug" name="categories[{{ $category->id }}][slug]" type="text" maxlength="80" pattern="[a-z0-9-]+" value="{{ $value('slug') }}" required>
                                    </div>

                                    <div class="cms-field">
                                        <label>Attached publications</label>
                                        <input type="text" value="{{ $category->publications_count }}" disabled>
                                        <small>Move or delete attached publications before deleting this category.</small>
                                    </div>
                                </div>
                            </div>
                        </section>
                    @endforeach

                    <div class="cms-savebar">
                        <span>Category changes affect filter pills and attached publications.</span>
                        <button class="cms-button cms-button-primary" type="submit">Save categories</button>
                    </div>
                </form>

                @foreach ($categories as $category)
                    <form
                        id="delete-category-{{ $category->id }}"
                        method="POST"
                        action="{{ route('admin.research.categories.destroy', $category) }}"
                    >
                        @csrf
                        @method('DELETE')
                    </form>
                @endforeach
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="{{ asset('js/admin-homepage.js') }}"></script>
@endpush
