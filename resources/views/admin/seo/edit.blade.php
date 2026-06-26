@extends('layouts.admin')

@section('title', 'SEO Settings')
@section('page-title', 'SEO Settings')

@push('styles')
    <link rel="stylesheet" href="{{ asset_version('css/admin-homepage.css') }}">
@endpush

@section('content')
    <div class="cms-page">
        <header class="cms-page-header">
            <div>
                <p class="cms-eyebrow">Search engine controls</p>
                <h2>Global SEO settings</h2>
                <p>Laravel generates safe robots.txt and sitemap.xml files automatically. Enable an override only when you need complete manual control.</p>
            </div>
        </header>

        @if (session('status'))
            <div class="cms-alert cms-alert-success">{{ session('status') }}</div>
        @endif

        @if ($errors->any())
            <div class="cms-alert cms-alert-error">
                <strong>The SEO settings were not saved.</strong>
                <span>Review the highlighted fields. {{ $errors->count() }} validation error(s) were found.</span>
            </div>
        @endif

        <div class="cms-editor">
            <form method="POST" action="{{ route('admin.seo.update') }}">
                @csrf
                @method('PUT')

                <section class="cms-section-card">
                    <header class="cms-section-header">
                        <div>
                            <span class="cms-section-type">site identity</span>
                            <h2>Site defaults</h2>
                        </div>
                    </header>
                    <div class="cms-section-body">
                        <div class="cms-fields-grid">
                            <div class="cms-field cms-field-wide">
                                <label for="site-name">Site name</label>
                                <input id="site-name" name="site_name" type="text" maxlength="160" value="{{ old('site_name', $settings->site_name) }}" required>
                                <small>Used by automatically generated WebSite and WebPage schema.</small>
                            </div>
                        </div>
                    </div>
                </section>

                <section class="cms-section-card">
                    <header class="cms-section-header">
                        <div>
                            <span class="cms-section-type">crawler rules</span>
                            <h2>robots.txt</h2>
                        </div>
                        <a class="cms-button cms-button-secondary" href="{{ route('robots') }}" target="_blank" rel="noopener">View live file ↗</a>
                    </header>
                    <div class="cms-section-body">
                        <div class="cms-fields-grid">
                            <div class="cms-field cms-field-wide">
                                <label class="cms-check">
                                    <input name="robots_override_enabled" type="hidden" value="0">
                                    <input name="robots_override_enabled" type="checkbox" value="1" @checked(old('robots_override_enabled', $settings->robots_override_enabled))>
                                    Override the automatically generated robots.txt
                                </label>
                                <small>The default permits public crawling and advertises the sitemap. The admin area is kept private and is not listed here.</small>
                            </div>

                            <div class="cms-field cms-field-wide">
                                <label for="robots-content">Custom robots.txt content</label>
                                <textarea id="robots-content" name="robots_content" rows="12" maxlength="50000" spellcheck="false">{{ old('robots_content', $settings->robots_content ?: $defaultRobots) }}</textarea>
                                @error('robots_content')<span class="cms-error">{{ $message }}</span>@enderror
                            </div>
                        </div>
                    </div>
                </section>

                <section class="cms-section-card">
                    <header class="cms-section-header">
                        <div>
                            <span class="cms-section-type">URL discovery</span>
                            <h2>sitemap.xml</h2>
                        </div>
                        <a class="cms-button cms-button-secondary" href="{{ route('sitemap') }}" target="_blank" rel="noopener">View live file ↗</a>
                    </header>
                    <div class="cms-section-body">
                        <div class="cms-fields-grid">
                            <div class="cms-field cms-field-wide">
                                <label class="cms-check">
                                    <input name="sitemap_override_enabled" type="hidden" value="0">
                                    <input name="sitemap_override_enabled" type="checkbox" value="1" @checked(old('sitemap_override_enabled', $settings->sitemap_override_enabled))>
                                    Override the automatically generated sitemap.xml
                                </label>
                                <small>The default includes published pages that are enabled for sitemap inclusion.</small>
                            </div>

                            <div class="cms-field cms-field-wide">
                                <label for="sitemap-content">Custom sitemap XML</label>
                                <textarea id="sitemap-content" name="sitemap_content" rows="18" maxlength="1000000" spellcheck="false">{{ old('sitemap_content', $settings->sitemap_content ?: $defaultSitemap) }}</textarea>
                                @error('sitemap_content')<span class="cms-error">{{ $message }}</span>@enderror
                            </div>
                        </div>
                    </div>
                </section>

                <div class="cms-savebar">
                    <span>Overrides affect the live files immediately after saving.</span>
                    <button class="cms-button cms-button-primary" type="submit">Save SEO settings</button>
                </div>
            </form>
        </div>
    </div>
@endsection
