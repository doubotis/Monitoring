<?php

function base64_to_jpeg( $base64_string, $output_file ) {
    $ifp = fopen( $output_file, "wb" ); 
    $data = base64_decode( $base64_string);
    fwrite( $ifp, $data ); 
    fclose( $ifp ); 
    return( $output_file ); 
}


?>