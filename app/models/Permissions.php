<?php

namespace Phalconvn\Models;

use Phalcon\Mvc\Model;

/**
 * Permissions
 *
 * Stores the permissions by profile
 */
class Permissions extends Model
{
    /**
     * @var integer
     */
    public $id;

    /**
     * @var string
     */
    public $action;

    /*public function initialize()
    {
        $this->belongsTo('userId', __NAMESPACE__ . '\Users', 'id', array(
            'alias' => 'user'
        ));
    }*/

    public function getList($params)
    {
        $orderby = $params['orderby'] ?: 'id';
        $order = $params['order'] ?: 'ASC';
        $page = (int) ($params['page'] ?: 1);
        $limit = $params['limit'] ?: 10;

        return Permissions::find([
            'order' => $orderby . ' ' . $order,
            'limit'=> $limit
        ]);
    }

    public function getUserPermissions($params)
    {
        $orderby = $params['orderby'] ?: 'id';
        $order = $params['order'] ?: 'ASC';
        $page = (int) ($params['page'] ?: 1);
        $limit = $params['limit'] ?: 10;

        return Permissions::find([
            'order' => $orderby . ' ' . $order,
            'limit'=> $limit
        ]);
    }
}