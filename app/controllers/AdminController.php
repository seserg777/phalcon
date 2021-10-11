<?php
namespace Phalconvn\Controllers;
use Phalcon\Mvc\Controller;

class AdminController extends Controller
{
    public function initialize()
    {
        if (!$this->session->has('auth-identity')) {
            $this->flash->error('You must login');
            $this->response->redirect('/');
        }
    }

    public function indexAction()
    {
        $this->metatag->setTitle("Admin panel");
        $this->view->pick('admin/dashboard/index');
    }
}
