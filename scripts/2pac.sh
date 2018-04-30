#!/usr/bin/env bash
RED='\033[0;31m'
YELLOW='\033[1;33m'
GREEN='\033[0;32m'

changedDirs=()

crawl () {
    for dir in $1
    do
        [ -d "$dir" ] || continue

        if [ ${dir} == 'vendor/vicimus/hashcash' ] || [ ${dir} == 'vendor/vicimus/standard' ]
        then
            continue
        fi

        cd ${dir}

        changes="$(git status | grep 'Changes not staged for commit')"
        if [ ! -z "$changes" ]
        then
            changedDirs+=(${dir})
        fi

        changes="$(git status | grep 'Untracked files')"
        if [ ! -z "$changes" ]
        then
            changedDirs+=(${dir})
        fi

        cd ../../..
    done
}

crawl 'vendor/vicimus/*'

if [ "$1" == "--dealer" ]
then
    crawl 'vendor/dealer-live/*'
fi

if [ "${#changedDirs[@]}" -gt 0  ]
then
    echo -e "${YELLOW}All I see is changes!"
    for dir in ${changedDirs[*]}
    do
        echo -e "${RED}${dir}"
    done
else
    echo -e "${GREEN}I see no changes!"
fi
