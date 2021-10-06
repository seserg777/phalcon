<?php namespace Phalconvn\Models;

use Phalcon\Mvc\Model;

/**
 * FailedLogins
 *
 * This model registers unsuccessfull logins registered and non-registered users have made
 */
class FailedLogins extends Model
{
    /**
     * @var integer
     */
    public $id;

    /**
     * @var integer
     */
    public $usersId;

    /**
     * @var string
     */
    public $ipAddress;

    /**
     * @var integer
     */
    public $attempted;

    public function initialize()
    {
        $this->belongsTo('usersId', 'Phalconvn\Models\Users', 'id', array(
            'alias' => 'user'
        ));
    }

}
