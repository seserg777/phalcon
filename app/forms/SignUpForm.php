<?php namespace Phalconvn\Forms;

use Phalcon\Forms\Form,
    Phalcon\Forms\Element\Text,
    Phalcon\Forms\Element\Select,
    Phalcon\Forms\Element\Date,
    Phalcon\Forms\Element\Numeric,
    Phalcon\Forms\Element\Hidden,
    Phalcon\Forms\Element\Password,
    Phalcon\Forms\Element\Submit,
    Phalcon\Forms\Element\File,
    Phalcon\Forms\Element\Check,
    Phalcon\Validation\Validator\PresenceOf,
    Phalcon\Validation\Validator\email,
    Phalcon\Validation\Validator\Regex,
    Phalcon\Validation\Validator\Identical,
    Phalcon\Validation\Validator\StringLength,
    Phalcon\Validation\Validator\Confirmation,
    Phalcon\Validation\Validator\Callback;

class SignUpForm extends Form
{

    public function initialize($entity=null, $options=null)
    {
        if (isset($options['edit']) && $options['edit']) {
            $id = new Hidden('id');
        } else {
            $id = new Text('id');
        }

        $username = new Text('username', ['placeholder' =>'username', 'class' => 'form-control']);
        $username->setLabel('username');
        $username->addValidators(array(
            new PresenceOf(array(
                'message' => 'username is required'
            ))
        ));
        $this->add($username);

        $email = new Text('email', ['placeholder' =>'e-mail', 'class' => 'form-control']);
        $email->setLabel('e-mail');
        $email->setFilters('email');
        $email->addValidators(array(
            new PresenceOf(array(
                'message' => 'e-mail is required'
            ))
        ));
        $this->add($email);

        $password = new Password('password', ['class' => 'form-control']);
        $password->setLabel('password');
        $password->addValidators(array(
            new PresenceOf(array(
                'message' => 'password is required'
            )),
            new StringLength(array(
                'min' => 8,
                'messageMinimum' => 'password min length 8 symbols'
            )),
            new Confirmation(array(
                'message' => 'both passwords must match',
                'with' => 'confirmPassword'
            ))
        ));
        $this->add($password);

        $confirmPassword = new Password('confirmPassword', ['class' => 'form-control']);
        $confirmPassword->setLabel('confirm password');
        $confirmPassword->addValidators(array(
            new PresenceOf(array(
                'message' => 'The confirmation password is required'
            ))
        ));
        $this->add($confirmPassword);

        $terms = new Check('terms', ['value' => 'yes']);
        $terms->setLabel('accept the terms');
        $terms->addValidator(
            new Identical(array(
                'value' => 'yes',
                'message' => 'you must accept the terms'
            ))
        );
        $this->add($terms);

        $csrf = new Hidden('csrf');
        /*$csrf->addValidator(
            new Identical(array(
                'value' => $this->security->getToken(),
                'message' => 'CSRF validation failed'
            ))
        );*/
        $csrf->addValidator( new Callback(
            [
                "message" => "CSRF validation failed",
                "callback" => $this->security->checkToken()
            ]
        ));
        $this->add($csrf);

        $this->add(new Submit('Sign Up', ['class' => 'btn btn-primary pull-right']));
    }

    /**
     * Prints messages for a specific element
     */
    public function messages($username)
    {
        if ($this->hasMessagesFor($username)) {
            foreach ($this->getMessagesFor($username) as $message) {
                $this->flash->error($message);
            }
        }
    }

    public function getCsrf()
    {
        return $this->security->getToken();
    }
}