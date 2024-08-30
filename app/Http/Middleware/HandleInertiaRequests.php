<?php

namespace App\Http\Middleware;

use Illuminate\Http\Request;
use Inertia\Middleware;
use App\Models\Notification;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class HandleInertiaRequests extends Middleware
{
    /**
     * The root template that is loaded on the first page visit.
     *
     * @var string
     */
    protected $rootView = 'app';

    /**
     * Determine the current asset version.
     */
    public function version(Request $request): string|null
    {
        return parent::version($request);
    }

    /**
     * Define the props that are shared by default.
     *
     * @return array<string, mixed>
     */
    public function share(Request $request): array
    {

        $notifications = Auth::check() ? Notification::where('recipient_id', '=', Auth::user()->id)->with('sender')->take(5)->orderBy('created_at', 'desc')->get()->map(function ($request) {
            $createdAt = Carbon::parse($request->created_at);
            $now = Carbon::now();

            $secondsDifference = $createdAt->diffInSeconds($now);

            if ($secondsDifference < 60) {
                $request->time_difference = intval($secondsDifference) . ' seconds ago';
            } else {
                $minutesDifference = $createdAt->diffInMinutes($now);
                if ($minutesDifference < 60) {
                    $request->time_difference = intval($minutesDifference) . ' minutes ago';
                } else {
                    $hoursDifference = $createdAt->diffInHours($now);
                    if ($hoursDifference < 24) {
                        $request->time_difference = intval($hoursDifference) . ' hours ago';
                    } else {
                        $daysDifference = $createdAt->diffInDays($now);
                        $request->time_difference = intval($daysDifference) . ' days ago';
                    }
                }
            }

            return $request;
        }) : null;

        $unseen_notifications = Auth::check() ? Notification::where('recipient_id', '=', Auth::id())->where('seen', false)->exists() : false;

        return [
            ...parent::share($request),
            'auth' => [
                'user' => $request->user(),
            ],
            'notifications' => $notifications,
            'unseen_notifications' => $unseen_notifications
        ];
    }
}
