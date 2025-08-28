<?php
namespace Deven\UserManager\Model\ResourceModel;

use Magento\Framework\Model\ResourceModel\Db\AbstractDb;

class User extends AbstractDb
{
    protected function _construct()
    {
        $this->_init('deven_users', 'user_id');
    }
}
