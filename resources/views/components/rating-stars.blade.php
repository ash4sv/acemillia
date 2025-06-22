<ul class="{{ $ulclass }}">
    @for ($i = 1; $i <= 5; $i++)
        @if ($rating >= $i)
            <li class="rating-on"><i class="fas fa-star"></i></li>
        @elseif ($rating >= $i - 0.5)
            <li class="rating-on"><i class="fas fa-star-half-alt"></i></li>
        @else
            <li class=""><i class="fas fa-star"></i></li>
        @endif
    @endfor
</ul>
