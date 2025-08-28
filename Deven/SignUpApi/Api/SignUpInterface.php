<?php
namespace Deven\SignUpApi\Api;

interface SignUpInterface
{
    /**
     * Register user
     *
     * @param string $name
     * @param string $email
     * @param string $password
     * @param string $address
     * @param string $user_type
     * @param string $product_type
     * 
     * @return array
     */
    public function register($name, $email, $password,$address,$user_type,$product_type);

     /**
     * Login user
     *
     * @param string $email
     * @param string $password
     * @return string
     */
    public function login($email, $password);
}
