<div class="table-responsive">
    <table class="table">
        <tbody>
        @if($product->categories->isNotEmpty())
        <tr>
            <td width="200px">CATEGORY</td>
            <td>{!! $product->categories->pluck('name')->implode(', ') !!}</td>
        </tr>
        @endif
        @if($product->sub_categories->isNotEmpty())
        <tr>
            <td width="200px">SUB CATEGORY</td>
            <td>{!! $product->sub_categories->pluck('name')->implode(', ') !!}</td>
        </tr>
        @endif
        @if($product->merchant_id)
        <tr>
            <td width="200px">MERCHANT</td>
            <td></td>
        </tr>
        @endif
        @if($product->name)
        <tr>
            <td width="200px">NAME</td>
            <td>{!! $product->name !!}</td>
        </tr>
        @endif
        @if($product->slug)
        <tr>
            <td width="200px">NAME</td>
            <td>{!! $product->slug !!}</td>
        </tr>
        @endif
        @if($product->product_description)
        <tr>
            <td width="200px">PRODUCT DESCRIPTION</td>
            <td>{!! $product->description !!}</td>
        </tr>
        @endif
        @if($product->description)
        <tr>
            <td width="200px">DESCRIPTION</td>
            <td>{!! $product->description !!}</td>
        </tr>
        @endif
        @if($product->information)
        <tr>
            <td width="200px">INFORMATION</td>
            <td>{!! $product->information !!}</td>
        </tr>
        @endif
        @if($product->image)
        <tr>
            <td width="200px">MAIN IMAGE</td>
            <td>{!! $product->image !!}</td>
        </tr>
        @endif
        </tbody>
    </table>
</div>
