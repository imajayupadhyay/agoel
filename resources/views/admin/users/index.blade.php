@extends('layouts.admin')

@section('title', 'Users')
@section('page-title', 'Users')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/admin-users.css') }}">
@endpush

@section('content')
    <div class="users-admin">
        <header class="users-head">
            <div>
                <p>User access</p>
                <h2>Manage administrators</h2>
                <span>Create administrator accounts, update details, reset passwords, and remove old access.</span>
            </div>
        </header>

        @if (session('status'))
            <div class="users-alert users-alert-success">{{ session('status') }}</div>
        @endif

        @if ($errors->any())
            <div class="users-alert users-alert-error">
                <strong>The request was not completed.</strong>
                <span>{{ $errors->first() }}</span>
            </div>
        @endif

        <section class="users-metrics" aria-label="Administrator metrics">
            <div><span>Administrator accounts</span><strong>{{ number_format($adminCount) }}</strong></div>
        </section>

        <section class="users-panel">
            <header class="users-panel-head">
                <div>
                    <span>Create</span>
                    <h3>Add an administrator</h3>
                </div>
            </header>

            <form class="users-form-grid" method="POST" action="{{ route('admin.users.store') }}">
                @csrf
                <div class="users-field">
                    <label for="create-name">Name</label>
                    <input id="create-name" name="name" type="text" maxlength="255" value="{{ old('name') }}" required>
                </div>
                <div class="users-field">
                    <label for="create-email">Email</label>
                    <input id="create-email" name="email" type="email" maxlength="255" value="{{ old('email') }}" required>
                </div>
                <div class="users-field">
                    <label for="create-password">Password</label>
                    <input id="create-password" name="password" type="password" minlength="12" autocomplete="new-password" required>
                </div>
                <div class="users-field">
                    <label for="create-password-confirmation">Confirm password</label>
                    <input id="create-password-confirmation" name="password_confirmation" type="password" minlength="12" autocomplete="new-password" required>
                </div>
                <button class="users-button users-button-primary" type="submit">Create administrator</button>
            </form>
        </section>

        <form class="users-filters" method="GET" action="{{ route('admin.users.index') }}">
            <div>
                <label for="users-search">Search</label>
                <input id="users-search" name="search" type="search" value="{{ $search }}" placeholder="Name or email">
            </div>
            <button type="submit">Apply</button>
            <a href="{{ route('admin.users.index') }}">Reset</a>
        </form>

        <section class="users-panel">
            @if ($users->isEmpty())
                <div class="users-empty">
                    <strong>No administrators found.</strong>
                    <span>Adjust the search or create a new administrator.</span>
                </div>
            @else
                <div class="users-table-wrap">
                    <table class="users-table">
                        <thead>
                            <tr>
                                <th>User</th>
                                <th>Last updated</th>
                                <th>Reset password</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($users as $managedUser)
                                <tr>
                                    <td>
                                        <form id="user-update-{{ $managedUser->id }}" method="POST" action="{{ route('admin.users.update', $managedUser) }}">
                                            @csrf
                                            @method('PUT')
                                        </form>

                                        <div class="users-inline-fields">
                                            <label>
                                                <span>Name</span>
                                                <input form="user-update-{{ $managedUser->id }}" name="name" type="text" maxlength="255" value="{{ old('name', $managedUser->name) }}" required>
                                            </label>
                                            <label>
                                                <span>Email</span>
                                                <input form="user-update-{{ $managedUser->id }}" name="email" type="email" maxlength="255" value="{{ old('email', $managedUser->email) }}" required>
                                            </label>
                                        </div>
                                        <span>Created {{ $managedUser->created_at->format('M j, Y g:i A') }}</span>
                                    </td>
                                    <td>
                                        <span>{{ $managedUser->updated_at->format('M j, Y g:i A') }}</span>
                                        @if ($managedUser->is(auth()->user()))
                                            <small>Current session</small>
                                        @endif
                                    </td>
                                    <td>
                                        <form class="users-password-form" method="POST" action="{{ route('admin.users.password.update', $managedUser) }}">
                                            @csrf
                                            @method('PUT')
                                            <input name="password" type="password" minlength="12" placeholder="New password" autocomplete="new-password" required>
                                            <input name="password_confirmation" type="password" minlength="12" placeholder="Confirm password" autocomplete="new-password" required>
                                            <button class="users-button" type="submit">Reset</button>
                                        </form>
                                    </td>
                                    <td>
                                        <div class="users-actions">
                                            <button class="users-button users-button-primary" form="user-update-{{ $managedUser->id }}" type="submit">Save</button>

                                            <form method="POST" action="{{ route('admin.users.destroy', $managedUser) }}" onsubmit="return confirm('Delete this user account?')">
                                                @csrf
                                                @method('DELETE')
                                                <button class="users-button users-button-danger" type="submit" @disabled($managedUser->is(auth()->user()))>Delete</button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="users-pagination">
                    {{ $users->links() }}
                </div>
            @endif
        </section>
    </div>
@endsection
