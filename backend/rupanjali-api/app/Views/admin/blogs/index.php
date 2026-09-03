<?= view('admin/layout/header', [
    'title' => 'Stories | Rupanjali'
]) ?>

<?= view('admin/layout/sidebar') ?>

<main class="flex-1 min-w-0 bg-[#faf7f5] min-h-screen">

    <div class="p-5 sm:p-6 lg:p-8 xl:p-10">

        <div class="max-w-[1500px] mx-auto">

            <!-- ===================================================== -->
            <!-- HEADER -->
            <!-- ===================================================== -->

            <div class="mb-8">

                <div class="flex flex-col lg:flex-row lg:items-end lg:justify-between gap-5">

                    <div>

                        <div class="flex items-center gap-3 mb-3">

                            <span class="w-10 h-px bg-[#c65d72]"></span>

                            <span class="text-[10px] uppercase tracking-[0.3em] text-[#c65d72] font-semibold">
                                Stories & Journal
                            </span>

                        </div>

                        <h1 class="font-serif text-4xl sm:text-5xl text-[#292322]">
                            Your Stories
                        </h1>

                        <p class="mt-3 text-sm sm:text-base text-[#817673] max-w-2xl">
                            Create, edit and manage the stories that appear on your makeup artistry website.
                        </p>

                    </div>


                    <a
                        href="<?= base_url('admin/blogs/create') ?>"
                        class="inline-flex items-center justify-center gap-2 rounded-xl bg-[#292322] px-6 py-3.5 text-sm font-semibold text-white shadow-sm hover:bg-[#3b3331] transition"
                    >
                        <span class="text-lg leading-none">+</span>
                        Create Story
                    </a>

                </div>

            </div>


            <!-- ===================================================== -->
            <!-- FLASH MESSAGES -->
            <!-- ===================================================== -->

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


            <!-- ===================================================== -->
            <!-- FILTER CARD -->
            <!-- ===================================================== -->

            <div class="rounded-2xl border border-[#eadfe0] bg-white shadow-sm mb-7">

                <form
                    method="GET"
                    action="<?= base_url('admin/blogs') ?>"
                    class="p-4 sm:p-5"
                >

                    <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-[1fr_220px_180px_auto] gap-3">

                        <!-- SEARCH -->

                        <div class="relative">

                            <span class="absolute left-4 top-1/2 -translate-y-1/2 text-[#a59a96]">
                                ⌕
                            </span>

                            <input
                                type="search"
                                name="search"
                                value="<?= esc($search ?? '') ?>"
                                placeholder="Search stories..."
                                class="w-full rounded-xl border border-[#ded3d5] bg-[#fffdfc] py-3 pl-11 pr-4 text-sm text-[#332b2d] outline-none transition focus:border-[#a56b76] focus:ring-2 focus:ring-[#a56b76]/10"
                            >

                        </div>


                        <!-- CATEGORY -->

                        <select
                            name="category"
                            class="w-full rounded-xl border border-[#ded3d5] bg-[#fffdfc] px-4 py-3 text-sm text-[#332b2d] outline-none transition focus:border-[#a56b76] focus:ring-2 focus:ring-[#a56b76]/10"
                        >

                            <option value="">
                                All Categories
                            </option>

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


                        <!-- STATUS -->

                        <select
                            name="status"
                            class="w-full rounded-xl border border-[#ded3d5] bg-[#fffdfc] px-4 py-3 text-sm text-[#332b2d] outline-none transition focus:border-[#a56b76] focus:ring-2 focus:ring-[#a56b76]/10"
                        >

                            <option value="">
                                All Status
                            </option>

                            <option
                                value="published"
                                <?= (($status ?? '') === 'published') ? 'selected' : '' ?>
                            >
                                Published
                            </option>

                            <option
                                value="draft"
                                <?= (($status ?? '') === 'draft') ? 'selected' : '' ?>
                            >
                                Draft
                            </option>

                        </select>


                        <!-- BUTTONS -->

                        <div class="flex gap-2">

                            <button
                                type="submit"
                                class="flex-1 xl:flex-none rounded-xl bg-[#4b3a3d] px-5 py-3 text-sm font-semibold text-white hover:bg-[#382c2f] transition"
                            >
                                Search
                            </button>


                            <?php if (
                                !empty($search) ||
                                !empty($category) ||
                                !empty($status)
                            ): ?>

                                <a
                                    href="<?= base_url('admin/blogs') ?>"
                                    class="inline-flex items-center justify-center rounded-xl border border-[#ded3d5] bg-white px-4 py-3 text-sm font-medium text-[#655b5d] hover:bg-[#faf6f3] transition"
                                    title="Clear filters"
                                >
                                    ×
                                </a>

                            <?php endif; ?>

                        </div>

                    </div>

                </form>

            </div>


            <!-- ===================================================== -->
            <!-- RESULT INFO -->
            <!-- ===================================================== -->

            <?php
                $currentPage = $pager
                    ? $pager->getCurrentPage()
                    : 1;

                $pageCount = $pager
                    ? $pager->getPageCount()
                    : 1;
            ?>

            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-2 mb-5">

                <div>

                    <p class="text-sm text-[#817673]">

                        <?php if (!empty($search)): ?>

                            Results for
                            <span class="font-medium text-[#332b2d]">
                                "<?= esc($search) ?>"
                            </span>

                        <?php elseif (!empty($category)): ?>

                            Stories in
                            <span class="font-medium text-[#332b2d]">
                                <?= esc($category) ?>
                            </span>

                        <?php else: ?>

                            All stories

                        <?php endif; ?>

                    </p>

                </div>


                <?php if ($pageCount > 1): ?>

                    <p class="text-xs text-[#a59a96]">
                        Page <?= $currentPage ?> of <?= $pageCount ?>
                    </p>

                <?php endif; ?>

            </div>


            <!-- ===================================================== -->
            <!-- STORIES -->
            <!-- ===================================================== -->

            <?php if (empty($blogs)): ?>

                <div class="rounded-3xl border border-[#eadfe0] bg-white shadow-sm px-6 py-16 text-center">

                    <div class="mx-auto h-16 w-16 rounded-full bg-[#f5e9eb] flex items-center justify-center">

                        <span class="font-serif text-2xl text-[#a56b76]">
                            R
                        </span>

                    </div>


                    <h2 class="mt-6 font-serif text-2xl sm:text-3xl text-[#292322]">
                        No stories found
                    </h2>


                    <p class="mt-2 text-sm text-[#817673] max-w-md mx-auto">
                        <?php if (
                            !empty($search) ||
                            !empty($category) ||
                            !empty($status)
                        ): ?>

                            Try changing your filters or create a new story.

                        <?php else: ?>

                            Your journal is waiting for its first story.

                        <?php endif; ?>
                    </p>


                    <div class="mt-6 flex flex-col sm:flex-row items-center justify-center gap-3">

                        <?php if (
                            !empty($search) ||
                            !empty($category) ||
                            !empty($status)
                        ): ?>

                            <a
                                href="<?= base_url('admin/blogs') ?>"
                                class="inline-flex items-center justify-center rounded-xl border border-[#ded3d5] px-5 py-3 text-sm font-medium text-[#655b5d] hover:bg-[#faf6f3] transition"
                            >
                                Clear Filters
                            </a>

                        <?php endif; ?>


                        <a
                            href="<?= base_url('admin/blogs/create') ?>"
                            class="inline-flex items-center justify-center rounded-xl bg-[#292322] px-5 py-3 text-sm font-semibold text-white hover:bg-[#3b3331] transition"
                        >
                            + Create Story
                        </a>

                    </div>

                </div>

            <?php else: ?>

                <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-3 gap-5 lg:gap-6">

                    <?php foreach ($blogs as $blog): ?>

                        <?php
                            $blogStatus = strtolower(
                                trim($blog['status'] ?? 'published')
                            );

                            $isPublished =
                                $blogStatus === 'published';

                            $categoryLabel =
                                !empty($blog['category'])
                                    ? $blog['category']
                                    : 'Uncategorized';

                            $excerpt =
                                trim($blog['excerpt'] ?? '');

                            if ($excerpt === '') {
                                $excerpt =
                                    trim(
                                        strip_tags(
                                            $blog['content'] ?? ''
                                        )
                                    );
                            }

                            if (
                                function_exists('mb_strlen') &&
                                mb_strlen($excerpt) > 120
                            ) {
                                $excerpt =
                                    mb_substr($excerpt, 0, 120) . '…';
                            } elseif (
                                !function_exists('mb_strlen') &&
                                strlen($excerpt) > 120
                            ) {
                                $excerpt =
                                    substr($excerpt, 0, 120) . '…';
                            }
                        ?>


                        <article
                            class="group bg-white rounded-3xl border border-[#eadfe0] shadow-sm overflow-hidden hover:shadow-md transition"
                        >

                            <!-- IMAGE -->

                            <div class="relative aspect-[4/3] bg-[#f2eeec] overflow-hidden">

                                <?php if (!empty($blog['featured_image'])): ?>

                                    <img
                                        src="<?= base_url('uploads/blogs/' . $blog['featured_image']) ?>"
                                        alt="<?= esc($blog['title']) ?>"
                                        class="w-full h-full object-cover transition duration-500 group-hover:scale-[1.03]"
                                    >

                                <?php else: ?>

                                    <div class="w-full h-full flex items-center justify-center bg-gradient-to-br from-[#f3e3e6] to-[#eee5df]">

                                        <span class="font-serif text-6xl text-white">
                                            R
                                        </span>

                                    </div>

                                <?php endif; ?>


                                <!-- STATUS -->

                                <div class="absolute top-4 left-4">

                                    <?php if ($isPublished): ?>

                                        <span class="inline-flex items-center gap-1.5 rounded-full bg-white/95 backdrop-blur px-3 py-1.5 text-[10px] uppercase tracking-wider font-semibold text-[#64835f] shadow-sm">

                                            <span class="h-1.5 w-1.5 rounded-full bg-[#8caf8a]"></span>

                                            Published

                                        </span>

                                    <?php else: ?>

                                        <span class="inline-flex items-center gap-1.5 rounded-full bg-white/95 backdrop-blur px-3 py-1.5 text-[10px] uppercase tracking-wider font-semibold text-[#9a742e] shadow-sm">

                                            <span class="h-1.5 w-1.5 rounded-full bg-[#c89b50]"></span>

                                            Draft

                                        </span>

                                    <?php endif; ?>

                                </div>

                            </div>


                            <!-- CONTENT -->

                            <div class="p-5 sm:p-6">

                                <div class="flex items-center justify-between gap-3">

                                    <span class="text-[10px] uppercase tracking-[0.18em] font-semibold text-[#a56b76]">
                                        <?= esc($categoryLabel) ?>
                                    </span>

                                    <?php if (!empty($blog['published_at'])): ?>

                                        <span class="text-[10px] text-[#a59a96]">
                                            <?= esc(
                                                date(
                                                    'd M Y',
                                                    strtotime($blog['published_at'])
                                                )
                                            ) ?>
                                        </span>

                                    <?php elseif (!empty($blog['created_at'])): ?>

                                        <span class="text-[10px] text-[#a59a96]">
                                            <?= esc(
                                                date(
                                                    'd M Y',
                                                    strtotime($blog['created_at'])
                                                )
                                            ) ?>
                                        </span>

                                    <?php endif; ?>

                                </div>


                                <h2 class="mt-2 font-serif text-2xl text-[#292322] leading-tight">
                                    <?= esc($blog['title']) ?>
                                </h2>


                                <?php if ($excerpt !== ''): ?>

                                    <p class="mt-3 text-sm leading-6 text-[#817673]">
                                        <?= esc($excerpt) ?>
                                    </p>

                                <?php endif; ?>


                                <div class="mt-5 pt-4 border-t border-[#eee5e5]">

                                    <div class="flex items-center gap-2">

                                        <a
                                            href="<?= base_url('admin/blogs/edit/' . $blog['id']) ?>"
                                            class="flex-1 inline-flex items-center justify-center rounded-xl bg-[#292322] px-4 py-2.5 text-sm font-semibold text-white hover:bg-[#3b3331] transition"
                                        >
                                            Edit Story
                                        </a>


                                        <a
                                            href="<?= base_url('admin/blogs/delete/' . $blog['id']) ?>"
                                            onclick="return confirm('Delete this story and all its images?')"
                                            class="inline-flex items-center justify-center rounded-xl border border-red-200 bg-red-50 px-4 py-2.5 text-sm font-medium text-red-600 hover:bg-red-100 transition"
                                            title="Delete story"
                                        >
                                            Delete
                                        </a>

                                    </div>

                                </div>

                            </div>

                        </article>

                    <?php endforeach; ?>

                </div>


                <!-- ================================================= -->
                <!-- PAGINATION -->
                <!-- ================================================= -->

                <?php if ($pageCount > 1): ?>

                    <?php
                        $buildPageUrl = function ($page) use (
                            $search,
                            $category,
                            $status
                        ) {

                            $params = [
                                'page' => $page
                            ];

                            if ($search !== '') {
                                $params['search'] = $search;
                            }

                            if ($category !== '') {
                                $params['category'] = $category;
                            }

                            if ($status !== '') {
                                $params['status'] = $status;
                            }

                            return base_url(
                                'admin/blogs?' .
                                http_build_query($params)
                            );
                        };
                    ?>


                    <div class="mt-8 flex items-center justify-center">

                        <div class="inline-flex items-center gap-1 rounded-2xl border border-[#eadfe0] bg-white p-1.5 shadow-sm">

                            <!-- PREVIOUS -->

                            <?php if ($currentPage > 1): ?>

                                <a
                                    href="<?= esc($buildPageUrl($currentPage - 1)) ?>"
                                    class="inline-flex h-10 min-w-10 items-center justify-center rounded-xl px-3 text-sm font-medium text-[#655b5d] hover:bg-[#faf6f3] transition"
                                >
                                    ←
                                    <span class="hidden sm:inline ml-1">
                                        Previous
                                    </span>
                                </a>

                            <?php else: ?>

                                <span
                                    class="inline-flex h-10 min-w-10 items-center justify-center rounded-xl px-3 text-sm text-[#c8bfbd] cursor-not-allowed"
                                >
                                    ←
                                </span>

                            <?php endif; ?>


                            <!-- PAGE NUMBERS -->

                            <?php
                                $startPage =
                                    max(
                                        1,
                                        $currentPage - 2
                                    );

                                $endPage =
                                    min(
                                        $pageCount,
                                        $currentPage + 2
                                    );
                            ?>


                            <?php if ($startPage > 1): ?>

                                <a
                                    href="<?= esc($buildPageUrl(1)) ?>"
                                    class="hidden sm:inline-flex h-10 w-10 items-center justify-center rounded-xl text-sm text-[#655b5d] hover:bg-[#faf6f3] transition"
                                >
                                    1
                                </a>

                                <?php if ($startPage > 2): ?>

                                    <span class="hidden sm:inline-flex h-10 w-8 items-center justify-center text-[#a59a96]">
                                        …
                                    </span>

                                <?php endif; ?>

                            <?php endif; ?>


                            <?php for ($page = $startPage; $page <= $endPage; $page++): ?>

                                <?php if ($page === $currentPage): ?>

                                    <span
                                        class="inline-flex h-10 w-10 items-center justify-center rounded-xl bg-[#a56b76] text-sm font-semibold text-white"
                                    >
                                        <?= $page ?>
                                    </span>

                                <?php else: ?>

                                    <a
                                        href="<?= esc($buildPageUrl($page)) ?>"
                                        class="inline-flex h-10 w-10 items-center justify-center rounded-xl text-sm text-[#655b5d] hover:bg-[#faf6f3] transition"
                                    >
                                        <?= $page ?>
                                    </a>

                                <?php endif; ?>

                            <?php endfor; ?>


                            <?php if ($endPage < $pageCount): ?>

                                <?php if ($endPage < $pageCount - 1): ?>

                                    <span class="hidden sm:inline-flex h-10 w-8 items-center justify-center text-[#a59a96]">
                                        …
                                    </span>

                                <?php endif; ?>


                                <a
                                    href="<?= esc($buildPageUrl($pageCount)) ?>"
                                    class="hidden sm:inline-flex h-10 w-10 items-center justify-center rounded-xl text-sm text-[#655b5d] hover:bg-[#faf6f3] transition"
                                >
                                    <?= $pageCount ?>
                                </a>

                            <?php endif; ?>


                            <!-- NEXT -->

                            <?php if ($currentPage < $pageCount): ?>

                                <a
                                    href="<?= esc($buildPageUrl($currentPage + 1)) ?>"
                                    class="inline-flex h-10 min-w-10 items-center justify-center rounded-xl px-3 text-sm font-medium text-[#655b5d] hover:bg-[#faf6f3] transition"
                                >
                                    <span class="hidden sm:inline mr-1">
                                        Next
                                    </span>
                                    →
                                </a>

                            <?php else: ?>

                                <span
                                    class="inline-flex h-10 min-w-10 items-center justify-center rounded-xl px-3 text-sm text-[#c8bfbd] cursor-not-allowed"
                                >
                                    →
                                </span>

                            <?php endif; ?>

                        </div>

                    </div>

                <?php endif; ?>

            <?php endif; ?>

        </div>

    </div>

</main>

<?= view('admin/layout/footer') ?>