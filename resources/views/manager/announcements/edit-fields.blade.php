<x-forms.input name="title" label="Title" :value="$announcement?->title" required />
<x-forms.textarea name="body" label="Body" :value="$announcement?->body" required />
<x-forms.select name="audience" label="Audience">
<option value="all" @selected(old('audience', $announcement?->audience) === 'all')>All</option>
<option value="tenants" @selected(old('audience', $announcement?->audience) === 'tenants')>Tenants</option>
<option value="managers" @selected(old('audience', $announcement?->audience) === 'managers')>Managers</option>
</x-forms.select>
<x-forms.input name="published_at" label="Published at" type="datetime-local" :value="$announcement?->published_at?->format('Y-m-d\\TH:i')" />
<x-forms.input name="expires_at" label="Expires at" type="datetime-local" :value="$announcement?->expires_at?->format('Y-m-d\\TH:i')" />
<label><input type="checkbox" name="is_pinned" value="1" @checked(old('is_pinned', $announcement?->is_pinned))> Pinned</label>
