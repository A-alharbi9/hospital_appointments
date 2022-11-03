<?php

$siteData = [
    'siteName' => 'hospital',
    'pageTitle' => array(
        'home' => 'home',
        'sign up' => 'sign up',
        'sign in' => 'sign in',
        'dashboard' => 'dashboard'
    ),
    'navItems' => array(
        'home' => 'home',
        'sign up' => 'sign up',
        'sign in' => 'sign in',
        'dashboard' => 'dashboard'
    ),
];

function pageTitle($title = 'home')
{
    global $siteData;

    if (in_array($title, $siteData['pageTitle'])) {

        echo ucwords($siteData['pageTitle'][strtolower($title)] . ' | ' . $siteData['siteName']);
    }
}