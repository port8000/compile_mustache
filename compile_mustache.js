#!/usr/bin/env node
/**
 * Render a Mustache template, optionally populated with JSON data
 */


var Mustache = require('mustache');
var fs = require('fs');
var view = {};
var partials_root = 'templates/partials';

try {
  var template = fs.readFileSync(process.argv[2], 'utf-8');
} catch (e) {
  process.stderr.write("usage: compile_templates template.mustache [data.json]\n");
  process.exit(1);
}

try {
  view = JSON.parse(fs.readFileSync(process.argv[3], 'utf-8'));
} catch (e) {}

/**
 * return the template code of a partial located in templates/partials/
 */
function partials(name) {
  var template = '';
  try {
    template = fs.readFileSync(partials_root+'/'+name+'.mustache',
                               'utf-8');
  } catch (e) {
    process.stderr.write('Couldn\'t find partial '+name+'\n');
  }
  return template;
}


var output = Mustache.render(template, view, partials);
process.stdout.write(output);
