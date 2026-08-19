<div class="admin-card admin-card--page-editor">
    <div class="admin-card__head">
        <div>
            <h2>{{ isset($post) ? 'Edit Instagram post' : 'Add Instagram post' }}</h2>
            <p class="admin-muted" style="margin: 0.2rem 0 0;">Paste an Instagram embed code or post URL. No image upload needed.</p>
        </div>
    </div>

    <form method="post" action="{{ $formAction }}" class="admin-form">
        @csrf
        @if ($formMethod !== 'POST')
            @method($formMethod)
        @endif

        <div class="form-group">
            <label for="embed_input">Paste Instagram embed code or post URL *</label>
            <textarea
                id="embed_input"
                name="embed_input"
                rows="8"
                placeholder="Paste embed code from Instagram (⋯ → Embed) or a URL like https://www.instagram.com/p/ABC123/"
                {{ isset($post) ? '' : 'required' }}
            >{{ old('embed_input', isset($post) ? $post->adminInputValue() : '') }}</textarea>
            <p class="admin-muted" style="margin: 0.45rem 0 0;">
                On Instagram: open a post → ⋯ → Embed → copy code. Works for photos, reels, and videos.
                @if (isset($post))
                    Leave blank on edit to keep the current permalink.
                @endif
            </p>
        </div>

        <div class="form-group">
            <label for="sort_order">Display order (lower = first)</label>
            <input type="number" id="sort_order" name="sort_order" min="0" value="{{ old('sort_order', $post->sort_order ?? 0) }}">
        </div>

        <div class="form-group">
            <label for="admin_note">Admin note (optional)</label>
            <input type="text" id="admin_note" name="admin_note" maxlength="255" placeholder="e.g. March product launch reel" value="{{ old('admin_note', $post->admin_note ?? '') }}">
        </div>

        <div class="form-group">
            <label>
                <input type="hidden" name="is_active" value="0">
                <input type="checkbox" name="is_active" value="1" {{ old('is_active', isset($post) ? $post->is_active : true) ? 'checked' : '' }}>
                Active (show on home page)
            </label>
        </div>

        <button type="submit" class="admin-btn">{{ $submitLabel }}</button>
        @if (isset($post))
            <button
                type="submit"
                formaction="{{ route('admin.instagram-posts.refresh-thumbnail', $post) }}"
                formmethod="post"
                class="admin-btn admin-btn--secondary"
            >
                Refresh thumbnail
            </button>
        @endif
        <a href="{{ route('admin.instagram-posts.index') }}" class="admin-btn admin-btn--secondary">Cancel</a>
    </form>
</div>
