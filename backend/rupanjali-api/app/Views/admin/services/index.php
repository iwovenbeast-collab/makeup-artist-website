<?= view('admin/layout/header', ['title' => 'Services | Rupanjali']) ?>
<?= view('admin/layout/sidebar') ?>

<main class="admin-main">
    <div class="admin-page-header">
        <div>
            <p class="admin-eyebrow">Content management</p>
            <h1>Services</h1>
            <p class="admin-muted">
                Manage the makeup services displayed on the public website.
            </p>
        </div>

        <a href="<?= base_url('admin/services/create') ?>" class="admin-button">
            + Add Service
        </a>
    </div>

    <?php if (session()->getFlashdata('success')): ?>
        <div class="admin-alert admin-alert-success">
            <?= esc(session()->getFlashdata('success')) ?>
        </div>
    <?php endif; ?>

    <?php if (session()->getFlashdata('error')): ?>
        <div class="admin-alert admin-alert-error">
            <?= esc(session()->getFlashdata('error')) ?>
        </div>
    <?php endif; ?>

    <form method="get" action="<?= base_url('admin/services') ?>" class="admin-filter-bar">
        <input
            type="text"
            name="search"
            value="<?= esc($search ?? '') ?>"
            placeholder="Search services..."
            class="admin-input"
        >

        <select name="status" class="admin-input">
            <option value="">All statuses</option>
            <option value="active" <?= ($status ?? '') === 'active' ? 'selected' : '' ?>>
                Active
            </option>
            <option value="inactive" <?= ($status ?? '') === 'inactive' ? 'selected' : '' ?>>
                Inactive
            </option>
        </select>

        <button type="submit" class="admin-button admin-button-secondary">
            Filter
        </button>

        <a href="<?= base_url('admin/services') ?>" class="admin-button admin-button-light">
            Reset
        </a>
    </form>

    <section class="admin-card">
        <div class="admin-card-header">
            <div>
                <h2>All services</h2>
                <p class="admin-muted">
                    <?= count($services ?? []) ?> service(s) found
                </p>
            </div>
        </div>

        <?php if (empty($services)): ?>
            <div class="admin-empty-state">
                <h3>No services found</h3>
                <p>Create your first service to display it on the website.</p>

                <a href="<?= base_url('admin/services/create') ?>" class="admin-button">
                    Add Service
                </a>
            </div>
        <?php else: ?>
            <div class="admin-table-wrapper">
                <table class="admin-table">
                    <thead>
                        <tr>
                            <th>Order</th>
                            <th>Service</th>
                            <th>Subtitle</th>
                            <th>Duration</th>
                            <th>Price</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>

                    <tbody>
                        <?php foreach ($services as $service): ?>
                            <tr>
                                <td><?= esc($service['sort_order'] ?? 0) ?></td>

                                <td>
                                    <strong><?= esc($service['title']) ?></strong>

                                    <?php
                                        $serviceIncludes = $service['includes'] ?? [];

                                        if (is_string($serviceIncludes)) {
                                            $decodedIncludes = json_decode($serviceIncludes, true);
                                            $serviceIncludes = is_array($decodedIncludes)
                                                ? $decodedIncludes
                                                : [];
                                        }

                                        if (!is_array($serviceIncludes)) {
                                            $serviceIncludes = [];
                                        }
                                    ?>

                                    <?php if (!empty($serviceIncludes)): ?>
                                        <ul class="admin-mini-list">
                                            <?php foreach ($serviceIncludes as $include): ?>
                                                <li><?= esc($include) ?></li>
                                            <?php endforeach; ?>
                                        </ul>
                                    <?php endif; ?>
                                </td>

                                <td><?= esc($service['subtitle'] ?? '') ?></td>

                                <td><?= esc($service['duration'] ?? '') ?></td>

                                <td><?= esc($service['price'] ?? '') ?></td>

                                <td>
                                    <?php if (($service['status'] ?? '') === 'active'): ?>
                                        <span class="admin-status admin-status-active">
                                            Active
                                        </span>
                                    <?php else: ?>
                                        <span class="admin-status admin-status-inactive">
                                            Inactive
                                        </span>
                                    <?php endif; ?>
                                </td>

                                <td>
                                    <div class="admin-actions">
                                        <a
                                            href="<?= base_url('admin/services/edit/' . $service['id']) ?>"
                                            class="admin-action-link"
                                        >
                                            Edit
                                        </a>

                                        <a
                                            href="<?= base_url('admin/services/delete/' . $service['id']) ?>"
                                            class="admin-action-link admin-action-danger"
                                            onclick="return confirm('Are you sure you want to delete this service?')"
                                        >
                                            Delete
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php endif; ?>
    </section>
</main>

<?= view('admin/layout/footer') ?>
