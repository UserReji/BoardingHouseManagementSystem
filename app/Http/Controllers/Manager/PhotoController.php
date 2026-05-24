<?php

namespace App\Http\Controllers\Manager;

use App\Http\Controllers\Controller;
use App\Http\Requests\Manager\StorePhotoRequest;
use App\Models\Photo;
use App\Models\Room;
use App\Services\Files\PhotoStorage;

class PhotoController extends Controller
{
    public function index()
    {
        return view('manager.photos.index', [
            'photos' => Photo::with('room', 'uploader')->latest()->paginate(12),
        ]);
    }

    public function create()
    {
        return view('manager.photos.create', ['rooms' => Room::orderBy('name')->get()]);
    }

    public function store(StorePhotoRequest $request, PhotoStorage $storage)
    {
        $data = $request->validated();
        $data['path'] = $storage->store($request->file('photo'), 'photos');
        $data['uploaded_by'] = $request->user()->id;
        $data['is_featured'] = $request->boolean('is_featured');

        $photo = Photo::create($data);

        return redirect()->route('manager.photos.show', $photo)->with('status', 'Photo uploaded.');
    }

    public function show(Photo $photo)
    {
        return view('manager.photos.show', ['photo' => $photo->load('room', 'uploader')]);
    }

    public function destroy(Photo $photo, PhotoStorage $storage)
    {
        $storage->delete($photo->path);
        $photo->delete();

        return redirect()->route('manager.photos.index')->with('status', 'Photo deleted.');
    }
}
