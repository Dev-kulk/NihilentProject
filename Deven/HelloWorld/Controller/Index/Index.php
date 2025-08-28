<?php
namespace Deven\HelloWorld\Controller\Index;

use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;
use Magento\Framework\Controller\ResultInterface;

class Index extends Action
{
    public function __construct(Context $context)
    {
        parent::__construct($context);
    }

    public function execute(): ResultInterface
    {
        // Direct output, no layout/template
        echo "Hello World! 🎉 from my first simple Magento module";
        exit;
    }
}
