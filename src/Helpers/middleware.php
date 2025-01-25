<?php
class Middleware {
    private $auth;

    public function __construct() {
        $this->auth = new Auth();
    }

    public function requireAuth() {
        if (!$this->auth->isLoggedIn()) {
            header('Location: ' . BASE_URL . '/login');
            exit;
        }
    }

    public function requireAdmin() {
        $this->requireAuth();
        if (!$this->auth->isAdmin()) {
            header('Location: ' . BASE_URL . '/student/home');
            exit;
        }
    }

    public function requireStudent() {
        $this->requireAuth();
        if ($this->auth->isAdmin()) {
            header('Location: ' . BASE_URL . '/admin/dashboard');
            exit;
        }
    }
}