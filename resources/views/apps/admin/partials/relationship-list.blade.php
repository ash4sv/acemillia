@if(isset($collection) && $collection->count())
    <ul class="list-unstyled mb-0">
        @foreach($collection as $item)
            <li>
                @isset($route)
                    <a href="{{ route($route, $item->id) }}">{{ $item->title ?? $item->name }}</a>
                @else
                    {{ $item->title ?? $item->name }}
                @endisset
            </li>
        @endforeach
    </ul>
@else
    <p class="mb-0">No items available.</p>
@endif
