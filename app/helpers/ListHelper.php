<?php
namespace Phalconvn\Helpers;

class ListHelper extends \Phalcon\DI\Injectable{
    public function getSortLink($name){
        //$request = new Phalcon\Http\Request();
        $di     = new \Phalcon\DI\FactoryDefault();
        $this->request->setDI($di);
        $order = $this->request->getQuery('order', 'string', 'ASC');
        $orderby = $this->request->getQuery('orderby', 'string', NULL);
        if($name == $orderby) {
            return ($order == 'ASC') ? '?orderby='.$orderby.'&order=DESC' : '?orderby='.$orderby.'&order=ASC';
        } else {
            return '?orderby='.$name.'&order=ASC';
        }
    }
}