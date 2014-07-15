<?php
    
    function createSessionIfNeeded()
    {
        session_start();
    }
    
    function destroySessionIfNeeded()
    {
        session_destroy();
    }
?>