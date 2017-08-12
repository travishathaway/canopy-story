@if ($paginator->lastPage() > 1)
<ul class="pagination mx-auto">
    <li class="{{ ($paginator->currentPage() == 1) ? ' disabled' : '' }} page-item">
        <a href="{{ $paginator->url(1) }}" class="page-link">Previous</a>
    </li>
    @for ($i = 1; $i <= $paginator->lastPage(); $i++)
        <li class="{{ ($paginator->currentPage() == $i) ? ' active' : '' }} page-item">
            <a href="{{ $paginator->url($i) }}" class="page-link">{{ $i }}</a>
        </li>
    @endfor
    <li class="{{ ($paginator->currentPage() == $paginator->lastPage()) ? ' disabled' : '' }} page-item">
        <a href="{{ $paginator->url($paginator->currentPage()+1) }}" class="page-link">Next</a>
    </li>
</ul>
@endif
