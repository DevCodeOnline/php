<div class="pagination-wrap">
    <div class="product-show">
        <div class="product-show__qnt"><span>Показано {{ $paginator->firstItem() }} - {{ $paginator->lastItem() }} из {{ $paginator->total() }}</span></div>
        <div class="product-show__select">
            <form id="show-product" action="{{ route('sear') }}" method="POST" data-token="{{ csrf_token() }}">
                @csrf
                <select name="product-qnt" id="product-qnt" class="product-qnt">
                    <option value="10">10</option>
                    <option value="20" selected>20</option>
                    <option value="50">50</option>
                </select>
            </form>
        </div>
    </div>

    @if ($paginator->hasPages())
        <div class="product-navigation">
            <ul>
                @if ($paginator->onFirstPage())
                    <li class="prev-link link-disable"><span aria-disabled="true" aria-label="@lang('pagination.previous')">Назад</span></li>
                @else
                    <li class="prev-link link-back"><a href="{{ $paginator->previousPageUrl() }}" rel="prev" aria-label="@lang('pagination.previous')">Назад</a></li>
                @endif

                @foreach(range(1, $paginator->lastPage()) as $i)
                    @if($i >= $paginator->currentPage() - 3 && $i <= $paginator->currentPage() + 5)
                        @if ($i == $paginator->currentPage())
                            <li class="link-number link-page active" aria-current="page"><span class="page-link">{{ $i }}</span></li>
                        @else
                            <li class="link-number link-page"><a href="{{ $paginator->url($i) }}">{{ $i }}</a></li>
                        @endif
                    @endif
                @endforeach
                @if($paginator->currentPage() < $paginator->lastPage() - 5)
                    <li class="link-number link-dots" aria-current="page"><span class="page-link">...</span></li>
                @endif
                @if($paginator->currentPage() < $paginator->lastPage() - 5)
                    <li class="link-number link-page"><a href="{{ $paginator->url($paginator->lastPage()) }}">{{ $paginator->lastPage() }}</a></li>
                @endif



                @if ($paginator->hasMorePages())
                    <li class="link-up"><a href="{{ $paginator->nextPageUrl() }}">Вперёд</a></li>
                @else
                    <li class="link-up link-disable"><span aria-hidden="true">Вперёд</span></li>
                @endif

            </ul>
        </div>
    @endif
</div>
