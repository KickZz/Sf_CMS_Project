<?php

namespace SfCmsProject\CmsBundle\Services;



class SaltRandom
{

    public function randSalt() {
        $chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
        $size = strlen( $chars );
        $str= '';
        for( $i = 0; $i < 16; $i++ ) {
            $str .= $chars[ rand( 0, $size - 1 ) ];
        }
        return $str;
    }
}
