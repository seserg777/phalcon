<?php
namespace Phalconvn\Controllers;
use Phalcon\Mvc\Controller;
use Phalconvn\Models\Permissions;
use Phalcon\Paginator\Adapter\Model as PaginatorModel;
use Phalconvn\Helpers\ListHelper;

class PermissionsController extends Controller
{
    public function indexAction()
    {
        $currentPage = $this->request->getQuery('page', 'int', 1);
        $paginator   = new PaginatorModel(
            [
                'model'  => Permissions::class,
                'limit' => 10,
                'page'  => $currentPage,
            ]
        );
        $page = $paginator->paginate();
        $this->view->setVar('page', $page);
        $model = new Permissions();
        $params = $this->request->getQuery();

        $this->view->setVar('permissions', $model->getList($params));
        $this->view->setVar('order', $this->request->getQuery('order', 'string', NULL));
        $this->view->setVar('orderby', $this->request->getQuery('orderby', 'string', NULL));
        $this->view->setVar('listHelper', new ListHelper());
        $this->metatag->setTitle("List of permissions");
        $this->view->pick('user/permissions');
    }
}