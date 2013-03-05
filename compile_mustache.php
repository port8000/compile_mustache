#!/usr/bin/env php
<?php

require __DIR__.'/vendor/mustache/mustache/src/Mustache/Autoloader.php';
Mustache_Autoloader::register();


class partials implements Mustache_Loader {
    /**
    * return the template code of a partial located in templates/partials/
    */
    public function load($name) {
        return file_get_contents(sprintf('templates/partials/%s.mustache',
                                         $name));
    }
}


if (count($argv) < 2) {
  fwrite(STDERR, "usage: compile_templates template.mustache [data.json]\n");
  exit(1);
}
$template = file_get_contents($argv[1]);
if ($template === FALSE) {
  fwrite(STDERR, "usage: compile_templates template.mustache [data.json]\n");
  exit(1);
}


if (count($argv) > 2) {
    $view = json_decode(file_get_contents($argv[2]), true);
} else {
    $view = array();
}


$mustache = new Mustache_Engine(array(
    "partials_loader" => new partials()
));

fwrite(STDOUT, $mustache->render(file_get_contents($argv[1]), $view));
