<?= view('admin/layout/header', ['title' => 'Add Service | Rupanjali']) ?>
<?= view('admin/layout/sidebar') ?>

<main class="admin-main">
    <div class="admin-page-header">
        <div>
            <p class="admin-eyebrow">Content management</p>
            <h1>Add Service</h1>
            <p class="admin-muted">
                Create a new service for the public website.
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

    <section class="admin-card">
        <form
            method="post"
            action="<?= base_url('admin/services/store') ?>"
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
                        value="<?= esc(old('title')) ?>"
                        class="admin-input"
                        placeholder="For example: Bridal Makeup"
                        required
                    >
                </div>

                <div class="admin-form-group">
                    <label for="subtitle">Subtitle</label>
                    <input
                        id="subtitle"
                        type="text"
                        name="subtitle"
                        value="<?= esc(old('subtitle')) ?>"
                        class="admin-input"
                        placeholder="For example: Your perfect wedding look"
                    >
                </div>

                <div class="admin-form-group admin-form-group-full">
                    <label for="description">Description</label>
                    <textarea
                        id="description"
                        name="description"
                        rows="5"
                        class="admin-input"
                        placeholder="Describe this service..."
                    ><?= esc(old('description')) ?></textarea>
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
                        placeholder="Skin preparation&#10;HD makeup&#10;Hairstyling&#10;Draping"
                    ><?= esc(old('includes')) ?></textarea>
                </div>

                <div class="admin-form-group">
                    <label for="duration">Duration</label>
                    <input
                        id="duration"
                        type="text"
                        name="duration"
                        value="<?= esc(old('duration')) ?>"
                        class="admin-input"
                        placeholder="For example: 2–3 hours"
                    >
                </div>

                <div class="admin-form-group">
                    <label for="price">Price</label>
                    <input
                        id="price"
                        type="text"
                        name="price"
                        value="<?= esc(old('price')) ?>"
                        class="admin-input"
                        placeholder="For example: Starting at ₹15,000"
                    >
                </div>

                <div class="admin-form-group">
                    <label for="icon">Icon name</label>
                    <input
                        id="icon"
                        type="text"
                        name="icon"
                        value="<?= esc(old('icon')) ?>"
                        class="admin-input"
                        placeholder="For example: crown"
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
                        value="<?= esc(old('sort_order', 0)) ?>"
                        class="admin-input"
                        min="0"
                    >
                </div>

                <div class="admin-form-group">
                    <label for="status">Status</label>
                    <select id="status" name="status" class="admin-input">
                        <option value="active" <?= old('status', 'active') === 'active' ? 'selected' : '' ?>>
                            Active
                        </option>
                        <option value="inactive" <?= old('status') === 'inactive' ? 'selected' : '' ?>>
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
                    Save Service
                </button>
            </div>
        </form>
    </section>
</main>

<?= view('admin/layout/footer') ?>
