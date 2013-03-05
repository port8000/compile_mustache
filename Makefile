SHELL := /bin/bash

all: test deps

.PHONY: all deps deps-js deps-php deps-py test clean

deps: deps-js deps-php deps-py

deps-js:
	npm install

deps-php:
	composer install

deps-py:
	pip install -r pip.txt

test:
	@echo "* do syntax checks"
	@jshint compile_mustache.js
	@php --syntax-check compile_mustache.php >/dev/null
	@python -m py_compile compile_mustache.py
	@jsonlint -q *.json
	@echo "* compare output with reference rendering"
	@diff test/output.txt <(CDPATH= cd test; ../compile_mustache.js templates/index.mustache data.json)
	@diff test/output.txt <(CDPATH= cd test; ../compile_mustache.php templates/index.mustache data.json)
	@diff test/output.txt <(CDPATH= cd test; ../compile_mustache.py templates/index.mustache data.json)

clean:
	rm -fr vendor node_modules *.pyc composer.lock
