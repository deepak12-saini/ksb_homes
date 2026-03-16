<footer class="site-footer" role="contentinfo">
    <div class="site-footer__inner">
        {{-- Contact section --}}
        <div class="site-footer__contact">
            <h3 class="site-footer__heading">Contact</h3>
            <p class="site-footer__text">If you would like to contact KSB homes about our services and product please don't hesitate to reach out.</p>
            <a href="{{ url('/contact') }}" class="btn btn--footer">Enquire Now</a>
          

        {{-- Mailing list / Newsletter --}}
        <div class="site-footer__mailing">
            <p class="site-footer__text">Join our mailing list to be the first to hear about our latest projects</p>
            @if (session('newsletter_success'))
                <p class="site-footer__message site-footer__message--success">{{ session('newsletter_success') }}</p>
            @endif
            @if (session('newsletter_info'))
                <p class="site-footer__message site-footer__message--info">{{ session('newsletter_info') }}</p>
            @endif
            @if ($errors->has('email'))
                <p class="site-footer__message site-footer__message--error">{{ $errors->first('email') }}</p>
            @endif
            <form class="site-footer__form" action="{{ route('newsletter.store') }}" method="post">
                @csrf
                <input type="email" name="email" placeholder="Email Address" class="site-footer__input" value="{{ old('email') }}" required aria-label="Email address">
                <button type="submit" class="btn btn--footer">Submit</button>
            </form>
        </div>

        {{-- Office, Social, Brand --}}
        <div class="site-footer__bottom">
            <div class="site-footer__col site-footer__col--office">
                <h3 class="site-footer__heading">Office</h3>
                <p class="site-footer__address">Austriala</p>
            </div>
            <div class="site-footer__col site-footer__col--social">
                <h3 class="site-footer__heading">Social</h3>
                <ul class="site-footer__social-list">
                    <li><a href="#" target="_blank" rel="noopener">Instagram</a></li>
                    <li><a href="#" target="_blank" rel="noopener">Facebook</a></li>
                    <li><a href="#" target="_blank" rel="noopener">Linkedin</a></li>
                </ul>
            </div>
            <div class="site-footer__col site-footer__col--access">
                <p class="site-footer__access">Ksb™ Exclusive Access</p>
            </div>
        </div>
    </div>
</footer>
