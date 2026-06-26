@extends('layouts.admin')

@section('title', 'Newsletters')
@section('page-title', 'Newsletters')

@push('styles')
    <link rel="stylesheet" href="{{ asset_version('css/admin-newsletters.css') }}">
@endpush

@section('content')
    <div class="newsletter-admin">
        <header class="newsletter-head">
            <div>
                <p>Audience</p>
                <h2>Newsletter subscriptions</h2>
                <span>Review, search, unsubscribe, reactivate, or delete homepage newsletter entries.</span>
            </div>
        </header>

        @if (session('status'))
            <div class="newsletter-alert">{{ session('status') }}</div>
        @endif

        <section class="newsletter-metrics" aria-label="Newsletter metrics">
            <div><span>Total</span><strong>{{ number_format($totalCount) }}</strong></div>
            <div><span>Active</span><strong>{{ number_format($activeCount) }}</strong></div>
            <div><span>Unsubscribed</span><strong>{{ number_format($unsubscribedCount) }}</strong></div>
        </section>

        <form class="newsletter-filters" method="GET" action="{{ route('admin.newsletters.index') }}">
            <div>
                <label for="newsletter-search">Search email</label>
                <input id="newsletter-search" name="search" type="search" value="{{ $search }}" placeholder="name@example.com">
            </div>
            <div>
                <label for="newsletter-status">Status</label>
                <select id="newsletter-status" name="status">
                    <option value="">All</option>
                    <option value="active" @selected($status === 'active')>Active</option>
                    <option value="unsubscribed" @selected($status === 'unsubscribed')>Unsubscribed</option>
                </select>
            </div>
            <button type="submit">Apply</button>
            <a href="{{ route('admin.newsletters.index') }}">Reset</a>
        </form>

        <section class="newsletter-panel">
            @if ($subscribers->isEmpty())
                <div class="newsletter-empty">
                    <strong>No newsletter entries yet.</strong>
                    <span>New homepage newsletter submissions will appear here.</span>
                </div>
            @else
                <div class="newsletter-table-wrap">
                    <table class="newsletter-table">
                        <thead>
                            <tr>
                                <th>Email</th>
                                <th>Status</th>
                                <th>Source</th>
                                <th>Subscribed</th>
                                <th>Technical context</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($subscribers as $subscriber)
                                <tr>
                                    <td>
                                        <strong>{{ $subscriber->email }}</strong>
                                        <span>Added {{ $subscriber->created_at->format('M j, Y g:i A') }}</span>
                                    </td>
                                    <td>
                                        <span class="status-badge status-{{ $subscriber->status }}">{{ ucfirst($subscriber->status) }}</span>
                                    </td>
                                    <td>{{ $subscriber->source ?: 'homepage' }}</td>
                                    <td>
                                        @if ($subscriber->subscribed_at)
                                            {{ $subscriber->subscribed_at->format('M j, Y g:i A') }}
                                        @else
                                            -
                                        @endif
                                        @if ($subscriber->unsubscribed_at)
                                            <span>Unsubscribed {{ $subscriber->unsubscribed_at->format('M j, Y g:i A') }}</span>
                                        @endif
                                    </td>
                                    <td>
                                        <span>{{ $subscriber->ip_address ?: 'No IP captured' }}</span>
                                        <small>{{ $subscriber->user_agent ? str($subscriber->user_agent)->limit(90) : 'No user agent captured' }}</small>
                                    </td>
                                    <td>
                                        <div class="newsletter-actions">
                                            @if ($subscriber->status === 'active')
                                                <form method="POST" action="{{ route('admin.newsletters.update', $subscriber) }}">
                                                    @csrf
                                                    @method('PATCH')
                                                    <input name="status" type="hidden" value="unsubscribed">
                                                    <button type="submit">Unsubscribe</button>
                                                </form>
                                            @else
                                                <form method="POST" action="{{ route('admin.newsletters.update', $subscriber) }}">
                                                    @csrf
                                                    @method('PATCH')
                                                    <input name="status" type="hidden" value="active">
                                                    <button type="submit">Reactivate</button>
                                                </form>
                                            @endif

                                            <form method="POST" action="{{ route('admin.newsletters.destroy', $subscriber) }}" onsubmit="return confirm('Delete this newsletter entry?')">
                                                @csrf
                                                @method('DELETE')
                                                <button class="danger" type="submit">Delete</button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="newsletter-pagination">
                    {{ $subscribers->links() }}
                </div>
            @endif
        </section>
    </div>
@endsection
