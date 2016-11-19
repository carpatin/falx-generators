#!/bin/sh
SRC_DIR=$(cd ..; pwd)
docker run --tty --interactive --rm --name falx-generators-container -v "$SRC_DIR":/usr/src/falx-generators falx-generators
