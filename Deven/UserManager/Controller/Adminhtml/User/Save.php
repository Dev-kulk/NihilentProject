<?php
namespace Deven\UserManager\Controller\Adminhtml\User;

use Magento\Backend\App\Action;
use Magento\Framework\App\Request\DataPersistorInterface;
use Deven\UserManager\Model\UserFactory;

class Save extends Action
{
    const ADMIN_RESOURCE = 'Deven_UserManager::save';

    protected $userFactory;
    protected $dataPersistor;

    public function __construct(
        Action\Context $context,
        UserFactory $userFactory,
        DataPersistorInterface $dataPersistor
    ) {
        parent::__construct($context);
        $this->userFactory = $userFactory;
        $this->dataPersistor = $dataPersistor;
    }

    public function execute()
    {
        $data = (array)$this->getRequest()->getPostValue();
        if (!$data) {
            return $this->_redirect('usermanager/user/index');
        }

        try {
            $id = isset($data['user_id']) ? (int)$data['user_id'] : 0;
            /** @var \Deven\UserManager\Model\User $model */
            $model = $this->userFactory->create();
            if ($id) {
                $model->load($id);
                if (!$model->getId()) {
                    $this->messageManager->addErrorMessage(__('User no longer exists.'));
                    return $this->_redirect('usermanager/user/index');
                }
            }
            $model->setData('name', $data['name'] ?? '');
            $model->setData('email', $data['email'] ?? '');
            $model->save();

            $this->messageManager->addSuccessMessage(__('User saved successfully.'));
            $this->dataPersistor->clear('deven_usermanager_user');

            if ($this->getRequest()->getParam('back')) {
                return $this->_redirect('usermanager/user/edit', ['user_id' => $model->getId()]);
            }
            return $this->_redirect('usermanager/user/index');
        } catch (\Throwable $e) {
            $this->messageManager->addErrorMessage($e->getMessage());
            $this->dataPersistor->set('deven_users', $data);
            $id = $data['user_id'] ?? null;
            return $this->_redirect('usermanager/user/edit', ['user_id' => $id]);
        }
    }
}
