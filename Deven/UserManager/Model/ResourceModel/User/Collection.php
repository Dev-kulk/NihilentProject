<?php
namespace Deven\UserManager\Model\ResourceModel\User;

use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;
use Deven\UserManager\Model\User as Model;
use Deven\UserManager\Model\ResourceModel\User as ResourceModel;

class Collection extends AbstractCollection
{
    protected function _construct()
    {
        $this->_init(Model::class, ResourceModel::class);
    }
}
