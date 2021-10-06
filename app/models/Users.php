<?php
namespace Phalconvn\Models;

use Phalcon\Mvc\Model;
use Phalcon\Paginator\Adapter\Model as PaginatorModel;
use Phalcon\Validation;
use Phalcon\Validation\Validator\Email as EmailValidator;
use Phalcon\Validation\Validator\Uniqueness as UniquenessValidator;
use Phalcon\Validation\Validator\StringLength as StringLength;

class Users extends Model
{
    public $id;
    public $name;
    public $email;
    public $password;
    public $active;
    public $banned;
    public $suspended;

    public function validation()
    {
        $validator = new Validation();

        $validator->add(
            'email',
            new EmailValidator([
                'model' => $this,
                'message' => 'Please enter a correct email address'
            ])
        );

        $validator->add(
            'name',
            new UniquenessValidator([
                'model' => $this,
                'message' => 'Sorry, That username is already taken',
            ])
        );

        $validator->add(
            'email',
            new UniquenessValidator([
                'message' => 'Sorry, That email is already taken',
            ])
        );

        $validator->add(
            'email',
            new StringLength(
                array(
                    'model' => $this,
                    'min' => 4,
                    'max' => 30,
                    'minMessage' => 'Your password must be at least 4 characters',
                    'maxMessage' => 'Your password must be less than 30 characters'
                )
            )
        );

        return $this->validate($validator);
    }

    /**
     * Before create the user assign a password
     */
    public function beforeValidationOnCreate()
    {
        if (empty($this->password)) {

            //Generate a plain temporary password
            $tempPassword = preg_replace('/[^a-zA-Z0-9]/', '', base64_encode(openssl_random_pseudo_bytes(12)));

            //The user must change its password in first login
            $this->mustChangePassword = 'Y';

            //Use this password as default
            $this->password = $this->getDI()->getSecurity()->hash($tempPassword);

        } else {
            //The user must not change its password in first login
            $this->mustChangePassword = 'N';

        }

        //The account must be confirmed via e-mail
        $this->active = 'Y';

        //The account is not suspended by default
        $this->suspended = 'N';

        //The account is not banned by default
        $this->banned = 'N';

    }

    /**
     * Send a confirmation e-mail to the user if the account is not active
     */
    public function afterSave()
    {
        if ($this->active == 'N') {

            $emailConfirmation = new EmailConfirmations();

            $emailConfirmation->usersId = $this->id;

            if ($emailConfirmation->save()) {
                $this->getDI()->getFlash()->notice(
                    'A confirmation mail has been sent to ' . $this->email
                );
            }
        }
    }

    /**
     * Validate that emails are unique across users
     */
    /*public function validation()
    {

        $this->validate(new Uniqueness(
            array(
                "field"   => "email",
                "message" => "E-mail đã tồn tại!"
            )
        ));
        if ($this->validationHasFailed() == true) {
            return false;
        }
        //return $this->validationHasFailed() != true;
    }*/

    public function initialize()
    {

        /*$this->belongsTo('profilesId', __NAMESPACE__ . '\Profiles', 'id', array(
            'alias' => 'profile',
            'reusable' => true
        ));*/
        /*$this->hasMany('id', __NAMESPACE__ . '\Posts', 'userId', array(
            'alias' => 'posts',
            'foreignKey' => array(
                'message' => 'User cannot be deleted because article has not for '
            )
        ));*/
        $this->hasMany('id', __NAMESPACE__ . '\SuccessLogins', 'usersId', array(
            'alias' => 'successLogins',
            'foreignKey' => array(
                'message' => 'User acannot be deleted because he/she has activity in the system'
            )
        ));


        $this->hasMany('id', __NAMESPACE__ . '\PasswordChanges', 'usersId', array(
            'alias' => 'passwordChanges',
            'foreignKey' => array(
                'message' => 'User cannot be deleted because he/she has activity in the system'
            )
        ));

        $this->hasMany('id', __NAMESPACE__ . '\ResetPasswords', 'usersId', array(
            'alias' => 'resetPasswords',
            'foreignKey' => array(
                'message' => 'User cannot be deleted because he/she has activity in the system'
            )
        ));
    }

    public function getList($params)
    {
        $orderby = $params['orderby'] ?: 'id';
        $order = $params['order'] ?: 'ASC';
        $page = (int) ($params['page'] ?: 1);
        $limit = $params['limit'] ?: 10;

        return Users::find([
            'order' => $orderby . ' ' . $order,
            'limit'=> $limit
        ]);
    }
}
