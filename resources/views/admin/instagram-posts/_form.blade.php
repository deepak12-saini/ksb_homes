<div class="admin-card">
    <div class="admin-card__head">
        <div>
            <h2>{{ isset($post) ? 'Edit post' : 'Add Instagram post' }}</h2>
            <p class="admin-muted" style="margin: 0.2rem 0 0;">Upload the image you want shown on the home page and link it to the live Instagram post.</p>
        </div>
    </div>

    <form method="post" action="{{ $formAction }}" enctype="multipart/form-data" class="admin-form">
        @csrf
        @if ($formMethod !== 'POST')
            @method($formMethod)
        @endif

        <div class="form-group">
            <label for="caption">Caption</label>
            <textarea id="caption" name="caption" maxlength="500" placeholder="Optional short caption shown for accessibility and previews.">{{ old('caption', $post->caption ?? '') }}</textarea>
        </div>

        <div class="form-group">
            <label for="instagram_url">Instagram post link</label>
            <input type="url" id="instagram_url" name="instagram_url" value="{{ old('instagram_url', $post->instagram_url ?? 'https://www.instagram.com/p/') }}" required>
        </div>

        <div class="form-group">
            <label for="image">Post image{{ isset($post) ? ' (leave empty to keep current image)' : '' }}</label>
            <input type="file" id="image" name="image" accept="image/*" {{ isset($post) ? '' : 'required' }}>
            @if (isset($post) && !empty($post->image))
                <div class="admin-thumb-preview">
                    <img src="{{ $post->imageUrl() }}" alt="Current Instagram post image preview">
                </div>
            @endif
        </div>

        <div class="form-group">
            <label for="published_at">Published date</label>
            <input
                type="text"
                id="published_at"
                name="published_at"
                value="{{ old('published_at', isset($post) && $post->published_at ? $post->published_at->format('Y-m-d H:i:s') : '') }}"
                placeholder="YYYY-MM-DD HH:MM:SS (optional)"
            >
        </div>

        <div class="form-group">
            <label for="sort_order">Display order</label>
            <input type="number" id="sort_order" name="sort_order" min="0" value="{{ old('sort_order', $post->sort_order ?? 0) }}">
        </div>

        <div class="form-group">
            <label>
                <input type="hidden" name="is_active" value="0">
                <input type="checkbox" name="is_active" value="1" {{ old('is_active', isset($post) ? $post->is_active : true) ? 'checked' : '' }}>
                Show this post on the website
            </label>
        </div>

        <button type="submit" class="admin-btn">{{ $submitLabel }}</button>
        <a href="{{ route('admin.instagram-posts.index') }}" class="admin-btn admin-btn--secondary">Back</a>
    </form>
</div>
