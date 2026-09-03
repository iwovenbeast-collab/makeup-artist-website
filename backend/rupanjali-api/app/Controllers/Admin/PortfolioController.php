<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\PortfolioItemModel;

class PortfolioController extends BaseController
{
    protected $portfolioModel;

    public function __construct()
    {
        $this->portfolioModel = new PortfolioItemModel();
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
        $category = trim($this->request->getGet('category') ?? '');
        $status = trim($this->request->getGet('status') ?? '');

        $query = $this->portfolioModel;

        if ($search !== '') {
            $query
                ->groupStart()
                ->like('title', $search)
                ->orLike('category', $search)
                ->groupEnd();
        }

        if ($category !== '') {
            $query->where('category', $category);
        }

        if ($status !== '' && in_array($status, ['active', 'inactive'], true)) {
            $query->where('status', $status);
        }

        $portfolio = $query
            ->orderBy('sort_order', 'ASC')
            ->orderBy('id', 'DESC')
            ->paginate(12);

        $categories = $this->portfolioModel
            ->select('category')
            ->where('category IS NOT NULL', null, false)
            ->where('category !=', '')
            ->groupBy('category')
            ->orderBy('category', 'ASC')
            ->findAll();

        return view('admin/portfolio/index', [
            'portfolio' => $portfolio,
            'categories' => $categories,
            'pager' => $this->portfolioModel->pager,
            'search' => $search,
            'category' => $category,
            'status' => $status,
        ]);
    }

    public function create()
    {
        if ($redirect = $this->checkAdmin()) {
            return $redirect;
        }

        return view('admin/portfolio/create');
    }

    public function store()
    {
        if ($redirect = $this->checkAdmin()) {
            return $redirect;
        }

        $title = trim($this->request->getPost('title') ?? '');
        $category = trim($this->request->getPost('category') ?? '');
        $sortOrder = (int) ($this->request->getPost('sort_order') ?? 0);
        $status = trim($this->request->getPost('status') ?? 'active');

        if ($title === '' || $category === '') {
            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Title and category are required.');
        }

        if (!in_array($status, ['active', 'inactive'], true)) {
            $status = 'inactive';
        }

        $image = $this->request->getFile('image');

        if (!$image || !$image->isValid() || $image->hasMoved()) {
            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Please upload a valid portfolio image.');
        }

        $uploadPath = FCPATH . 'uploads/portfolio';

        if (!is_dir($uploadPath)) {
            mkdir($uploadPath, 0775, true);
        }

        $imageName = $image->getRandomName();
        $image->move($uploadPath, $imageName);

        $this->portfolioModel->insert([
            'title' => $title,
            'category' => $category,
            'image' => $imageName,
            'sort_order' => $sortOrder,
            'status' => $status,
        ]);

        return redirect()
            ->to('/admin/portfolio')
            ->with('success', 'Portfolio item created successfully.');
    }

    public function edit($id)
    {
        if ($redirect = $this->checkAdmin()) {
            return $redirect;
        }

        $item = $this->portfolioModel->find($id);

        if (!$item) {
            return redirect()
                ->to('/admin/portfolio')
                ->with('error', 'Portfolio item not found.');
        }

        return view('admin/portfolio/edit', [
            'item' => $item,
        ]);
    }

    public function update($id)
    {
        if ($redirect = $this->checkAdmin()) {
            return $redirect;
        }

        $item = $this->portfolioModel->find($id);

        if (!$item) {
            return redirect()
                ->to('/admin/portfolio')
                ->with('error', 'Portfolio item not found.');
        }

        $title = trim($this->request->getPost('title') ?? '');
        $category = trim($this->request->getPost('category') ?? '');
        $sortOrder = (int) ($this->request->getPost('sort_order') ?? 0);
        $status = trim($this->request->getPost('status') ?? 'active');

        if ($title === '' || $category === '') {
            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Title and category are required.');
        }

        if (!in_array($status, ['active', 'inactive'], true)) {
            $status = 'inactive';
        }

        $data = [
            'title' => $title,
            'category' => $category,
            'sort_order' => $sortOrder,
            'status' => $status,
        ];

        $image = $this->request->getFile('image');

        if ($image && $image->isValid() && !$image->hasMoved()) {
            $uploadPath = FCPATH . 'uploads/portfolio';

            if (!is_dir($uploadPath)) {
                mkdir($uploadPath, 0775, true);
            }

            $imageName = $image->getRandomName();
            $image->move($uploadPath, $imageName);

            $data['image'] = $imageName;
        }

        $this->portfolioModel->update($id, $data);

        return redirect()
            ->to('/admin/portfolio')
            ->with('success', 'Portfolio item updated successfully.');
    }

    public function delete($id)
    {
        if ($redirect = $this->checkAdmin()) {
            return $redirect;
        }

        $item = $this->portfolioModel->find($id);

        if (!$item) {
            return redirect()
                ->to('/admin/portfolio')
                ->with('error', 'Portfolio item not found.');
        }

        $this->portfolioModel->delete($id);

        return redirect()
            ->to('/admin/portfolio')
            ->with('success', 'Portfolio item deleted successfully.');
    }
}
