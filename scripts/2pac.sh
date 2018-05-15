#!/usr/bin/env bash
RED='\033[0;31m'
YELLOW='\033[1;33m'
GREEN='\033[0;32m'

changedDirs=()
tagDirs=()

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

        tags="$(git describe --tags | grep '-')"
        if [ ! -z "$tags" ]
        then
            tagDirs+=(${dir})
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


if [ "${#tagDirs[@]}" -gt 0 ]
then
    echo -e "${YELLOW}Can't a brother get a little peace!"
    for dir in ${tagDirs[*]}
    do
        echo -e "${RED}${dir} needs a tag"
    done
else
    echo -e "${GREEN}Flippin' on foes, puttin' tags on toes."
fi
