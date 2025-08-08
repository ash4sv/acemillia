<div class="table-responsive">
    <table class="table">
        <tbody>
        @isset($widget->id)
        <tr>
            <td width="200px">ID</td>
            <td>{!! $widget->id !!}</td>
        </tr>
        @endisset
        @isset($widget->name)
        <tr>
            <td>Name</td>
            <td>{!! $widget->name !!}</td>
        </tr>
        @endisset
        @isset($widget->image)
        <tr>
            <td>Image</td>
            <td><img src="{!! asset($widget->image) !!}" alt="" class="img-fluid"></td>
        </tr>
        @endisset
        @isset($widget->url)
        <tr>
            <td>URL</td>
            <td>{!! $widget->url !!}</td>
        </tr>
        @endisset
        @isset($widget->size)
        <tr>
            <td>Size</td>
            <td>{!! $widget->size !!}</td>
        </tr>
        @endisset
        @isset($widget->start_at)
        <tr>
            <td>Start At</td>
            <td>{!! $widget->start_at !!}</td>
        </tr>
        @endisset
        @isset($widget->end_at)
        <tr>
            <td>End At</td>
            <td>{!! $widget->end_at !!}</td>
        </tr>
        @endisset
        @isset($widget->status)
        <tr>
            <td>Status</td>
            <td>{!! $widget->status !!}</td>
        </tr>
        @endisset
        </tbody>
    </table>
</div>
