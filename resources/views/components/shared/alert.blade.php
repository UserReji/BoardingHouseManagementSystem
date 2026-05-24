@if (session('status'))
    <div class="alert">{{ session('status') }}</div>
@endif

@if ($errors->any())
    <div class="alert" style="border-color:#fecdca;background:#fffbfa;color:#b42318">
        Please check the highlighted fields and try again.
    </div>
@endif
