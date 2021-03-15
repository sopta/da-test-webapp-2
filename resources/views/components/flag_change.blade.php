<div class="modal js-rendererReplace" tabindex="-1" role="dialog" id="{{ $id }}" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-body">
                <h4>@lang('app.change_flag.title')</h4>
                <form action="{{ $route }}" method="POST" class="flagChangeWrap">
                    @foreach (config('czechitas.flags') as $level => $flag)
                        <button type="submit" name="flag" value="{{ $level == 'default' ? null : $level }}" class="btn btn-sm btn-{{ $level == 'default' ? 'light' : $level }} mr-2">
                            <i class="fa fa-fw {{ $level == 'default' ? 'fa-times' : $flag }}"></i>
                        </button>
                    @endforeach
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-info" data-dismiss="modal">@lang('app.change_flag.cancel')</button>
            </div>
        </div>
    </div>
</div>
