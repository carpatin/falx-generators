#!/bin/sh
docker rmi falx-generators
docker build -t falx-generators ..
