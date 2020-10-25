<?php
/**
 * This file builds scaffolder templates for the pressmind web-core sdk installer. it's for theme-development only
 */
$files = [];
$files[] = ['Reise_Detail1.php', 'scaffolder/Detail1.txt'];
$files[] = ['Reise_Teaser1.php', 'scaffolder/Teaser1.txt'];

foreach($files as $file){
    $c = file_get_contents($file[0]);
    $c = str_replace(['Custom\MediaType\Reise'], ['Custom\MediaType\###CLASSNAME###'], $c);
    file_put_contents($file[1], $c);
}
