<?php

if( isset( $_POST[ 'Submit' ] ) ) {
        // Get input
        $target = $_REQUEST[ 'ip' ];

        // Validate that the input is a valid IP address
        if( filter_var( $target, FILTER_VALIDATE_IP ) === false ) {
                $html .= '<pre>ERROR: You have entered an invalid IP address.</pre>';
        }
        else {
                // Escape the validated argument before passing it to the shell
                $safe_target = escapeshellarg( $target );

                // Determine OS and execute the ping command.
                if( stristr( php_uname( 's' ), 'Windows NT' ) ) {
                        // Windows
                        $cmd = shell_exec( 'ping ' . $safe_target );
                }
                else {
                        // *nix
                        $cmd = shell_exec( 'ping -c 4 ' . $safe_target );
                }

                // Feedback for the end user
                $html .= "<pre>{$cmd}</pre>";
        }
}

?>
