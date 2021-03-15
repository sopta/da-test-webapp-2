<div class="modal js-rendererReplace" tabindex="-1" role="dialog" id="{{ $id }}" aria-hidden="true">
    <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content">
            <div class="modal-body">
                @php
                    $slot = trim($slot);
                @endphp
                @if (empty($slot))
                    @lang('app.delete.confirm')
                @else
                    {!! $slot !!}
                @endif
            </div>
            <div class="modal-footer">
                <form action="{{ $route }}" method="POST">
                    @csrf
                    @method($method ?? 'DELETE')
                    <button type="submit" class="btn btn-danger">@lang('app.modal.yes')</button>
                </form>
                <button type="button" class="btn btn-info" data-dismiss="modal">@lang('app.modal.no_dont')</button>
            </div>
        </div>
    </div>
</div>