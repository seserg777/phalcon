<?php
namespace Phalconvn\Controllers;
use Phalcon\Mvc\Controller;
use Phalcon\Mvc\Model\Validator\Email;
use Phalconvn\Forms\SignUpForm;
use Phalconvn\Forms\LoginForm;
use Phalconvn\Forms\UserForm;
use Phalconvn\Auth\Auth;
use Phalconvn\Auth\Exception as AuthException;
use Phalconvn\Models\Users;

class UserController extends Controller
{
    /**
     * Show form to register a new user
     */
    public function indexAction()
    {
        $form = new SignUpForm(null);
        $this->view->form = $form;
        $this->metatag->setTitle("Register");
        $this->view->pick('user/register');
    }

    /**
     * Register new user and show message
     */
    public function registerAction()
    {
        $form = new SignUpForm(null);
        $request = $this->request;

        if ($request->isPost()) {
            if ($form->isValid($request->getPost()) != false) {
                $user = new Users();
                $user->name = $request->getPost('username', 'striptags');
                $user->email = $request->getPost('email', 'striptags');
                $user->password = $this->security->hash($request->getPost('password'));
                if ($user->save()) {
                    return $this->dispatcher->forward(array(
                        'controller' => 'index',
                        'action' => 'index'
                    ));
                }

                //$this->flash->error($form->getMessages());
                $form->getMessages();
            }
        }
        /*$user = new Users();
        $user->name = $this->request->getPost('name', 'string', NULL);
        $user->email = $this->request->getPost('email', 'email', NULL);


        if ($user->save()) {
            $this->view->success = true;
            $message = "Thanks for registering!";
        } else {
            $message = "Sorry, the following problems were generated:<br>" . implode('<br>', $user->getMessages());
        }

        $this->view->message = $message;*/
        $this->view->form = $form;
        $this->view->pick('user/register');
    }

    public function loginAction()
    {
        $form = new LoginForm(null);

        if ($this->request->isPost()) {
            try {
                /*$identity = $this->auth->getIdentity();
                if (!$request->isPost()) {
                    if ($this->auth->hasRememberMe()) {
                        return $this->auth->loginWithRememberMe();
                    }
                    //check if login without check remember
                    if (is_array($identity)) {
                        return $this->response->redirect('/');
                    }
                } else {*/
                    if ($form->isValid($this->request->getPost()) == true) {
                        $check = $this->auth->check(array(
                            'email' => $this->request->getPost('email'),
                            'password' => $this->request->getPost('password'),
                            'remember' => $this->request->getPost('remember')
                        ));
                        if($check){
                            return $this->response->redirect('/');
                        } else {
                            $this->view->form = $form;
                            $this->view->pick('user/login');
                        }
                    } else {
                        $this->flash->error('your login data is wrong');
                        $this->view->form = $form;
                        $this->view->pick('user/login');
                    }
                /*}*/
            } catch (AuthException $e) {
                $this->flash->error($e->getMessage());
            }
        } else {
            $this->metatag->setTitle("Login");
            $this->view->form = $form;
            $this->view->pick('user/login');
        }
    }

    public function logoutAction()
    {
        $this->auth->remove();

        return $this->response->redirect('/');
    }

    public function editAction($id) {
        $user = Users::findFirstById($id);
        if (!$user) {
            $this->flash->error("User was not found");
            return $this->dispatcher->forward(array('action' => 'index'));
        }

        if ($this->request->isPost()) {
            $user->assign(array(
                'name' => $this->request->getPost('name', 'striptags'),
                'email' => $this->request->getPost('email', 'email'),
                //'banned' => $user->banned,
                //'suspended' => $this->request->getPost('suspended'),
                //'active' => $user->active
            ));

            if (!$user->save()) {
                foreach($user->getMessages() as $msg){
                    $this->flash->error($msg->getMessage());
                }
            } else {
                $this->flash->success("User was updated successfully");
                //Tag::resetInput();
            }
        } else {

        }

        $this->metatag->setTitle("Edit user");
        $form = new SignUpForm($user, array('edit' => true));
        $this->view->form = $form;
        $this->view->setVar('user', $this->auth->getUser());
        $this->view->pick('user/edit');
    }

    public function editPermissionsAction($id) {
        $this->view->pick('user/edit_permissions');
    }
}
