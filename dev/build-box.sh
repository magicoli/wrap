#!/bin/bash

set -xeu

# compile binary
./vendor/bin/box compile

# extract phar content to check its content
rm -rf tmp/extract/
./vendor/bin/box extract cli/bin/wrap-cli tmp/extract/
tree tmp/extract/ -L 3

# test with --version argument 
./cli/bin/wrap-cli --version

# test with list argument
./cli/bin/wrap-cli list

# test without argument
./cli/bin/wrap-cli
