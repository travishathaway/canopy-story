#! /bin/bash

ssh -A thath@research.pdx.edu << EOF
cd /vol/www/climatecope/apps/canopy-story

git checkout --force master
git pull

composer update --no-dev

cp -r public /vol/www/climatecope/htdocs/cs-stage

cp envs/stage/index.php /vol/www/climatecope/htdocs/cs-stage/index.php

EOF
