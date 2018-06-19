#!/usr/bin/env bash

# A script to check in vendor/vicimus packages for changes
# and tags that need to be pushed
# Apply the --chillin-in-cuba flag to determine which
# packages need a new tag

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

        if [ "$2" == "--chillin-in-cuba" ]
        then
            git checkout master &> /dev/null
            git pull &> /dev/null

            tags="$(git describe | grep '-')"
            if [ ! -z "$tags" ]
            then
                tagDirs+=(${dir})
            fi
        else
            tags="$(git describe --tags | grep '-')"
            if [ ! -z "$tags" ]
            then
                tagDirs+=(${dir})
            fi
        fi

        cd ../../..
    done
}


if [ "$1" == "--dealer" ]
then
    crawl 'vendor/dealer-live/*'
fi

if [ "$2" == "--ui" ]
then
    crawl 'node_modules/@vicimus/*' $1
else
    crawl 'vendor/vicimus/*' $1
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
