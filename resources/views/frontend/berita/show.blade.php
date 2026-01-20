@extends('layouts.app')

@section('title', $berita->judul . ' - PPID')

@section('content')

<style>
    /* === PERAPIAN TAMPILAN BERITA === */
    .content {
        font-size: 17px;
        line-height: 1.8;
        text-align: justify;
        color: #333;
        white-space: normal; /* supaya teks panjang tidak numpuk */
        word-break: break-word; /* antisipasi kata nyambung tanpa spasi */
    }

    .content p {
        margin-bottom: 1.2rem;
    }

    .content img {
        max-width: 100%;
        height: auto;
        margin: 15px 0;
        border-radius: 6px;
        display: block;
    }

    .content br {
        margin-bottom: 10px;
    }

    .content h1, 
    .content h2, 
    .content h3, 
    .content h4 {
        margin-top: 25px;
        margin-bottom: 15px;
        font-weight: 600;
        line-height: 1.3;
    }

    .content ul, 
    .content ol {
        padding-left: 20px;
        margin-bottom: 1.2rem;
    }

    /* Supaya tulisan tidak berdempetan jika admin tidak pakai <p> */
    .content * + * {
        margin-top: 10px;
    }
</style>

<div class="container my-5">
    <div class="row">
        <div class="col-md-8">
            <article>
                <h1>{{ $berita->judul }}</h1>
                <p class="text-muted">
                    <span class="badge bg-secondary">{{ $berita->kategori_label }}</span>
                    <span class="ms-2">{{ $berita->created_at->format('d M Y') }}</span>
                    <span class="ms-2">| {{ $berita->views }} views</span>
                </p>

                @if($berita->gambar)
                <img src="{{ asset('storage/' . $berita->gambar) }}" class="img-fluid mb-3" alt="{{ $berita->judul }}">
                @endif

                <div class="content">
                    {!! $berita->konten !!}
                </div>
            </article>
        </div>

        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    <h5>Berita Terbaru</h5>
                </div>
                <div class="list-group list-group-flush">
                    @foreach($beritaTerbaru->take(3) as $item)
                    <a href="{{ route('berita.show', $item->slug) }}" class="list-group-item list-group-item-action">
                        <h6 class="mb-1">{{ $item->judul }}</h6>
                        <small class="text-muted">{{ $item->created_at->format('d M Y') }}</small>
                    </a>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>

@endsection