<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\NewsletterSubscriber;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class NewsletterController extends Controller
{
    public function index(Request $request): View
    {
        $status = $request->string('status')->toString();
        $search = trim($request->string('search')->toString());

        $subscribers = NewsletterSubscriber::query()
            ->when(in_array($status, ['active', 'unsubscribed'], true), fn ($query) => $query->where('status', $status))
            ->when($search !== '', fn ($query) => $query->where('email', 'like', "%{$search}%"))
            ->orderByDesc('created_at')
            ->paginate(25)
            ->withQueryString();

        return view('admin.newsletters.index', [
            'subscribers' => $subscribers,
            'status' => $status,
            'search' => $search,
            'activeCount' => NewsletterSubscriber::query()->where('status', 'active')->count(),
            'unsubscribedCount' => NewsletterSubscriber::query()->where('status', 'unsubscribed')->count(),
            'totalCount' => NewsletterSubscriber::query()->count(),
        ]);
    }

    public function updateStatus(NewsletterSubscriber $subscriber, Request $request): RedirectResponse
    {
        abort_unless($request->user()?->isAdmin(), 403);

        $data = $request->validate([
            'status' => ['required', 'in:active,unsubscribed'],
        ]);

        $subscriber->update([
            'status' => $data['status'],
            'subscribed_at' => $data['status'] === 'active' ? ($subscriber->subscribed_at ?: now()) : $subscriber->subscribed_at,
            'unsubscribed_at' => $data['status'] === 'unsubscribed' ? now() : null,
        ]);

        return back()->with('status', 'Newsletter subscriber updated.');
    }

    public function destroy(NewsletterSubscriber $subscriber, Request $request): RedirectResponse
    {
        abort_unless($request->user()?->isAdmin(), 403);

        $subscriber->delete();

        return back()->with('status', 'Newsletter subscriber deleted.');
    }
}
