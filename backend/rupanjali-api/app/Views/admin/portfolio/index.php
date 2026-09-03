<?= view('admin/layout/header', [
    'title' => 'Portfolio | Rupanjali'
]) ?>

<?= view('admin/layout/sidebar') ?>

<main class="flex-1 min-w-0 bg-[#faf7f5] min-h-screen">
    <div class="p-5 sm:p-6 lg:p-8 xl:p-10">
        <div class="max-w-[1500px] mx-auto">

            <div class="flex flex-col lg:flex-row lg:items-end lg:justify-between gap-5 mb-8">
                <div>
                    <div class="flex items-center gap-3 mb-3">
                        <span class="w-10 h-px bg-[#c65d72]"></span>
                        <span class="text-[10px] uppercase tracking-[0.3em] text-[#c65d72] font-semibold">
                            Portfolio Management
                        </span>
                    </div>

                    <h1 class="font-serif text-4xl sm:text-5xl text-[#292322]">
                        Your Portfolio
                    </h1>

                    <p class="mt-3 text-sm sm:text-base text-[#817673]">
                        Manage the makeup looks displayed on your public website.
                    </p>
                </div>

                <a
                    href="<?= base_url('admin/portfolio/create') ?>"
                    class="inline-flex items-center justify-center gap-2 rounded-xl bg-[#292322] px-6 py-3.5 text-sm font-semibold text-white hover:bg-[#3b3331] transition"
                >
                    <span class="text-lg leading-none">+</span>
                    Add Portfolio Item
                </a>
            </div>

            <?php if (session()->getFlashdata('success')): ?>
                <div class="mb-6 rounded-2xl border border-green-200 bg-green-50 px-5 py-4 text-sm text-green-700">
                    <?= esc(session()->getFlashdata('success')) ?>
                </div>
            <?php endif; ?>

            <?php if (session()->getFlashdata('error')): ?>
                <div class="mb-6 rounded-2xl border border-red-200 bg-red-50 px-5 py-4 text-sm text-red-700">
                    <?= esc(session()->getFlashdata('error')) ?>
                </div>
            <?php endif; ?>

            <div class="rounded-2xl border border-[#eadfe0] bg-white shadow-sm mb-7">
                <form method="GET" action="<?= base_url('admin/portfolio') ?>" class="p-4 sm:p-5">
                    <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-[1fr_220px_180px_auto] gap-3">

                        <input
                            type="search"
                            name="search"
                            value="<?= esc($search ?? '') ?>"
                            placeholder="Search portfolio..."
                            class="w-full rounded-xl border border-[#ded3d5] bg-[#fffdfc] px-4 py-3 text-sm text-[#332b2d] outline-none focus:border-[#a56b76] focus:ring-2 focus:ring-[#a56b76]/10"
                        >

                        <select
                            name="category"
                            class="w-full rounded-xl border border-[#ded3d5] bg-[#fffdfc] px-4 py-3 text-sm text-[#332b2d] outline-none focus:border-[#a56b76]"
                        >
                            <option value="">All Categories</option>

                            <?php foreach (($categories ?? []) as $item): ?>
                                <?php if (!empty($item['category'])): ?>
                                    <option
                                        value="<?= esc($item['category']) ?>"
                                        <?= (($category ?? '') === $item['category']) ? 'selected' : '' ?>
                                    >
                                        <?= esc($item['category']) ?>
                                    </option>
                                <?php endif; ?>
                            <?php endforeach; ?>
                        </select>

                        <select
                            name="status"
                            class="w-full rounded-xl border border-[#ded3d5] bg-[#fffdfc] px-4 py-3 text-sm text-[#332b2d] outline-none focus:border-[#a56b76]"
                        >
                            <option value="">All Status</option>
                            <option value="active" <?= (($status ?? '') === 'active') ? 'selected' : '' ?>>
                                Active
                            </option>
                            <option value="inactive" <?= (($status ?? '') === 'inactive') ? 'selected' : '' ?>>
                                Inactive
                            </option>
                        </select>

                        <div class="flex gap-2">
                            <button
                                type="submit"
                                class="flex-1 rounded-xl bg-[#4b3a3d] px-5 py-3 text-sm font-semibold text-white hover:bg-[#382c2f] transition"
                            >
                                Search
                            </button>

                            <?php if (!empty($search) || !empty($category) || !empty($status)): ?>
                                <a
                                    href="<?= base_url('admin/portfolio') ?>"
                                    class="inline-flex items-center justify-center rounded-xl border border-[#ded3d5] px-4 py-3 text-sm text-[#655b5d] hover:bg-[#faf6f3]"
                                >
                                    ×
                                </a>
                            <?php endif; ?>
                        </div>
                    </div>
                </form>
            </div>

            <?php if (empty($portfolio)): ?>

                <div class="rounded-3xl border border-[#eadfe0] bg-white px-6 py-16 text-center shadow-sm">
                    <div class="mx-auto h-16 w-16 rounded-full bg-[#f5e9eb] flex items-center justify-center">
                        <span class="font-serif text-2xl text-[#a56b76]">R</span>
                    </div>

                    <h2 class="mt-6 font-serif text-2xl text-[#292322]">
                        No portfolio items found
                    </h2>

                    <p class="mt-2 text-sm text-[#817673]">
                        Add your first makeup look to display it on the website.
                    </p>

                    <a
                        href="<?= base_url('admin/portfolio/create') ?>"
                        class="inline-flex mt-6 rounded-xl bg-[#292322] px-5 py-3 text-sm font-semibold text-white"
                    >
                        Add Portfolio Item
                    </a>
                </div>

            <?php else: ?>

                <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-3 gap-6">
                    <?php foreach ($portfolio as $item): ?>

                        <?php
                            $image = $item['image'] ?? '';
                            $imageUrl = str_starts_with($image, 'http')
                                ? $image
                                : base_url('uploads/portfolio/' . $image);
                        ?>

                        <article class="overflow-hidden rounded-3xl border border-[#eadfe0] bg-white shadow-sm">
                            <div class="aspect-[4/5] bg-[#f5efec] overflow-hidden">
                                <img
                                    src="<?= esc($imageUrl) ?>"
                                    alt="<?= esc($item['title']) ?>"
                                    class="w-full h-full object-cover"
                                >
                            </div>

                            <div class="p-5">
                                <div class="flex items-start justify-between gap-3">
                                    <div>
                                        <p class="text-[10px] uppercase tracking-[0.2em] text-[#a56b76]">
                                            <?= esc($item['category']) ?>
                                        </p>

                                        <h2 class="mt-2 font-serif text-2xl text-[#292322]">
                                            <?= esc($item['title']) ?>
                                        </h2>
                                    </div>

                                    <span class="rounded-full px-3 py-1 text-xs font-medium <?= $item['status'] === 'active'
                                        ? 'bg-green-50 text-green-700'
                                        : 'bg-gray-100 text-gray-500' ?>">
                                        <?= esc(ucfirst($item['status'])) ?>
                                    </span>
                                </div>

                                <p class="mt-3 text-xs text-[#817673]">
                                    Display order: <?= esc($item['sort_order']) ?>
                                </p>

                                <div class="mt-5 flex gap-2">
                                    <a
                                        href="<?= base_url('admin/portfolio/edit/' . $item['id']) ?>"
                                        class="flex-1 rounded-xl border border-[#ded3d5] px-4 py-2.5 text-center text-sm font-medium text-[#655b5d] hover:bg-[#faf6f3]"
                                    >
                                        Edit
                                    </a>

                                    <a
                                        href="<?= base_url('admin/portfolio/delete/' . $item['id']) ?>"
                                        onclick="return confirm('Delete this portfolio item?')"
                                        class="rounded-xl bg-red-50 px-4 py-2.5 text-sm font-medium text-red-600 hover:bg-red-100"
                                    >
                                        Delete
                                    </a>
                                </div>
                            </div>
                        </article>

                    <?php endforeach; ?>
                </div>

                <?php if (isset($pager)): ?>
                    <div class="mt-8">
                        <?= $pager->links() ?>
                    </div>
                <?php endif; ?>

            <?php endif; ?>

        </div>
    </div>
</main>
