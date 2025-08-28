<?php
namespace Deven\SignUpApi\Api;

interface LoginInterface
{
    /**
     * Login user
     *
     * @param string $email
     * @param string $password
     * @return array
     */
    public function login($email, $password);
}
