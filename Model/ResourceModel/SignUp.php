<?php
namespace Deven\SignUpApi\Model\ResourceModel;

use Magento\Framework\Model\ResourceModel\Db\AbstractDb;

class SignUp extends AbstractDb
{
    protected function _construct()
    {
        $this->_init('deven_signup', 'signup_id'); 
        // Table name, Primary key
    }
}
