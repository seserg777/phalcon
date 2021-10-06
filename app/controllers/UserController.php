<?php
namespace Phalconvn\Controllers;
use Phalcon\Mvc\Controller;
use Phalcon\Mvc\Model\Validator\Email;
use Phalconvn\Forms\SignUpForm;
use Phalconvn\Forms\LoginForm;
use Phalconvn\Auth\Auth;
use Phalconvn\Auth\Exception as AuthException;

class UserController extends Controller
{
    /**
     * Show form to register a new user
     */
    public function indexAction()
    {
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
        //var_dump('get');exit;
        $form = new SignUpForm(null);
        $this->view->form = $form;
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
                        $this->auth->check(array(
                            'email' => $this->request->getPost('email'),
                            'password' => $this->request->getPost('password'),
                            'remember' => $this->request->getPost('remember')
                        ));
                        return $this->response->redirect('/');
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
            $this->view->form = $form;
            $this->view->pick('user/login');
        }
    }

    public function logoutAction()
    {
        $this->auth->remove();

        return $this->response->redirect('/');
    }

    public function editAction() {
        if ($this->request->isPost()) {

        } else {

        }
        $this->view->pick('user/edit');
    }
}
