#!/bin/bash

DIRNAME=$(dirname $0)
DIRNAME=$(realpath ${DIRNAME})
GITREPO="http://git.netshadow.net/thallium.git"
GITORIGIN="devel"

SOURCE="${DIRNAME}/$(basename ${GITREPO} .git)"

if [ ! -d ${SOURCE} ]; then
   if [ -f ${SOURCE} ]; then
      echo "${SOURCE} already exists!"
      exit 1
   fi
   echo "Cloning thallium repository from ${GITREPO}."
   pushd ${DIRNAME} >/dev/null
   git clone -q ${GITREPO}
   popd >/dev/null

   if [ ! -d ${SOURCE} ] || [ ! -d ${SOURCE}/.git ]; then
      echo "git-clone on ${GITREPO} failed!"
      exit 1
   fi
fi

echo "Update thallium repository."
pushd ${SOURCE} >/dev/null
git fetch -q ${GITORIGIN}
git rebase -q -s recursive -X ours ${GITORIGIN}/master
popd >/dev/null

bash run_tests.sh
