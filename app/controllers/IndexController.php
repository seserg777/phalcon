<?php
namespace Phalconvn\Controllers;
use Phalcon\Mvc\Controller;
use Phalconvn\Models\Users;
use Phalcon\Paginator\Adapter\Model as PaginatorModel;
use Phalconvn\Helpers\ListHelper;

class IndexController extends Controller
{
    /**
     * Welcome and user list
     */
    public function indexAction()
    {
        $currentPage = $this->request->getQuery('page', 'int', 1);
        $paginator   = new PaginatorModel(
            [
                'model'  => Users::class,
                'limit' => 10,
                'page'  => $currentPage,
            ]
        );
        $page = $paginator->paginate();
        $this->view->setVar('page', $page);
        $model = new Users();
        $params = $this->request->getQuery();

        $this->view->setVar('users', $model->getList($params));
        $this->view->setVar('order', $this->request->getQuery('order', 'string', NULL));
        $this->view->setVar('orderby', $this->request->getQuery('orderby', 'string', NULL));
        $this->view->setVar('listHelper', new ListHelper());
        $this->view->setVar('user', $this->auth->getUser());
        //echo $this->view->render('index', 'index', ['users' => Users::find()]);
    }

    public function route404Action() {
        $this->response->setHeader('HTTP/1.0 404','Not Found');
        $this->view->pick('error/404');
    }
}
