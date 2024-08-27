@if ($paginator->hasPages())
    <nav aria-label="Page navigation">
        <ul class="pagination justify-content-center">
            {{-- Previous Page Link --}}
            @if ($paginator->onFirstPage())
                <li class="page-item disabled">
                    <span class="page-link text-dark">&laquo; Previous</span> <!-- Ubah warna teks menjadi hitam -->
                </li>
            @else
                <li class="page-item">
                    <a class="page-link text-dark" href="{{ $paginator->previousPageUrl() }}" rel="prev">&laquo; Previous</a> <!-- Ubah warna teks menjadi hitam -->
                </li>
            @endif

            {{-- Pagination Elements --}}
            @foreach ($elements as $element)
                {{-- "Three Dots" Separator --}}
                @if (is_string($element))
                    <li class="page-item disabled"><span class="page-link text-dark">{{ $element }}</span></li> <!-- Ubah warna teks menjadi hitam -->
                @endif

                {{-- Array Of Links --}}
                @if (is_array($element))
                    @foreach ($element as $page => $url)
                        @if ($page == $paginator->currentPage())
                            <li class="page-item active" aria-current="page">
                                <span class="page-link text-white bg-dark">{{ $page }}</span> <!-- Ubah warna teks menjadi putih dan latar belakang menjadi hitam -->
                            </li>
                        @else
                            <li class="page-item">
                                <a class="page-link text-dark" href="{{ $url }}">{{ $page }}</a> <!-- Ubah warna teks menjadi hitam -->
                            </li>
                        @endif
                    @endforeach
                @endif
            @endforeach

            {{-- Next Page Link --}}
            @if ($paginator->hasMorePages())
                <li class="page-item">
                    <a class="page-link text-dark" href="{{ $paginator->nextPageUrl() }}" rel="next">Next &raquo;</a> <!-- Ubah warna teks menjadi hitam -->
                </li>
            @else
                <li class="page-item disabled">
                    <span class="page-link text-dark">Next &raquo;</span> <!-- Ubah warna teks menjadi hitam -->
                </li>
            @endif
        </ul>
    </nav>
@endif