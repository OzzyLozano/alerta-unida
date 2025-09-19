@if ($paginator->hasPages())
  <nav role="navigation" aria-label="{{ __('Pagination Navigation') }}" class="paginator">
    <div class="paginator-pages">

      {{-- Pagination Elements --}}
      @foreach ($elements as $element)
        {{-- "Three Dots" Separator --}}
        @if (is_string($element))
        @endif

        {{-- Array Of Links --}}
        @if (is_array($element))
          @foreach ($element as $page => $url)
            @if ($page == $paginator->currentPage())
              <span aria-current="page" class="current-page">{{ $page }}</span>
            @else
              <a href="{{ $url }}" class="text-dark" aria-label="{{ __('Go to page :page', ['page' => $page]) }}">
                {{ $page }}
              </a>
            @endif
          @endforeach
        @endif
      @endforeach
    </div>
    <div class="paginator-results">
      <p>
        {!! __('Mostrando') !!}
        @if ($paginator->firstItem())
          <span>{{ $paginator->firstItem() }}</span>
          {!! __('a') !!}
          <span>{{ $paginator->lastItem() }}</span>
        @else
          {{ $paginator->count() }}
        @endif
        {!! __('de') !!}
        <span>{{ $paginator->total() }}</span>
        {!! __('resultados') !!}
      </p>
    </div>
  </nav>
@endif
