#!/usr/bin/env bash
RED='\033[0;31m'
YELLOW='\033[1;33m'
GREEN='\033[0;32m'

echo 'Installing 2pac.sh'

pwd=$(pwd | grep 'scripts')
if [ -z "$pwd" ]
then
    cd scripts
fi

if [ ! -d ~/bin ]
then
    echo 'Creating: ~/bin';
    mkdir ~/bin
fi

sudo chmod -R 777 ~/bin

echo 'Creating: ~/bin/2pac.sh'
sudo cp -rf 2pac.sh ~/bin/2pac.sh

if [ -f ~/.zshrc ]
then
    # Remove any existing 2pac alias
    sed -i '' '/alias 2pac/d' ~/.zshrc

    echo 'Creating 2pac alias'
    echo 'alias 2pac="~/bin/2pac.sh"' >> ~/.zshrc
    echo "${GREEN}Complete"
    zsh
fi
