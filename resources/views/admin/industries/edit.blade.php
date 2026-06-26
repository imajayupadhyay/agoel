@extends('layouts.admin')

@section('title', 'Industries')
@section('page-title', 'Industries')

@push('styles')
    <link rel="stylesheet" href="{{ asset_version('css/admin-homepage.css') }}">
    <link rel="stylesheet" href="{{ asset_version('css/admin-industries.css') }}">
@endpush

@section('content')
    <div class="cms-page">
        <header class="cms-page-header">
            <div>
                <p class="cms-eyebrow">Website content</p>
                <h2>Manage the Industries page</h2>
                <p>Edit page sections, SEO, industry theses, imagery, visibility, and display order.</p>
            </div>

            <a class="cms-button cms-button-secondary" href="{{ route('industries') }}" target="_blank" rel="noopener">
                View Industries page ↗
            </a>
        </header>

        @if (session('status'))
            <div class="cms-alert cms-alert-success">{{ session('status') }}</div>
        @endif

        @if ($errors->any())
            <div class="cms-alert cms-alert-error">
                <strong>The Industries page was not saved.</strong>
                <span>Review the fields below. {{ $errors->count() }} validation error(s) were found.</span>
            </div>
        @endif

        <div class="cms-layout">
            <aside class="cms-section-index">
                <strong>Page sections</strong>
                <nav>
                    <a href="#industries-seo">SEO & Publishing</a>
                    @foreach ($sections as $section)
                        <a href="#section-{{ $section->id }}">{{ $section->name }}</a>
                    @endforeach
                    <a href="#industry-items">Industry entries</a>
                </nav>

                <form class="cms-add-section" method="POST" action="{{ route('admin.industries.items.store') }}">
                    @csrf
                    <label for="new-industry-name">Add industry</label>
                    <input id="new-industry-name" name="name" type="text" maxlength="160" placeholder="Industry name" required>
                    <button class="cms-button cms-button-secondary" type="submit">Add industry</button>
                </form>
            </aside>

            <div class="cms-editor">
                <form
                    id="industries-form"
                    data-cms-form
                    method="POST"
                    action="{{ route('admin.industries.update') }}"
                    enctype="multipart/form-data"
                >
                    @csrf
                    @method('PUT')

                    <section class="cms-section-card" id="industries-seo">
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
                                        Industries page is published
                                    </label>
                                    <small>Turning this off makes the public Industries page return 404.</small>
                                </div>
                            </div>
                        </div>
                    </section>

                    @foreach ($sections as $section)
                        @include('admin.homepage.partials.section')
                    @endforeach

                    <div class="industries-editor-heading" id="industry-items">
                        <div>
                            <span class="cms-section-type">portfolio records</span>
                            <h2>Industry entries</h2>
                        </div>
                        <p>Entries are server-rendered on the public page in the order shown here.</p>
                    </div>

                    <div data-industry-list>
                        @foreach ($industries as $industry)
                            @include('admin.industries.partials.industry')
                        @endforeach
                    </div>

                    <div class="cms-savebar">
                        <span>Changes are not public until you save.</span>
                        <button class="cms-button cms-button-primary" type="submit">Save Industries page</button>
                    </div>
                </form>

                @foreach ($industries as $industry)
                    <form
                        id="delete-industry-{{ $industry->id }}"
                        method="POST"
                        action="{{ route('admin.industries.items.destroy', $industry) }}"
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
    <script src="{{ asset_version('js/admin-homepage.js') }}"></script>
    <script src="{{ asset_version('js/admin-industries.js') }}"></script>
@endpush
