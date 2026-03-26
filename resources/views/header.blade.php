<header class="site-header" role="banner">
    <div class="site-header__inner">
        <a href="{{ url('/') }}" class="site-header__logo" aria-label="KSB homes - Home">
            <img src="{{ asset('assets/images/ksb_logo.svg') }}" alt="KSB homes" width="120" height="32" class="site-header__logo-img">
        </a>
        <button type="button" class="site-header__menu-btn" id="menu-toggle" aria-label="Open menu" aria-expanded="false">
            Menu
        </button>
    </div>
</header>

{{-- Full-screen overlay menu --}}
<div class="nav-overlay" id="nav-overlay" aria-hidden="true">
    <div class="nav-overlay__inner">
        <div class="nav-overlay__top">
            <a href="{{ url('/') }}" class="nav-overlay__logo">
                <img src="{{ asset('assets/images/ksb_logo.svg') }}" alt="KSB homes" width="120" height="32">
            </a>
            <button type="button" class="nav-overlay__close" id="menu-close" aria-label="Close menu">
                Close
            </button>
        </div>
        <nav class="nav-overlay__nav" aria-label="Main navigation">
            <ul class="nav-overlay__list">
                <li><a href="{{ url('/') }}">Home</a></li>
                <li><a href="{{ route('our-story') }}">Our Story</a></li>
                <li><a href="{{ url('/projects') }}">Projects</a></li>
                <!-- <li><a href="{{ url('/developments') }}">Developments</a></li> -->
                <!-- <li><a href="{{ url('/ksb-circle') }}">KSB Circle</a></li> -->
                <!-- <li><a href="{{ url('/awards') }}">Awards</a></li> -->
                <!-- <li><a href="{{ url('/careers') }}">Careers</a></li> -->
                <!-- <li><a href="{{ url('/media') }}">Media</a></li> -->
                <li><a href="{{ url('/contact') }}">Contact</a></li>
            </ul>
        </nav>
        <div class="nav-overlay__bottom" aria-hidden="true"></div>
    </div>
</div>
