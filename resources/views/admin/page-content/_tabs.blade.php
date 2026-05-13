@php
    $active = $activeTab ?? 'home';
@endphp
<nav class="admin-page-tabs" aria-label="Which page to edit">
    <a href="{{ route('admin.page-content.home.edit') }}" class="admin-pill-tab{{ $active === 'home' ? ' admin-pill-tab--active' : '' }}">Home</a>
    <a href="{{ route('admin.page-content.our-story.edit') }}" class="admin-pill-tab{{ $active === 'our-story' ? ' admin-pill-tab--active' : '' }}">Our Story</a>
    <a href="{{ route('admin.page-content.contact.edit') }}" class="admin-pill-tab{{ $active === 'contact' ? ' admin-pill-tab--active' : '' }}">Contact</a>
</nav>
