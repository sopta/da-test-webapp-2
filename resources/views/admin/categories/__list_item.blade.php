<td>@if ($loop->depth > 1){{ $loop->parent->iteration }}.@endif{{ $loop->iteration }}</td>
<td>
    @if ($loop->depth > 1) - @endif<span class="@if ($loop->depth > 1) pl-3 @endif">{{ $category->name }}</span>
</td>
<td>
    @if ($loop->depth > 1)
        {{ $category->terms_count }} / {{$category->total_terms_count - $category->terms_count}} / {{ $category->possible_terms }}
    @endif
</td>
<td>
    <form action="{{ route('admin.categories.reorder', [$category]) }}" method="POST">
        @csrf
        <div class="btn-group" role="group">
            @can('view', $category)
                <a href="{{ route('admin.categories.show', [$category]) }}" title="@lang('app.actions.show')" class="btn btn-sm btn-secondary"><i class="fa fa-fw fa-info-circle"></i></a>
            @endcan
            @can('update', $category)
                <a href="{{ route('admin.categories.edit',[$category]) }}" title="@lang('app.actions.edit')" class="btn btn-sm btn-success"><i class="fa fa-fw fa-edit"></i></a>
                <button name="up" value="up" title="@lang('categories.table.move_up')" class="btn btn-sm @if (!$loop->first){{ "btn-warning" }}@endif" @if ($loop->first){{ "disabled=\"disabled\"" }}@endif><i class="fa fa-fw fa-arrow-alt-circle-up"></i></button>
                <button name="down" value="down" title="@lang('categories.table.move_down')" class="btn btn-sm @if (!$loop->last){{ "btn-warning" }}@endif" @if ($loop->last){{ "disabled=\"disabled\"" }}@endif><i class="fa fa-fw fa-arrow-alt-circle-down"></i></button>
            @endcan
            @can('delete', $category)
                <a href="#deleteCat_{{ $category->id }}" data-toggle="modal" title="@lang('app.actions.destroy')" class="btn btn-sm btn-danger"><i class="fa fa-fw fa-trash"></i></a>
            @endcan
        </div>
    </form>
    @can('delete', $category)
        <div>
            @component('components.modal_yes_no_form', [ 'id' => 'deleteCat_'.$category->id, 'route' => route('admin.categories.destroy', $category)] )
                @lang('categories.delete_modal', ['name' => $category->name])
            @endcomponent
        </div>
    @endcan
</td>
