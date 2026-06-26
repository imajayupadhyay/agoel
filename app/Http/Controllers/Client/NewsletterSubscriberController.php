<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Http\Requests\Client\StoreNewsletterSubscriberRequest;
use App\Models\NewsletterSubscriber;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;

class NewsletterSubscriberController extends Controller
{
    public function store(StoreNewsletterSubscriberRequest $request): JsonResponse|RedirectResponse
    {
        if (filled($request->validated('website'))) {
            return $this->response($request, 'Thank you — you are on the list.');
        }

        $email = mb_strtolower(trim($request->validated('email')));

        DB::transaction(function () use ($email, $request): void {
            $subscriber = NewsletterSubscriber::query()->firstOrNew(['email' => $email]);
            $subscribedAt = $subscriber->exists && $subscriber->status === 'active'
                ? $subscriber->subscribed_at
                : now();

            $subscriber->fill([
                'status' => 'active',
                'source' => $request->validated('source') ?: 'homepage',
                'subscribed_at' => $subscribedAt,
                'unsubscribed_at' => null,
                'ip_address' => $request->ip(),
                'user_agent' => mb_substr((string) $request->userAgent(), 0, 2000),
            ]);

            $subscriber->save();
        });

        return $this->response($request, 'Thank you — you are on the list.');
    }

    private function response(StoreNewsletterSubscriberRequest $request, string $message): JsonResponse|RedirectResponse
    {
        if ($request->expectsJson()) {
            return response()->json([
                'message' => $message,
            ]);
        }

        return back()->with('newsletter_status', $message);
    }
}
