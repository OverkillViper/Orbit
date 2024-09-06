<?php

namespace App\Http\Controllers;

use App\Models\Group;
use App\Models\Post;
use App\Models\Gallery;
use App\Models\GroupMember;
use App\Models\Notification;

use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\Auth;
use App\Helpers\TimeHelper;
use App\Helpers\BuddyHelper;

class GroupController extends Controller
{

    private function loadGroup(Group $group) {
        $is_member = GroupMember::where('status', 'approved')->where('group_id', $group->id)->where('member_id', Auth::id())->exists();
        $requests  = GroupMember::where('status', 'pending')->where('group_id', $group->id)->count();
        $member_count = GroupMember::where('status', 'approved')->where('group_id', $group->id)->count();


        $group->is_member     = $is_member;
        $group->requests      = $requests;
        $group->member_count  = $member_count;

        return $group;
    }

    public function groups(Request $request) {

        $query = $request->input("query");

        $groups = $query ? Group::where("name","like","%".$query."%")->orderBy('created_at', 'desc')->get()->map(function ($group) {
            $group = $this->loadGroup($group);

            return $group;
        }) : null;
    
        $context = [
            'request' => $query,
            'groups'  => $groups,
        ];

        return Inertia::render('Group/Groups', $context);
    }

    public function createGroup(Request $request) {
        $group = Group::create([
            'name'          => $request->name,
            'admin_id'      => Auth::id(),
            'visibility'    => $request->visibility,
        ]);

        GroupMember::create([
            'member_id' => Auth::id(),
            'group_id'  => $group->id,
            'status'    => 'approved',
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
            $group->loadCount('members');

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

        $group = $this->loadGroup($group);
        
        if($group->visibility === 'public' || $group->is_member) {
            $context = [
                'posts' => $posts,
                'group' => $group,
            ];
    
            return Inertia::render('Group/GroupPosts', $context);
        } else {

            $requested = GroupMember::where('status', 'pending')->where('group_id', $group->id)->where('member_id', Auth::id())->exists();

            $context = [
                'group' => $group,
                'requested' => $requested,
            ];

            return Inertia::render('Group/PrivateGroup', $context);
        }
    }

    public function memberRequests(Group $group) {
        $requests = GroupMember::with('member')->where('status', 'pending')->where('group_id', $group->id)->get()->map(
            function ($request) {
                $request = TimeHelper::addTimeDifference($request);

                return $request;
            }
        );

        $group = $this->loadGroup($group);

        $context = [
            'group' => $group,
            'requests' => $requests,
        ];

        return Inertia::render('Group/MemberRequests', $context);
    }

    public function groupMembers(Group $group) {
        $members = GroupMember::with('member')->where('group_id', $group->id)->where('status','approved')->orderBy('created_at', 'desc')->get();

        $group = $this->loadGroup($group);

        if($group->visibility === 'public' || $group->is_member) {
            $context = [
                'members' => $members,
                'group'   => $group,
            ];
    
            return Inertia::render('Group/Members', $context);
        } else {

            $requested = GroupMember::where('status', 'pending')->where('group_id', $group->id)->where('member_id'. Auth::id())->exists();

            $context = [
                'group' => $group,
                'requested' => $requested,
            ];

            return Inertia::render('Group/PrivateGroup', $context);
        }
    }

    public function joinGroup(Group $group) {
        GroupMember::create([
            'group_id'  => $group->id,
            'member_id' => Auth::id(),
            'status'    => $group->visibility === 'private' ? 'pending' : 'approved',
        ]);

        Notification::create([
            'sender_id'    => Auth::id(),
            'recipient_id' => $group->admin_id,
            'title'        => $group->visibility === 'private' ? 'New member request' : 'New member joined',
            'content'      => $group->visibility === 'private' ? Auth::user()->name . ' has requested to join ' . $group->name : Auth::user()->name . ' has joined your ' . $group->name . ' group',
            'type'         => $group->visibility === 'private' ? 'group_request' : 'group_join',
            'href'         => $group->visibility === 'private' ? "/group/{$group->id}/requests" : "/group/{$group->id}/members",
        ]);

        return redirect()->route('group.posts', $group->id);
    }

    public function leaveGroup(Group $group) {
        $groupmember = GroupMember::where('status', 'approved')->where('group_id', $group->id)->where('member_id', Auth::id())->first();
        $groupmember->delete();

        return redirect()->back();
    }

    public function aboutGroup(Group $group) {
        $group = $this->loadGroup($group);

        $group->load('admin');

        $context = [
            'group' => $group,
        ];

        return Inertia::render('Group/AboutGroup', $context);
    }

    public function cancelJoinRequest(Group $group) {
        $groupmember = GroupMember::where('status', 'pending')->where('group_id', $group->id)->where('member_id', Auth::id())->first();
        $groupmember->delete();

        return redirect()->back();
    }

    public function acceptJoinRequest(GroupMember $request) {
        $request->update([
            'status' => 'approved',
        ]);

        Notification::create([
            'sender_id'    => Auth::id(),
            'recipient_id' => $request->member_id,
            'title'        => 'Welcome to ' . $request->group->name,
            'content'      => 'The admin of ' . $request->group->name . ' has accepted your join request',
            'type'         => 'group_request_accepted',
            'href'         => "/group/{$request->group->id}/posts"
        ]);

        return redirect()->back();
    }

    public function declineJoinRequest(GroupMember $request) {
        $request->delete();

        return redirect()->back();
    }
    
    public function joinedGroups() {
        $groups = GroupMember::with('group')->where("status", "approved")->where('member_id', Auth::id())->get()->map(function ($groupmember) {
            $group = $groupmember->group;
            $group->is_member = true;

            return $group;
        });

        $context = [
            'groups'        => $groups,
            'buddies_count' => BuddyHelper::getBuddiesCount(),
        ];

        return Inertia::render('Group/JoinedGroups', $context);
    }
}
