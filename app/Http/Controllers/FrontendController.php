<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use App\Models\Notification;

class FrontendController extends Controller
{
    public function search(Request $request) {

        $searchTerm = $request->input('query');

        $request->validate([
            'query' => 'required|string|max:255',
        ]);

        $authUser = Auth::user();

        $users = User::where('id', '!=', $authUser->id)
            ->where(function ($query) use ($searchTerm) {
                $query->where('name', 'LIKE', "%{$searchTerm}%")
                      ->orWhere('email', 'LIKE', "%{$searchTerm}%");
            })
            ->get();

        $users->each(function ($user) use ($authUser) {
            $user->buddy_status = $authUser->getBuddyStatus($user->id);
        });

        $context = [
            'users' => $users,
        ];

        return Inertia::render('Search/SearchResult', $context);
    }

    public function visitNotification(Notification $notification) {
        $notification->update([
            'seen' => true,
        ]);

        return redirect()->route($notification->href);
    }

    public function deleteNotification(Notification $notification) {
        $notification->delete();

        return redirect()->back();
    }
}
