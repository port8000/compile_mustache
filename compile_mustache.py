#!/usr/bin/env python
"""Render a Mustache template, optionally populated with JSON data"""


import pystache
import json
import sys


class partials(object):
    def get(self, name):
        """return the template code of a partial located
        in templates/partials/
        """
        with open('templates/partials/'+name+'.mustache') as partial:
            return partial.read().decode('utf-8')


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
