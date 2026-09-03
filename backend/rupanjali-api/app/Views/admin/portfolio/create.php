<?= view('admin/layout/header', [
    'title' => 'Add Portfolio Item | Rupanjali'
]) ?>

<?= view('admin/layout/sidebar') ?>

<main class="flex-1 min-w-0 bg-[#faf7f5] min-h-screen">

    <div class="p-5 sm:p-6 lg:p-8 xl:p-10">

        <div class="max-w-4xl mx-auto">

            <div class="mb-8">

                <a
                    href="<?= base_url('admin/portfolio') ?>"
                    class="inline-flex items-center gap-2 text-sm text-[#817673] hover:text-[#292322] transition mb-5"
                >
                    ← Back to Portfolio
                </a>

                <div class="flex items-center gap-3 mb-3">
                    <span class="w-10 h-px bg-[#c65d72]"></span>

                    <span class="text-[10px] uppercase tracking-[0.3em] text-[#c65d72] font-semibold">
                        Portfolio Management
                    </span>
                </div>

                <h1 class="font-serif text-4xl sm:text-5xl text-[#292322]">
                    Add New Portfolio Item
                </h1>

                <p class="mt-3 text-sm sm:text-base text-[#817673]">
                    Add a new makeup look to your public portfolio gallery.
                </p>

            </div>

            <?php if (session()->getFlashdata('error')): ?>
                <div class="mb-6 rounded-2xl border border-red-200 bg-red-50 px-5 py-4 text-sm text-red-700">
                    <?= esc(session()->getFlashdata('error')) ?>
                </div>
            <?php endif; ?>

            <div class="rounded-3xl border border-[#eadfe0] bg-white shadow-sm">

                <form
                    action="<?= base_url('admin/portfolio/store') ?>"
                    method="POST"
                    enctype="multipart/form-data"
                    class="p-5 sm:p-7 lg:p-8"
                >

                    <?= csrf_field() ?>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                        <div class="md:col-span-2">

                            <label
                                for="title"
                                class="block text-sm font-semibold text-[#4d4542] mb-2"
                            >
                                Portfolio Title
                            </label>

                            <input
                                id="title"
                                type="text"
                                name="title"
                                value="<?= esc(old('title')) ?>"
                                placeholder="Example: Classic Bridal Look"
                                required
                                class="w-full rounded-xl border border-[#ded3d5] bg-[#fffdfc] px-4 py-3 text-sm text-[#332b2d] outline-none transition focus:border-[#a56b76] focus:ring-2 focus:ring-[#a56b76]/10"
                            >

                        </div>

                        <div>

                            <label
                                for="category"
                                class="block text-sm font-semibold text-[#4d4542] mb-2"
                            >
                                Category
                            </label>

                            <select
                                id="category"
                                name="category"
                                required
                                class="w-full rounded-xl border border-[#ded3d5] bg-[#fffdfc] px-4 py-3 text-sm text-[#332b2d] outline-none transition focus:border-[#a56b76] focus:ring-2 focus:ring-[#a56b76]/10"
                            >
                                <option value="">Select category</option>
                                <option value="Bridal" <?= old('category') === 'Bridal' ? 'selected' : '' ?>>
                                    Bridal
                                </option>
                                <option value="Engagement" <?= old('category') === 'Engagement' ? 'selected' : '' ?>>
                                    Engagement
                                </option>
                                <option value="Party" <?= old('category') === 'Party' ? 'selected' : '' ?>>
                                    Party
                                </option>
                                <option value="Editorial" <?= old('category') === 'Editorial' ? 'selected' : '' ?>>
                                    Editorial
                                </option>
                            </select>

                        </div>

                        <div>

                            <label
                                for="sort_order"
                                class="block text-sm font-semibold text-[#4d4542] mb-2"
                            >
                                Display Order
                            </label>

                            <input
                                id="sort_order"
                                type="number"
                                name="sort_order"
                                value="<?= esc(old('sort_order', 0)) ?>"
                                min="0"
                                placeholder="0"
                                class="w-full rounded-xl border border-[#ded3d5] bg-[#fffdfc] px-4 py-3 text-sm text-[#332b2d] outline-none transition focus:border-[#a56b76] focus:ring-2 focus:ring-[#a56b76]/10"
                            >

                            <p class="mt-2 text-xs text-[#9b908b]">
                                Lower numbers appear first.
                            </p>

                        </div>

                        <div>

                            <label
                                for="status"
                                class="block text-sm font-semibold text-[#4d4542] mb-2"
                            >
                                Status
                            </label>

                            <select
                                id="status"
                                name="status"
                                required
                                class="w-full rounded-xl border border-[#ded3d5] bg-[#fffdfc] px-4 py-3 text-sm text-[#332b2d] outline-none transition focus:border-[#a56b76] focus:ring-2 focus:ring-[#a56b76]/10"
                            >
                                <option value="active" <?= old('status', 'active') === 'active' ? 'selected' : '' ?>>
                                    Active — Show publicly
                                </option>

                                <option value="inactive" <?= old('status') === 'inactive' ? 'selected' : '' ?>>
                                    Inactive — Hide publicly
                                </option>
                            </select>

                        </div>

                        <div class="md:col-span-2">

                            <label
                                for="image"
                                class="block text-sm font-semibold text-[#4d4542] mb-2"
                            >
                                Portfolio Image
                            </label>

                            <input
                                id="image"
                                type="file"
                                name="image"
                                accept="image/jpeg,image/png,image/webp,image/jpg"
                                required
                                class="block w-full rounded-xl border border-[#ded3d5] bg-[#fffdfc] px-4 py-3 text-sm text-[#332b2d] file:mr-4 file:rounded-lg file:border-0 file:bg-[#f5e9eb] file:px-4 file:py-2 file:text-sm file:font-semibold file:text-[#8d5362] hover:file:bg-[#f1dfe3]"
                            >

                            <p class="mt-2 text-xs text-[#9b908b]">
                                Recommended: portrait or square makeup image. JPG, PNG, or WebP.
                            </p>

                        </div>

                    </div>

                    <div class="mt-8 flex flex-col-reverse sm:flex-row sm:justify-end gap-3">

                        <a
                            href="<?= base_url('admin/portfolio') ?>"
                            class="inline-flex items-center justify-center rounded-xl border border-[#ded3d5] bg-white px-6 py-3 text-sm font-semibold text-[#655b5d] hover:bg-[#faf6f3] transition"
                        >
                            Cancel
                        </a>

                        <button
                            type="submit"
                            class="inline-flex items-center justify-center rounded-xl bg-[#292322] px-6 py-3 text-sm font-semibold text-white hover:bg-[#3b3331] transition"
                        >
                            Save Portfolio Item
                        </button>

                    </div>

                </form>

            </div>

        </div>

    </div>

</main>

<?= view('admin/layout/footer') ?>
