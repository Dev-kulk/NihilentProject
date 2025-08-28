<?php
namespace Deven\UserManager\Controller\Adminhtml\User;

use Magento\Backend\App\Action;
use Magento\Framework\View\Result\PageFactory;

class Edit extends Action
{
    const ADMIN_RESOURCE = 'Deven_UserManager::save';

    protected $resultPageFactory;

    public function __construct(Action\Context $context, PageFactory $resultPageFactory)
    {
        parent::__construct($context);
        $this->resultPageFactory = $resultPageFactory;
    }

    public function execute()
    {
        $id = (int)$this->getRequest()->getParam('user_id');
        $resultPage = $this->resultPageFactory->create();
        $title = $id ? __('Edit User') : __('Add User');
        $resultPage->getConfig()->getTitle()->prepend($title);
        return $resultPage;
    }
}
