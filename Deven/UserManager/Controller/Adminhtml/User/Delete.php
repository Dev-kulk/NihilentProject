<?php
namespace Deven\UserManager\Controller\Adminhtml\User;

use Magento\Backend\App\Action;
use Deven\UserManager\Model\UserFactory;

class Delete extends Action
{
    const ADMIN_RESOURCE = 'Deven_UserManager::delete';

    protected $userFactory;

    public function __construct(Action\Context $context, UserFactory $userFactory)
    {
        parent::__construct($context);
        $this->userFactory = $userFactory;
    }

    public function execute()
    {
        $id = (int)$this->getRequest()->getParam('user_id');
        if (!$id) {
            $this->messageManager->addErrorMessage(__('No User ID provided.'));
            return $this->_redirect('usermanager/user/index');
        }

        try {
            $model = $this->userFactory->create()->load($id);
            if (!$model->getId()) {
                $this->messageManager->addErrorMessage(__('User no longer exists.'));
            } else {
                $model->delete();
                $this->messageManager->addSuccessMessage(__('User deleted.'));
            }
        } catch (\Throwable $e) {
            $this->messageManager->addErrorMessage($e->getMessage());
        }

        return $this->_redirect('usermanager/user/index');
    }
}
