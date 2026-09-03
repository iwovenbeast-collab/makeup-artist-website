<?= view('admin/layout/header', ['title' => 'Edit Service | Rupanjali']) ?>
<?= view('admin/layout/sidebar') ?>

<main class="admin-main">
    <div class="admin-page-header">
        <div>
            <p class="admin-eyebrow">Content management</p>
            <h1>Edit Service</h1>
            <p class="admin-muted">
                Update the selected service.
            </p>
        </div>

        <a href="<?= base_url('admin/services') ?>" class="admin-button admin-button-light">
            Back to Services
        </a>
    </div>

    <?php if (session()->getFlashdata('error')): ?>
        <div class="admin-alert admin-alert-error">
            <?= esc(session()->getFlashdata('error')) ?>
        </div>
    <?php endif; ?>

    <?php if (session()->getFlashdata('errors')): ?>
        <div class="admin-alert admin-alert-error">
            <ul>
                <?php foreach (session()->getFlashdata('errors') as $error): ?>
                    <li><?= esc($error) ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>

    <?php
        $includesText = '';

        if (!empty($service['includes']) && is_array($service['includes'])) {
            $includesText = implode("\n", $service['includes']);
        }
    ?>

    <section class="admin-card">
        <form
            method="post"
            action="<?= base_url('admin/services/update/' . $service['id']) ?>"
            class="admin-form"
        >
            <?= csrf_field() ?>

            <div class="admin-form-grid">
                <div class="admin-form-group">
                    <label for="title">Service title *</label>
                    <input
                        id="title"
                        type="text"
                        name="title"
                        value="<?= esc(old('title', $service['title'] ?? '')) ?>"
                        class="admin-input"
                        required
                    >
                </div>

                <div class="admin-form-group">
                    <label for="subtitle">Subtitle</label>
                    <input
                        id="subtitle"
                        type="text"
                        name="subtitle"
                        value="<?= esc(old('subtitle', $service['subtitle'] ?? '')) ?>"
                        class="admin-input"
                    >
                </div>

                <div class="admin-form-group admin-form-group-full">
                    <label for="description">Description</label>
                    <textarea
                        id="description"
                        name="description"
                        rows="5"
                        class="admin-input"
                    ><?= esc(old('description', $service['description'] ?? '')) ?></textarea>
                </div>

                <div class="admin-form-group admin-form-group-full">
                    <label for="includes">
                        Includes
                        <span class="admin-help-text">
                            Add one item per line
                        </span>
                    </label>

                    <textarea
                        id="includes"
                        name="includes"
                        rows="6"
                        class="admin-input"
                    ><?= esc(old('includes', $includesText)) ?></textarea>
                </div>

                <div class="admin-form-group">
                    <label for="duration">Duration</label>
                    <input
                        id="duration"
                        type="text"
                        name="duration"
                        value="<?= esc(old('duration', $service['duration'] ?? '')) ?>"
                        class="admin-input"
                    >
                </div>

                <div class="admin-form-group">
                    <label for="price">Price</label>
                    <input
                        id="price"
                        type="text"
                        name="price"
                        value="<?= esc(old('price', $service['price'] ?? '')) ?>"
                        class="admin-input"
                    >
                </div>

                <div class="admin-form-group">
                    <label for="icon">Icon name</label>
                    <input
                        id="icon"
                        type="text"
                        name="icon"
                        value="<?= esc(old('icon', $service['icon'] ?? '')) ?>"
                        class="admin-input"
                    >
                    <small class="admin-help-text">
                        Suggested values: crown, heart, sparkles, camera
                    </small>
                </div>

                <div class="admin-form-group">
                    <label for="sort_order">Display order</label>
                    <input
                        id="sort_order"
                        type="number"
                        name="sort_order"
                        value="<?= esc(old('sort_order', $service['sort_order'] ?? 0)) ?>"
                        class="admin-input"
                        min="0"
                    >
                </div>

                <div class="admin-form-group">
                    <label for="status">Status</label>
                    <select id="status" name="status" class="admin-input">
                        <option value="active" <?= old('status', $service['status'] ?? 'active') === 'active' ? 'selected' : '' ?>>
                            Active
                        </option>
                        <option value="inactive" <?= old('status', $service['status'] ?? '') === 'inactive' ? 'selected' : '' ?>>
                            Inactive
                        </option>
                    </select>
                </div>
            </div>

            <div class="admin-form-actions">
                <a href="<?= base_url('admin/services') ?>" class="admin-button admin-button-light">
                    Cancel
                </a>

                <button type="submit" class="admin-button">
                    Update Service
                </button>
            </div>
        </form>
    </section>
</main>

<?= view('admin/layout/footer') ?>
