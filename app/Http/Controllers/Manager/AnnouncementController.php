<?php

namespace App\Http\Controllers\Manager;

use App\Http\Controllers\Controller;
use App\Http\Requests\Manager\StoreAnnouncementRequest;
use App\Http\Requests\Manager\UpdateAnnouncementRequest;
use App\Models\Announcement;

class AnnouncementController extends Controller
{
    public function index()
    {
        return view('manager.announcements.index', [
            'announcements' => Announcement::latest()->paginate(12),
        ]);
    }

    public function create()
    {
        return view('manager.announcements.create');
    }

    public function store(StoreAnnouncementRequest $request)
    {
        $data = $request->validated();
        $data['is_pinned'] = $request->boolean('is_pinned');
        $data['created_by'] = $request->user()->id;

        $announcement = Announcement::create($data);

        return redirect()->route('manager.announcements.show', $announcement)->with('status', 'Announcement posted.');
    }

    public function show(Announcement $announcement)
    {
        return view('manager.announcements.show', ['announcement' => $announcement->load('creator')]);
    }

    public function edit(Announcement $announcement)
    {
        return view('manager.announcements.edit', ['announcement' => $announcement]);
    }

    public function update(UpdateAnnouncementRequest $request, Announcement $announcement)
    {
        $data = $request->validated();
        $data['is_pinned'] = $request->boolean('is_pinned');
        $announcement->update($data);

        return redirect()->route('manager.announcements.show', $announcement)->with('status', 'Announcement updated.');
    }

    public function destroy(Announcement $announcement)
    {
        $announcement->delete();

        return redirect()->route('manager.announcements.index')->with('status', 'Announcement deleted.');
    }
}
