<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\AdminModel;
class AuthController extends BaseController
{
    public function login()
    {
        return view('admin/auth/login');
    }

    public function attemptLogin()
    {
        $email = $this->request->getPost('email');
        $password = $this->request->getPost('password');

        $model = new AdminModel();
        $admin = $model->where('email', $email)->first();

        if (!$admin || !password_verify($password, $admin['password'])) {
            return redirect()->back()->with('error', 'Invalid credentials');
        }

        session()->set([
            'admin_logged_in' => true,
            'admin_id' => $admin['id'],
            'admin_name' => $admin['name'],
        ]);

        return redirect()->to('/admin/dashboard');
    }

    public function logout()
    {
        session()->destroy();
        return redirect()->to('/admin/login');
    }
}
