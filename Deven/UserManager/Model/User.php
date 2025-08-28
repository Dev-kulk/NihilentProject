<?php
namespace Deven\UserManager\Model;

use Magento\Framework\Model\AbstractModel;

class User extends AbstractModel
{
    protected function _construct()
    {
        $this->_init(\Deven\UserManager\Model\ResourceModel\User::class);
    }
}
