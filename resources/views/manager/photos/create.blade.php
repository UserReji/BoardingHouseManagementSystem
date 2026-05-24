@extends('layouts.manager', ['title' => 'Upload Photo'])

@section('content')
<div class="page-head"><h1 class="page-title">Upload Photo</h1></div>
<form method="POST" action="{{ route('manager.photos.store') }}" enctype="multipart/form-data" class="grid grid-2">
@csrf
<x-forms.input name="title" label="Title" required />
<x-forms.select name="room_id" label="Room"><option value="">Common area</option>@foreach ($rooms as $room)<option value="{{ $room->id }}">{{ $room->name }}</option>@endforeach</x-forms.select>
<x-forms.textarea name="description" label="Description" />
<x-forms.input name="taken_at" label="Taken at" type="date" />
<x-forms.select name="visibility" label="Visibility"><option value="tenants">Tenants</option><option value="public">Public</option><option value="managers">Managers</option></x-forms.select>
<x-forms.file-upload name="photo" label="Photo" accept="image/*" required />
<label><input type="checkbox" name="is_featured" value="1"> Featured</label>
<div><button class="btn primary" type="submit">Upload</button></div>
</form>
@endsection
