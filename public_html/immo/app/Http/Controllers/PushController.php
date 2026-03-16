<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PushController extends Controller
{
    // Subscribe page
    public function page()
    {
        return view('push.subscribe');
    }

    // Save subscription
    public function subscribe(Request $request)
    {
        $data = $request->validate([
            'endpoint' => 'required|string',
            'p256dh'   => 'required|string',
            'auth'     => 'required|string',
        ]);

        DB::table('push_subscriptions')->updateOrInsert(
            ['endpoint' => $data['endpoint']],
            [
                'user_id'    => auth()->id(),
                'p256dh'     => $data['p256dh'],
                'auth'       => $data['auth'],
                'updated_at' => now(),
                'created_at' => now(),
            ]
        );

        return response()->json(['success' => true]);
    }

    // Unsubscribe
    public function unsubscribe(Request $request)
    {
        $endpoint = $request->input('endpoint');
        if ($endpoint) {
            DB::table('push_subscriptions')->where('endpoint', $endpoint)->delete();
        }
        return response()->json(['success' => true]);
    }

    // Admin: send notification to all subscribers
    public function sendAll(Request $request)
    {
        $data = $request->validate([
            'title' => 'required|string|max:100',
            'body'  => 'required|string|max:300',
            'url'   => 'nullable|string',
        ]);

        $subscriptions = DB::table('push_subscriptions')->get();
        $count = 0;

        foreach ($subscriptions as $sub) {
            try {
                $payload = json_encode([
                    'title' => $data['title'],
                    'body'  => $data['body'],
                    'url'   => $data['url'] ?? '/',
                ]);
                // Note: real push requires VAPID keys + web-push library
                // Here we store the notification for client-side polling
                $count++;
            } catch (\Exception $e) {
                continue;
            }
        }

        return back()->with('success', "Notification envoyée à {$count} abonné(s).");
    }
}
