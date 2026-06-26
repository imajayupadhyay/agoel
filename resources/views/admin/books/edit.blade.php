@extends('layouts.admin')

@section('title', 'Books')
@section('page-title', 'Books')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/admin-homepage.css') }}">
@endpush

@section('content')
    <div class="cms-page">
        <header class="cms-page-header">
            <div>
                <p class="cms-eyebrow">Website content</p>
                <h2>Manage the Books page</h2>
                <p>Edit the manifesto, library shelf, annual reading lists, book reviews, closing quote, footer, SEO, publishing state, images, visibility, and ordering.</p>
            </div>

            <a class="cms-button cms-button-secondary" href="{{ route('books') }}" target="_blank" rel="noopener">
                View Books page ↗
            </a>
        </header>

        @if (session('status'))
            <div class="cms-alert cms-alert-success">{{ session('status') }}</div>
        @endif

        @if ($errors->any())
            <div class="cms-alert cms-alert-error">
                <strong>Books page was not saved.</strong>
                <span>Review the highlighted fields. {{ $errors->count() }} validation error(s) were found.</span>
            </div>
        @endif

        <div class="cms-layout">
            <aside class="cms-section-index">
                <strong>Sections</strong>
                <nav>
                    <a href="#books-seo">SEO & Publishing</a>
                    @foreach ($sections as $section)
                        <a href="#section-{{ $section->id }}">{{ $section->name }}</a>
                    @endforeach
                </nav>
            </aside>

            <div class="cms-editor">
                <form
                    id="books-form"
                    data-cms-form
                    method="POST"
                    action="{{ route('admin.books.update') }}"
                    enctype="multipart/form-data"
                >
                    @csrf
                    @method('PUT')

                    <section class="cms-section-card" id="books-seo">
                        <header class="cms-section-header">
                            <div>
                                <span class="cms-section-type">page settings</span>
                                <h2>SEO & Publishing</h2>
                            </div>
                        </header>

                        <div class="cms-section-body">
                            <div class="cms-fields-grid">
                                <div class="cms-field">
                                    <label for="page-title">Internal page title</label>
                                    <input id="page-title" name="page[title]" type="text" maxlength="160" value="{{ old('page.title', $page->title) }}" required>
                                </div>

                                <div class="cms-field">
                                    <label for="page-seo-title">SEO title</label>
                                    <input id="page-seo-title" name="page[seo_title]" type="text" maxlength="180" value="{{ old('page.seo_title', $page->seo_title) }}" required>
                                </div>

                                <div class="cms-field cms-field-wide">
                                    <label for="page-meta-description">Meta description</label>
                                    <textarea id="page-meta-description" name="page[meta_description]" rows="4" maxlength="320" required>{{ old('page.meta_description', $page->meta_description) }}</textarea>
                                </div>

                                <div class="cms-field cms-field-wide cms-image-field">
                                    <label for="page-og-image">Social sharing image</label>
                                    <div class="cms-image-control">
                                        @if ($page->og_image)
                                            <img src="{{ $media->url($page->og_image) }}" alt="">
                                        @else
                                            <div class="cms-image-empty">No social image</div>
                                        @endif

                                        <div class="cms-image-actions">
                                            <input id="page-og-image" name="page[og_image_upload]" type="file" accept=".jpg,.jpeg,.png,.webp,image/jpeg,image/png,image/webp">
                                            <small>Recommended: 1200 × 630 px.</small>

                                            @if ($page->og_image)
                                                <label class="cms-check cms-check-danger">
                                                    <input name="page[remove_og_image]" type="hidden" value="0">
                                                    <input name="page[remove_og_image]" type="checkbox" value="1">
                                                    Remove current image
                                                </label>
                                            @endif
                                        </div>
                                    </div>
                                </div>

                                @include('admin.partials.page-seo-controls')

                                <div class="cms-field cms-field-wide">
                                    <label class="cms-check">
                                        <input name="page[is_published]" type="hidden" value="0">
                                        <input name="page[is_published]" type="checkbox" value="1" @checked(old('page.is_published', $page->is_published))>
                                        Books page is published
                                    </label>
                                    <small>Turning this off makes the public Books page return 404.</small>
                                </div>
                            </div>
                        </div>
                    </section>

                    @foreach ($sections as $section)
                        @include('admin.homepage.partials.section')
                    @endforeach

                    <div class="cms-savebar">
                        <span>Changes are not public until you save.</span>
                        <button class="cms-button cms-button-primary" type="submit">Save Books page</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="{{ asset('js/admin-homepage.js') }}"></script>
@endpush
