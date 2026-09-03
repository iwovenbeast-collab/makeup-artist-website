<?= view('admin/layout/header', [
    'title' => 'Edit Portfolio Item | Rupanjali'
]) ?>

<?= view('admin/layout/sidebar') ?>

<main class="flex-1 min-w-0 bg-[#faf7f5] min-h-screen">
    <div class="p-5 sm:p-6 lg:p-8 xl:p-10">
        <div class="max-w-3xl mx-auto">

            <div class="mb-8">
                <a
                    href="<?= base_url('admin/portfolio') ?>"
                    class="text-sm text-[#a56b76] hover:text-[#7f4655]"
                >
                    ← Back to Portfolio
                </a>

                <h1 class="mt-4 font-serif text-4xl text-[#292322]">
                    Edit Portfolio Item
                </h1>
            </div>

            <?php if (session()->getFlashdata('error')): ?>
                <div class="mb-6 rounded-2xl border border-red-200 bg-red-50 px-5 py-4 text-sm text-red-700">
                    <?= esc(session()->getFlashdata('error')) ?>
                </div>
            <?php endif; ?>

            <?php
                $image = $item['image'] ?? '';
                $imageUrl = str_starts_with($image, 'http')
                    ? $image
                    : base_url('uploads/portfolio/' . $image);
            ?>

            <form
                method="POST"
                action="<?= base_url('admin/portfolio/update/' . $item['id']) ?>"
                enctype="multipart/form-data"
                class="rounded-3xl border border-[#eadfe0] bg-white p-6 sm:p-8 shadow-sm space-y-6"
            >
                <?= csrf_field() ?>

                <div>
                    <label class="block text-sm font-medium text-[#4d4542] mb-2">
                        Title
                    </label>

                    <input
                        type="text"
                        name="title"
                        value="<?= esc(old('title', $item['title'])) ?>"
                        required
                        class="w-full rounded-xl border border-[#ded3d5] px-4 py-3 text-sm outline-none focus:border-[#a56b76]"
                    >
                </div>

                <div>
                    <label class="block text-sm font-medium text-[#4d4542] mb-2">
                        Category
                    </label>

                    <input
                        type="text"
                        name="category"
                        value="<?= esc(old('category', $item['category'])) ?>"
                        required
                        class="w-full rounded-xl border border-[#ded3d5] px-4 py-3 text-sm outline-none focus:border-[#a56b76]"
                    >
                </div>

                <div>
                    <label class="block text-sm font-medium text-[#4d4542] mb-2">
                        Current image
                    </label>

                    <img
                        src="<?= esc($imageUrl) ?>"
                        alt="<?= esc($item['title']) ?>"
                        class="w-48 aspect-[4/5] object-cover rounded-2xl border border-[#eadfe0]"
                    >
                </div>

                <div>
                    <label class="block text-sm font-medium text-[#4d4542] mb-2">
                        Replace image
                    </label>

                    <input
                        type="file"
                        name="image"
                        accept="image/*"
                        class="w-full rounded-xl border border-[#ded3d5] bg-white px-4 py-3 text-sm"
                    >
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                    <div>
                        <label class="block text-sm font-medium text-[#4d4542] mb-2">
                            Display order
                        </label>

                        <input
                            type="number"
                            name="sort_order"
                            value="<?= esc(old('sort_order', $item['sort_order'])) ?>"
                            min="0"
                            class="w-full rounded-xl border border-[#ded3d5] px-4 py-3 text-sm outline-none focus:border-[#a56b76]"
                        >
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-[#4d4542] mb-2">
                            Status
                        </label>

                        <select
                            name="status"
                            class="w-full rounded-xl border border-[#ded3d5] px-4 py-3 text-sm outline-none focus:border-[#a56b76]"
                        >
                            <option value="active" <?= $item['status'] === 'active' ? 'selected' : '' ?>>
                                Active
                            </option>
                            <option value="inactive" <?= $item['status'] === 'inactive' ? 'selected' : '' ?>>
                                Inactive
                            </option>
                        </select>
                    </div>
                </div>

                <div class="flex flex-col sm:flex-row gap-3 pt-3">
                    <a
                        href="<?= base_url('admin/portfolio') ?>"
                        class="flex-1 rounded-xl border border-[#ded3d5] px-5 py-3 text-center text-sm font-semibold text-[#655b5d] hover:bg-[#faf6f3]"
                    >
                        Cancel
                    </a>

                    <button
                        type="submit"
                        class="flex-1 rounded-xl bg-[#292322] px-5 py-3 text-sm font-semibold text-white hover:bg-[#3b3331]"
                    >
                        Update Portfolio Item
                    </button>
                </div>
            </form>

        </div>
    </div>
</main>
