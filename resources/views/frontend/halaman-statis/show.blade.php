@extends('layouts.app')

@section('title', $halaman->judul)

@php
    use Illuminate\Support\Facades\Storage;
@endphp

@section('content')

<section class="hero-section">
    <div class="container hero-container">
        <div class="row align-items-center">
            <div class="col-md-8">
                <h1 class="text-white fw-bold mb-1">{{ $halaman->judul }}</h1>
                <p class="text-white-50 mb-0">
                    Informasi dan dokumen terkait {{ $halaman->judul }}
                </p>
            </div>
            <div class="col-md-4 text-end d-none d-md-block">
                <i class="bi bi-book-half text-white icon-hero"></i>
            </div>
        </div>
    </div>
</section>

<section class="content-section">
    <div class="container">
        <div class="content-card">

            @foreach($halaman->konten as $section)
                <div class="content-block mb-5">
                    {{-- Judul Section --}}
                    <h2 class="section-title mb-3">{{ $section['section'] }}</h2>

                    {{-- Daftar Dokumen --}}
                    <ul class="doc-list">
                        @foreach($section['items'] as $item)
                            @php
                                $hasSubsections = !empty($item['subsections']) && is_array($item['subsections']) && count($item['subsections']) > 0;

                                if (!$hasSubsections) {
                                    $fileLink = !empty($item['file_path'])
                                        ? Storage::url($item['file_path'])
                                        : (!empty($item['file_url']) ? $item['file_url'] : null);

                                    $extPath = !empty($item['file_path'])
                                        ? $item['file_path']
                                        : (parse_url($item['file_url'] ?? '', PHP_URL_PATH) ?: '');

                                    $ext = strtolower(pathinfo($extPath, PATHINFO_EXTENSION));

                                    $iconClass = match($ext) {
                                        'pdf' => 'bi-file-earmark-pdf text-danger',
                                        'doc', 'docx' => 'bi-file-earmark-word text-primary',
                                        'xls', 'xlsx' => 'bi-file-earmark-excel text-success',
                                        'ppt', 'pptx' => 'bi-file-earmark-ppt text-warning',
                                        'jpg', 'jpeg', 'png', 'webp', 'svg' => 'bi-file-earmark-image text-info',
                                        default => 'bi-file-earmark text-secondary'
                                    };
                                }
                            @endphp

                            @if($hasSubsections)
                                {{-- Item dengan subsection --}}
                                <li class="doc-item has-sub" onclick="toggleSub(this)">
                                    <div class="doc-row">
                                        <div class="doc-left">
                                            <div class="doc-title-wrap">
                                                <div class="doc-title-text">{{ $item['text'] }}</div>
                                            </div>
                                        </div>
                                        <div class="doc-right">
                                            <i class="bi bi-chevron-down sub-chevron"></i>
                                        </div>
                                    </div>

                                    {{-- Subsection list --}}
                                    <div class="subsection-list">
                                        <ul class="sub-doc-list">
                                            @foreach($item['subsections'] as $sub)
                                                @php
                                                    $subFileLink = !empty($sub['file_path'])
                                                        ? Storage::url($sub['file_path'])
                                                        : (!empty($sub['file_url']) ? $sub['file_url'] : null);

                                                    $subExtPath = !empty($sub['file_path'])
                                                        ? $sub['file_path']
                                                        : (parse_url($sub['file_url'] ?? '', PHP_URL_PATH) ?: '');

                                                    $subExt = strtolower(pathinfo($subExtPath, PATHINFO_EXTENSION));

                                                    $subIconClass = match($subExt) {
                                                        'pdf' => 'bi-file-earmark-pdf text-danger',
                                                        'doc', 'docx' => 'bi-file-earmark-word text-primary',
                                                        'xls', 'xlsx' => 'bi-file-earmark-excel text-success',
                                                        'ppt', 'pptx' => 'bi-file-earmark-ppt text-warning',
                                                        'jpg', 'jpeg', 'png', 'webp', 'svg' => 'bi-file-earmark-image text-info',
                                                        default => 'bi-file-earmark text-secondary'
                                                    };
                                                @endphp
                                                <li class="sub-doc-item">
                                                    <div class="sub-doc-row">
                                                        <div class="sub-doc-left">
                                                            <i class="bi {{ $subIconClass }} sub-doc-icon"></i>
                                                            <span class="sub-doc-text">{{ $sub['text'] }}</span>
                                                        </div>
                                                        @if($subFileLink)
                                                            <a href="{{ $subFileLink }}" target="_blank" rel="noopener"
                                                               class="btn-download btn-download-sm"
                                                               onclick="event.stopPropagation()">
                                                                Preview
                                                            </a>
                                                        @endif
                                                    </div>
                                                </li>
                                            @endforeach
                                        </ul>
                                    </div>
                                </li>

                            @else
                                {{-- Item biasa dengan link/file --}}
                                <li class="doc-item" onclick="toggleDeskripsi(this)">
                                    <div class="doc-row">
                                        <div class="doc-left">
                                            <i class="bi {{ $iconClass }} doc-icon"></i>
                                            <div class="doc-title-wrap">
                                                <div class="doc-title-text">{{ $item['text'] }}</div>
                                            </div>
                                        </div>

                                        <div class="doc-right">
                                            @if($fileLink)
                                                <a href="{{ $fileLink }}" target="_blank" rel="noopener"
                                                   class="btn-download"
                                                   onclick="event.stopPropagation()">
                                                    Preview
                                                </a>
                                            @endif
                                        </div>
                                    </div>
                                </li>
                            @endif

                        @endforeach
                    </ul>
                </div>
            @endforeach

        </div>
    </div>
</section>

{{-- ================= STYLES ================= --}}
<style>
:root{
    --main-blue:#1A6B8A;
    --soft-bg: #f6f9fb;
    --text-dark: #1e293b;
    --text-soft: #475569;
    --soft-border: #e2e8f0;
}

/* Hero Section */
.hero-section{
    position:relative;
    background:linear-gradient(135deg,#1a6b8a 0%,#003344 100%);
    min-height:120px;
    padding:32px 0;
    display:flex;
    align-items:center;
    overflow:hidden;
    z-index:1;
}
.hero-section::before{
    content:"";
    position:absolute;
    inset:0;
    background-image:url('{{ asset("images/Pattern - Midnight Green.png") }}');
    background-size:180px;
    background-repeat:repeat;
    mix-blend-mode:overlay;
    opacity:.35;
    z-index:-1;
}
.hero-container{z-index:5;position:relative;}
.icon-hero{font-size:64px;opacity:.18}

/* Content Styles */
.content-section { background: var(--soft-bg); padding: 50px 0; }
.content-card {
    background: #fff; border-radius: 16px; padding: 40px;
    box-shadow: 0 6px 20px rgba(0,0,0,.06);
}
.section-title {
    font-size: 1.25rem; font-weight: 700; color: var(--text-dark);
    margin-bottom: 14px; padding-bottom: 10px; border-bottom: 3px solid var(--main-blue);
}

/* Doc List */
.doc-list { list-style: none; padding: 0; margin: 0; }
.doc-item {
    margin-bottom: 10px; background: #ffffff;
    border: 1px solid var(--soft-border); border-radius: 12px;
    transition: all .3s ease; cursor: pointer; overflow: hidden;
}
.doc-item:hover { border-color: var(--main-blue); background: #fcfdfe; }
.doc-item.active { border-color: var(--main-blue); box-shadow: 0 8px 20px rgba(26,107,138,0.1); }

.doc-row { display: flex; align-items: center; justify-content: space-between; gap: 12px; padding: 14px 16px; }
.doc-left { display: flex; align-items: center; gap: 14px; flex: 1; min-width: 0; }
.doc-icon { font-size: 1.4rem; flex: 0 0 auto; }
.doc-title-wrap { flex: 1; min-width: 0; }
.doc-title-text {
    color: var(--text-dark); font-weight: 600; font-size: 1rem;
    line-height: 1.5; overflow: hidden; text-overflow: ellipsis;
    white-space: nowrap; transition: all 0.3s ease;
}
.doc-item.active .doc-title-text { white-space: normal; word-break: break-word; }

.doc-right { flex-shrink: 0; display: flex; align-items: center; gap: 8px; }

/* Item has-sub (subsection parent) */
.doc-item.has-sub .doc-row { background: #ffffff; border-radius: 10px; }
.doc-item.has-sub:hover .doc-row { background: #fcfdfe; }
.sub-chevron { transition: transform 0.3s ease; font-size: 1.1rem; color: var(--main-blue); }
.doc-item.has-sub.active .sub-chevron { transform: rotate(180deg); }

/* Subsection list */
.subsection-list {
    max-height: 0; overflow: hidden; transition: max-height 0.4s ease;
}
.doc-item.has-sub.active .subsection-list {
    max-height: 2000px;
}
.sub-doc-list {
    list-style: none; padding: 10px 16px 16px 16px; margin: 0;
    border-top: 1px dashed var(--soft-border);
    background: #f8fafc;
}
.sub-doc-item {
    padding: 8px 12px;
    border-radius: 8px;
    margin-bottom: 6px;
    background: #fff;
    border: 1px solid #e8f0fe;
    transition: all 0.2s;
}
.sub-doc-item:hover { border-color: var(--main-blue); background: #f0f7ff; }
.sub-doc-row {
    display: flex; align-items: center; justify-content: space-between; gap: 10px;
}
.sub-doc-left { display: flex; align-items: center; gap: 10px; flex: 1; min-width: 0; }
.sub-doc-icon { font-size: 1.1rem; flex: 0 0 auto; }
.sub-doc-text { font-size: 0.9rem; color: var(--text-dark); font-weight: 500; }

/* Buttons */
.btn-download {
    background: #1a6b8a; color: #fff !important; border: none;
    padding: 6px 14px; border-radius: 8px; font-weight: 600; font-size: .85rem;
    text-decoration: none; transition: .2s; white-space: nowrap;
}
.btn-download:hover { background: #155a75; transform: translateY(-1px); }
.btn-download-sm {
    background: #1a6b8a; color: #fff !important; border: none;
    padding: 4px 10px; border-radius: 6px; font-weight: 600; font-size: .78rem;
    text-decoration: none; transition: .2s; white-space: nowrap; flex-shrink: 0;
}
.btn-download-sm:hover { background: #155a75; }

/* Responsive */
@media(max-width:768px){
    .hero-section{ min-height:100px; padding:24px 0; text-align:center; }
    .icon-hero{display:none}
    .content-card { padding: 20px; }
    .doc-row { flex-direction: column; align-items: stretch; gap: 10px; }
    .doc-left { flex-direction: row; align-items: center; width: 100%; }
    .doc-right { width: 100%; }
    .btn-download { width: 100%; text-align: center; }
    .sub-doc-row { flex-direction: column; align-items: flex-start; }
    .btn-download-sm { align-self: flex-start; margin-top: 4px; }
}
</style>

<script>
    function toggleDeskripsi(el) {
        const isActive = el.classList.contains('active');
        document.querySelectorAll('.doc-item:not(.has-sub)').forEach(item => item.classList.remove('active'));
        if (!isActive) el.classList.add('active');
    }

    function toggleSub(el) {
        const isActive = el.classList.contains('active');
        document.querySelectorAll('.doc-item.has-sub').forEach(item => item.classList.remove('active'));
        if (!isActive) el.classList.add('active');
    }
</script>

@endsection