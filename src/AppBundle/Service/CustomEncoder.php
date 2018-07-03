<?php
/**
 * Created by PhpStorm.
 * User: wilder
 * Date: 15/06/18
 * Time: 16:19
 */

namespace AppBundle\Service;


use Symfony\Component\Security\Core\Encoder\PasswordEncoderInterface;

class CustomEncoder implements PasswordEncoderInterface
{

    public function encodePassword( $raw, $salt ) {
        //do not use salt here
        return sha1($raw);
    }

    public function isPasswordValid( $encoded, $raw, $salt ) {
        return $encoded === $this->encodePassword( $raw, $salt );
    }
}