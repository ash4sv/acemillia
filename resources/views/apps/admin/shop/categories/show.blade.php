<div class="table-responsive">
    <table class="table">
        <tbody>
        @isset($category->id)
        <tr>
            <td width="200px">ID</td>
            <td>{!! $category->id !!}</td>
        </tr>
        @endisset
        @isset($category->merchant_id)
        <tr>
            <td>VENDOR</td>
            <td>{!! $category !!}</td>
        </tr>
        @endisset
        @isset($category->name)
        <tr>
            <td>NAME</td>
            <td>{!! $category->name !!}</td>
        </tr>
        @endisset
        @isset($category->slug)
        <tr>
            <td>URL</td>
            <td>{!! $category->slug !!}</td>
        </tr>
        @endisset
        @isset($category->description)
        <tr>
            <td>DESCRIPTION</td>
            <td>{!! $category->description !!}</td>
        </tr>
        @endisset
        @isset($category->icon)
        <tr>
            <td>ICON</td>
            <td>{!! $category->icon !!}</td>
        </tr>
        @endisset
        @isset($category->image)
        <tr>
            <td>IMAGE</td>
            <td><img src="{!! asset($category->image) !!}" alt="" class="img-fluid"></td>
        </tr>
        @endisset
        @isset($category->status)
        <tr>
            <td>STATUS</td>
            <td>{!! $category->status !!}</td>
        </tr>
        @endisset
        </tbody>
    </table>
</div>
