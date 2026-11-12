@extends('king-monitor::layouts.app')

@section('title')
    {{ config('app.name', 'KingMonitor') }} — Dashboard
@endsection

@php
    /* ─────────────────────────────────────────────
     | Pre-process all chart data in PHP once.
     | Using @json() instead of @foreach loops
     | eliminates the large inline-JS problem.
     ───────────────────────────────────────────── */

    // Historical Total (years)
    $reqTotal = collect($historical['request']['total']['details'] ?? []);
    $errTotal = collect($historical['errors']['total']['details'] ?? []);

    $yearsTotal = $reqTotal->pluck('year')
        ->merge($errTotal->pluck('year'))
        ->unique()->sort()->values();

    $chartHistoricalTotal = [
        'labels'  => $yearsTotal,
        'request' => $yearsTotal->map(fn($y) => (int) ($reqTotal->firstWhere('year', $y)['total']  ?? 0))->values(),
        'error'   => $yearsTotal->map(fn($y) => (int) ($errTotal->firstWhere('year',  $y)['total'] ?? 0))->values(),
    ];

    // Historical Year (months)
    $reqYear = collect($historical['request']['year']['details'] ?? []);
    $errYear = collect($historical['errors']['year']['details'] ?? []);

    $monthsYear = $reqYear->pluck('month')
        ->merge($errYear->pluck('month'))
        ->unique()->sort()->values();

    $chartHistoricalYear = [
        'labels'  => $monthsYear,
        'request' => $monthsYear->map(fn($m) => (int) ($reqYear->firstWhere('month', $m)['total'] ?? 0))->values(),
        'error'   => $monthsYear->map(fn($m) => (int) ($errYear->firstWhere('month', $m)['total'] ?? 0))->values(),
    ];

    // Historical Exceeded Year (months)
    $reqExcYear = collect($historicalExceeded['request']['year']['details'] ?? []);
    $errExcYear = collect($historicalExceeded['errors']['year']['details'] ?? []);

    $monthsExc = $reqExcYear->pluck('month')
        ->merge($errExcYear->pluck('month'))
        ->unique()->sort()->values();

    $chartExceededYear = [
        'labels'  => $monthsExc,
        'request' => $monthsExc->map(fn($m) => (int) ($reqExcYear->firstWhere('month', $m)['total'] ?? 0))->values(),
        'error'   => $monthsExc->map(fn($m) => (int) ($errExcYear->firstWhere('month', $m)['total'] ?? 0))->values(),
    ];

    // Method stats for year
    $chartMethods = [
        'labels'  => ['GET', 'POST', 'PUT', 'PATCH', 'DELETE'],
        'request' => [
            $statistics['request']['year']['method']['GET']    ?? 0,
            $statistics['request']['year']['method']['POST']   ?? 0,
            $statistics['request']['year']['method']['PUT']    ?? 0,
            $statistics['request']['year']['method']['PATCH']  ?? 0,
            $statistics['request']['year']['method']['DELETE'] ?? 0,
        ],
        'error' => [
            $statistics['errors']['year']['method']['GET']    ?? 0,
            $statistics['errors']['year']['method']['POST']   ?? 0,
            $statistics['errors']['year']['method']['PUT']    ?? 0,
            $statistics['errors']['year']['method']['PATCH']  ?? 0,
            $statistics['errors']['year']['method']['DELETE'] ?? 0,
        ],
    ];

    // Doughnut: requests vs errors this year
    $chartDoughnutYear = [
        'request' => $statistics['request']['year']['total'] ?? 0,
        'error'   => $statistics['errors']['year']['total']  ?? 0,
    ];

    // Summary numbers
    $totalRequests    = $statistics['total']['request']['total']             ?? 0;
    $totalErrors      = $statistics['total']['error']['total']               ?? 0;
    $totalAlerts      = $statisticsAlert['total']                            ?? 0;
    $topAlertIp       = $statisticsAlert['ip'][0]                            ?? 'N/A';
    $totalExcReq      = $statisticsExceeded['request']['total']['total']     ?? 0;
    $totalExcErr      = $statisticsExceeded['errors']['total']['total']      ?? 0;
    $topRequest       = $statistics['request']['total']['method']['mostCommon'][0] ?? 'ANY';
    $topError         = $statistics['errors']['total']['method']['mostCommon'][0]  ?? 'ANY';
@endphp

@section('style')
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=JetBrains+Mono:wght@400;600;700&family=Syne:wght@400;600;800&display=swap" rel="stylesheet">
    <style>
        :root {
            --bg:        #0a0d12;
            --bg-card:   #111622;
            --bg-hover:  #161d2e;
            --border:    #1e2a3a;
            --teal:      #00d4aa;
            --teal-dim:  rgba(0,212,170,.12);
            --rose:      #f43f5e;
            --rose-dim:  rgba(244,63,94,.12);
            --amber:     #f59e0b;
            --amber-dim: rgba(245,158,11,.12);
            --sky:       #38bdf8;
            --sky-dim:   rgba(56,189,248,.12);
            --text:      #e2e8f0;
            --text-muted:#64748b;
            --mono: 'JetBrains Mono', monospace;
            --sans: 'Syne', sans-serif;
        }

        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        body {
            background: var(--bg);
            color: var(--text);
            font-family: var(--sans);
            min-height: 100vh;
        }

        /* ── Layout ── */
        .km-shell   { display: flex; flex-direction: column; min-height: 100vh; }
        .km-topbar  {
            position: sticky; top: 0; z-index: 50;
            display: flex; align-items: center; justify-content: space-between;
            padding: .875rem 2rem;
            background: rgba(10,13,18,.85);
            backdrop-filter: blur(12px);
            border-bottom: 1px solid var(--border);
        }
        .km-topbar-logo {
            font-family: var(--mono); font-weight: 700; font-size: 1.1rem;
            color: var(--teal); letter-spacing: .05em;
            display: flex; align-items: center; gap: .5rem;
        }
        .km-topbar-logo span { color: var(--text-muted); font-weight: 400; }
        .km-topbar-nav { display: flex; gap: .25rem; }
        .km-topbar-nav a {
            font-family: var(--mono); font-size: .75rem; font-weight: 600;
            letter-spacing: .08em; text-transform: uppercase;
            padding: .375rem .875rem; border-radius: 6px;
            color: var(--text-muted); text-decoration: none;
            border: 1px solid transparent;
            transition: all .15s;
        }
        .km-topbar-nav a:hover, .km-topbar-nav a.active {
            color: var(--teal); border-color: var(--border); background: var(--bg-card);
        }

        .km-page { padding: 2rem; max-width: 1600px; margin: 0 auto; }

        /* ── Section title ── */
        .km-section-label {
            font-family: var(--mono); font-size: .65rem; font-weight: 600;
            letter-spacing: .18em; text-transform: uppercase;
            color: var(--text-muted); margin-bottom: 1rem;
            display: flex; align-items: center; gap: .5rem;
        }
        .km-section-label::after {
            content: ''; flex: 1; height: 1px; background: var(--border);
        }

        /* ── Stat Cards ── */
        .km-stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
            gap: 1rem; margin-bottom: 2rem;
        }
        .km-stat {
            background: var(--bg-card);
            border: 1px solid var(--border);
            border-radius: 10px;
            padding: 1.25rem 1.5rem;
            position: relative; overflow: hidden;
            transition: border-color .2s, background .2s;
        }
        .km-stat:hover { border-color: #2d3f56; background: var(--bg-hover); }
        .km-stat__accent {
            position: absolute; top: 0; left: 0;
            width: 3px; height: 100%; border-radius: 10px 0 0 10px;
        }
        .km-stat__label {
            font-family: var(--mono); font-size: .65rem; font-weight: 600;
            letter-spacing: .12em; text-transform: uppercase;
            color: var(--text-muted); margin-bottom: .5rem;
        }
        .km-stat__value {
            font-family: var(--mono); font-size: 1.75rem; font-weight: 700;
            line-height: 1; letter-spacing: -.02em;
        }
        .km-stat__sub {
            font-family: var(--mono); font-size: .7rem;
            color: var(--text-muted); margin-top: .35rem;
        }
        .color-teal  { color: var(--teal); }
        .color-rose  { color: var(--rose); }
        .color-amber { color: var(--amber); }
        .color-sky   { color: var(--sky); }
        .bg-teal     { background: var(--teal); }
        .bg-rose     { background: var(--rose); }
        .bg-amber    { background: var(--amber); }
        .bg-sky      { background: var(--sky); }

        /* ── Chart Cards ── */
        .km-charts-grid {
            display: grid;
            grid-template-columns: repeat(12, 1fr);
            gap: 1rem; margin-bottom: 2rem;
        }
        .km-chart-card {
            background: var(--bg-card);
            border: 1px solid var(--border);
            border-radius: 10px;
            overflow: hidden;
            display: flex; flex-direction: column;
        }
        .km-chart-card--6  { grid-column: span 6; }
        .km-chart-card--4  { grid-column: span 4; }
        .km-chart-card--3  { grid-column: span 3; }
        .km-chart-card--8  { grid-column: span 8; }
        @media (max-width: 1200px) {
            .km-chart-card--6, .km-chart-card--4,
            .km-chart-card--3, .km-chart-card--8 { grid-column: span 12; }
        }
        @media (min-width: 1201px) and (max-width: 1400px) {
            .km-chart-card--3 { grid-column: span 6; }
            .km-chart-card--4 { grid-column: span 6; }
        }

        .km-chart-header {
            padding: 1rem 1.25rem .75rem;
            border-bottom: 1px solid var(--border);
            display: flex; align-items: center; justify-content: space-between;
            flex-shrink: 0;
        }
        .km-chart-title {
            font-family: var(--mono); font-size: .72rem; font-weight: 600;
            letter-spacing: .1em; text-transform: uppercase; color: var(--text);
        }
        .km-chart-badge {
            font-family: var(--mono); font-size: .62rem; font-weight: 600;
            padding: .2rem .6rem; border-radius: 4px;
            letter-spacing: .06em; text-transform: uppercase;
        }
        .km-chart-badge--teal { background: var(--teal-dim); color: var(--teal); }
        .km-chart-badge--rose { background: var(--rose-dim); color: var(--rose); }
        .km-chart-badge--amber { background: var(--amber-dim); color: var(--amber); }

        .km-chart-body {
            padding: 1.25rem;
            flex: 1; display: flex; align-items: center; justify-content: center;
            min-height: 240px; position: relative;
        }
        .km-chart-body canvas { max-height: 260px; width: 100% !important; }

        /* ── Skeleton loader ── */
        .km-skeleton {
            position: absolute; inset: 1.25rem;
            background: linear-gradient(90deg, var(--border) 25%, #1e2d3f 50%, var(--border) 75%);
            background-size: 200% 100%;
            animation: shimmer 1.6s infinite;
            border-radius: 6px; opacity: .6;
        }
        @keyframes shimmer {
            0%   { background-position: 200% 0; }
            100% { background-position: -200% 0; }
        }
        .km-chart-body canvas { opacity: 0; transition: opacity .4s; }
        .km-chart-body.loaded canvas { opacity: 1; }
        .km-chart-body.loaded .km-skeleton { display: none; }

        /* ── Legend ── */
        .km-legend {
            display: flex; gap: 1rem; flex-wrap: wrap;
            padding: 0 1.25rem 1rem;
        }
        .km-legend-item {
            display: flex; align-items: center; gap: .35rem;
            font-family: var(--mono); font-size: .65rem;
            color: var(--text-muted);
        }
        .km-legend-dot { width: 8px; height: 8px; border-radius: 50%; flex-shrink: 0; }

        /* ── Tabs ── */
        .km-tabs {
            display: flex; gap: .25rem;
            border-bottom: 1px solid var(--border);
            padding: .5rem 1.25rem 0;
        }
        .km-tab {
            font-family: var(--mono); font-size: .65rem; font-weight: 600;
            letter-spacing: .1em; text-transform: uppercase;
            padding: .375rem .7rem; border-radius: 6px 6px 0 0;
            background: none; border: none; cursor: pointer;
            color: var(--text-muted);
            border: 1px solid transparent; border-bottom: none;
            margin-bottom: -1px;
            transition: color .15s, background .15s, border-color .15s;
        }
        .km-tab.active {
            color: var(--teal); background: var(--bg-card);
            border-color: var(--border); border-bottom-color: var(--bg-card);
        }
        .km-tab:hover:not(.active) { color: var(--text); }

        /* ── Divider row ── */
        .km-divider { height: 1px; background: var(--border); margin: .5rem 0 1.5rem; }
    </style>
@endsection

@section('content')
    <div class="km-shell">

        {{-- ── Topbar ── --}}
        <nav class="km-topbar">
            <div class="km-topbar-logo">
                ◈ KING<span>MONITOR</span>
            </div>
            <div class="km-topbar-nav">
                <a href="{{ route('monitor.index') }}" class="active">Dashboard</a>
                <a href="{{ route('monitor.errors') }}">Errors</a>
                <a href="{{ route('monitor.requests') }}">Requests</a>
            </div>
        </nav>

        {{-- ── Page content ── --}}
        <div class="km-page">

            {{-- ── Summary Stats ── --}}
            <p class="km-section-label">Overview · All time</p>

            <div class="km-stats-grid">
                <div class="km-stat">
                    <div class="km-stat__accent bg-teal"></div>
                    <div class="km-stat__label">Total Requests</div>
                    <div class="km-stat__value color-teal">{{ number_format($totalRequests) }}</div>
                    <div class="km-stat__sub">Most common: <strong>{{ $topRequest }}</strong></div>
                </div>
                <div class="km-stat">
                    <div class="km-stat__accent bg-rose"></div>
                    <div class="km-stat__label">Total Errors</div>
                    <div class="km-stat__value color-rose">{{ number_format($totalErrors) }}</div>
                    <div class="km-stat__sub">Most common: <strong>{{ $topError }}</strong></div>
                </div>
                <div class="km-stat">
                    <div class="km-stat__accent bg-amber"></div>
                    <div class="km-stat__label">Alerts</div>
                    <div class="km-stat__value color-amber">{{ number_format($totalAlerts) }}</div>
                    <div class="km-stat__sub">Top IP: <strong>{{ $topAlertIp }}</strong></div>
                </div>
                <div class="km-stat">
                    <div class="km-stat__accent bg-sky"></div>
                    <div class="km-stat__label">Exceeded Requests</div>
                    <div class="km-stat__value color-sky">{{ number_format($totalExcReq) }}</div>
                    <div class="km-stat__sub">Exceeded errors: <strong>{{ number_format($totalExcErr) }}</strong></div>
                </div>
                <div class="km-stat">
                    <div class="km-stat__accent bg-teal"></div>
                    <div class="km-stat__label">Requests · Year</div>
                    <div class="km-stat__value color-teal">{{ number_format($statistics['request']['year']['total'] ?? 0) }}</div>
                    <div class="km-stat__sub">This year</div>
                </div>
                <div class="km-stat">
                    <div class="km-stat__accent bg-rose"></div>
                    <div class="km-stat__label">Errors · Year</div>
                    <div class="km-stat__value color-rose">{{ number_format($statistics['errors']['year']['total'] ?? 0) }}</div>
                    <div class="km-stat__sub">This year</div>
                </div>
                <div class="km-stat">
                    <div class="km-stat__accent bg-teal"></div>
                    <div class="km-stat__label">Requests · Today</div>
                    <div class="km-stat__value color-teal">{{ number_format($statistics['request']['today']['total'] ?? 0) }}</div>
                    <div class="km-stat__sub">Since midnight</div>
                </div>
                <div class="km-stat">
                    <div class="km-stat__accent bg-rose"></div>
                    <div class="km-stat__label">Errors · Today</div>
                    <div class="km-stat__value color-rose">{{ number_format($statistics['errors']['today']['total'] ?? 0) }}</div>
                    <div class="km-stat__sub">Since midnight</div>
                </div>
            </div>

            {{-- ── Charts row 1 ── --}}
            <p class="km-section-label">Historical trends</p>

            <div class="km-charts-grid">

                {{-- Historical Total --}}
                <div class="km-chart-card km-chart-card--8">
                    <div class="km-chart-header">
                        <span class="km-chart-title">Requests vs Errors — All years</span>
                        <span class="km-chart-badge km-chart-badge--teal">Line</span>
                    </div>
                    <div class="km-chart-body" data-chart="historicalTotal">
                        <div class="km-skeleton"></div>
                        <canvas id="chart-historical-total"></canvas>
                    </div>
                    <div class="km-legend">
                        <div class="km-legend-item"><div class="km-legend-dot" style="background:var(--teal)"></div>Requests</div>
                        <div class="km-legend-item"><div class="km-legend-dot" style="background:var(--rose)"></div>Errors</div>
                    </div>
                </div>

                {{-- Doughnut year --}}
                <div class="km-chart-card km-chart-card--4">
                    <div class="km-chart-header">
                        <span class="km-chart-title">Distribution · Year</span>
                        <span class="km-chart-badge km-chart-badge--amber">Doughnut</span>
                    </div>
                    <div class="km-chart-body" data-chart="doughnutYear">
                        <div class="km-skeleton"></div>
                        <canvas id="chart-doughnut-year"></canvas>
                    </div>
                    <div class="km-legend">
                        <div class="km-legend-item"><div class="km-legend-dot" style="background:var(--teal)"></div>Requests</div>
                        <div class="km-legend-item"><div class="km-legend-dot" style="background:var(--rose)"></div>Errors</div>
                    </div>
                </div>

            </div>

            {{-- ── Charts row 2 ── --}}
            <div class="km-charts-grid">

                {{-- Historical year (radar) --}}
                <div class="km-chart-card km-chart-card--4">
                    <div class="km-chart-header">
                        <span class="km-chart-title">Monthly pattern · Year</span>
                        <span class="km-chart-badge km-chart-badge--teal">Radar</span>
                    </div>
                    <div class="km-chart-body" data-chart="historicalYear">
                        <div class="km-skeleton"></div>
                        <canvas id="chart-historical-year"></canvas>
                    </div>
                    <div class="km-legend">
                        <div class="km-legend-item"><div class="km-legend-dot" style="background:var(--teal)"></div>Requests</div>
                        <div class="km-legend-item"><div class="km-legend-dot" style="background:var(--rose)"></div>Errors</div>
                    </div>
                </div>

                {{-- Methods bar --}}
                <div class="km-chart-card km-chart-card--4">
                    <div class="km-chart-header">
                        <span class="km-chart-title">HTTP Methods · Year</span>
                        <span class="km-chart-badge km-chart-badge--rose">Bar</span>
                    </div>
                    <div class="km-chart-body" data-chart="methods">
                        <div class="km-skeleton"></div>
                        <canvas id="chart-methods"></canvas>
                    </div>
                    <div class="km-legend">
                        <div class="km-legend-item"><div class="km-legend-dot" style="background:var(--teal)"></div>Requests</div>
                        <div class="km-legend-item"><div class="km-legend-dot" style="background:var(--rose)"></div>Errors</div>
                    </div>
                </div>

                {{-- Exceeded year --}}
                <div class="km-chart-card km-chart-card--4">
                    <div class="km-chart-header">
                        <span class="km-chart-title">Limit exceeded · Year</span>
                        <span class="km-chart-badge km-chart-badge--amber">Line</span>
                    </div>
                    <div class="km-chart-body" data-chart="exceededYear">
                        <div class="km-skeleton"></div>
                        <canvas id="chart-exceeded-year"></canvas>
                    </div>
                    <div class="km-legend">
                        <div class="km-legend-item"><div class="km-legend-dot" style="background:var(--teal)"></div>Requests</div>
                        <div class="km-legend-item"><div class="km-legend-dot" style="background:var(--rose)"></div>Errors</div>
                    </div>
                </div>

            </div>

        </div>{{-- /km-page --}}
    </div>{{-- /km-shell --}}
@endsection

@section('script')
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
    <script>
        /**
         * All chart data is prepared in PHP and passed as JSON — no foreach loops.
         * Charts are initialised lazily via IntersectionObserver, so off-screen
         * canvases never block the initial render.
         */

        const DATA = {
            historicalTotal: @json($chartHistoricalTotal),
            historicalYear:  @json($chartHistoricalYear),
            exceededYear:    @json($chartExceededYear),
            methods:         @json($chartMethods),
            doughnutYear:    @json($chartDoughnutYear),
        };

        /* ── Design tokens ── */
        const C = {
            teal:     '#00d4aa',
            tealFill: 'rgba(0,212,170,.15)',
            rose:     '#f43f5e',
            roseFill: 'rgba(244,63,94,.15)',
            amber:    '#f59e0b',
            sky:      '#38bdf8',
            grid:     '#1e2a3a',
            text:     '#64748b',
            textMain: '#e2e8f0',
        };

        /* ── Shared Chart.js defaults ── */
        Chart.defaults.color           = C.text;
        Chart.defaults.borderColor     = C.grid;
        Chart.defaults.font.family     = "'JetBrains Mono', monospace";
        Chart.defaults.font.size       = 11;
        Chart.defaults.animation.duration = 600;

        const tickOpts = { color: C.text, maxTicksLimit: 6 };
        const gridOpts = { color: C.grid };

        function lineDataset(label, data, color, fill = C.tealFill) {
            return {
                label, data,
                borderColor: color,
                backgroundColor: fill,
                fill: true,
                tension: .35,
                pointRadius: 3,
                pointBackgroundColor: color,
                pointBorderColor: '#0a0d12',
                pointBorderWidth: 2,
                pointHoverRadius: 5,
            };
        }

        /* ── Chart factory functions ── */
        const CHARTS = {

            historicalTotal(ctx) {
                const d = DATA.historicalTotal;
                new Chart(ctx, {
                    type: 'line',
                    data: {
                        labels: d.labels,
                        datasets: [
                            lineDataset('Requests', d.request, C.teal, C.tealFill),
                            lineDataset('Errors',   d.error,   C.rose, C.roseFill),
                        ],
                    },
                    options: {
                        responsive: true, maintainAspectRatio: false,
                        interaction: { mode: 'index', intersect: false },
                        plugins: { legend: { display: false } },
                        scales: {
                            x: { ticks: tickOpts, grid: gridOpts },
                            y: { ticks: tickOpts, grid: gridOpts, beginAtZero: true },
                        },
                    },
                });
            },

            doughnutYear(ctx) {
                const d = DATA.doughnutYear;
                new Chart(ctx, {
                    type: 'doughnut',
                    data: {
                        labels: ['Requests', 'Errors'],
                        datasets: [{
                            data: [d.request, d.error],
                            backgroundColor: [C.tealFill, C.roseFill],
                            borderColor:     [C.teal,     C.rose],
                            borderWidth: 2,
                            hoverOffset: 6,
                        }],
                    },
                    options: {
                        responsive: true, maintainAspectRatio: false,
                        cutout: '68%',
                        plugins: {
                            legend: { display: false },
                            tooltip: { callbacks: {
                                    label: ctx => ` ${ctx.label}: ${ctx.parsed.toLocaleString()}`
                                }},
                        },
                    },
                });
            },

            historicalYear(ctx) {
                const d = DATA.historicalYear;
                new Chart(ctx, {
                    type: 'radar',
                    data: {
                        labels: d.labels,
                        datasets: [
                            lineDataset('Requests', d.request, C.teal, C.tealFill),
                            lineDataset('Errors',   d.error,   C.rose, C.roseFill),
                        ],
                    },
                    options: {
                        responsive: true, maintainAspectRatio: false,
                        plugins: { legend: { display: false } },
                        scales: {
                            r: {
                                ticks: { ...tickOpts, backdropColor: 'transparent' },
                                grid:  { color: C.grid },
                                pointLabels: { color: C.textMain, font: { size: 11 } },
                            },
                        },
                    },
                });
            },

            methods(ctx) {
                const d = DATA.methods;
                new Chart(ctx, {
                    type: 'bar',
                    data: {
                        labels: d.labels,
                        datasets: [
                            { label: 'Requests', data: d.request, backgroundColor: C.tealFill, borderColor: C.teal, borderWidth: 1, borderRadius: 4 },
                            { label: 'Errors',   data: d.error,   backgroundColor: C.roseFill, borderColor: C.rose, borderWidth: 1, borderRadius: 4 },
                        ],
                    },
                    options: {
                        responsive: true, maintainAspectRatio: false,
                        interaction: { mode: 'index', intersect: false },
                        plugins: { legend: { display: false } },
                        scales: {
                            x: { ticks: tickOpts, grid: { display: false } },
                            y: { ticks: tickOpts, grid: gridOpts, beginAtZero: true },
                        },
                    },
                });
            },

            exceededYear(ctx) {
                const d = DATA.exceededYear;
                new Chart(ctx, {
                    type: 'line',
                    data: {
                        labels: d.labels,
                        datasets: [
                            lineDataset('Requests', d.request, C.amber, 'rgba(245,158,11,.12)'),
                            lineDataset('Errors',   d.error,   C.rose,  C.roseFill),
                        ],
                    },
                    options: {
                        responsive: true, maintainAspectRatio: false,
                        interaction: { mode: 'index', intersect: false },
                        plugins: { legend: { display: false } },
                        scales: {
                            x: { ticks: tickOpts, grid: gridOpts },
                            y: { ticks: tickOpts, grid: gridOpts, beginAtZero: true },
                        },
                    },
                });
            },
        };

        /* ── Lazy initialisation via IntersectionObserver ── */
        function initChart(body) {
            const key = body.dataset.chart;
            if (!CHARTS[key]) return;

            const canvas = body.querySelector('canvas');
            CHARTS[key](canvas.getContext('2d'));
            body.classList.add('loaded');
        }

        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    initChart(entry.target);
                    observer.unobserve(entry.target);
                }
            });
        }, { rootMargin: '80px' });

        document.querySelectorAll('[data-chart]').forEach(el => observer.observe(el));
    </script>
@endsection