<?php
require_once __DIR__ . '/../models/NewsModel.php';
require_once __DIR__ . '/../controllers/AuthController.php';
require_once __DIR__ . '/../helpers/validation.php';

class NewsController {
    private $model;
    private $auth;

    public function __construct() {
        $this->model = new NewsModel();
        $this->auth = new AuthController();
        $this->auth->checkAdmin();
    }

    public function index() {
        $news = $this->model->getAll();
        include __DIR__ . '/../views/news/index.php';
    }

    public function createForm() {
        include __DIR__ . '/../views/news/create.php';
    }

    public function create($data) {
        $this->model->create($data['title'], $data['content']);
        header("Location: /admin/news.php");
    }

    public function editForm($id) {
        $newsItem = $this->model->findById($id);
        include __DIR__ . '/../views/news/edit.php';
    }

    public function update($id, $data) {
        $this->model->update($id, $data['title'], $data['content']);
        header("Location: /admin/news.php");
    }

    public function delete($id) {
        $this->model->delete($id);
        header("Location: /admin/news.php");
    }
}
?>
