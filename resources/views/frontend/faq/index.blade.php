@extends('layouts.app')

@section('title', 'FAQ - PPID')

@section('content')

<section class="hero-section">
    <div class="container hero-container">
        <div class="row align-items-center">
            <div class="col-md-8">
                <h1 class="text-white fw-bold mb-1">Frequently Asked Questions</h1>
                <p class="text-white-50 mb-0">
                    Pertanyaan yang sering diajukan seputar layanan PPID
                </p>
            </div>
            <div class="col-md-4 text-end d-none d-md-block">
                <i class="bi bi-question-circle text-white icon-hero"></i>
            </div>
        </div>
    </div>
</section>

<section class="bg-light filter-section border-bottom">
    <div class="container py-4">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="input-group shadow-sm">
                    <span class="input-group-text bg-white border-0 ps-3">
                        <i class="bi bi-search text-muted"></i>
                    </span>
                    <input type="text" id="searchFaq" class="form-control border-0 py-2" placeholder="Cari pertanyaan...">
                    <button class="btn btn-primary px-4 fw-semibold" type="button">Cari</button>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="py-5 bg-white">
    <div class="container">
        
        @if($faqs->count() > 0)
            @foreach($faqs as $kategori => $items)
            <div class="faq-category-wrapper mb-4">
                <div class="category-header mb-3">
                    <h4 class="fw-bold text-main-blue mb-0">{{ $kategori ?? 'Umum' }}</h4>
                    <div class="category-line"></div>
                </div>

                <div class="doc-list">
                    @foreach($items as $faq)
                    <div class="doc-item" onclick="toggleFaq(this)">
                        <div class="doc-row">
                            <div class="doc-left">
                                <i class="bi bi-question-circle-fill doc-icon"></i>
                                <div class="doc-title-wrap">
                                    <div class="doc-title-text">{{ $faq->pertanyaan }}</div>
                                </div>
                            </div>
                            <div class="doc-right">
                                <i class="bi bi-chevron-down arrow-icon"></i>
                            </div>
                        </div>

                        <div class="doc-body">
                            <div class="answer-inner">
                                <i class="bi bi-chat-left-text-fill text-success me-3 mt-1"></i>
                                <div class="answer-text">
                                    {!! nl2br(e($faq->jawaban)) !!}
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
            @endforeach
        @endif

        <div class="row justify-content-center mt-5 mb-5">
            <div class="col-lg-10 col-xl-9">
                <div class="cta-card-compact shadow-lg">
                    <div class="text-center text-white">
                        <div class="mb-2">
                            <i class="bi bi-envelope-exclamation" style="font-size: 2.5rem;"></i>
                        </div>
                        <h3 class="fw-bold mb-2">Tidak Menemukan Jawaban?</h3>
                        <p class="mb-3 mx-auto px-md-5" style="max-width: 650px; opacity: 0.9; font-size: 0.95rem;">
                            Apabila Anda tidak menemukan jawaban yang sesuai, silakan hubungi kami melalui WhatsApp PPID.
                        </p>
                        <a href="https://api.whatsapp.com/send/?phone=6285975062727"
                           target="_blank"
                           class="btn btn-white-small px-4 py-2 fw-bold rounded-3">
                            <i class="bi bi-whatsapp me-2"></i>Hubungi Kami
                        </a>
                    </div>
                </div>
            </div>
        </div>

    </div>
</section>

@endsection

@push('styles')
<style>
    :root {
        --main-blue: #1A6B8A;
        --dark-blue: #003344;
    }

    /* ================= HERO SECTION (IDENTIK BERITA/GALERI) ================= */
    .hero-section {
        position: relative;
        background: linear-gradient(135deg, #1a6b8a 0%, #003344 100%);
        min-height: 120px;
        padding: 32px 0;
        display: flex;
        align-items: center;
        overflow: hidden;
        z-index: 1;
    }

    .hero-section::before {
        content: "";
        position: absolute;
        inset: 0;
        background-image: url('{{ asset("images/Pattern - Midnight Green.png") }}');
        background-size: 180px;
        background-repeat: repeat;
        mix-blend-mode: overlay;
        opacity: .35;
        z-index: -1;
    }

    .hero-container { z-index: 5; position: relative; }

    .icon-hero {
        font-size: 64px;
        opacity: .18;
    }

    /* ================= FILTER SECTION STYLE ================= */
    .btn-primary { 
        background-color: var(--main-blue) !important; 
        border: none;
    }

    /* ================= FAQ CONTENT STYLING ================= */
    .text-main-blue { color: var(--main-blue); }
    .category-line { height: 3px; background: var(--main-blue); width: 60px; margin-top: 5px; border-radius: 2px; }

    .doc-item {
        margin-bottom: 15px; background: #ffffff;
        border: 1px solid #e2e8f0; border-radius: 15px;
        transition: all .35s ease;
        cursor: pointer;
    }
    .doc-row { display: flex; align-items: center; justify-content: space-between; padding: 18px 25px; }
    .doc-left { display: flex; align-items: center; gap: 15px; }
    .doc-icon { font-size: 1.4rem; color: var(--main-blue); }
    .doc-title-text { color: #1e293b; font-weight: 700; font-size: 1.05rem; }
    
    .arrow-icon { transition: 0.4s; color: #cbd5e1; }
    .doc-item.active .arrow-icon { transform: rotate(180deg); color: var(--main-blue); }
    
    .doc-body { max-height: 0; opacity: 0; overflow: hidden; transition: all 0.45s ease; padding: 0 25px; }
    .doc-item.active .doc-body { max-height: 1000px; opacity: 1; padding: 20px 25px; border-top: 1px dashed #e2e8f0; }
    
    .answer-inner { display: flex; padding: 15px; background: #f8fafc; border-radius: 12px; }
    .answer-text { color: #475569; line-height: 1.8; font-size: 0.95rem; }

    .cta-card-compact { background-color: var(--main-blue); border-radius: 20px; padding: 45px 25px; }
    .btn-white-small { background: #fff !important; color: #000 !important; padding: 10px 30px; text-decoration: none; }

    @media(max-width: 768px) {
        .hero-section { min-height: 100px; padding: 24px 0; text-align: center; }
        .icon-hero { display: none; }
    }
</style>
@endpush

@push('scripts')
<script>
    function toggleFaq(el) {
        const isActive = el.classList.contains('active');
        document.querySelectorAll('.doc-item').forEach(item => {
            item.classList.remove('active');
        });
        if (!isActive) {
            el.classList.add('active');
        }
    }

    document.addEventListener('DOMContentLoaded', function() {
        const searchInput = document.getElementById('searchFaq');
        if(searchInput) {
            searchInput.addEventListener('input', function(e) {
                const searchTerm = e.target.value.toLowerCase();
                document.querySelectorAll('.doc-item').forEach(item => {
                    const text = item.textContent.toLowerCase();
                    item.style.display = text.includes(searchTerm) ? 'block' : 'none';
                });
            });
        }
    });
</script>
@endpush