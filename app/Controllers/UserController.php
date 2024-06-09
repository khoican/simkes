<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\User;
use CodeIgniter\HTTP\ResponseInterface;
use PhpParser\Node\Expr\FuncCall;

class UserController extends BaseController
{
    protected $userModel;

    public function __construct()
    {
        $this->userModel = new User();
    }

    public function index()
    {
        return view('pages/user');
    }

    public function getUser()
    {
        $users = $this->userModel->getAllUser();
        return $this->response->setJSON($users);
    }

    public function getUserById($id)
    {
        $user = $this->userModel->getUserById($id);
        return $this->response->setJSON($user);
    }

    public function postUser()
    {   
        $username = $this->request->getPost('username');
        $data = [
            'nama' => $this->request->getPost('nama'),
            'username' => $username,
            'password' => password_hash($this->request->getVar('password'), PASSWORD_DEFAULT),
            'role' => $this->request->getPost('role'),
        ];


        if (!$this->userModel->usernameExists($username)) {
            if ($this->userModel->postUser($data)) {
                session()->setFlashdata('pesan', 'Pengguna berhasil didaftarkan');
            } else {
                session()->setFlashdata('error', 'Pengguna gagal didaftarkan');
            }
        } else {
            session()->setFlashdata('error', 'Username sudah terdaftar');
        }

        return redirect()->to('/user');
    }

    public function auth() {
        $username = $this->request->getVar('username');
        $password = $this->request->getVar('password');

        $usernameIsExist = $this->userModel->usernameExists($username);
        if ($usernameIsExist) {
            if (password_verify($password, $usernameIsExist['password'])) {
                session()->set('name', $usernameIsExist['nama']);
                session()->set('role', $usernameIsExist['role']);
                session()->set('isLogin', true);

                if($username == 'admin' && $password == 'adminsimkes123') {
                    $this->userModel->deleteUser($usernameIsExist['id']);
                }

                session()->setFlashdata('pesan', 'Login berhasil');
                return redirect()->to('/');
            } else {
                session()->setFlashdata('error', 'Password salah');
            }
        } elseif(!$usernameIsExist && $username) {
            session()->setFlashdata('error', 'Username salah');
        } else {
            session()->setFlashdata('error', 'Silahkan masukkan username dan password anda');
        }

        return redirect()->to('/login');
    }

    public function changePassword($id) {
        $oldPassword = $this->request->getVar('oldPassword');
        $newPassword = $this->request->getVar('newPassword');
        $confirmPassword = $this->request->getVar('confirmPassword');

        if (password_verify($oldPassword, $this->userModel->getUserById($id)['password'])) {

            if ($newPassword == $confirmPassword) {
                $data = [
                    'password' => password_hash($newPassword, PASSWORD_DEFAULT)
                ];
                if ($this->userModel->editUser($id, $data)) {
                    session()->setFlashdata('pesan', 'Password berhasil diubah');
                } else {
                    session()->setFlashdata('error', 'Password gagal diubah');
                }
            } else {
                session()->setFlashdata('error', 'Konfirmasi password gagal, password tidak sama');
            }

        } else {
            session()->setFlashdata('error', 'Password lama salah');
        }

        return redirect()->to('/user');
    }

    public function editUser($id) {
        $data = [
            'id' => $id,
            'nama' => $this->request->getPost('nama'),
            'username' => $this->request->getPost('username'),
            'role' => $this->request->getPost('role'),
        ];
        
        if ($this->userModel->editUser($id, $data)) {
            session()->setFlashdata('pesan', 'Pengguna berhasil diubah');
        } else {
            session()->setFlashdata('error', 'Pengguna gagal diubah');
        }
        return redirect()->to('/user');
    }

    public function deleteUser($id) {
        if ($this->userModel->deleteUser($id)) {
            session()->setFlashdata('pesan', 'Pengguna berhasil dihapus');
        } else {
            session()->setFlashdata('error', 'Pengguna gagal dihapus');
        }
        return redirect()->to('/user');
    }

    public function logout() {
        session()->destroy();
        return redirect()->to('/login');
    }
}