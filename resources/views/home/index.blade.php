@extends('layouts.app')

@push('styles')
<style>
    /* ─── MARQUEE ─── */
    .marquee-strip {
        border-top: 1px solid var(--g7);
        border-bottom: 1px solid var(--g7);
        overflow: hidden;
        padding: 1rem 0;
        background: var(--g9);
    }

    .marquee-inner {
        display: inline-flex;
        white-space: nowrap;
        animation: slide-ticker 25s linear infinite;
    }

    .marquee-word {
        font-family: 'Bebas Neue', sans-serif;
        font-size: 2rem;
        letter-spacing: .12em;
        color: transparent;
        -webkit-text-stroke: 1px var(--g7);
        padding: 0 2.5rem;
    }

    .marquee-word.lit {
        color: var(--white);
        -webkit-text-stroke: 0;
    }

    /* ─── HERO ─── */
    #hero {
        min-height: 100vh;
        padding-top: 106px;
        display: grid;
        grid-template-columns: 1fr 1fr;
        position: relative;
        overflow: hidden;
    }

    .hero-bg-grid {
        position: absolute;
        inset: 0;
        pointer-events: none;
        background-image: linear-gradient(var(--g8) 1px, transparent 1px), linear-gradient(90deg, var(--g8) 1px, transparent 1px);
        background-size: 60px 60px;
        opacity: .4;
        mask-image: radial-gradient(ellipse 80% 80% at 50% 50%, black 30%, transparent 100%);
    }

    .hero-left {
        display: flex;
        flex-direction: column;
        justify-content: center;
        padding: clamp(3rem, 6vw, 6rem) clamp(1.5rem, 4vw, 4rem);
        border-right: 1px solid var(--g7);
        position: relative;
        z-index: 2;
    }

    .hero-eyebrow {
        display: inline-flex;
        align-items: center;
        gap: .6rem;
        background: var(--g8);
        border: 1px solid var(--g6);
        padding: .4rem 1rem;
        border-radius: 2px;
        font-size: .72rem;
        font-weight: 600;
        letter-spacing: .15em;
        text-transform: uppercase;
        color: var(--g2);
        margin-bottom: 2rem;
        width: fit-content;
    }

    .hero-eyebrow-dot {
        width: 6px;
        height: 6px;
        background: var(--green);
        border-radius: 50%;
        animation: blink 1.8s ease-in-out infinite;
        flex-shrink: 0;
    }

    @keyframes blink {

        0%,
        100% {
            opacity: 1;
        }

        50% {
            opacity: .3;
        }
    }

    .hero-h1 {
        font-family: 'Bebas Neue', sans-serif;
        font-size: clamp(3.8rem, 8vw, 8.5rem);
        line-height: .88;
        letter-spacing: .02em;
        color: var(--white);
        margin-bottom: 1.75rem;
    }

    .hero-h1 .outline {
        color: transparent;
        -webkit-text-stroke: 1.5px var(--g5);
    }

    .hero-h1 .gold {
        color: var(--gold);
    }

    .hero-p {
        font-size: clamp(.92rem, 1.5vw, 1.05rem);
        line-height: 1.85;
        color: var(--g2);
        max-width: 46ch;
        margin-bottom: 2.5rem;
    }

    .hero-ctas {
        display: flex;
        gap: 1rem;
        flex-wrap: wrap;
        margin-bottom: 3rem;
    }

    .hero-trust {
        display: flex;
        gap: 2rem;
        flex-wrap: wrap;
    }

    .trust-num {
        font-family: 'Bebas Neue', sans-serif;
        font-size: 1.8rem;
        letter-spacing: .04em;
        color: var(--white);
    }

    .trust-label {
        font-size: .72rem;
        font-weight: 500;
        color: var(--g3);
        letter-spacing: .06em;
        text-transform: uppercase;
    }

    .hero-right {
        display: flex;
        flex-direction: column;
        justify-content: center;
        padding: clamp(2rem, 4vw, 4rem);
        position: relative;
        z-index: 2;
        gap: 1.25rem;
    }

    /* ─── STAT GRID ─── */
    .stat-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 1px;
        background: var(--g7);
        border: 1px solid var(--g7);
        border-radius: 4px;
        overflow: hidden;
    }

    .stat-cell {
        background: var(--g9);
        padding: 1.5rem 1.25rem;
        transition: background .2s;
    }

    .stat-cell:hover {
        background: var(--g8);
    }

    .stat-cell-label {
        font-size: .7rem;
        font-weight: 600;
        letter-spacing: .15em;
        text-transform: uppercase;
        color: var(--g4);
        margin-bottom: .4rem;
    }

    .stat-cell-value {
        font-family: 'Bebas Neue', sans-serif;
        font-size: 2.2rem;
        letter-spacing: .04em;
        color: var(--white);
        line-height: 1;
    }

    .stat-cell-change {
        font-size: .72rem;
        font-weight: 500;
        margin-top: .25rem;
    }

    .ch-up {
        color: var(--green);
    }

    .ch-down {
        color: var(--red);
    }

    /* ─── CHART CARD ─── */
    .chart-card {
        background: var(--g9);
        border: 1px solid var(--g7);
        border-radius: 4px;
        padding: 1.5rem;
        overflow: hidden;
    }

    .chart-card-header {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        margin-bottom: 1rem;
    }

    .chart-card-title {
        font-size: .72rem;
        font-weight: 600;
        letter-spacing: .12em;
        text-transform: uppercase;
        color: var(--g4);
    }

    .chart-price-big {
        font-family: 'Bebas Neue', sans-serif;
        font-size: 2rem;
        letter-spacing: .04em;
        color: var(--white);
        line-height: 1;
    }

    .chg-badge {
        font-size: .72rem;
        font-weight: 600;
        padding: .2rem .6rem;
        border-radius: 2px;
        letter-spacing: .04em;
    }

    .badge-up {
        background: rgba(74, 222, 128, .12);
        color: var(--green);
    }

    .badge-down {
        background: rgba(248, 113, 113, .12);
        color: var(--red);
    }

    /* ─── ABOUT ─── */
    #about {
        padding: clamp(4rem, 8vw, 8rem) 0;
    }

    .about-layout {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: clamp(3rem, 6vw, 6rem);
        align-items: center;
    }

    .about-nums {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 1px;
        background: var(--g7);
        border: 1px solid var(--g7);
        border-radius: 4px;
        overflow: hidden;
    }

    .about-num-cell {
        background: var(--g9);
        padding: 2rem 1.5rem;
        transition: background .25s;
        cursor: default;
    }

    .about-num-cell:hover {
        background: var(--g8);
    }

    .anc-value {
        font-family: 'Bebas Neue', sans-serif;
        font-size: 2.6rem;
        color: var(--white);
        line-height: 1;
        margin-bottom: .3rem;
    }

    .anc-label {
        font-size: .78rem;
        font-weight: 500;
        color: var(--g3);
        line-height: 1.5;
    }

    .about-text {
        display: flex;
        flex-direction: column;
        gap: 1.5rem;
    }

    .about-body {
        font-size: clamp(.88rem, 1.5vw, 1rem);
        line-height: 1.9;
        color: var(--g2);
    }

    .about-body strong {
        color: var(--white);
        font-weight: 600;
    }

    .pill-row {
        display: flex;
        gap: .6rem;
        flex-wrap: wrap;
    }

    .pill {
        padding: .35rem .9rem;
        background: var(--g8);
        border: 1px solid var(--g6);
        border-radius: 2px;
        font-size: .72rem;
        font-weight: 600;
        letter-spacing: .06em;
        color: var(--g2);
        text-transform: uppercase;
    }

    /* ─── SERVICES ─── */
    #services {
        padding: clamp(4rem, 8vw, 8rem) 0;
        background: var(--g9);
    }

    .services-header {
        display: flex;
        justify-content: space-between;
        align-items: flex-end;
        gap: 2rem;
        flex-wrap: wrap;
        margin-bottom: 3rem;
    }

    .services-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 1px;
        background: var(--g7);
        border-radius: 4px;
        overflow: hidden;
    }

    .svc-card {
        background: var(--g9);
        padding: 2.5rem 2rem;
        transition: background .25s;
        position: relative;
        overflow: hidden;
        display: flex;
        flex-direction: column;
    }

    .svc-card::after {
        content: '';
        position: absolute;
        bottom: 0;
        left: 0;
        width: 0;
        height: 2px;
        background: var(--gold);
        transition: width .4s ease;
    }

    .svc-card:hover::after {
        width: 100%;
    }

    .svc-card:hover {
        background: var(--g8);
    }

    .svc-icon {
        width: 48px;
        height: 48px;
        background: var(--g8);
        border: 1px solid var(--g6);
        border-radius: 4px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.4rem;
        margin-bottom: 1.5rem;
    }

    .svc-num {
        font-family: 'Bebas Neue', sans-serif;
        font-size: .85rem;
        letter-spacing: .15em;
        color: var(--g6);
        margin-bottom: .6rem;
    }

    .svc-title {
        font-family: 'Bebas Neue', sans-serif;
        font-size: 1.7rem;
        letter-spacing: .04em;
        color: var(--white);
        margin-bottom: .75rem;
        line-height: 1;
    }

    .svc-desc {
        font-size: .85rem;
        line-height: 1.8;
        color: var(--g3);
        margin-bottom: 1.75rem;
        flex: 1;
    }

    .svc-features {
        list-style: none;
        margin-top: auto;
    }

    .svc-features li {
        font-size: .78rem;
        color: var(--g3);
        padding: .5rem 0;
        border-top: 1px solid var(--g8);
        display: flex;
        align-items: center;
        gap: .6rem;
        line-height: 1.5;
    }

    .svc-features li .dot {
        width: 5px;
        height: 5px;
        background: var(--gold);
        border-radius: 50%;
        flex-shrink: 0;
    }

    /* ─── PERFORMANCE ─── */
    #performance {
        padding: clamp(4rem, 8vw, 8rem) 0;
    }

    .perf-layout {
        display: grid;
        grid-template-columns: 1.4fr 1fr;
        gap: clamp(2rem, 5vw, 5rem);
        align-items: start;
    }

    .perf-chart-card {
        background: var(--g9);
        border: 1px solid var(--g7);
        border-radius: 4px;
        padding: 2rem;
        overflow: hidden;
    }

    .perf-chart-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 1.5rem;
    }

    .perf-legend {
        display: flex;
        gap: 1.5rem;
    }

    .legend-item {
        display: flex;
        align-items: center;
        gap: .5rem;
        font-size: .75rem;
        color: var(--g3);
    }

    .legend-dot {
        width: 8px;
        height: 8px;
        border-radius: 50%;
    }

    .perf-stats-list {
        display: flex;
        flex-direction: column;
        gap: 1px;
        background: var(--g7);
        border-radius: 4px;
        overflow: hidden;
    }

    .perf-row {
        background: var(--g9);
        padding: 1.4rem 1.5rem;
        display: flex;
        justify-content: space-between;
        align-items: center;
        transition: background .2s;
    }

    .perf-row:hover {
        background: var(--g8);
    }

    .perf-row-name {
        font-size: .88rem;
        font-weight: 600;
        color: var(--white);
        margin-bottom: .2rem;
    }

    .perf-row-desc {
        font-size: .72rem;
        color: var(--g4);
    }

    .perf-row-num {
        font-family: 'Bebas Neue', sans-serif;
        font-size: 2rem;
        color: var(--white);
        letter-spacing: .04em;
    }

    /* ─── DASHBOARD ─── */
    #dashboard {
        padding: clamp(4rem, 8vw, 8rem) 0;
        background: var(--g9);
    }

    .dash-grid {
        display: grid;
        grid-template-columns: 2fr 1fr 1fr;
        gap: 1px;
        background: var(--g7);
        border-radius: 4px;
        overflow: hidden;
    }

    .dash-panel {
        background: var(--g9);
        padding: 1.75rem;
    }

    .dash-panel-head {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 1.25rem;
    }

    .dash-panel-title {
        font-size: .72rem;
        font-weight: 700;
        letter-spacing: .15em;
        text-transform: uppercase;
        color: var(--g4);
    }

    .live-badge {
        display: inline-flex;
        align-items: center;
        gap: .35rem;
        font-size: .65rem;
        font-weight: 600;
        letter-spacing: .1em;
        color: var(--green);
        background: rgba(74, 222, 128, .08);
        border: 1px solid rgba(74, 222, 128, .2);
        padding: .2rem .6rem;
        border-radius: 2px;
    }

    .live-badge::before {
        content: '';
        width: 6px;
        height: 6px;
        background: var(--green);
        border-radius: 50%;
        animation: blink 1.5s ease-in-out infinite;
    }

    .ohlcv-row {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 1px;
        background: var(--g7);
        border-radius: 2px;
        overflow: hidden;
        margin-top: 1rem;
    }

    .ohlcv-cell {
        background: var(--g8);
        padding: .75rem;
    }

    .ohlcv-label {
        font-size: .65rem;
        font-weight: 600;
        letter-spacing: .1em;
        color: var(--g4);
        margin-bottom: .3rem;
    }

    .ohlcv-val {
        font-family: 'Bebas Neue', sans-serif;
        font-size: 1.1rem;
        color: var(--white);
    }

    .ob-row {
        display: grid;
        grid-template-columns: 1fr 1fr 1fr;
        font-size: .7rem;
        padding: .35rem 0;
        gap: .5rem;
    }

    .ob-row.hdr {
        font-size: .65rem;
        font-weight: 700;
        letter-spacing: .1em;
        color: var(--g5);
        border-bottom: 1px solid var(--g7);
        margin-bottom: .25rem;
        padding-bottom: .5rem;
    }

    .ob-row .ask-p {
        color: var(--red);
    }

    .ob-row .bid-p {
        color: var(--green);
    }

    .ob-mid {
        text-align: center;
        font-family: 'Bebas Neue', sans-serif;
        font-size: 1.2rem;
        color: var(--white);
        padding: .5rem 0;
        border-top: 1px solid var(--g7);
        border-bottom: 1px solid var(--g7);
        margin: .3rem 0;
    }

    .asset-row {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: .75rem;
        background: var(--g8);
        border-radius: 3px;
        margin-bottom: .4rem;
        transition: background .2s;
    }

    .asset-row:hover {
        background: var(--g7);
    }

    .asset-sym {
        font-weight: 700;
        font-size: .85rem;
        color: var(--white);
    }

    .asset-name {
        font-size: .68rem;
        color: var(--g4);
    }

    .asset-price {
        font-size: .82rem;
        font-weight: 600;
        color: var(--white);
        font-variant-numeric: tabular-nums;
    }

    .asset-chg {
        font-size: .72rem;
        font-weight: 600;
        padding: .2rem .5rem;
        border-radius: 2px;
    }

    .chg-up {
        background: rgba(74, 222, 128, .1);
        color: var(--green);
    }

    .chg-down {
        background: rgba(248, 113, 113, .1);
        color: var(--red);
    }

    /* ─── BOTS ─── */
    #bots {
        padding: clamp(4rem, 8vw, 8rem) 0;
    }

    .bots-section-head {
        display: flex;
        justify-content: space-between;
        align-items: flex-end;
        flex-wrap: wrap;
        gap: 1.5rem;
        margin-bottom: .5rem;
    }

    .bots-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 1px;
        background: var(--g7);
        border-radius: 4px;
        overflow: hidden;
        margin-top: 3rem;
    }

    .bot-card {
        background: var(--g9);
        padding: 2.5rem 2rem;
        display: flex;
        flex-direction: column;
        transition: background .25s;
        position: relative;
    }

    .bot-card:hover {
        background: var(--g8);
    }

    .bot-card.featured {
        background: var(--white);
        color: var(--black);
    }

    .bot-card.featured:hover {
        background: #eee;
    }

    .bot-badge {
        position: absolute;
        top: 1.25rem;
        right: 1.25rem;
        font-size: .65rem;
        font-weight: 700;
        letter-spacing: .12em;
        text-transform: uppercase;
        padding: .25rem .7rem;
        border-radius: 2px;
        border: 1px solid var(--g6);
        color: var(--g3);
    }

    .bot-card.featured .bot-badge {
        border-color: rgba(0, 0, 0, .2);
        color: rgba(0, 0, 0, .5);
    }

    .bot-name {
        font-family: 'Bebas Neue', sans-serif;
        font-size: 2rem;
        letter-spacing: .04em;
        margin-bottom: .5rem;
    }

    .bot-desc {
        font-size: .85rem;
        line-height: 1.8;
        color: var(--g3);
        margin-bottom: 2rem;
        flex: 1;
    }

    .bot-card.featured .bot-desc {
        color: rgba(0, 0, 0, .6);
    }

    .bot-stats-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 1rem;
        margin-bottom: 1.5rem;
    }

    .bsg-label {
        font-size: .65rem;
        font-weight: 600;
        letter-spacing: .12em;
        text-transform: uppercase;
        color: var(--g4);
        margin-bottom: .25rem;
    }

    .bot-card.featured .bsg-label {
        color: rgba(0, 0, 0, .5);
    }

    .bsg-val {
        font-family: 'Bebas Neue', sans-serif;
        font-size: 1.8rem;
        color: var(--white);
        line-height: 1;
    }

    .bot-card.featured .bsg-val {
        color: var(--black);
    }

    .bot-bar-wrap {
        height: 3px;
        background: var(--g7);
        border-radius: 2px;
        margin-bottom: 2rem;
        overflow: hidden;
    }

    .bot-card.featured .bot-bar-wrap {
        background: rgba(0, 0, 0, .15);
    }

    .bot-bar-fill {
        height: 100%;
        background: var(--gold);
        border-radius: 2px;
    }

    .bot-card.featured .bot-bar-fill {
        background: var(--black);
    }

    .btn-deploy {
        padding: .85rem;
        font-size: .78rem;
        font-weight: 700;
        letter-spacing: .1em;
        text-transform: uppercase;
        border-radius: 3px;
        transition: all .25s;
        border: 1px solid var(--g6);
        background: transparent;
        color: var(--g2);
    }

    .btn-deploy:hover {
        border-color: var(--white);
        color: var(--white);
    }

    .bot-card.featured .btn-deploy {
        background: var(--black);
        color: var(--white);
        border-color: var(--black);
    }

    .bot-card.featured .btn-deploy:hover {
        background: var(--g8);
    }

    /* ─── LOANS ─── */
    #loans {
        padding: clamp(4rem, 8vw, 8rem) 0;
    }

    .loans-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 1px;
        background: var(--g7);
        border-radius: 4px;
        overflow: hidden;
        margin-top: 3rem;
    }

    .loan-card {
        background: var(--g9);
        padding: 2.5rem 2rem;
        transition: background .25s;
        border-top: 3px solid var(--g7);
    }

    .loan-card:hover {
        background: var(--g8);
        border-top-color: var(--gold);
    }

    .loan-card.featured {
        border-top-color: var(--white);
    }

    .loan-type {
        font-size: .78rem;
        font-weight: 700;
        letter-spacing: .15em;
        text-transform: uppercase;
        color: var(--g3);
        margin-bottom: .75rem;
    }

    .loan-rate {
        font-family: 'Bebas Neue', sans-serif;
        font-size: 4.5rem;
        color: var(--white);
        line-height: 1;
    }

    .loan-rate-unit {
        font-family: 'Bebas Neue', sans-serif;
        font-size: 2rem;
        color: var(--g4);
    }

    .loan-rate-label {
        font-size: .75rem;
        color: var(--g4);
        margin-bottom: 2rem;
    }

    .loan-range {
        font-size: .88rem;
        font-weight: 600;
        color: var(--g2);
        margin-bottom: 1.75rem;
    }

    .loan-features {
        list-style: none;
    }

    .loan-features li {
        font-size: .82rem;
        color: var(--g3);
        padding: .65rem 0;
        border-bottom: 1px solid var(--g8);
        display: flex;
        align-items: center;
        gap: .75rem;
        line-height: 1.5;
    }

    .loan-features li .check {
        color: var(--gold);
        font-size: .85rem;
        flex-shrink: 0;
    }

    .btn-apply {
        width: 100%;
        margin-top: 2rem;
        padding: .9rem;
        font-size: .78rem;
        font-weight: 700;
        letter-spacing: .1em;
        text-transform: uppercase;
        border-radius: 3px;
        transition: all .25s;
        border: 1px solid var(--g6);
        background: transparent;
        color: var(--g2);
    }

    .btn-apply:hover {
        border-color: var(--white);
        color: var(--white);
        background: var(--g8);
    }

    .loan-card.featured .btn-apply {
        background: var(--white);
        color: var(--black);
        border-color: var(--white);
    }

    .loan-card.featured .btn-apply:hover {
        background: var(--g1);
    }

    /* ─── CONTACT ─── */
    #contact {
        padding: clamp(4rem, 8vw, 8rem) 0;
        background: var(--g9);
    }

    .contact-layout {
        display: grid;
        grid-template-columns: 1fr 1.2fr;
        gap: clamp(3rem, 6vw, 6rem);
    }

    .contact-body {
        font-size: clamp(.88rem, 1.5vw, 1rem);
        line-height: 1.9;
        color: var(--g2);
        margin-bottom: 2.5rem;
    }

    .contact-links {
        display: flex;
        flex-direction: column;
        gap: 1px;
        background: var(--g7);
        border-radius: 4px;
        overflow: hidden;
    }

    .contact-link-item {
        display: flex;
        justify-content: space-between;
        align-items: center;
        background: var(--g9);
        padding: 1.1rem 1.4rem;
        font-size: .85rem;
        color: var(--g3);
        transition: all .2s;
        gap: 1rem;
    }

    .contact-link-item:hover {
        background: var(--g8);
        color: var(--white);
    }

    .contact-link-item .arrow {
        font-size: 1rem;
        color: var(--g6);
        transition: transform .2s;
    }

    .contact-link-item:hover .arrow {
        transform: translateX(4px);
        color: var(--white);
    }

    .form-card {
        background: var(--g8);
        border: 1px solid var(--g7);
        border-radius: 4px;
        padding: 2.5rem;
    }

    .form-card-title {
        font-family: 'Bebas Neue', sans-serif;
        font-size: 1.8rem;
        letter-spacing: .06em;
        color: var(--white);
        margin-bottom: .5rem;
    }

    .form-card-sub {
        font-size: .8rem;
        color: var(--g4);
        margin-bottom: 2rem;
        line-height: 1.6;
    }

    .form-group {
        margin-bottom: 1.25rem;
    }

    .form-label {
        display: block;
        font-size: .72rem;
        font-weight: 600;
        letter-spacing: .12em;
        text-transform: uppercase;
        color: var(--g3);
        margin-bottom: .5rem;
    }

    .form-input,
    .form-select,
    .form-textarea {
        width: 100%;
        background: var(--g9);
        border: 1px solid var(--g6);
        color: var(--white);
        font-family: 'Outfit', sans-serif;
        font-size: .88rem;
        padding: .85rem 1rem;
        border-radius: 3px;
        outline: none;
        transition: border-color .2s;
        appearance: none;
    }

    .form-input:focus,
    .form-select:focus,
    .form-textarea:focus {
        border-color: var(--g3);
    }

    .form-input::placeholder,
    .form-textarea::placeholder {
        color: var(--g6);
    }

    .form-textarea {
        height: 110px;
        resize: none;
    }

    .btn-send {
        width: 100%;
        padding: 1rem;
        background: var(--white);
        color: var(--black);
        font-size: .85rem;
        font-weight: 700;
        letter-spacing: .1em;
        text-transform: uppercase;
        border-radius: 3px;
        transition: all .25s;
        border: 1px solid var(--white);
    }

    .btn-send:hover {
        background: transparent;
        color: var(--white);
    }

    /* ─── RESPONSIVE ─── */
    @media (max-width: 1100px) {
        .services-grid {
            grid-template-columns: 1fr 1fr;
        }

        .bots-grid {
            grid-template-columns: 1fr 1fr;
        }

        .dash-grid {
            grid-template-columns: 1fr 1fr;
        }
    }

    @media (max-width: 900px) {
        #hero {
            grid-template-columns: 1fr;
            min-height: auto;
        }

        .hero-right {
            border-top: 1px solid var(--g7);
            padding-top: 2rem;
        }

        .about-layout {
            grid-template-columns: 1fr;
        }

        .perf-layout {
            grid-template-columns: 1fr;
        }

        .contact-layout {
            grid-template-columns: 1fr;
        }

        .traders-grid {
            grid-template-columns: 1fr 1fr;
        }

        .loans-grid {
            grid-template-columns: 1fr 1fr;
        }

        .services-header {
            flex-direction: column;
            align-items: flex-start;
        }

        .services-header p {
            text-align: left !important;
        }
    }

    @media (max-width: 640px) {

        .services-grid,
        .bots-grid,
        .dash-grid,
        .traders-grid,
        .loans-grid {
            grid-template-columns: 1fr;
        }

        .stat-grid {
            grid-template-columns: 1fr 1fr;
        }

        .hero-trust {
            gap: 1.5rem;
        }

        .copy-header {
            flex-direction: column;
            align-items: flex-start;
        }

        .bots-section-head {
            flex-direction: column;
            align-items: flex-start;
        }
    }
</style>
@endpush

@section('content')

{{-- ═══════════════ HERO ═══════════════ --}}
<section id="hero">
    <div class="hero-bg-grid"></div>

    <div class="hero-left">
        <div class="hero-eyebrow">
            <span class="hero-eyebrow-dot"></span>
            Live Markets &middot; 183K+ Active Traders
        </div>

        <h1 class="hero-h1">
            TRADE<br>
            <span class="outline">SMARTER</span><br>
            <span class="gold">GROW</span> FASTER
        </h1>

        <p class="hero-p">
            Oasisxmarket is an institutional-grade platform for serious investors.
            Access live markets, AI bots, copy trading, and flexible capital loans &mdash; all in one place.
        </p>

        <div class="hero-ctas">
            <a href="{{ url('/register') }}" class="cta-primary">Start Trading Free &rarr;</a>
            <a href="#services" class="cta-secondary">Explore Platform</a>
        </div>

        <div class="hero-trust">
            <div>
                <div class="trust-num">$48B+</div>
                <div class="trust-label">Total Volume</div>
            </div>
            <div>
                <div class="trust-num">183K</div>
                <div class="trust-label">Active Traders</div>
            </div>
            <div>
                <div class="trust-num">78.3%</div>
                <div class="trust-label">Bot Win Rate</div>
            </div>
            <div>
                <div class="trust-num">+31%</div>
                <div class="trust-label">Avg Annual Return</div>
            </div>
        </div>
    </div>

    <div class="hero-right">
        <div class="stat-grid">
            <div class="stat-cell">
                <div class="stat-cell-label">BTC / USD</div>
                <div class="stat-cell-value" id="hBTC">$67,842</div>
                <div class="stat-cell-change ch-up">&uarr; +2.34% today</div>
            </div>
            <div class="stat-cell">
                <div class="stat-cell-label">ETH / USD</div>
                <div class="stat-cell-value" id="hETH">$3,441</div>
                <div class="stat-cell-change ch-up">&uarr; +1.12% today</div>
            </div>
            <div class="stat-cell">
                <div class="stat-cell-label">24h Platform Volume</div>
                <div class="stat-cell-value">$4.2B</div>
                <div class="stat-cell-change ch-up">&uarr; +12.4% vs yesterday</div>
            </div>
            <div class="stat-cell">
                <div class="stat-cell-label">Open Positions</div>
                <div class="stat-cell-value">284K</div>
                <div class="stat-cell-change ch-up">&uarr; +3,200 this week</div>
            </div>
        </div>

        <div class="chart-card">
            <div class="chart-card-header">
                <div>
                    <div class="chart-card-title">BTC / USD &mdash; 1H Chart</div>
                    <div class="chart-price-big" id="heroPriceDisplay">$67,842</div>
                </div>
                <span class="chg-badge badge-up">+2.34%</span>
            </div>
            <canvas id="heroChart" style="max-height:170px;"></canvas>
        </div>
    </div>
</section>

{{-- ═══════════════ MARQUEE ═══════════════ --}}
<div class="marquee-strip">
    <div class="marquee-inner" id="marqueeInner"></div>
</div>

{{-- ═══════════════ ABOUT ═══════════════ --}}
<section id="about">
    <div class="sw">
        <div class="about-layout">
            <div class="about-nums">
                <div class="about-num-cell">
                    <div class="anc-value">$48B+</div>
                    <div class="anc-label">Total trading volume since 2018</div>
                </div>
                <div class="about-num-cell">
                    <div class="anc-value">183K</div>
                    <div class="anc-label">Verified active traders in 94 countries</div>
                </div>
                <div class="about-num-cell">
                    <div class="anc-value">0.1ms</div>
                    <div class="anc-label">Average order execution latency</div>
                </div>
                <div class="about-num-cell">
                    <div class="anc-value">99.98%</div>
                    <div class="anc-label">Platform uptime over 36 months</div>
                </div>
                <div class="about-num-cell">
                    <div class="anc-value">340+</div>
                    <div class="anc-label">Trading pairs across all asset classes</div>
                </div>
                <div class="about-num-cell">
                    <div class="anc-value">FSA</div>
                    <div class="anc-label">Fully licensed. Institutional-grade custody</div>
                </div>
            </div>

            <div class="about-text">
                <div>
                    <div class="sec-label">About Oasisxmarket</div>
                    <h2 class="sec-title">BUILT FOR<br>SERIOUS <em>TRADERS</em></h2>
                </div>
                <p class="about-body">
                    Founded in 2018, Oasisxmarket was engineered to give retail investors access to the same
                    infrastructure used by <strong>hedge funds and proprietary trading desks</strong>.
                    We don't believe in gatekeeping alpha.
                </p>
                <p class="about-body">
                    Our platform combines <strong>low-latency execution engines</strong>, quantitative trading bots,
                    a curated copy-trading network, and institutional lending &mdash; built for speed, power, and
                    clarity.
                </p>
                <div class="pill-row">
                    <span class="pill">FSA Regulated</span>
                    <span class="pill">Cold Storage</span>
                    <span class="pill">2FA Security</span>
                    <span class="pill">24/7 SOC</span>
                    <span class="pill">SSL Encrypted</span>
                </div>
                <a href="{{ url('/register') }}" class="cta-primary" style="width:fit-content;">Open Free Account
                    &rarr;</a>
            </div>
        </div>
    </div>
</section>

{{-- ═══════════════ SERVICES ═══════════════ --}}
<section id="services">
    <div class="sw">
        <div class="services-header">
            <div>
                <div class="sec-label">What We Offer</div>
                <h2 class="sec-title">OUR CORE <em>SERVICES</em></h2>
            </div>
            <p style="font-size:.9rem;color:var(--g3);max-width:36ch;line-height:1.8;text-align:right;">
                Four powerful pillars engineered to maximise your capital's potential &mdash; from manual trading to
                fully autonomous strategies.
            </p>
        </div>

        <div class="services-grid">
            <div class="svc-card">
                <div class="svc-icon">📈</div>
                <div class="svc-num">01</div>
                <div class="svc-title">LIVE TRADING</div>
                <p class="svc-desc">
                    Execute trades across 340+ pairs with institutional-grade order types, advanced charting,
                    and real-time depth of market &mdash; built for speed and full control.
                </p>
                <ul class="svc-features">
                    <li><span class="dot"></span>Spot, Margin &amp; Futures</li>
                    <li><span class="dot"></span>OCO &amp; trailing stop orders</li>
                    <li><span class="dot"></span>Real-time TradingView charts</li>
                    <li><span class="dot"></span>0.1% maker / 0.15% taker fees</li>
                    <li><span class="dot"></span>Up to 100&times; leverage on futures</li>
                </ul>
            </div>

            <div class="svc-card">
                <div class="svc-icon">🤖</div>
                <div class="svc-num">02</div>
                <div class="svc-title">BOT TRADING</div>
                <p class="svc-desc">
                    Deploy AI-powered bots that trade 24/7. Our engine processes market signals in microseconds &mdash;
                    executing your strategy without emotion or delay.
                </p>
                <ul class="svc-features">
                    <li><span class="dot"></span>Grid, DCA &amp; momentum bots</li>
                    <li><span class="dot"></span>5-year backtesting engine</li>
                    <li><span class="dot"></span>No-code strategy builder</li>
                    <li><span class="dot"></span>Real-time performance dashboard</li>
                    <li><span class="dot"></span>Automated risk stop controls</li>
                </ul>
            </div>

            <div class="svc-card">
                <div class="svc-icon">👥</div>
                <div class="svc-num">03</div>
                <div class="svc-title">COPY TRADING</div>
                <p class="svc-desc">
                    Automatically replicate trades from 500+ verified top-performing traders. Set allocation limits,
                    risk parameters, and let proven strategies work for you.
                </p>
                <ul class="svc-features">
                    <li><span class="dot"></span>500+ vetted signal providers</li>
                    <li><span class="dot"></span>Full transparency on track records</li>
                    <li><span class="dot"></span>Proportional trade copying</li>
                    <li><span class="dot"></span>Max drawdown protection</li>
                    <li><span class="dot"></span>Start with as little as $100</li>
                </ul>
            </div>

            <div class="svc-card">
                <div class="svc-icon">🏦</div>
                <div class="svc-num">04</div>
                <div class="svc-title">CAPITAL LOANS</div>
                <p class="svc-desc">
                    Access flexible capital through our lending network. Collateralize your crypto assets for
                    immediate liquidity &mdash; without selling your positions.
                </p>
                <ul class="svc-features">
                    <li><span class="dot"></span>Rates from 4.9% APR</li>
                    <li><span class="dot"></span>LTV ratios up to 70%</li>
                    <li><span class="dot"></span>Instant approval process</li>
                    <li><span class="dot"></span>No credit score required</li>
                    <li><span class="dot"></span>Flexible repayment terms</li>
                </ul>
            </div>
        </div>
    </div>
</section>

{{-- ═══════════════ PERFORMANCE ═══════════════ --}}
<section id="performance">
    <div class="sw">
        <div class="sec-label">Proven Results</div>
        <h2 class="sec-title" style="margin-bottom:3rem;">PLATFORM <em>PERFORMANCE</em></h2>

        <div class="perf-layout">
            <div class="perf-chart-card">
                <div class="perf-chart-header">
                    <div>
                        <div
                            style="font-size:.72rem;font-weight:700;letter-spacing:.15em;text-transform:uppercase;color:var(--g4);margin-bottom:.3rem;">
                            Portfolio Growth Index &mdash; 12 Months
                        </div>
                        <div
                            style="font-family:'Bebas Neue',sans-serif;font-size:2.5rem;color:var(--white);line-height:1;">
                            +127.4% <span style="font-size:1rem;color:var(--green);">&uarr;</span>
                        </div>
                    </div>
                    <div class="perf-legend">
                        <div class="legend-item">
                            <div class="legend-dot" style="background:var(--white);"></div> Oasisxmarket Portfolio
                        </div>
                        <div class="legend-item">
                            <div class="legend-dot" style="background:var(--g6);"></div> Market Index
                        </div>
                    </div>
                </div>
                <canvas id="perfChart" style="max-height:220px;"></canvas>
            </div>

            <div class="perf-stats-list">
                <div class="perf-row">
                    <div>
                        <div class="perf-row-name">Bot Average Return</div>
                        <div class="perf-row-desc">All active bots, 90-day period</div>
                    </div>
                    <div class="perf-row-num">+31%</div>
                </div>
                <div class="perf-row">
                    <div>
                        <div class="perf-row-name">Copy Traders ROI</div>
                        <div class="perf-row-desc">Top 10 providers, annual average</div>
                    </div>
                    <div class="perf-row-num">+89%</div>
                </div>
                <div class="perf-row">
                    <div>
                        <div class="perf-row-name">Sharpe Ratio</div>
                        <div class="perf-row-desc">Risk-adjusted return metric</div>
                    </div>
                    <div class="perf-row-num">2.14</div>
                </div>
                <div class="perf-row">
                    <div>
                        <div class="perf-row-name">Max Drawdown</div>
                        <div class="perf-row-desc">Worst peak-to-trough decline</div>
                    </div>
                    <div class="perf-row-num" style="color:var(--red);">&minus;8.3%</div>
                </div>
                <div class="perf-row">
                    <div>
                        <div class="perf-row-name">Win Rate</div>
                        <div class="perf-row-desc">Profitable closed positions</div>
                    </div>
                    <div class="perf-row-num">78.3%</div>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- ═══════════════ DASHBOARD ═══════════════ --}}
<section id="dashboard">
    <div class="sw">
        <div class="sec-label">Platform Preview</div>
        <h2 class="sec-title" style="margin-bottom:2.5rem;">LIVE <em>DASHBOARD</em></h2>

        <div class="dash-grid">
            <div class="dash-panel">
                <div class="dash-panel-head">
                    <div class="dash-panel-title">BTC / USD &middot; 1H</div>
                    <div class="live-badge">LIVE</div>
                </div>
                <canvas id="dashChart" style="max-height:200px;"></canvas>
                <div class="ohlcv-row">
                    <div class="ohlcv-cell">
                        <div class="ohlcv-label">OPEN</div>
                        <div class="ohlcv-val">66,120</div>
                    </div>
                    <div class="ohlcv-cell">
                        <div class="ohlcv-label">HIGH</div>
                        <div class="ohlcv-val">68,440</div>
                    </div>
                    <div class="ohlcv-cell">
                        <div class="ohlcv-label">LOW</div>
                        <div class="ohlcv-val">65,880</div>
                    </div>
                    <div class="ohlcv-cell">
                        <div class="ohlcv-label">VOLUME</div>
                        <div class="ohlcv-val">$4.2B</div>
                    </div>
                </div>
            </div>

            <div class="dash-panel">
                <div class="dash-panel-head">
                    <div class="dash-panel-title">Order Book</div>
                    <div class="live-badge">LIVE</div>
                </div>
                <div id="orderBook">
                    <div class="ob-row hdr"><span>PRICE</span><span>SIZE BTC</span><span>TOTAL</span></div>
                </div>
            </div>

            <div class="dash-panel">
                <div class="dash-panel-head">
                    <div class="dash-panel-title">Watchlist</div>
                </div>
                <div class="asset-row">
                    <div>
                        <div class="asset-sym">BTC</div>
                        <div class="asset-name">Bitcoin</div>
                    </div>
                    <div class="asset-price" id="wBTC">$67,842</div>
                    <div class="asset-chg chg-up">+2.34%</div>
                </div>
                <div class="asset-row">
                    <div>
                        <div class="asset-sym">ETH</div>
                        <div class="asset-name">Ethereum</div>
                    </div>
                    <div class="asset-price" id="wETH">$3,441</div>
                    <div class="asset-chg chg-up">+1.12%</div>
                </div>
                <div class="asset-row">
                    <div>
                        <div class="asset-sym">SOL</div>
                        <div class="asset-name">Solana</div>
                    </div>
                    <div class="asset-price" id="wSOL">$172.4</div>
                    <div class="asset-chg chg-down">&minus;0.84%</div>
                </div>
                <div class="asset-row">
                    <div>
                        <div class="asset-sym">BNB</div>
                        <div class="asset-name">BNB Chain</div>
                    </div>
                    <div class="asset-price" id="wBNB">$412.2</div>
                    <div class="asset-chg chg-up">+0.73%</div>
                </div>
                <div class="asset-row">
                    <div>
                        <div class="asset-sym">EUR/USD</div>
                        <div class="asset-name">Forex</div>
                    </div>
                    <div class="asset-price">$1.0821</div>
                    <div class="asset-chg chg-down">&minus;0.12%</div>
                </div>
                <div class="asset-row">
                    <div>
                        <div class="asset-sym">GOLD</div>
                        <div class="asset-name">Commodity</div>
                    </div>
                    <div class="asset-price">$2,341</div>
                    <div class="asset-chg chg-up">+0.44%</div>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- ═══════════════ BOTS ═══════════════ --}}
<section id="bots">
    <div class="sw">
        <div class="bots-section-head">
            <div>
                <div class="sec-label">Automated Strategies</div>
                <h2 class="sec-title">TRADING <em>BOTS</em></h2>
            </div>
            <p style="font-size:.88rem;color:var(--g3);max-width:36ch;line-height:1.8;">
                AI-driven bots that trade 24/7 &mdash; no coding required. Choose your risk profile and let the machine
                work for you.
            </p>
        </div>

        <div class="bots-grid">
            <div class="bot-card">
                <div class="bot-badge">Conservative</div>
                <div class="bot-name">GRID BOT</div>
                <p class="bot-desc">
                    Places buy and sell orders at preset price intervals. Profits systematically from sideways
                    market volatility with low risk exposure and steady returns.
                </p>
                <div class="bot-stats-grid">
                    <div>
                        <div class="bsg-label">Win Rate</div>
                        <div class="bsg-val">71%</div>
                    </div>
                    <div>
                        <div class="bsg-label">Avg Return</div>
                        <div class="bsg-val">+18%</div>
                    </div>
                    <div>
                        <div class="bsg-label">Max DD</div>
                        <div class="bsg-val">&minus;6%</div>
                    </div>
                    <div>
                        <div class="bsg-label">Active Users</div>
                        <div class="bsg-val">42K</div>
                    </div>
                </div>
                <div class="bot-bar-wrap">
                    <div class="bot-bar-fill" style="width:71%"></div>
                </div>
                <button class="btn-deploy" onclick="location.href='{{ url('/register') }}'">Deploy Bot &rarr;</button>
            </div>

            <div class="bot-card featured">
                <div class="bot-badge">⭐ Most Popular</div>
                <div class="bot-name">MOMENTUM AI</div>
                <p class="bot-desc">
                    Our flagship AI bot uses machine learning to detect momentum signals, trend reversals,
                    and breakout patterns in real time across any market condition.
                </p>
                <div class="bot-stats-grid">
                    <div>
                        <div class="bsg-label">Win Rate</div>
                        <div class="bsg-val">78%</div>
                    </div>
                    <div>
                        <div class="bsg-label">Avg Return</div>
                        <div class="bsg-val">+31%</div>
                    </div>
                    <div>
                        <div class="bsg-label">Max DD</div>
                        <div class="bsg-val">&minus;8%</div>
                    </div>
                    <div>
                        <div class="bsg-label">Active Users</div>
                        <div class="bsg-val">87K</div>
                    </div>
                </div>
                <div class="bot-bar-wrap">
                    <div class="bot-bar-fill" style="width:78%"></div>
                </div>
                <button class="btn-deploy" onclick="location.href='{{ url('/register') }}'">Deploy Bot &rarr;</button>
            </div>

            <div class="bot-card">
                <div class="bot-badge">Aggressive</div>
                <div class="bot-name">DCA PRO</div>
                <p class="bot-desc">
                    Dollar-cost averaging bot that systematically buys on RSI dips and scales positions
                    with precision &mdash; maximising long-term accumulation strategies.
                </p>
                <div class="bot-stats-grid">
                    <div>
                        <div class="bsg-label">Win Rate</div>
                        <div class="bsg-val">84%</div>
                    </div>
                    <div>
                        <div class="bsg-label">Avg Return</div>
                        <div class="bsg-val">+44%</div>
                    </div>
                    <div>
                        <div class="bsg-label">Max DD</div>
                        <div class="bsg-val">&minus;14%</div>
                    </div>
                    <div>
                        <div class="bsg-label">Active Users</div>
                        <div class="bsg-val">31K</div>
                    </div>
                </div>
                <div class="bot-bar-wrap">
                    <div class="bot-bar-fill" style="width:84%"></div>
                </div>
                <button class="btn-deploy" onclick="location.href='{{ url('/register') }}'">Deploy Bot &rarr;</button>
            </div>
        </div>
    </div>
</section>

{{-- ═══════════════ LOANS ═══════════════ --}}
<section id="loans">
    <div class="sw">
        <div class="sec-label">Capital Solutions</div>
        <h2 class="sec-title" style="margin-bottom:.5rem;">CRYPTO <em>LOANS</em></h2>
        <p class="body-text" style="max-width:52ch;margin-bottom:0;">
            Unlock liquidity from your crypto holdings without selling. Instant approvals, competitive rates, and
            flexible terms.
        </p>

        <div class="loans-grid">
            <div class="loan-card">
                <div class="loan-type">Instant Loan</div>
                <div><span class="loan-rate">4.9</span><span class="loan-rate-unit">%</span></div>
                <div class="loan-rate-label">APR &middot; Starting rate</div>
                <div class="loan-range">$500 &rarr; $50,000</div>
                <ul class="loan-features">
                    <li><span class="check">◆</span>Instant approval, no credit check</li>
                    <li><span class="check">◆</span>BTC, ETH, SOL as collateral</li>
                    <li><span class="check">◆</span>LTV up to 50%</li>
                    <li><span class="check">◆</span>30 to 365 day terms</li>
                    <li><span class="check">◆</span>Repay anytime, no penalty</li>
                </ul>
                <button class="btn-apply" onclick="location.href='{{ url('/register') }}'">Apply Now &rarr;</button>
            </div>

            <div class="loan-card featured">
                <div class="loan-type">Flex Credit Line</div>
                <div><span class="loan-rate">6.9</span><span class="loan-rate-unit">%</span></div>
                <div class="loan-rate-label">APR &middot; Revolving credit line</div>
                <div class="loan-range">Up to $500,000</div>
                <ul class="loan-features">
                    <li><span class="check">◆</span>Draw and repay flexibly</li>
                    <li><span class="check">◆</span>Multi-asset collateral basket</li>
                    <li><span class="check">◆</span>LTV up to 65%</li>
                    <li><span class="check">◆</span>Dedicated account manager</li>
                    <li><span class="check">◆</span>Priority processing</li>
                </ul>
                <button class="btn-apply" onclick="location.href='{{ url('/register') }}'">Apply Now &rarr;</button>
            </div>

            <div class="loan-card">
                <div class="loan-type">Institutional</div>
                <div><span class="loan-rate">2.9</span><span class="loan-rate-unit">%</span></div>
                <div class="loan-rate-label">APR &middot; Custom structured facilities</div>
                <div class="loan-range">$500,000+</div>
                <ul class="loan-features">
                    <li><span class="check">◆</span>Bespoke facility structure</li>
                    <li><span class="check">◆</span>OTC desk support</li>
                    <li><span class="check">◆</span>LTV up to 70%</li>
                    <li><span class="check">◆</span>Multi-currency settlement</li>
                    <li><span class="check">◆</span>White-glove onboarding</li>
                </ul>
                <button class="btn-apply" onclick="location.href='{{ url('/register') }}'">Contact Us &rarr;</button>
            </div>
        </div>
    </div>
</section>

{{-- ═══════════════ CONTACT ═══════════════ --}}
<section id="contact">
    <div class="sw">
        <div class="contact-layout">
            <div>
                <div class="sec-label">Get In Touch</div>
                <h2 class="sec-title" style="margin-bottom:1.5rem;">LET'S <em>TALK</em></h2>
                <p class="contact-body">
                    Whether you're opening your first trading account or managing institutional capital,
                    our team is available 24/7 to help you get started or answer any questions.
                </p>
                <div class="contact-links">
                    <div class="contact-link-item">
                        <span>support@Oasisxmarket.space</span>
                        <span class="arrow">&rarr;</span>
                    </div>
                    <div class="contact-link-item">
                        <span>Live Chat &mdash; Available 24/7</span>
                        <span class="arrow">&rarr;</span>
                    </div>
                    <div class="contact-link-item">
                        <span>350 Fifth Avenue, New York, NY 10118</span>
                        <span class="arrow">&rarr;</span>
                    </div>
                </div>
            </div>

            <div class="form-card">
                <div class="form-card-title">Send a Message</div>
                <div class="form-card-sub">We typically respond within 2 hours during business hours.</div>

                <div class="form-group">
                    <label class="form-label">Full Name</label>
                    <input class="form-input" type="text" placeholder="John Smith">
                </div>
                <div class="form-group">
                    <label class="form-label">Email Address</label>
                    <input class="form-input" type="email" placeholder="john@example.com">
                </div>
                <div class="form-group">
                    <label class="form-label">Subject</label>
                    <select class="form-select">
                        <option>Account Inquiry</option>
                        <option>Trading Support</option>
                        <option>Bot Setup Help</option>
                        <option>Loan Application</option>
                        <option>Copy Trading</option>
                        <option>Institutional Services</option>
                        <option>Technical Issue</option>
                    </select>
                </div>
                <div class="form-group">
                    <label class="form-label">Message</label>
                    <textarea class="form-textarea" placeholder="Tell us how we can help you..."></textarea>
                </div>

                <button class="btn-send" id="sendBtn" onclick="handleSend()">Send Message</button>
            </div>
        </div>
    </div>
</section>

@endsection

@push('scripts')
<script>
    /* ── MARQUEE ── */
    const WORDS = ['TRADING','BOT AUTOMATION','COPY TRADING','CAPITAL LOANS','SPOT MARKETS','FUTURES','OPTIONS','DeFi','FOREX','CRYPTO'];
    const mi = document.getElementById('marqueeInner');
    if (mi) {
        let mhtml = '';
        for (let r = 0; r < 2; r++) {
            WORDS.forEach((w, i) => {
                mhtml += `<span class="marquee-word${i % 3 === 0 ? ' lit' : ''}">${w}</span>`;
            });
        }
        mi.innerHTML = mhtml;
    }

    /* ── CHART HELPERS ── */
    const COPT = {
        responsive: true,
        maintainAspectRatio: false,
        plugins: { legend: { display: false }, tooltip: { enabled: false } },
        scales: { x: { display: false }, y: { display: false } },
        elements: { point: { radius: 0 }, line: { tension: .4 } },
        animation: { duration: 0 }
    };

    function genLine(n, base, vol, trend = 1) {
        let d = [base], v = base;
        for (let i = 1; i < n; i++) {
            v = v + (Math.random() - .45) * vol + trend * .3;
            d.push(Math.max(0, +v.toFixed(2)));
        }
        return d;
    }

    function mkGrad(ctx, h, r, g, b) {
        const gr = ctx.createLinearGradient(0, 0, 0, h);
        gr.addColorStop(0, `rgba(${r},${g},${b},.15)`);
        gr.addColorStop(1, `rgba(${r},${g},${b},0)`);
        return gr;
    }

    /* ── HERO CHART ── */
    const hCtx = document.getElementById('heroChart');
    if (hCtx) {
        new Chart(hCtx, {
            type: 'line',
            data: {
                labels: Array(60).fill(''),
                datasets: [{
                    data: genLine(60, 62000, 700, 1.2),
                    borderColor: '#F8F6F1', borderWidth: 2, fill: true,
                    backgroundColor: (c) => mkGrad(c.chart.ctx, 160, 248, 246, 241)
                }]
            },
            options: { ...COPT }
        });
    }

    /* ── PERFORMANCE CHART ── */
    const pCtx = document.getElementById('perfChart');
    if (pCtx) {
        const months = ['Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec'];
        new Chart(pCtx, {
            type: 'line',
            data: {
                labels: months,
                datasets: [
                    {
                        data: [100, 109, 104, 117, 124, 119, 133, 142, 137, 155, 163, 177],
                        borderColor: '#F8F6F1', borderWidth: 2, fill: true,
                        backgroundColor: (c) => mkGrad(c.chart.ctx, 200, 248, 246, 241),
                        tension: .4, pointRadius: 3,
                        pointBackgroundColor: '#F8F6F1', pointBorderColor: '#050505'
                    },
                    {
                        data: [100, 97, 99, 105, 102, 108, 110, 107, 112, 109, 115, 118],
                        borderColor: '#3D3D3D', borderWidth: 1.5, fill: false, tension: .4, pointRadius: 0
                    }
                ]
            },
            options: {
                ...COPT,
                scales: {
                    x: { display: true, ticks: { color: '#555', font: { family: "'Outfit'", size: 10 } }, grid: { color: '#1C1C1C' } },
                    y: { display: true, ticks: { color: '#555', font: { family: "'Outfit'", size: 10 }, callback: v => v + '%' }, grid: { color: '#1C1C1C' } }
                }
            }
        });
    }

    /* ── DASHBOARD CHART ── */
    const dCtx = document.getElementById('dashChart');
    if (dCtx) {
        new Chart(dCtx, {
            type: 'line',
            data: {
                labels: Array(80).fill(''),
                datasets: [{
                    data: genLine(80, 65000, 500, 1.1),
                    borderColor: '#F8F6F1', borderWidth: 1.5, fill: true,
                    backgroundColor: (c) => mkGrad(c.chart.ctx, 200, 248, 246, 241)
                }]
            },
            options: { ...COPT }
        });
    }

    /* ── ORDER BOOK ── */
    function buildOB() {
        const ob = document.getElementById('orderBook');
        if (!ob) return;
        const base = 67842;
        let h = '<div class="ob-row hdr"><span>PRICE</span><span>SIZE BTC</span><span>TOTAL</span></div>';
        for (let i = 8; i >= 1; i--) {
            const p = (base + i * 14).toLocaleString();
            const s = (Math.random() * 2 + .1).toFixed(3);
            h += `<div class="ob-row"><span class="ask-p">${p}</span><span style="color:var(--g3)">${s}</span><span style="color:var(--g4)">$${Math.round(parseFloat(s) * (base + i * 14)).toLocaleString()}</span></div>`;
        }
        h += `<div class="ob-mid">67,842 ▲</div>`;
        for (let i = 1; i <= 8; i++) {
            const p = (base - i * 14).toLocaleString();
            const s = (Math.random() * 2 + .1).toFixed(3);
            h += `<div class="ob-row"><span class="bid-p">${p}</span><span style="color:var(--g3)">${s}</span><span style="color:var(--g4)">$${Math.round(parseFloat(s) * (base - i * 14)).toLocaleString()}</span></div>`;
        }
        ob.innerHTML = h;
    }
    buildOB();
    setInterval(buildOB, 2500);

    /* ── LIVE PRICE UPDATES ── */
    setInterval(() => {
        const b = 67842 * (1 + (Math.random() - .5) * .002);
        const e = 3441  * (1 + (Math.random() - .5) * .002);
        const s = 172.4 * (1 + (Math.random() - .5) * .003);
        const n = 412.2 * (1 + (Math.random() - .5) * .002);

        ['hBTC', 'wBTC', 'heroPriceDisplay'].forEach(id => {
            const el = document.getElementById(id);
            if (el) el.textContent = '$' + Math.round(b).toLocaleString();
        });
        ['hETH', 'wETH'].forEach(id => {
            const el = document.getElementById(id);
            if (el) el.textContent = '$' + Math.round(e).toLocaleString();
        });
        const ws = document.getElementById('wSOL');
        if (ws) ws.textContent = '$' + s.toFixed(1);
        const wb = document.getElementById('wBNB');
        if (wb) wb.textContent = '$' + n.toFixed(1);
    }, 2000);

    /* ── CONTACT FORM ── */
    function handleSend() {
        const btn = document.getElementById('sendBtn');
        btn.textContent = 'Sending...';
        btn.style.pointerEvents = 'none';
        btn.style.opacity = '.7';
        setTimeout(() => {
            btn.textContent = '✓ Message Sent!';
            btn.style.background = 'var(--g7)';
            btn.style.color = 'var(--white)';
            btn.style.opacity = '1';
            setTimeout(() => {
                btn.textContent = 'Send Message';
                btn.style.background = '';
                btn.style.color = '';
                btn.style.pointerEvents = '';
            }, 3000);
        }, 1400);
    }
</script>
@endpush