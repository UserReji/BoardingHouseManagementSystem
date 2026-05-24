<?php

namespace App\Http\Controllers\Tenant;

use App\Http\Controllers\Controller;
use App\Models\Photo;

class GalleryController extends Controller
{
    public function index()
    {
        return view('tenant.gallery.index', [
            'photos' => Photo::with('room')->whereIn('visibility', ['public', 'tenants'])->latest()->paginate(12),
        ]);
    }

    public function show(Photo $photo)
    {
        abort_unless(in_array($photo->visibility, ['public', 'tenants'], true), 403);

        return view('tenant.gallery.show', ['photo' => $photo->load('room')]);
    }
}
