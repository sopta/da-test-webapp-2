<div class="modal" tabindex="-1" role="dialog" id="{{ $id }}" aria-hidden="true">
    <div class="modal-dialog {{ $extraClass ?? '' }}" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title">{{ $heading }}</h3>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                {{ $slot }}
            </div>
        </div>
    </div>
</div>
