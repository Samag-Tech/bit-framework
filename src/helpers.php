<?php

if ( ! function_exists('prd') ) {
    function prd($var) {
        echo "<pre>";
        print_r($var);
        echo "</pre>";
        die;
    }
}