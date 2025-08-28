<?php
namespace Deven\SignUpApi\Model;

use Deven\SignUpApi\Api\SignUpInterface;
use Deven\SignUpApi\Model\SignUpFactory;
use Deven\SignUpApi\Model\ResourceModel\SignUp as SignUpResource;
use Deven\SignUpApi\Model\ResourceModel\SignUp\CollectionFactory as SignUpCollectionFactory;
use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Framework\Exception\InputException;

class SignUpManagement implements SignUpInterface
{
    protected $signUpFactory;
    protected $signUpResource;
    protected $signUpCollectionFactory;

    public function __construct(
        SignUpFactory $signUpFactory,
        SignUpResource $signUpResource,
        SignUpCollectionFactory $signUpCollectionFactory
    ) {
        $this->signUpFactory = $signUpFactory;
        $this->signUpResource = $signUpResource;
        $this->signUpCollectionFactory = $signUpCollectionFactory;
    }

    // --- Register API ---
    public function register($name, $email, $password, $address = null, $user_type = null, $product_type = null)
    {
        try {
            if (!preg_match('/^[a-zA-Z\s]+$/', $name)) {
                throw new InputException(__('Invalid Name: Only alphabets are allowed.'));
            }
            if (!preg_match('/^[a-zA-Z0-9._%+-]+@gmail\.com$/', $email)) {
                throw new InputException(__('Invalid Email: Only Gmail addresses are allowed.'));
            }
            if (strlen($password) < 10) {
                throw new InputException(__('Invalid Password: Minimum 10 characters.'));
            }

            $collection = $this->signUpCollectionFactory->create();
            $collection->addFieldToFilter('name', $name)
                       ->addFieldToFilter('email', $email)
                       ->addFieldToFilter('address', $address)
                       ->addFieldToFilter('user_type', $user_type)
                       ->addFieldToFilter('product_type', $product_type);

            if ($collection->getSize() > 0) {
                throw new InputException(__('User with same details already exists.'));
            }

            $signUp = $this->signUpFactory->create();
            $signUp->setData([
                'name'         => $name,
                'email'        => $email,
                'password'     => password_hash($password, PASSWORD_BCRYPT),
                'address'      => $address,
                'user_type'    => $user_type,
                'product_type' => $product_type
            ]);

            $this->signUpResource->save($signUp);

            return "User registered successfully with ID: " . $signUp->getId();

        } catch (InputException $e) {
            throw $e;
        } catch (\Exception $e) {
            throw new CouldNotSaveException(__("Could not save user: " . $e->getMessage()));
        }
    }

    // --- Login API ---
    public function login($email, $password)
    {
        if (!preg_match('/^[a-zA-Z0-9._%+-]+@gmail\.com$/', $email)) {
            throw new InputException(__('Invalid Email: Only Gmail addresses are allowed.'));
        }
        if (strlen($password) < 10) {
            throw new InputException(__('Invalid Password: Minimum 10 characters.'));
        }

        $collection = $this->signUpCollectionFactory->create();
        $collection->addFieldToFilter('email', $email);

        if ($collection->getSize() === 0) {
            throw new InputException(__('User not found.'));
        }

        $user = $collection->getFirstItem();
        if (!password_verify($password, $user->getPassword())) {
            throw new InputException(__('Incorrect password.'));
        }

        return "Login successful for user: " . $user->getName();
    }
}
