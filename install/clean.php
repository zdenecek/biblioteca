<?php
function rrmdir($dir) {
    if (is_dir($dir)) {
        $objects = scandir($dir);
        foreach ($objects as $object) {
            if ($object != "." && $object != "..") {
                if (filetype($dir."/".$object) == "dir")
                rrmdir($dir."/".$object);
                else unlink($dir."/".$object);
            }
        }
        reset($objects);
        rmdir($dir);
    }
}

function clean($dir){
    if (is_dir($dir)) {
        $objects = scandir($dir);
        foreach ($objects as $object) {
            if ($object != "." && $object != "..") {
                if (filetype($dir."/".$object) == "dir")
                rrmdir($dir."/".$object);
                elseif($object == 'clean.php' or $object == 'install.php')
                    continue;
                else unlink($dir."/".$object);
            }
        }
        reset($objects);
    }
}
clean(getcwd());
