<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\ServiceModel;

class ServiceController extends BaseController
{
    protected $serviceModel;

    public function __construct()
    {
        $this->serviceModel = new ServiceModel();
    }

    private function checkAdmin()
    {
        if (!session()->get('admin_logged_in')) {
            return redirect()->to('/admin/login');
        }

        return null;
    }

    public function index()
    {
        if ($redirect = $this->checkAdmin()) {
            return $redirect;
        }

        $search = trim($this->request->getGet('search') ?? '');
        $status = trim($this->request->getGet('status') ?? '');

        $query = $this->serviceModel;

        if ($search !== '') {
            $query
                ->groupStart()
                ->like('title', $search)
                ->orLike('subtitle', $search)
                ->orLike('description', $search)
                ->groupEnd();
        }

        if ($status !== '' && in_array($status, ['active', 'inactive'], true)) {
            $query->where('status', $status);
        }

        $services = $query
            ->orderBy('sort_order', 'ASC')
            ->orderBy('id', 'DESC')
            ->findAll();

        return view('admin/services/index', [
            'services' => $services,
            'search' => $search,
            'status' => $status,
        ]);
    }

    public function create()
    {
        if ($redirect = $this->checkAdmin()) {
            return $redirect;
        }

        return view('admin/services/create');
    }

    public function store()
    {
        if ($redirect = $this->checkAdmin()) {
            return $redirect;
        }

        $title = trim($this->request->getPost('title') ?? '');
        $subtitle = trim($this->request->getPost('subtitle') ?? '');
        $description = trim($this->request->getPost('description') ?? '');
        $duration = trim($this->request->getPost('duration') ?? '');
        $price = trim($this->request->getPost('price') ?? '');
        $icon = trim($this->request->getPost('icon') ?? 'sparkles');
        $sortOrder = (int) ($this->request->getPost('sort_order') ?? 0);
        $status = trim($this->request->getPost('status') ?? 'active');

        $includesInput = $this->request->getPost('includes') ?? '';
        $includes = $this->formatIncludes($includesInput);

        if ($title === '') {
            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Service title is required.');
        }

        if ($description === '') {
            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Service description is required.');
        }

        if (!in_array($status, ['active', 'inactive'], true)) {
            $status = 'inactive';
        }

        $this->serviceModel->insert([
            'title' => $title,
            'subtitle' => $subtitle,
            'description' => $description,
            'includes' => json_encode($includes),
            'duration' => $duration,
            'price' => $price,
            'icon' => $icon !== '' ? $icon : 'sparkles',
            'sort_order' => $sortOrder,
            'status' => $status,
        ]);

        return redirect()
            ->to('/admin/services')
            ->with('success', 'Service created successfully.');
    }

    public function edit($id)
    {
        if ($redirect = $this->checkAdmin()) {
            return $redirect;
        }

        $service = $this->serviceModel->find($id);

        if (!$service) {
            return redirect()
                ->to('/admin/services')
                ->with('error', 'Service not found.');
        }

        $service['includes'] = $this->decodeIncludes($service['includes'] ?? null);

        return view('admin/services/edit', [
            'service' => $service,
        ]);
    }

    public function update($id)
    {
        if ($redirect = $this->checkAdmin()) {
            return $redirect;
        }

        $service = $this->serviceModel->find($id);

        if (!$service) {
            return redirect()
                ->to('/admin/services')
                ->with('error', 'Service not found.');
        }

        $title = trim($this->request->getPost('title') ?? '');
        $subtitle = trim($this->request->getPost('subtitle') ?? '');
        $description = trim($this->request->getPost('description') ?? '');
        $duration = trim($this->request->getPost('duration') ?? '');
        $price = trim($this->request->getPost('price') ?? '');
        $icon = trim($this->request->getPost('icon') ?? 'sparkles');
        $sortOrder = (int) ($this->request->getPost('sort_order') ?? 0);
        $status = trim($this->request->getPost('status') ?? 'active');

        if ($title === '') {
            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Service title is required.');
        }

        if ($description === '') {
            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Service description is required.');
        }

        if (!in_array($status, ['active', 'inactive'], true)) {
            $status = 'inactive';
        }

        $includesInput = $this->request->getPost('includes') ?? '';
        $includes = $this->formatIncludes($includesInput);

        $this->serviceModel->update($id, [
            'title' => $title,
            'subtitle' => $subtitle,
            'description' => $description,
            'includes' => json_encode($includes),
            'duration' => $duration,
            'price' => $price,
            'icon' => $icon !== '' ? $icon : 'sparkles',
            'sort_order' => $sortOrder,
            'status' => $status,
        ]);

        return redirect()
            ->to('/admin/services')
            ->with('success', 'Service updated successfully.');
    }

    public function delete($id)
    {
        if ($redirect = $this->checkAdmin()) {
            return $redirect;
        }

        $service = $this->serviceModel->find($id);

        if (!$service) {
            return redirect()
                ->to('/admin/services')
                ->with('error', 'Service not found.');
        }

        $this->serviceModel->delete($id);

        return redirect()
            ->to('/admin/services')
            ->with('success', 'Service deleted successfully.');
    }

    private function formatIncludes($value): array
    {
        if (is_array($value)) {
            $lines = $value;
        } else {
            $lines = preg_split('/\r\n|\r|\n/', (string) $value);
        }

        $lines = array_map('trim', $lines);
        $lines = array_filter($lines, static function ($line) {
            return $line !== '';
        });

        return array_values($lines);
    }

    private function decodeIncludes($value): array
    {
        if (is_array($value)) {
            return $value;
        }

        if (!$value) {
            return [];
        }

        $decoded = json_decode($value, true);

        return is_array($decoded) ? $decoded : [];
    }
}
