<div class="table-responsive">
    <table class="table">
        <tbody>
        @if($subCategory->categories->isNotEmpty())
        <tr>
            <td width="200px">CATEGORY</td>
            <td>{!! $subCategory->categories->pluck('name')->implode(', ') !!}</td>
        </tr>
        @endif
        @isset($subCategory->id)
        <tr>
            <td width="200px">ID</td>
            <td>{!! $subCategory->id !!}</td>
        </tr>
        @endisset
        @isset($subCategory->merchant_id)
        <tr>
            <td>VENDOR</td>
            <td>{!! $subCategory !!}</td>
        </tr>
        @endisset
        @isset($subCategory->name)
        <tr>
            <td>NAME</td>
            <td>{!! $subCategory->name !!}</td>
        </tr>
        @endisset
        @isset($subCategory->slug)
        <tr>
            <td>URL</td>
            <td>{!! $subCategory->slug !!}</td>
        </tr>
        @endisset
        @isset($subCategory->description)
        <tr>
            <td>DESCRIPTION</td>
            <td>{!! $subCategory->description !!}</td>
        </tr>
        @endisset
        @isset($subCategory->icon)
        <tr>
            <td>ICON</td>
            <td>{!! $subCategory->icon !!}</td>
        </tr>
        @endisset
        @isset($subCategory->image)
        <tr>
            <td>IMAGE</td>
            <td><img src="{!! asset($subCategory->image) !!}" alt="" class="img-fluid"></td>
        </tr>
        @endisset
        @isset($subCategory->status)
        <tr>
            <td>STATUS</td>
            <td>{!! $subCategory->status !!}</td>
        </tr>
        @endisset
        </tbody>
    </table>
</div>
