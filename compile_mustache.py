#!/usr/bin/env python
"""Render a Mustache template, optionally populated with JSON data"""


import pystache
import json
import sys


class partials(object):
    partials_root = 'templates/partials'
    def get(self, name):
        """return the template code of a partial located
        in templates/partials/
        """
        r = ""
        try:
            with open(self.partials_root+'/'+name+'.mustache') as partial:
                r = partial.read().decode('utf-8')
        except IOError:
            sys.stderr.write('Couldn\'t find partial '+name+'\n')
        return r


try:
    template = open(sys.argv[1]).read().decode('utf-8')
except Exception:
    sys.stderr.write("usage: compile_templates template.mustache [data.json]\n")
    sys.exit(1)

try:
    view = json.load(open(sys.argv[2]))
except:
    view = {}

renderer = pystache.Renderer(partials=partials())
sys.stdout.write(renderer.render(template, view).encode('utf-8'))
