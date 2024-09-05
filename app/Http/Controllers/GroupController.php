<?php

namespace App\Http\Controllers;

use App\Models\Group;
use App\Models\Post;
use App\Models\Gallery;
use App\Models\GroupMember;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\Auth;
use App\Helpers\TimeHelper;

class GroupController extends Controller
{
    public function groups(Request $request) {

        $context = [];

        return Inertia::render('Group/Groups', $context);
    }

    public function createGroup(Request $request) {
        $group = Group::create([
            'name'          => $request->name,
            'admin_id'      => Auth::id(),
            'visibility'    => $request->visibility,
            'status'        => 'approved',
        ]);

        GroupMember::create([
            'member_id' => Auth::id(),
            'group_id'  => $group->id,
        ]);

        return redirect()->route('group.posts', $group->id);
    }

    public function deleteGroup(Group $group) {
        $galleries = Gallery::where('imageable_type', Group::class)->where('imageable_id', $group->id)->get();

        foreach ($galleries as $gallery) {
            $gallery->delete();
        }

        $group->delete();

        return redirect()->route('groups');
    }

    public function discoverGroups() {
        $groups = Group::withCount('members')->orderBy('created_at', 'desc')->get()->map(function ($group) {
            $is_member = GroupMember::where('status', 'approved')->where('group_id', $group->id)->where('member_id', Auth::id())->exists();
            $group->is_member = $is_member;

            return $group;
        });

        $context = [
            'groups' => $groups,
        ];

        return Inertia::render('Group/AllGroups', $context);
    }
    public function groupPosts(Group $group) {

        $posts = Post::where('group_id', $group->id)
                    ->with(['author', 'galleries'])
                    ->withCount('likes')
                    ->withCount(['likes as isLiked' => function ($query) {
                        $query->where('user_id', Auth::id());
                    }])
                    ->orderBy('created_at', 'desc')
                    ->get()
                    ->map(function ($post) {
                        $post = TimeHelper::addTimeDifference($post);
                        $post->isLiked = $post->isLiked > 0;
                        return $post;
                    });

        $is_member = GroupMember::where('status', 'approved')->where('group_id', $group->id)->where('member_id', Auth::id())->exists();
        $group->is_member = $is_member;

        $context = [
            'posts' => $posts,
            'group' => $group,
        ];

        return Inertia::render('Group/GroupPosts', $context);
    }

    public function groupMembers(Group $group) {
        $members = GroupMember::with('member')->where('group_id', $group->id)->where('status','approved')->orderBy('created_at', 'desc')->get();

        $context = [
            'members' => $members,
            'group'   => $group,
        ];

        return Inertia::render('Group/Members', $context);
    }

    public function joinGroup(Group $group) {
        GroupMember::create([
            'group_id'  => $group->id,
            'member_id' => Auth::id(),
            'status'    => $group->visibility === 'private' ? 'pending' : 'approved',
        ]);

        return redirect()->route('groups.posts', $group->id);
    }
}
