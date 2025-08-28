<?php
namespace Deven\SignUpApi\Model\ResourceModel\SignUp;

use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;
use Deven\SignUpApi\Model\SignUp as SignUpModel;
use Deven\SignUpApi\Model\ResourceModel\SignUp as SignUpResource;

class Collection extends AbstractCollection
{
    protected function _construct()
    {
        $this->_init(SignUpModel::class, SignUpResource::class);
    }
}
