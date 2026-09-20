<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\HomeContentModel;

class HomeController extends BaseController
{
    protected $homeModel;

    public function __construct()
    {
        $this->homeModel = new HomeContentModel();
    }

    private function checkAdmin()
    {
        if (!session()->get('admin_logged_in')) {
            return redirect()->to('/admin/login');
        }

        return null;
    }

    private function getUploadPath(): string
    {
        return FCPATH . 'uploads/home';
    }

    private function deleteImageFile(?string $filename): void
    {
        if (!$filename) {
            return;
        }

        // Never attempt to delete remote URLs.
        if (filter_var($filename, FILTER_VALIDATE_URL)) {
            return;
        }

        $path = $this->getUploadPath() . DIRECTORY_SEPARATOR . basename($filename);

        if (is_file($path)) {
            @unlink($path);
        }
    }

    private function getHomeContent(): array
    {
        $home = $this->homeModel->first();

        if (!$home) {
            $id = $this->homeModel->insert([
                'hero_image'       => null,
                'bridal_image'     => null,
                'engagement_image' => null,
                'party_image'      => null,
            ]);

            return $this->homeModel->find($id) ?? [
                'id'               => $id,
                'hero_image'       => null,
                'bridal_image'     => null,
                'engagement_image' => null,
                'party_image'      => null,
            ];
        }

        return $home;
    }

    public function index()
    {
        if ($redirect = $this->checkAdmin()) {
            return $redirect;
        }

        $home = $this->getHomeContent();

        return view('admin/home/index', [
            'home' => $home,
        ]);
    }

    public function update()
    {
        if ($redirect = $this->checkAdmin()) {
            return $redirect;
        }

        $home = $this->getHomeContent();
        $homeId = (int) $home['id'];

        $uploadPath = $this->getUploadPath();

        if (!is_dir($uploadPath)) {
            mkdir($uploadPath, 0775, true);
        }

        $fields = [
            'hero_image',
            'bridal_image',
            'engagement_image',
            'party_image',
        ];

        $newFiles = [];
        $oldFiles = [];
        $data = [];

        $allowedTypes = [
            'image/jpeg',
            'image/png',
            'image/webp',
        ];

        foreach ($fields as $field) {
            $image = $this->request->getFile($field);

            // No new image selected for this field.
            if (!$image || !$image->isValid() || $image->hasMoved()) {
                continue;
            }

            if (!in_array($image->getMimeType(), $allowedTypes, true)) {
                $this->deleteUploadedFiles($newFiles);

                return redirect()
                    ->back()
                    ->withInput()
                    ->with(
                        'error',
                        'Only JPG, PNG, and WebP images are allowed.'
                    );
            }

            // 5 MB maximum per image.
            if ($image->getSizeByUnit('mb') > 5) {
                $this->deleteUploadedFiles($newFiles);

                return redirect()
                    ->back()
                    ->withInput()
                    ->with(
                        'error',
                        ucfirst(str_replace('_', ' ', $field)) .
                        ' must be 5 MB or smaller.'
                    );
            }

            $newImageName = $image->getRandomName();

            if (!$image->move($uploadPath, $newImageName)) {
                $this->deleteUploadedFiles($newFiles);

                return redirect()
                    ->back()
                    ->withInput()
                    ->with(
                        'error',
                        'Unable to save the uploaded image.'
                    );
            }

            $newFiles[] = $newImageName;
            $oldFiles[] = $home[$field] ?? null;
            $data[$field] = $newImageName;
        }

        if (empty($data)) {
            return redirect()
                ->back()
                ->with('error', 'Please select at least one image to update.');
        }

        try {
            $this->homeModel->update($homeId, $data);
        } catch (\Throwable $e) {
            $this->deleteUploadedFiles($newFiles);

            return redirect()
                ->back()
                ->with('error', 'Unable to update Home content.');
        }

        // Delete previous local images only after the database update succeeds.
        foreach ($oldFiles as $oldFile) {
            $this->deleteImageFile($oldFile);
        }

        return redirect()
            ->to('/admin/home')
            ->with('success', 'Home images updated successfully.');
    }

    private function deleteUploadedFiles(array $files): void
    {
        foreach ($files as $file) {
            $this->deleteImageFile($file);
        }
    }
}
