#!/bin/bash
# Local Travis :-)
echo "===================================="
echo "Path: \${1}"
echo "===================================="

find . \( -name '*.php' \) -exec php -lf {} \;
jshint .
jscs .
phpcs -p -s -v -n . --standard=./codesniffer.ruleset.xml --extensions=php -a