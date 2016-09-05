#!/bin/bash

#
# APIGEN
#

APIGEN="/usr/bin/apigen"
#APIGEN="strace -f -s 256 /usr/bin/apigen"

DIRNAME=$(dirname $0)
DIRNAME=$(realpath ${DIRNAME})

OUTPUT="${DIRNAME}/docs"
TITLE="Thallium Test Suite Documentation"
SOURCE="tests"

if [ -d "${OUTPUT}" ]; then
   rm -r "${OUTPUT}"
fi

if [ ! -d "${SOURCE}" ]; then
   echo "${SOURCE} already exists!"
   exit 1
fi

${APIGEN} \
   generate \
   --debug \
   --source="${SOURCE}" \
   --destination="${OUTPUT}" \
   --title="${TITLE}" \
   --todo \
   --tree \
   --template-theme="bootstrap"

RETVAL=$?

if [ "x${RETVAL}" != "x0" ]; then
   echo "${APIGEN} exited with exit code ${RETVAL}!"
   exit 1
fi
