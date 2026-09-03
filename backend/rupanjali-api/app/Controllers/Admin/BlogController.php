<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\BlogModel;
use App\Models\BlogImageModel;

class BlogController extends BaseController
{
    protected $blogModel;
    protected $imageModel;

    public function __construct()
    {
        $this->blogModel = new BlogModel();
        $this->imageModel = new BlogImageModel();
    }

    /**
     * Check admin authentication.
     */
    private function requireAdmin()
    {
        if (!session()->get('admin_logged_in')) {
            return redirect()->to('/admin/login');
        }

        return null;
    }

    /**
     * Admin - Blog list
     */
    public function index()
    {
        $redirect = $this->requireAdmin();

        if ($redirect) {
            return $redirect;
        }

        $search    = trim($this->request->getGet('search') ?? '');
        $category  = trim($this->request->getGet('category') ?? '');
        $status    = trim($this->request->getGet('status') ?? '');

        $query = $this->blogModel;

        /*
        * Search
        */
        if ($search !== '') {
            $query->groupStart()
                ->like('title', $search)
                ->orLike('excerpt', $search)
                ->orLike('content', $search)
                ->groupEnd();
        }

        /*
        * Category filter
        */
        if ($category !== '') {
            $query->where('category', $category);
        }

        /*
        * Status filter
        */
        if (
            $status !== '' &&
            in_array($status, ['published', 'draft'], true)
        ) {
            $query->where('status', $status);
        }

        /*
        * Pagination
        *
        * 9 stories per page gives us a clean
        * 3-column desktop layout.
        */
        $blogs = $query
            ->orderBy('id', 'DESC')
            ->paginate(9);

        /*
        * Get all categories for the filter.
        */
        $categories = $this->blogModel
            ->select('category')
            ->where('category IS NOT NULL', null, false)
            ->where('category !=', '')
            ->groupBy('category')
            ->orderBy('category', 'ASC')
            ->findAll();

        return view('admin/blogs/index', [
            'blogs'      => $blogs,
            'categories' => $categories,
            'pager'      => $this->blogModel->pager,
            'search'     => $search,
            'category'   => $category,
            'status'     => $status,
        ]);
    }

    /**
     * Admin - Create blog page
     */
    public function create()
    {
        $redirect = $this->requireAdmin();

        if ($redirect) {
            return $redirect;
        }

        return view('admin/blogs/create');
    }

    /**
     * Admin - Store new blog
     */
    public function store()
    {
        $redirect = $this->requireAdmin();

        if ($redirect) {
            return $redirect;
        }

        $title = trim($this->request->getPost('title') ?? '');
        $slug = trim($this->request->getPost('slug') ?? '');
        $category = trim($this->request->getPost('category') ?? '');
        $excerpt = trim($this->request->getPost('excerpt') ?? '');
        $content = trim($this->request->getPost('content') ?? '');
        $status = trim($this->request->getPost('status') ?? 'published');
        $publishedAt = trim($this->request->getPost('published_at') ?? '');

        /*
         * Title validation
         */
        if ($title === '') {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Story title is required.');
        }

        /*
         * Content validation
         */
        if ($content === '') {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Story content is required.');
        }

        /*
        * Status validation
        */
        if (!in_array($status, ['published', 'draft'], true)) {
            $status = 'draft';
        }

        /*
        * Published date
        */
        if ($publishedAt === '') {
            $publishedAt = null;
        }

        /*
         * Automatic slug generation
         *
         * If admin leaves slug empty,
         * generate it from the title.
         */
        if ($slug === '') {
            $slug = url_title($title, '-', true);
        } else {
            /*
             * Normalize manually entered slug.
             *
             * Example:
             * "My Beautiful Bridal Look"
             *
             * becomes:
             * "my-beautiful-bridal-look"
             */
            $slug = url_title($slug, '-', true);
        }

        if ($slug === '') {
            return redirect()->back()
                ->withInput()
                ->with('error', 'A valid URL slug could not be generated.');
        }

        /*
         * Check slug uniqueness.
         */
        $existing = $this->blogModel
            ->where('slug', $slug)
            ->first();

        if ($existing) {
            return redirect()->back()
                ->withInput()
                ->with(
                    'error',
                    'This URL slug is already being used by another story.'
                );
        }

        /*
         * Featured image
         */
        $image = $this->request->getFile('featured_image');

        $imageName = null;

        if ($image && $image->isValid() && !$image->hasMoved()) {

            $uploadPath = FCPATH . 'uploads/blogs';

            if (!is_dir($uploadPath)) {
                mkdir($uploadPath, 0775, true);
            }

            $imageName = $image->getRandomName();

            $image->move($uploadPath, $imageName);
        }

        /*
        * Story video
        *
        * A story can have either:
        * - an uploaded MP4/WebM video
        * - OR a YouTube URL
        * - OR no video
        */
        $videoType = null;
        $videoPath = null;
        $videoUrl  = null;

        $youtubeUrl = trim(
            $this->request->getPost('video_url') ?? ''
        );

        $videoFile = $this->request->getFile('video_file');

        if ($youtubeUrl !== '') {

            $youtubeId = $this->getYouTubeVideoId($youtubeUrl);

            if (!$youtubeId) {
                return redirect()->back()
                    ->withInput()
                    ->with(
                        'error',
                        'Please enter a valid YouTube video URL.'
                    );
            }

            $videoType = 'youtube';
            $videoUrl = $youtubeUrl;

        } elseif (
            $videoFile &&
            $videoFile->isValid() &&
            !$videoFile->hasMoved()
        ) {

            $extension = strtolower(
                $videoFile->getExtension()
            );

            if (!in_array($extension, ['mp4', 'webm'], true)) {
                return redirect()->back()
                    ->withInput()
                    ->with(
                        'error',
                        'Video must be an MP4 or WebM file.'
                    );
            }

            if ($videoFile->getSize() > 100 * 1024 * 1024) {
                return redirect()->back()
                    ->withInput()
                    ->with(
                        'error',
                        'Video must be smaller than 100 MB.'
                    );
            }

            $videoPath = $this->uploadStoryVideo(
                $videoFile
            );

            if (!$videoPath) {
                return redirect()->back()
                    ->withInput()
                    ->with(
                        'error',
                        'The video could not be uploaded.'
                    );
            }

            $videoType = 'upload';
        }

        /*
         * Create blog
         */
        $blogId = $this->blogModel->insert([
            'title'          => $title,
            'slug'           => $slug,
            'category'       => $category ?: null,
            'excerpt'        => $excerpt ?: null,
            'content'        => $content,
            'featured_image' => $imageName,
            'video_type'     => $videoType,
            'video_path'     => $videoPath,
            'video_url'      => $videoUrl,
            'status'         => $status,
            'published_at'   => $publishedAt,
        ], true);

        if (!$blogId) {
            return redirect()->back()
                ->withInput()
                ->with(
                    'error',
                    'The story could not be created.'
                );
        }

        /*
         * Optional gallery images during creation.
         *
         * The form can send multiple files using:
         * gallery_images[]
         */
        $galleryImages = $this->request->getFileMultiple('gallery_images');

        if ($galleryImages) {

            $sortOrder = 0;

            foreach ($galleryImages as $galleryImage) {

                if (
                    $galleryImage &&
                    $galleryImage->isValid() &&
                    !$galleryImage->hasMoved()
                ) {

                    $uploadPath = FCPATH . 'uploads/blogs';

                    if (!is_dir($uploadPath)) {
                        mkdir($uploadPath, 0775, true);
                    }

                    $galleryName = $galleryImage->getRandomName();

                    $galleryImage->move(
                        $uploadPath,
                        $galleryName
                    );

                    $this->imageModel->insert([
                        'blog_id'    => $blogId,
                        'image_path' => $galleryName,
                        'sort_order' => $sortOrder,
                    ]);

                    $sortOrder++;
                }
            }
        }

        return redirect()
            ->to('/admin/blogs/edit/' . $blogId)
            ->with(
                'success',
                'Story created successfully.'
            );
    }

    /**
     * Admin - Edit blog page
     */
    public function edit($id)
    {
        $redirect = $this->requireAdmin();

        if ($redirect) {
            return $redirect;
        }

        $blog = $this->blogModel->find($id);

        if (!$blog) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException(
                'Blog not found'
            );
        }

        $images = $this->imageModel
            ->where('blog_id', $id)
            ->orderBy('sort_order', 'ASC')
            ->findAll();

        return view('admin/blogs/edit', [
            'blog'   => $blog,
            'images' => $images,
        ]);
    }

    /**
     * Admin - Update blog
     */
    public function update($id)
    {
        $redirect = $this->requireAdmin();

        if ($redirect) {
            return $redirect;
        }

        $blog = $this->blogModel->find($id);

        if (!$blog) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException(
                'Blog not found'
            );
        }

        $title = trim($this->request->getPost('title') ?? '');
        $slug = trim($this->request->getPost('slug') ?? '');
        $category = trim($this->request->getPost('category') ?? '');
        $excerpt = trim($this->request->getPost('excerpt') ?? '');
        $content = trim($this->request->getPost('content') ?? '');
        $status = trim($this->request->getPost('status') ?? 'published');
        $publishedAt = trim($this->request->getPost('published_at') ?? '');

        /*
         * Validation
         */
        if ($title === '') {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Story title is required.');
        }

        if ($content === '') {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Story content is required.');
        }

        /*
        * Status validation
        */
        if (!in_array($status, ['published', 'draft'], true)) {
            $status = 'draft';
        }

        /*
        * Published date
        */
        if ($publishedAt === '') {
            $publishedAt = null;
        }

        /*
         * If slug is empty, generate it from title.
         */
        if ($slug === '') {
            $slug = url_title($title, '-', true);
        } else {
            $slug = url_title($slug, '-', true);
        }

        if ($slug === '') {
            return redirect()->back()
                ->withInput()
                ->with('error', 'A valid URL slug is required.');
        }

        /*
         * Check slug uniqueness.
         *
         * The current blog is excluded.
         */
        $existing = $this->blogModel
            ->where('slug', $slug)
            ->where('id !=', $id)
            ->first();

        if ($existing) {
            return redirect()->back()
                ->withInput()
                ->with(
                    'error',
                    'This URL slug is already being used by another story.'
                );
        }

        /*
        * Update basic information.
        */
        $data = [
            'title'        => $title,
            'slug'         => $slug,
            'category'     => $category ?: null,
            'excerpt'      => $excerpt ?: null,
            'content'      => $content,
            'status'       => $status,
            'published_at' => $publishedAt,
        ];

        /*
        * Story video update.
        *
        * A story can have:
        * - one uploaded MP4/WebM video
        * - OR one YouTube video
        * - OR no video change
        */
        $youtubeUrl = trim(
            $this->request->getPost('video_url') ?? ''
        );

        $videoFile = $this->request->getFile('video_file');

            /*
            * Diagnose upload errors.
            *
            * If the browser submitted a video but PHP rejected it,
            * show the actual upload error instead of silently ignoring it.
            */
            if (
                $videoFile &&
                $videoFile->getError() !== UPLOAD_ERR_NO_FILE &&
                !$videoFile->isValid()
            ) {
                return redirect()->back()
                    ->withInput()
                    ->with(
                        'error',
                        'Video upload error: ' .
                        $videoFile->getErrorString()
                    );
            }


        if ($youtubeUrl !== '') {

            $youtubeId = $this->getYouTubeVideoId(
                $youtubeUrl
            );

            if (!$youtubeId) {
                return redirect()->back()
                    ->withInput()
                    ->with(
                        'error',
                        'Please enter a valid YouTube video URL.'
                    );
            }

            /*
            * Remove old uploaded video if replacing it
            * with YouTube.
            */
            if (
                $blog['video_type'] === 'upload' &&
                !empty($blog['video_path'])
            ) {
                $this->deleteStoryVideo(
                    $blog['video_path']
                );
            }

            $data['video_type'] = 'youtube';
            $data['video_path'] = null;
            $data['video_url']  = $youtubeUrl;

        } elseif (
            $videoFile &&
            $videoFile->isValid() &&
            !$videoFile->hasMoved()
        ) {

            $extension = strtolower(
                $videoFile->getExtension()
            );

            if (!in_array($extension, ['mp4', 'webm'], true)) {
                return redirect()->back()
                    ->withInput()
                    ->with(
                        'error',
                        'Video must be an MP4 or WebM file.'
                    );
            }

            if ($videoFile->getSize() > 100 * 1024 * 1024) {
                return redirect()->back()
                    ->withInput()
                    ->with(
                        'error',
                        'Video must be smaller than 100 MB.'
                    );
            }

            $newVideoPath = $this->uploadStoryVideo(
                $videoFile
            );

            if (!$newVideoPath) {
                return redirect()->back()
                    ->withInput()
                    ->with(
                        'error',
                        'The video could not be uploaded.'
                    );
            }

            /*
            * Remove previous uploaded video.
            */
            if (
                $blog['video_type'] === 'upload' &&
                !empty($blog['video_path'])
            ) {
                $this->deleteStoryVideo(
                    $blog['video_path']
                );
            }

            $data['video_type'] = 'upload';
            $data['video_path'] = $newVideoPath;
            $data['video_url']  = null;
        }


        /*
         * Replace featured image if a new one was uploaded.
         */
        $image = $this->request->getFile('featured_image');

        if (
            $image &&
            $image->isValid() &&
            !$image->hasMoved()
        ) {

            $uploadPath = FCPATH . 'uploads/blogs';

            if (!is_dir($uploadPath)) {
                mkdir($uploadPath, 0775, true);
            }

            $newName = $image->getRandomName();

            $image->move(
                $uploadPath,
                $newName
            );

            /*
             * Delete old featured image.
             */
            if (!empty($blog['featured_image'])) {

                $oldPath =
                    FCPATH .
                    'uploads/blogs/' .
                    $blog['featured_image'];

                if (is_file($oldPath)) {
                    @unlink($oldPath);
                }
            }

            $data['featured_image'] = $newName;
        }

        $this->blogModel->update($id, $data);

        /*
         * Add additional gallery images.
         */
        $galleryImages = $this->request->getFileMultiple('gallery_images');

        if ($galleryImages) {

            $lastImage = $this->imageModel
                ->where('blog_id', $id)
                ->orderBy('sort_order', 'DESC')
                ->first();

            $sortOrder = $lastImage
                ? ((int) $lastImage['sort_order'] + 1)
                : 0;

            foreach ($galleryImages as $galleryImage) {

                if (
                    $galleryImage &&
                    $galleryImage->isValid() &&
                    !$galleryImage->hasMoved()
                ) {

                    $uploadPath = FCPATH . 'uploads/blogs';

                    if (!is_dir($uploadPath)) {
                        mkdir($uploadPath, 0775, true);
                    }

                    $galleryName =
                        $galleryImage->getRandomName();

                    $galleryImage->move(
                        $uploadPath,
                        $galleryName
                    );

                    $this->imageModel->insert([
                        'blog_id'    => $id,
                        'image_path' => $galleryName,
                        'sort_order' => $sortOrder,
                    ]);

                    $sortOrder++;
                }
            }
        }

        return redirect()
            ->to('/admin/blogs/edit/' . $id)
            ->with(
                'success',
                'Story updated successfully.'
            );
    }

    /**
     * Admin - Delete individual gallery image
     */
    public function deleteImage($id)
    {
        $redirect = $this->requireAdmin();

        if ($redirect) {
            return $redirect;
        }

        $image = $this->imageModel->find($id);

        if (!$image) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException(
                'Image not found'
            );
        }

        $filePath =
            FCPATH .
            'uploads/blogs/' .
            $image['image_path'];

        if (is_file($filePath)) {
            @unlink($filePath);
        }

        $blogId = $image['blog_id'];

        $this->imageModel->delete($id);

        return redirect()
            ->to('/admin/blogs/edit/' . $blogId)
            ->with(
                'success',
                'Gallery image deleted.'
            );
    }

    /**
     * Admin - Delete complete blog
     */
    public function delete($id)
    {
        $redirect = $this->requireAdmin();

        if ($redirect) {
            return $redirect;
        }

        $blog = $this->blogModel->find($id);

        if (!$blog) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException(
                'Blog not found'
            );
        }

        /*
        * Delete uploaded story video.
        */
        if (
            !empty($blog['video_path']) &&
            $blog['video_type'] === 'upload'
        ) {
            $this->deleteStoryVideo(
                $blog['video_path']
            );
        }

        /*
         * Delete featured image.
         */
        if (!empty($blog['featured_image'])) {

            $featuredPath =
                FCPATH .
                'uploads/blogs/' .
                $blog['featured_image'];

            if (is_file($featuredPath)) {
                @unlink($featuredPath);
            }
        }

        /*
         * Delete gallery files.
         */
        $images = $this->imageModel
            ->where('blog_id', $id)
            ->findAll();

        foreach ($images as $image) {

            $filePath =
                FCPATH .
                'uploads/blogs/' .
                $image['image_path'];

            if (is_file($filePath)) {
                @unlink($filePath);
            }
        }

        /*
         * Delete gallery database records.
         */
        $this->imageModel
            ->where('blog_id', $id)
            ->delete();

        /*
         * Delete blog.
         */
        $this->blogModel->delete($id);

        return redirect()
            ->to('/admin/blogs')
            ->with(
                'success',
                'Story deleted successfully.'
            );
    }
    
    /**
     * Store an uploaded story video.
     */
    /**
     * Store an uploaded story video.
     */
    private function uploadStoryVideo($file)
    {
        if (!$file || !$file->isValid() || $file->hasMoved()) {
            return null;
        }

        $allowedExtensions = [
            'mp4',
            'webm',
        ];

        $extension = strtolower($file->getExtension());

        if (!in_array($extension, $allowedExtensions, true)) {
            return null;
        }

        /*
        * Maximum video size: 100 MB.
        */
        if ($file->getSize() > 100 * 1024 * 1024) {
            return null;
        }

        $uploadPath = FCPATH . 'uploads/blogs/videos';

        if (!is_dir($uploadPath)) {
            if (!mkdir($uploadPath, 0775, true) && !is_dir($uploadPath)) {
                return null;
            }
        }

        if (!is_writable($uploadPath)) {
            return null;
        }

        $videoName = $file->getRandomName();

        /*
        * Move the uploaded file.
        */
        if (!$file->move($uploadPath, $videoName)) {
            return null;
        }

        /*
        * Confirm that the file actually exists.
        */
        $savedPath = $uploadPath . DIRECTORY_SEPARATOR . $videoName;

        if (!is_file($savedPath)) {
            return null;
        }

        return $videoName;
    }

    /**
     * Delete an uploaded story video.
     */
    private function deleteStoryVideo(?string $videoPath): void
    {
        if (empty($videoPath)) {
            return;
        }

        $filePath =
            FCPATH .
            'uploads/blogs/videos/' .
            $videoPath;

        if (is_file($filePath)) {
            @unlink($filePath);
        }
    }

    /**
     * Extract a YouTube video ID from common YouTube URLs.
     */
    private function getYouTubeVideoId(?string $url): ?string
    {
        if (empty($url)) {
            return null;
        }

        $url = trim($url);

        $patterns = [
            '/youtube\.com\/watch\?v=([a-zA-Z0-9_-]{11})/',
            '/youtu\.be\/([a-zA-Z0-9_-]{11})/',
            '/youtube\.com\/embed\/([a-zA-Z0-9_-]{11})/',
            '/youtube\.com\/shorts\/([a-zA-Z0-9_-]{11})/',
        ];

        foreach ($patterns as $pattern) {
            if (preg_match($pattern, $url, $matches)) {
                return $matches[1];
            }
        }

        return null;
    }

}