<?php 
function Validate($page, $total_pages)
{
    if ($page>=1 && $page <= $total_pages) {
        return true;
    } else {
        return false;
    }
}


?>