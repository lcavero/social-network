#!/bin/sh

GIT_DIR=$(git rev-parse --git-dir)

for hook in $(find $GIT_DIR -type l); do
    rm $hook;
done

for file in .githooks/*; do
	fileBaseName="$(basename "$file")"
	echo "$GIT_DIR/hooks/$fileBaseName"
    ln -s ../../.githooks/$fileBaseName "$GIT_DIR/hooks/$fileBaseName"
done
