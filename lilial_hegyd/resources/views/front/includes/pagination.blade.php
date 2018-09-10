@if($link_limit)
    @if ($paginator->lastPage() > 1)
        <?php
            $half_total_links = floor($link_limit / 2);
            $from = ($paginator->currentPage() - $half_total_links) < 1 ? 1 : $paginator->currentPage() - $half_total_links;
            $to = ($paginator->currentPage() + $half_total_links) > $paginator->lastPage() ? $paginator->lastPage() : ($paginator->currentPage() + $half_total_links);
            if ($from > $paginator->lastPage() - $link_limit) {
               $from = ($paginator->lastPage() - $link_limit) + 1;
               $to = $paginator->lastPage();
            }
            if ($to <= $link_limit) {
                $from = 1;
                $to = $link_limit < $paginator->lastPage() ? $link_limit : $paginator->lastPage();
            }
        ?>
        <ul class="pagination" style="display: inline-flex">
            @if($paginator->currentPage() == 1)
                <li class="disabled">
                    <span>«</span>
                </li>
            @else
                <li style="margin-right: 20px;">
                    <a href="{{ $paginator->url($paginator->currentPage() - 1) }}">«</a>
                </li>
            @endif
            @for ($i = $from; $i <= $to; $i++)
                @if($paginator->currentPage() == $i)
                    <li class="active disabled" style="margin-right: 20px;">
                        <span style="margin-right: 0;">{{ $i }}</span>
                    </li>
                @else
                    <li style="margin-right: 20px;">
                        <a href="{{ $paginator->url($i) }}">{{ $i }}</a>
                    </li>
                @endif
            @endfor
            @if($paginator->currentPage() == $paginator->lastPage())
                <li class="disabled">
                    <span>»</span>
                </li>
            @else
                <li style="margin-right: 20px;">
                    <a href="{{ $paginator->url($paginator->currentPage() + 1) }}">»</a>
                </li>
            @endif
        </ul>
    @endif
@endif