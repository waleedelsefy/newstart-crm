@props(['title' => 'Title', 'content' => '', 'save' => '', 'close' => 'Close']);

<style>
    #general-modal .select2-container {
        display: block;
    }
</style>

<!-- Modal -->
<div class="modal fade" id="general-modal" tabindex="-1" role="dialog" aria-labelledby="general-modal-title"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">{{ $title }}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                {!! $content !!}
            </div>
            <div class="modal-footer">
                @if ($close)
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ __($close) }}</button>
                @endif

                @if ($save)
                    <button type="button" class="btn btn-primary">{{ __($save) }}</button>
                @endif
            </div>
        </div>
    </div>
</div>
