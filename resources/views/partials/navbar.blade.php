{{-- Navigation Bar --}}
<nav>
    <div class="nav-inner">
        <a href="{{ url('/') }}" class="nav-logo">
            Oasisxmarket
        </a>

        <ul class="nav-links">
            <li><a href="{{ url('/') }}#hero">Home</a></li>
            <li><a href="{{ url('/') }}#about">About</a></li>
            <li><a href="{{ url('/') }}#services">Services</a></li>
            <li><a href="{{ url('/') }}#dashboard">Platform</a></li>
            <li><a href="{{ url('/') }}#bots">Bots</a></li>
            <li><a href="{{ url('/') }}#contact">Contact</a></li>
        </ul>

        <div class="nav-actions">
            <a href="{{ url('/login') }}" class="btn-outline">Sign In</a>
            <a href="{{ url('/register') }}" class="btn-solid">Open Account</a>
        </div>

        <button class="hamburger" id="hamburger" aria-label="Open menu">
            <span></span><span></span><span></span>
        </button>
    </div>
</nav>

{{-- Mobile Menu --}}
<div class="mobile-menu" id="mobileMenu">
    <a href="{{ url('/') }}#hero" onclick="closeMob()">Home</a>
    <a href="{{ url('/') }}#about" onclick="closeMob()">About</a>
    <a href="{{ url('/') }}#services" onclick="closeMob()">Services</a>
    <a href="{{ url('/') }}#dashboard" onclick="closeMob()">Platform</a>
    <a href="{{ url('/') }}#bots" onclick="closeMob()">Bots</a>
    <a href="{{ url('/') }}#contact" onclick="closeMob()">Contact</a>
    <div class="mob-btns">
        <a href="{{ url('/login') }}" class="btn-outline">Sign In</a>
        <a href="{{ url('/register') }}" class="btn-solid">Open Account</a>
    </div>
</div>