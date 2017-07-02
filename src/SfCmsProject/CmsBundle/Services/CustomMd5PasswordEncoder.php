<?php
namespace SfCmsProject\CmsBundle\Services;

use Symfony\Component\Security\Core\Encoder\PasswordEncoderInterface;

class CustomMd5PasswordEncoder implements PasswordEncoderInterface
{
    public function __construct() {

    }

    public function encodePassword($raw, $salt) {

    return md5($salt.$raw);

    }

    public function isPasswordValid($encoded, $raw, $salt) {

    return md5($salt.$raw) == $encoded;

    }
}
