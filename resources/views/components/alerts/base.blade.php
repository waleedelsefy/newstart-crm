@props(['message', 'if' => true, 'auto_close' => false, 'delay' => 5000])


@if ($if)
    <div {{ $attributes->class(['alert', 'alert-dismissible', 'fade', 'show', "$auto_close" => $auto_close]) }}
        role="alert">
        <p class="mb-0">
            {{ $message }}
        </p>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">×</span>
        </button>
    </div>

    @push('scripts')
        @if ($auto_close)
            <script>
                $(document).ready(function() {
                    $(".{{ $auto_close }}").delay("{{ $delay }}").slideUp(300);
                });
            </script>
        @endif
    @endpush
@endif
