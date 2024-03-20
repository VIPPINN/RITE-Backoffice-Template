@if ($paginator->hasPages())
    <nav aria-label="Page navigation example">
        <ul class="pagination justify-content-center">
            @if (! $paginator->onFirstPage())
                <li class="page-item">
                  <a class="page-link link-continue"
                    href="{{ $paginator->previousPageUrl() }}">
                    <span><img src="{{ asset('images/menor.png') }}" class="img-fluid" alt=">"></span>
                    &nbsp;&nbsp;Anterior
                  </a>
                </li>
            @endif

            @foreach ($elements as $element)
                @if (is_string($element))
                    <li class="page-item disabled">{{ $element }}</li>
                @endif

                @if (is_array($element))
                    @foreach ($element as $page => $url)
                        @if ($page == $paginator->currentPage())
                            <li class="page-item active">
                                <a class="page-link link-active">{{ $page }}</a>
                            </li>
                        @else
                            <li class="page-item">
                                <a class="page-link link-inactive" href="{{ $url }}">{{ $page }}</a>
                            </li>
                        @endif
                    @endforeach
                @endif
            @endforeach

            @if ($paginator->hasMorePages())
                <li class="page-item">
                    <a class="page-link link-continue" 
                      href="{{ $paginator->nextPageUrl() }}" rel="next">
                      Siguiente&nbsp;&nbsp;
                      <span><img src="{{ asset('images/mayor.png') }}" class="img-fluid" alt=">"></span>
                    </a>
                </li>
            @endif
        </ul>
@endif

<style type="text/css">
  .link-active {
    background-color: transparent !important;
    border: 0;
    font-family: Encode Sans Bold;
    font-style: normal;
    font-weight: bold;
    font-size: 18px;
    line-height: 24px;
    display: flex;
    align-items: center;
    color: #231F20 !important;
  }
  .link-inactive {
    background-color: transparent !important;
    border: 0;
    font-family: Encode Sans light;
    font-style: normal;
    font-weight: 600;
    font-size: 16px;
    line-height: 24px;
    display: flex;
    align-items: center;
    color: #50535C !important;
  }
  .link-continue {
    background-color: transparent !important;
    border: 0;
    font-family: Encode Sans light;
    font-style: normal;
    font-weight: 600;
    font-size: 16px;
    line-height: 24px;
    display: flex;
    align-items: center;
    color: #50535C !important;
  }
</style>