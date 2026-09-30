<?php

// Default to the main File Inclusion page
$file = 'include.php';

// Allow only approved pages
switch( $_GET[ 'page' ] ?? '' ) {
        case 'file1.php':
                $file = 'file1.php';
                break;

        case 'file2.php':
                $file = 'file2.php';
                break;

        case 'file3.php':
                $file = 'file3.php';
                break;

        case 'include.php':
                $file = 'include.php';
                break;

        default:
                $file = 'include.php';
                break;
}

?>
