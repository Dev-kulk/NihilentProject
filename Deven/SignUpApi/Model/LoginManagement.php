<?php
namespace Deven\SignUpApi\Model;

use Deven\SignUpApi\Api\LoginInterface;
use Deven\SignUpApi\Model\SignUpFactory;
use Deven\SignUpApi\Model\ResourceModel\SignUp\CollectionFactory as SignUpCollectionFactory;
use Magento\Framework\Exception\LocalizedException;

class LoginManagement implements LoginInterface
{
    protected $signUpCollectionFactory;

    public function __construct(
        SignUpCollectionFactory $signUpCollectionFactory
    ) {
        $this->signUpCollectionFactory = $signUpCollectionFactory;
    }

    /**
     * Login user
     */
    public function login($email, $password)
    {
        // ✅ Validate Email (must be gmail.com)
        if (!preg_match('/^[a-zA-Z0-9._%+-]+@gmail\.com$/', $email)) {
            throw new LocalizedException(__('Invalid Email: Only Gmail addresses are allowed.'));
        }

        // ✅ Validate Password length
        if (strlen($password) < 10) {
            throw new LocalizedException(__('Invalid Password: Must be at least 10 characters.'));
        }

        $collection = $this->signUpCollectionFactory->create();
        $collection->addFieldToFilter('email', $email);

        if ($collection->getSize() === 0) {
            throw new LocalizedException(__('User does not exist.'));
        }

        $user = $collection->getFirstItem();
        $hashedPassword = $user->getPassword();

        if (!password_verify($password, $hashedPassword)) {
            throw new LocalizedException(__('Invalid Password.'));
        }

        // ✅ Success: return user info (except password)
        return [
            'id'           => $user->getId(),
            'name'         => $user->getName(),
            'email'        => $user->getEmail(),
            'address'      => $user->getAddress(),
            'user_type'    => $user->getUserType(),
            'product_type' => $user->getProductType()
        ];
    }
}
