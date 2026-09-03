<?php

namespace App\Controllers\Api;

use App\Controllers\BaseController;
use App\Models\BlogModel;
use App\Models\BlogImageModel;
use CodeIgniter\API\ResponseTrait;

class BlogController extends BaseController
{
    use ResponseTrait;

    /**
     * GET /api/blogs
     *
     * Return only published blogs for the React website.
     *
     * Draft stories must never be exposed through the
     * public API.
     */
    public function index()
    {
        $blogModel  = new BlogModel();
        $imageModel = new BlogImageModel();

        $blogs = $blogModel
            ->where('status', 'published')
            ->orderBy('created_at', 'DESC')
            ->findAll();

        foreach ($blogs as &$blog) {

            /*
             * Featured image
             */
            $blog['featured_image_url'] = null;

            if (!empty($blog['featured_image'])) {

                $blog['featured_image_url'] =
                    base_url(
                        'uploads/blogs/' .
                        $blog['featured_image']
                    );

            }


            /*
             * Gallery images
             */
            $images = $imageModel
                ->where('blog_id', $blog['id'])
                ->orderBy('sort_order', 'ASC')
                ->findAll();

            $blog['images'] = [];

            foreach ($images as $image) {

                $blog['images'][] = [
                    'id' => $image['id'],

                    'image_path' =>
                        $image['image_path'],

                    'image_url' =>
                        base_url(
                            'uploads/blogs/' .
                            $image['image_path']
                        ),

                    'sort_order' =>
                        $image['sort_order'],
                ];

            }

        }

        unset($blog);

        return $this->respond([
            'status' => true,
            'blogs'  => $blogs,
        ]);
    }


    /**
     * GET /api/blogs/:slug
     *
     * Return one published blog with all its images.
     *
     * Draft stories behave as if they do not exist publicly.
     */
    public function show($slug)
    {
        $blogModel  = new BlogModel();
        $imageModel = new BlogImageModel();

        /*
         * IMPORTANT:
         * Only published stories can be retrieved
         * through this public endpoint.
         */
        $blog = $blogModel
            ->where('slug', $slug)
            ->where('status', 'published')
            ->first();

        if (!$blog) {

            return $this->failNotFound(
                'Blog not found'
            );

        }


        /*
         * Featured image
         */
        $blog['featured_image_url'] = null;

        if (!empty($blog['featured_image'])) {

            $blog['featured_image_url'] =
                base_url(
                    'uploads/blogs/' .
                    $blog['featured_image']
                );

        }


        /*
         * Gallery images
         */
        $images = $imageModel
            ->where('blog_id', $blog['id'])
            ->orderBy('sort_order', 'ASC')
            ->findAll();

        $blog['images'] = [];

        foreach ($images as $image) {

            $blog['images'][] = [
                'id' => $image['id'],

                'image_path' =>
                    $image['image_path'],

                'image_url' =>
                    base_url(
                        'uploads/blogs/' .
                        $image['image_path']
                    ),

                'sort_order' =>
                    $image['sort_order'],
            ];

        }


        return $this->respond([
            'status' => true,
            'blog'   => $blog,
        ]);
    }
}