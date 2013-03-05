

all: test deps

deps: deps-js deps-php deps-py

deps-js:
	npm install

deps-php:
	composer install

deps-py:
	pip install -r pip.txt

test:
	jshint compile_mustache.js
	php --syntax-check compile_mustache.php
	python -m py_compile compile_mustache.py
	jsonlint -q *.json

clean:
	rm -fr vendor node_modules *.pyc composer.lock
