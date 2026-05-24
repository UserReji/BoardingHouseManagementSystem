<?php

namespace App\Http\Controllers\Tenant;

use App\Http\Controllers\Controller;
use App\Models\Announcement;

class AnnouncementController extends Controller
{
    public function index()
    {
        return view('tenant.announcements.index', [
            'announcements' => Announcement::visibleToTenants()->latest('published_at')->paginate(12),
        ]);
    }

    public function show(Announcement $announcement)
    {
        abort_unless($announcement->audience === 'all' || $announcement->audience === 'tenants', 403);

        return view('tenant.announcements.show', ['announcement' => $announcement->load('creator')]);
    }
}
