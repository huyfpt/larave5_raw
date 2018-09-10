<nav class="fixed-bottom navbar-expand-lg navbar-dark bg-dark">
    @if (!isset($_COOKIE["comply_cookie"]))
    <div id="cookies">
        <p>@lang('app.message_cookies').
            {{-- <span class="cookie-accept" title="Accept"">X</span> --}}

            <button type="button" id="cookie-accept" class="btn">Autoriser</button>
            <button type="button" id="cookie-decline" class="btn">Refuser</button>
        </p>
    </div>
    @endif
</nav>