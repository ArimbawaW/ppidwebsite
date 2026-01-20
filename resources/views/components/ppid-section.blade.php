<div class="ppid-section">
    <div class="container">
        <h2 class="ppid-title">PPID PELAKSANA PUSAT</h2>

        @php
            $ppidItems = [
                [
                    'label' => ['Sekretariat Jenderal'],
                    'url' => 'https://pkp.go.id/'
                ],
                [
                    'label' => ['Inspektorat Jenderal'],
                    'url' => 'https://pkp.go.id/'
                ],
                [
                    'label' => ['Direktorat Jenderal', 'Kawasan Permukiman'],
                    'url' => 'https://pkp.go.id/'
                ],
                [
                    'label' => ['Direktorat Jenderal', 'Perumahan Perdesaan'],
                    'url' => 'https://pkp.go.id/unor/direktorat-jenderal-perumahan-perdesaan'
                ],
                [
                    'label' => ['Direktorat Jenderal', 'Perumahan Perkotaan'],
                    'url' => 'https://pkp.go.id/'
                ],
                [
                    'label' => ['Direktorat Jenderal', 'Tata Kelola dan', 'Pengendalian Risiko'],
                    'url' => 'https://pkp.go.id/unor/direktorat-jenderal-tata-kelola-dan-pengendalian-risiko'
                ],
            ];
        @endphp

        <div class="row g-4 mb-4">
            @foreach(array_slice($ppidItems, 0, 3) as $item)
                <div class="col-md-4">
                    @if($item['url'])
                        <a href="{{ $item['url'] }}" target="_blank" class="ppid-link">
                    @endif

                    <div class="ppid-card {{ $item['url'] ? 'ppid-card-clickable' : '' }}">
                        <h5>{!! implode('<br>', $item['label']) !!}</h5>
                    </div>

                    @if($item['url'])
                        </a>
                    @endif
                </div>
            @endforeach
        </div>

        <div class="row g-4">
            @foreach(array_slice($ppidItems, 3) as $item)
                <div class="col-md-4">
                    @if($item['url'])
                        <a href="{{ $item['url'] }}" target="_blank" class="ppid-link">
                    @endif

                    <div class="ppid-card {{ $item['url'] ? 'ppid-card-clickable' : '' }}">
                        <h5>{!! implode('<br>', $item['label']) !!}</h5>
                    </div>

                    @if($item['url'])
                        </a>
                    @endif
                </div>
            @endforeach
        </div>
    </div>
</div>
