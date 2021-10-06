<?php

use Phalcon\Mvc\Controller;

class UserController extends Controller
{

    public function registrationAction()
    {
        $this->view->pick("signup/index");
        /*$username = $this->request->getPost('username');
        $pass= $this->request->getPost('password');
        $user=User::findFirstByUsername($username);
        if ($user) {
            if ($this->security->checkHash($pass, $user->getpassword())) {
                $this->session->set('auth',
                    ['userName' => $user->getusername(),
                        'role' => $user->getRole()]);
                $this->session->set('user',$user);
                $this->flash->success("Welcome back " . $user->getusername());
                return $this->dispatcher->forward(["controller" => "member","action" => "search"]);
            }
            else {
                $this->flash->error("Your password is incorrect - try again");
                return $this->dispatcher->forward(["controller" => "user","action" => "login"]);
            }
        }
        else {
            $this->flash->error("That username was not found - try again");
            return $this->dispatcher->forward(["controller" => "user","action" => "login"]);
        }
        return $this->dispatcher->forward(["controller" => "index","action" => "index"]);*/
    }

    public function loginAction()
    {
        $this->view->pick("login/index");
    }

    public function logoutAction()
    {
        $this->session->destroy();
        return $this->dispatcher->forward(["controller" => "member","action" => "search"]);
    }
}
