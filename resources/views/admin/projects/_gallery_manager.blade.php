@php
    $existingImages = $existingImages ?? collect();
    $showExisting = $existingImages->isNotEmpty();
@endphp

<div class="form-group admin-gallery" data-gallery-manager>
    <label>Project renders</label>
    <p class="admin-muted" style="margin:0 0 0.85rem;">
        Drag images here or click to upload. Drag cards to reorder. They stack below the main image on the public detail page (max 5MB each).
    </p>

    <div class="admin-dropzone" data-gallery-dropzone tabindex="0" role="button" aria-label="Upload project renders">
        <input type="file" name="gallery_images[]" id="gallery_images" accept="image/*" multiple class="admin-dropzone__input" data-gallery-input>
        <div class="admin-dropzone__content">
            <span class="admin-dropzone__icon" aria-hidden="true">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M12 16V5"/><path d="m8 8 4-4 4 4"/><path d="M4 16v2a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2v-2"/></svg>
            </span>
            <strong>Drop renders here</strong>
            <span>or click to browse · JPG, PNG, WEBP</span>
        </div>
    </div>

    <div class="admin-gallery-pending" data-gallery-pending hidden>
        <p class="admin-gallery-pending__label">New uploads (saved when you submit)</p>
        <div class="admin-gallery-grid admin-gallery-grid--pending" data-gallery-pending-list></div>
    </div>

    @if ($showExisting)
        <div class="admin-gallery-existing" data-gallery-existing>
            <p class="admin-gallery-pending__label">Existing renders — drag to reorder · click × to remove · then save</p>
            <div class="admin-gallery-grid" data-gallery-list>
                @foreach ($existingImages as $galleryImage)
                    <figure class="admin-gallery-item" draggable="true" data-gallery-item data-id="{{ $galleryImage->id }}">
                        <input type="hidden" name="gallery_order[]" value="{{ $galleryImage->id }}" data-gallery-order>
                        <span class="admin-gallery-item__handle" title="Drag to reorder" aria-hidden="true">
                            <svg viewBox="0 0 24 24" width="16" height="16" fill="currentColor"><circle cx="9" cy="6" r="1.5"/><circle cx="15" cy="6" r="1.5"/><circle cx="9" cy="12" r="1.5"/><circle cx="15" cy="12" r="1.5"/><circle cx="9" cy="18" r="1.5"/><circle cx="15" cy="18" r="1.5"/></svg>
                        </span>
                        <img src="{{ $galleryImage->public_url }}" alt="Render {{ $loop->iteration }}" draggable="false">
                        <button type="button" class="admin-gallery-item__delete" data-gallery-remove title="Remove render" aria-label="Remove render">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><path d="M6 6l12 12M18 6 6 18"/></svg>
                        </button>
                    </figure>
                @endforeach
            </div>
            <div data-gallery-remove-fields></div>
        </div>
    @endif
</div>

<script>
(function () {
    var roots = document.querySelectorAll('[data-gallery-manager]');
    if (!roots.length) return;

    roots.forEach(function (root) {
        if (root.dataset.galleryReady === '1') return;
        root.dataset.galleryReady = '1';

        var input = root.querySelector('[data-gallery-input]');
        var dropzone = root.querySelector('[data-gallery-dropzone]');
        var pendingWrap = root.querySelector('[data-gallery-pending]');
        var pendingList = root.querySelector('[data-gallery-pending-list]');
        var list = root.querySelector('[data-gallery-list]');
        var removeFields = root.querySelector('[data-gallery-remove-fields]');
        var pendingFiles = [];
        var dragItem = null;

        function syncInputFiles() {
            if (!input || typeof DataTransfer === 'undefined') return;
            var dt = new DataTransfer();
            pendingFiles.forEach(function (file) { dt.items.add(file); });
            input.files = dt.files;
        }

        function renderPending() {
            if (!pendingList || !pendingWrap) return;
            pendingList.innerHTML = '';
            if (!pendingFiles.length) {
                pendingWrap.hidden = true;
                return;
            }
            pendingWrap.hidden = false;
            pendingFiles.forEach(function (file, index) {
                var figure = document.createElement('figure');
                figure.className = 'admin-gallery-item admin-gallery-item--pending';
                var img = document.createElement('img');
                img.alt = file.name;
                img.src = URL.createObjectURL(file);
                var badge = document.createElement('span');
                badge.className = 'admin-gallery-item__badge';
                badge.textContent = 'New';
                var btn = document.createElement('button');
                btn.type = 'button';
                btn.className = 'admin-gallery-item__delete';
                btn.title = 'Remove upload';
                btn.setAttribute('aria-label', 'Remove upload');
                btn.innerHTML = '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><path d="M6 6l12 12M18 6 6 18"/></svg>';
                btn.addEventListener('click', function () {
                    pendingFiles.splice(index, 1);
                    syncInputFiles();
                    renderPending();
                });
                figure.appendChild(img);
                figure.appendChild(badge);
                figure.appendChild(btn);
                pendingList.appendChild(figure);
            });
        }

        function addFiles(fileList) {
            Array.prototype.forEach.call(fileList || [], function (file) {
                if (!file || !file.type || file.type.indexOf('image/') !== 0) return;
                if (file.size > 5 * 1024 * 1024) {
                    alert('“' + file.name + '” is larger than 5MB and was skipped.');
                    return;
                }
                pendingFiles.push(file);
            });
            syncInputFiles();
            renderPending();
        }

        if (input) {
            input.addEventListener('change', function () {
                addFiles(input.files);
                syncInputFiles();
            });
        }

        if (dropzone) {
            ['dragenter', 'dragover'].forEach(function (evt) {
                dropzone.addEventListener(evt, function (e) {
                    e.preventDefault();
                    e.stopPropagation();
                    dropzone.classList.add('is-dragover');
                });
            });
            ['dragleave', 'drop'].forEach(function (evt) {
                dropzone.addEventListener(evt, function (e) {
                    e.preventDefault();
                    e.stopPropagation();
                    dropzone.classList.remove('is-dragover');
                });
            });
            dropzone.addEventListener('drop', function (e) {
                if (e.dataTransfer && e.dataTransfer.files) {
                    addFiles(e.dataTransfer.files);
                }
            });
        }

        if (list) {
            list.addEventListener('click', function (e) {
                var btn = e.target.closest ? e.target.closest('[data-gallery-remove]') : null;
                if (!btn) return;
                var item = btn.closest('[data-gallery-item]');
                if (!item) return;
                var id = item.getAttribute('data-id');
                if (!id) return;
                if (!confirm('Remove this render? It will be deleted when you save the project.')) return;

                if (removeFields) {
                    var hidden = document.createElement('input');
                    hidden.type = 'hidden';
                    hidden.name = 'remove_gallery_images[]';
                    hidden.value = id;
                    removeFields.appendChild(hidden);
                }

                item.remove();
            });

            list.addEventListener('dragstart', function (e) {
                var item = e.target.closest ? e.target.closest('[data-gallery-item]') : null;
                if (!item) return;
                dragItem = item;
                item.classList.add('is-dragging');
                if (e.dataTransfer) {
                    e.dataTransfer.effectAllowed = 'move';
                    e.dataTransfer.setData('text/plain', item.getAttribute('data-id') || '');
                }
            });

            list.addEventListener('dragend', function () {
                if (dragItem) dragItem.classList.remove('is-dragging');
                list.querySelectorAll('.is-drop-target').forEach(function (el) {
                    el.classList.remove('is-drop-target');
                });
                dragItem = null;
            });

            list.addEventListener('dragover', function (e) {
                e.preventDefault();
                var target = e.target.closest ? e.target.closest('[data-gallery-item]') : null;
                if (!dragItem || !target || target === dragItem) return;
                list.querySelectorAll('.is-drop-target').forEach(function (el) {
                    el.classList.remove('is-drop-target');
                });
                target.classList.add('is-drop-target');

                var rect = target.getBoundingClientRect();
                var before = (e.clientY - rect.top) < rect.height / 2;
                if (before) {
                    list.insertBefore(dragItem, target);
                } else {
                    list.insertBefore(dragItem, target.nextSibling);
                }
            });

            list.addEventListener('drop', function (e) {
                e.preventDefault();
            });
        }
    });
})();
</script>
