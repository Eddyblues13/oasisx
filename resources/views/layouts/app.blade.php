<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Oasisxmarket') }}</title>
    <meta name="description"
        content="Trade smarter, grow faster. Access live markets, AI trading bots, copy trading, and crypto-backed capital loans on one institutional-grade platform.">

    {{-- Fonts --}}
    <link rel="preconnect" href="https://fonts.googleapis.com/">
    <link rel="preconnect" href="https://fonts.gstatic.com/" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Bebas+Neue&family=Outfit:wght@300;400;500;600;700&family=DM+Serif+Display:ital@0;1&display=swap"
        rel="stylesheet" />

    {{-- Chart.js --}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/4.4.1/chart.umd.min.js"></script>

    {{-- Tailwind CSS --}}
    <script src="https://cdn.tailwindcss.com/"></script>

    {{-- Base Styles --}}
    <style>
        /* ─── CSS VARIABLES ─── */
        :root {
            --black: #050505;
            --white: #F8F6F1;
            --g9: #0D0D0D;
            --g8: #141414;
            --g7: #1C1C1C;
            --g6: #2A2A2A;
            --g5: #3D3D3D;
            --g4: #5A5A5A;
            --g3: #888888;
            --g2: #B0B0B0;
            --g1: #D0D0D0;
            --gold: #C9A84C;
            --green: #4ADE80;
            --red: #F87171;
        }

        /* ─── RESET ─── */
        *,
        *::before,
        *::after {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        html {
            scroll-behavior: smooth;
            font-size: 16px;
        }

        body {
            background: var(--black);
            color: var(--white);
            font-family: 'Outfit', sans-serif;
            overflow-x: hidden;
            line-height: 1.6;
        }

        a {
            text-decoration: none;
            color: inherit;
        }

        button {
            border: none;
            cursor: pointer;
            font-family: inherit;
        }

        /* ─── SCROLLBAR ─── */
        ::-webkit-scrollbar {
            width: 4px;
        }

        ::-webkit-scrollbar-track {
            background: var(--black);
        }

        ::-webkit-scrollbar-thumb {
            background: var(--g6);
            border-radius: 2px;
        }

        /* ─── TICKER ─── */
        #ticker-bar {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            z-index: 1000;
            background: var(--white);
            color: var(--black);
            height: 36px;
            overflow: hidden;
            display: flex;
            align-items: center;
        }

        .ticker-track {
            display: flex;
            white-space: nowrap;
            animation: slide-ticker 35s linear infinite;
        }

        @keyframes slide-ticker {
            0% {
                transform: translateX(0);
            }

            100% {
                transform: translateX(-50%);
            }
        }

        .tick-item {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 0 28px;
            font-size: 11px;
            font-weight: 600;
            letter-spacing: .08em;
            border-right: 1px solid rgba(0, 0, 0, .1);
        }

        .tick-up {
            color: #15803d;
        }

        .tick-down {
            color: #b91c1c;
        }

        /* ─── NAV ─── */
        nav {
            position: fixed;
            top: 36px;
            left: 0;
            right: 0;
            z-index: 999;
            background: rgba(5, 5, 5, .95);
            backdrop-filter: blur(20px);
            border-bottom: 1px solid var(--g7);
            height: 70px;
            display: flex;
            align-items: center;
            padding: 0 clamp(1.5rem, 5vw, 4rem);
        }

        .nav-inner {
            width: 100%;
            max-width: 1400px;
            margin: 0 auto;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .nav-logo {
            font-family: 'Bebas Neue', sans-serif;
            font-size: 1.7rem;
            letter-spacing: .12em;
            color: var(--white);
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .nav-logo-dot {
            color: var(--gold);
            font-size: 1rem;
        }

        .nav-links {
            display: flex;
            gap: 2rem;
            list-style: none;
        }

        .nav-links a {
            font-size: .8rem;
            font-weight: 500;
            letter-spacing: .06em;
            color: var(--g3);
            text-transform: uppercase;
            transition: color .2s;
            padding: 4px 0;
            border-bottom: 1px solid transparent;
        }

        .nav-links a:hover {
            color: var(--white);
            border-bottom-color: var(--g5);
        }

        .nav-actions {
            display: flex;
            gap: .75rem;
            align-items: center;
        }

        .btn-outline {
            padding: .55rem 1.3rem;
            border: 1px solid var(--g6);
            color: var(--g2);
            font-size: .78rem;
            font-weight: 500;
            letter-spacing: .05em;
            border-radius: 3px;
            transition: all .2s;
        }

        .btn-outline:hover {
            border-color: var(--g3);
            color: var(--white);
        }

        .btn-solid {
            padding: .55rem 1.5rem;
            background: var(--white);
            color: var(--black);
            font-size: .78rem;
            font-weight: 700;
            letter-spacing: .06em;
            border-radius: 3px;
            transition: all .2s;
        }

        .btn-solid:hover {
            background: var(--g1);
        }

        .hamburger {
            display: none;
            flex-direction: column;
            gap: 5px;
            background: transparent;
            padding: 4px;
        }

        .hamburger span {
            display: block;
            width: 22px;
            height: 1.5px;
            background: var(--white);
            border-radius: 1px;
            transition: all .3s;
        }

        .mobile-menu {
            display: none;
            position: fixed;
            top: 106px;
            left: 0;
            right: 0;
            background: var(--g9);
            border-bottom: 1px solid var(--g7);
            padding: 1.5rem clamp(1.5rem, 5vw, 4rem);
            z-index: 998;
            flex-direction: column;
            gap: 1rem;
        }

        .mobile-menu.open {
            display: flex;
        }

        .mobile-menu a {
            font-size: 1rem;
            font-weight: 500;
            color: var(--g2);
            padding: .6rem 0;
            border-bottom: 1px solid var(--g8);
        }

        .mobile-menu a:hover {
            color: var(--white);
        }

        .mob-btns {
            display: flex;
            gap: .75rem;
            margin-top: .5rem;
        }

        .mob-btns a {
            border-bottom: none !important;
            font-size: .85rem;
        }

        /* ─── LAYOUT UTILITIES ─── */
        .sw {
            max-width: 1400px;
            margin: 0 auto;
            padding-left: clamp(1.5rem, 5vw, 4rem);
            padding-right: clamp(1.5rem, 5vw, 4rem);
        }

        .sec-label {
            display: inline-flex;
            align-items: center;
            gap: .75rem;
            font-size: .72rem;
            font-weight: 600;
            letter-spacing: .2em;
            text-transform: uppercase;
            color: var(--g3);
            margin-bottom: 1.25rem;
        }

        .sec-label::before {
            content: '';
            display: block;
            width: 28px;
            height: 1px;
            background: var(--gold);
        }

        .sec-title {
            font-family: 'Bebas Neue', sans-serif;
            font-size: clamp(2.8rem, 6vw, 5.5rem);
            line-height: .95;
            letter-spacing: .02em;
            color: var(--white);
        }

        .sec-title em {
            font-family: 'DM Serif Display', serif;
            font-style: italic;
            color: var(--gold);
        }

        .body-text {
            font-size: clamp(.88rem, 1.5vw, 1rem);
            line-height: 1.85;
            color: var(--g2);
        }

        /* ─── SHARED BUTTON STYLES ─── */
        .cta-primary {
            padding: .9rem 2.2rem;
            background: var(--white);
            color: var(--black);
            font-size: .85rem;
            font-weight: 700;
            letter-spacing: .08em;
            text-transform: uppercase;
            border-radius: 3px;
            transition: all .25s;
            border: 1px solid var(--white);
            display: inline-flex;
            align-items: center;
            gap: .5rem;
        }

        .cta-primary:hover {
            background: transparent;
            color: var(--white);
        }

        .cta-secondary {
            padding: .9rem 2.2rem;
            background: transparent;
            color: var(--g2);
            font-size: .85rem;
            font-weight: 600;
            letter-spacing: .08em;
            text-transform: uppercase;
            border: 1px solid var(--g6);
            border-radius: 3px;
            transition: all .25s;
            display: inline-flex;
            align-items: center;
            gap: .5rem;
        }

        .cta-secondary:hover {
            border-color: var(--white);
            color: var(--white);
        }

        /* ─── FOOTER ─── */
        footer {
            background: var(--black);
            border-top: 1px solid var(--g7);
            padding: clamp(3rem, 6vw, 5rem) clamp(1.5rem, 5vw, 4rem) 0;
        }

        .footer-inner {
            max-width: 1400px;
            margin: 0 auto;
            display: grid;
            grid-template-columns: 1.5fr 1fr 1fr 1fr;
            gap: clamp(2rem, 4vw, 4rem);
            padding-bottom: 3rem;
        }

        .footer-brand-logo {
            font-family: 'Bebas Neue', sans-serif;
            font-size: 1.8rem;
            letter-spacing: .12em;
            color: var(--white);
            margin-bottom: .75rem;
        }

        .footer-tagline {
            font-size: .82rem;
            line-height: 1.8;
            color: var(--g4);
            max-width: 28ch;
            margin-bottom: 1.5rem;
        }

        .footer-socials {
            display: flex;
            gap: .5rem;
        }

        .soc-btn {
            width: 34px;
            height: 34px;
            border: 1px solid var(--g7);
            border-radius: 3px;
            background: transparent;
            color: var(--g4);
            font-size: .8rem;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all .2s;
            cursor: pointer;
        }

        .soc-btn:hover {
            border-color: var(--g4);
            color: var(--white);
        }

        .footer-col-title {
            font-size: .72rem;
            font-weight: 700;
            letter-spacing: .18em;
            text-transform: uppercase;
            color: var(--white);
            margin-bottom: 1.25rem;
        }

        .footer-links {
            list-style: none;
            display: flex;
            flex-direction: column;
            gap: .7rem;
        }

        .footer-links a {
            font-size: .82rem;
            color: var(--g4);
            transition: color .2s;
        }

        .footer-links a:hover {
            color: var(--white);
        }

        .footer-bottom {
            max-width: 1400px;
            margin: 0 auto;
            border-top: 1px solid var(--g8);
            padding: 1.5rem 0;
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 1rem;
            flex-wrap: wrap;
        }

        .footer-bottom p {
            font-size: .75rem;
            color: var(--g5);
        }

        .risk-warning {
            background: var(--g9);
            border: 1px solid var(--g7);
            border-radius: 3px;
            padding: 1rem 1.25rem;
            margin-bottom: 2rem;
            font-size: .75rem;
            color: var(--g4);
            line-height: 1.7;
            max-width: 1400px;
            margin-left: auto;
            margin-right: auto;
        }

        /* ─── RESPONSIVE ─── */
        @media (max-width: 640px) {

            .nav-links,
            .nav-actions {
                display: none;
            }

            .hamburger {
                display: flex;
            }

            .footer-inner {
                grid-template-columns: 1fr 1fr;
            }
        }

        @media (max-width: 900px) {
            .footer-inner {
                grid-template-columns: 1fr 1fr;
            }
        }
    </style>

    @stack('styles')

    <!-- Smartsupp Live Chat script -->
<script type="text/javascript">
var _smartsupp = _smartsupp || {};
_smartsupp.key = '7306ffedc726b4ef2f14996741ffeae02c1c5f4e';
window.smartsupp||(function(d) {
  var s,c,o=smartsupp=function(){ o._.push(arguments)};o._=[];
  s=d.getElementsByTagName('script')[0];c=d.createElement('script');
  c.type='text/javascript';c.charset='utf-8';c.async=true;
  c.src='https://www.smartsuppchat.com/loader.js?';s.parentNode.insertBefore(c,s);
})(document);
</script>
<noscript>Powered by <a href="https://www.smartsupp.com" target="_blank">Smartsupp</a></noscript>

</head>

<body>

    {{-- Ticker Bar --}}
    @include('partials.ticker')

    {{-- Navigation --}}
    @include('partials.navbar')

    {{-- Main Content --}}
    <main>
        @yield('content')
    </main>

    {{-- Footer --}}
    @include('partials.footer')

    {{-- Ticker + Mobile Menu Scripts --}}
    <script>
        /* ── TICKER ── */
        const TICKS = [
            { s: 'BTC/USD',    p: '$67,842', c: '+2.34%', u: true  },
            { s: 'ETH/USD',    p: '$3,441',  c: '+1.12%', u: true  },
            { s: 'SOL/USD',    p: '$172.40', c: '−0.84%', u: false },
            { s: 'BNB/USD',    p: '$412.20', c: '+0.73%', u: true  },
            { s: 'XRP/USD',    p: '$0.5821', c: '−1.20%', u: false },
            { s: 'EUR/USD',    p: '$1.0821', c: '−0.12%', u: false },
            { s: 'GBP/USD',    p: '$1.2640', c: '+0.08%', u: true  },
            { s: 'GOLD',       p: '$2,341',  c: '+0.44%', u: true  },
            { s: 'SPX500',     p: '$5,214',  c: '+0.61%', u: true  },
            { s: 'CRUDE OIL',  p: '$81.20',  c: '−0.33%', u: false },
        ];
        const tt = document.getElementById('tickerTrack');
        if (tt) {
            let html = '';
            for (let r = 0; r < 2; r++) {
                TICKS.forEach(t => {
                    html += `<div class="tick-item"><strong>${t.s}</strong> ${t.p} <span class="${t.u ? 'tick-up' : 'tick-down'}">${t.c}</span></div>`;
                });
            }
            tt.innerHTML = html;
        }

        /* ── MOBILE MENU ── */
        const ham = document.getElementById('hamburger');
        const mob = document.getElementById('mobileMenu');
        if (ham) ham.addEventListener('click', () => mob.classList.toggle('open'));
        function closeMob() { if (mob) mob.classList.remove('open'); }
    </script>

    @stack('scripts')
</body>

</html>