@php
    $active = $activeTab ?? 'home';
@endphp
<div style="display:flex; gap:0.5rem; flex-wrap:wrap; border-bottom:1px solid #e2e8f0; margin-bottom:1rem; padding-bottom:0.75rem;">
    <a href="{{ route('admin.page-content.home.edit') }}" class="admin-btn{{ $active === 'home' ? '' : ' admin-btn--secondary' }}">Home</a>
    <a href="{{ route('admin.page-content.our-story.edit') }}" class="admin-btn{{ $active === 'our-story' ? '' : ' admin-btn--secondary' }}">Our Story</a>
    <a href="{{ route('admin.page-content.contact.edit') }}" class="admin-btn{{ $active === 'contact' ? '' : ' admin-btn--secondary' }}">Contact</a>
    <span class="admin-btn admin-btn--secondary" style="opacity:0.65; cursor:not-allowed;">KSB Select (next)</span>
</div>
