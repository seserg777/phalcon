<?php

namespace Phalconvn\Forms;

use Phalcon\Forms\Form,
    Phalcon\Forms\Element\Text,
    Phalcon\Forms\Element\Password,
    Phalcon\Forms\Element\Submit,
    Phalcon\Forms\Element\Check,
    Phalcon\Forms\Element\Hidden,
    Phalcon\Validation\Validator\PresenceOf,
    Phalcon\Validation\Validator\Email,
    Phalcon\Validation\Validator\Identical,
    Phalcon\Validation\Validator\Callback;

class LoginForm extends Form
{

    public function initialize()
    {
        $email = new Text('email', ['placeholder' => 'Email', 'class' => 'form-control']);
        $email->addValidators(array(
            new PresenceOf(array(
                'message' => 'e-mail is required'
            )),
            new Email(array(
                'message' => 'invalid email format'
            ))
        ));
        $this->add($email);


        $password = new Password('password', ['placeholder' => 'Password', 'class' => 'form-control']);
        $password->addValidator(
            new PresenceOf(array(
                'message' => 'password is wrong'
            ))
        );
        $this->add($password);

        $remember = new Check('remember', array(
            'value' => 'yes'
        ));
        $remember->setLabel('Remember me');
        $this->add($remember);

        $csrf = new Hidden('csrf');
        $csrf->addValidator( new Callback(
            [
                "message" => "CSRF validation failed",
                "callback" => $this->security->checkToken()
            ]
        ));
        $this->add($csrf);
        $this->add(new Submit('Login', array(
            'class' => 'btn btn-success'
        )));
    }
    /**
     * Prints messages for a specific element
     */
    public function messages($name)
    {
        if ($this->hasMessagesFor($name)) {
            foreach ($this->getMessagesFor($name) as $message) {
                $this->flash->error($message);
            }
        }
    }

    public function getCsrf()
    {
        return $this->security->getToken();
    }
}