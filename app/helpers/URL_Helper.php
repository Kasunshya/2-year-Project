<?php
// Redirect to a different page
function redirect($url)
{
    header('Location: ' . URLROOT . '/' . $url);
    exit();
}
?>