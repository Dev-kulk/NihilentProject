<?php
namespace Deven\SignUpApi\Model;

use Magento\Framework\Model\AbstractModel;

class SignUp extends AbstractModel
{
    protected function _construct()
    {
        $this->_init(\Deven\SignUpApi\Model\ResourceModel\SignUp::class);
    }
}
