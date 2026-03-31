{{-- Footer --}}
<footer>
    <div class="risk-warning">
        ⚠ <strong>Risk Warning:</strong> Trading and investing involve substantial risk of loss and are not suitable for
        all investors.
        Past performance does not guarantee future results. Capital loans are subject to approval and terms.
        Oasisxmarket is authorised and regulated by the FSA (Reg. No. 284441).
    </div>
    <div class="footer-inner">
        <div>
            <div class="footer-brand-logo">Oasisxmarket</div>
            <p class="footer-tagline">Institutional-grade trading infrastructure for the modern investor. Regulated,
                secure, and built for performance.</p>
            <div class="footer-socials">
                <button class="soc-btn">𝕏</button>
                <button class="soc-btn">in</button>
                <button class="soc-btn">tg</button>
                <button class="soc-btn">yt</button>
            </div>
        </div>
        <div>
            <div class="footer-col-title">Platform</div>
            <ul class="footer-links">
                <li><a href="{{ url('/register') }}">Live Trading</a></li>
                <li><a href="{{ url('/register') }}">Bot Automation</a></li>
                <li><a href="{{ url('/register') }}">Copy Trading</a></li>
                <li><a href="{{ url('/register') }}">Capital Loans</a></li>
                <li><a href="{{ url('/register') }}">API Access</a></li>
                <li><a href="{{ url('/register') }}">Mobile App</a></li>
            </ul>
        </div>
        <div>
            <div class="footer-col-title">Company</div>
            <ul class="footer-links">
                <li><a href="{{ url('/') }}#about">About Us</a></li>
                <li><a href="#">Careers</a></li>
                <li><a href="#">Press Kit</a></li>
                <li><a href="#">Blog</a></li>
                <li><a href="#">Security</a></li>
                <li><a href="#">Compliance</a></li>
            </ul>
        </div>
        <div>
            <div class="footer-col-title">Legal</div>
            <ul class="footer-links">
                <li><a href="#">Terms of Service</a></li>
                <li><a href="#">Privacy Policy</a></li>
                <li><a href="#">Risk Disclosure</a></li>
                <li><a href="#">AML Policy</a></li>
                <li><a href="#">Cookie Policy</a></li>
                <li><a href="#">GDPR</a></li>
            </ul>
        </div>
    </div>
    <div class="footer-bottom">
        <p>&copy; {{ date('Y') }} Oasisxmarket. All rights reserved. FSA Reg. No. 284441</p>
        <p>New York &middot; London &middot; Singapore &middot; Dubai</p>
    </div>
</footer>