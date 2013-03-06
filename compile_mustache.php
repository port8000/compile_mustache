#!/usr/bin/env php
<?php

require __DIR__.'/vendor/mustache/mustache/src/Mustache/Autoloader.php';
Mustache_Autoloader::register();


class partials implements Mustache_Loader {

    public $partials_root = "templates/partials";

    /**
    * return the template code of a partial located in templates/partials/
    */
    public function load($name) {
        $tpl = sprintf('%s/%s.mustache', $this->partials_root, $name);
        if (is_file($tpl)) {
            return file_get_contents($tpl);
        } else {
            fwrite(STDERR, "Couldn't find partial $name\n");
            return '';
        }
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
