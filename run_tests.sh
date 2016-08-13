#!/bin/bash

#
# This triggers our test procedures for Thallium.
#
# Basically it starts up an empty MySQL instance.
# Initializes Thallium on it.
# And then runs the phpunit test suite.
#

SCRIPT_NAME=$(basename $0)
SCRIPT_DIR=$(dirname $0)
SCRIPT_DIR=$(realpath ${SCRIPT_DIR})

trap cleanup INT QUIT TERM EXIT

function cleanup()
{
   [ -d mysql ] || exit 0;

   [ -s mysql/instance/mysqld.pid ] || exit 0;

   pkill -0 -F mysql/instance/mysqld.pid || exit 0;

   [ -S mysql/instance/mysqld.sock ] || exit 0;

   [ ! -e mysql/root.conf ] || local DEFAULTS_FILE="--defaults-file=mysql/root.conf"
   echo "Stopping MySQL instance."
   mysqladmin ${DEFAULTS_FILE} --socket mysql/instance/mysqld.sock --user root shutdown

   [ ! -s mysql/instance/mysqld.pid ] || pkill -F mysql/instance/mysqld.pid
   exit 0;
}

echo; echo;
echo "$0 starting ($(date))."
echo; echo;

[ ! -e mysql/root.conf ] || DEFAULTS_FILE="--defaults-file=mysql/root.conf"

if [ -S mysql/instance/mysqld.sock ]; then
   if mysqladmin  ${DEFAULTS_FILE} --socket mysql/instance/mysqld.sock --user root ping >/dev/null; then
      echo "Stopping leftover MySQL instance."
      mysqladmin  ${DEFAULTS_FILE} --socket mysql/instance/mysqld.sock --user root shutdown
   fi
fi


#
# pre-create directory structure
#
[ -d mysql/instance ] || mkdir mysql/instance
#[ -d mysql/tmp ] || mkdir mysql/tmp

echo "Cleaning up MySQL data directory."
find mysql/instance -type f -delete
find mysql/instance -type f -delete
#find mysql/tmp -type f -delete
find mysql/instance -mindepth 1 -type d -empty -delete

pushd mysql >/dev/null

[ -d instance/tmp ] || mkdir instance/tmp

echo "Creating MySQL instance."
/usr/bin/mysql_install_db \
   --defaults-file=mysqld.cnf \
   --keep-my-cnf >/dev/null
RETVAL=$?

( [ ${RETVAL} -eq 0 ] || [ ${RETVAL} -eq 141 ] ) || { echo "Failed to create a new MySQL instance."; exit 1; }

echo "Starting MySQL instance."
/usr/bin/mysqld_safe --defaults-file=mysqld.cnf >/dev/null &
RETVAL=$?

[ ${RETVAL} -eq 0 ] || { echo "Failed to start MySQL instance."; exit 1; }
popd >/dev/null

echo -n "Waiting for MySQL instance to become ready (5sec timeout)"

CNT=0
while [ ! -S mysql/instance/mysqld.sock ]; do
   [ $CNT -ne 5 ] || break
   echo -n "."
   sleep 1
   ((CNT+=1))
done

[ -S mysql/instance/mysqld.sock ] || { echo "Failed to locate mysql/instance/mysqld.sock."; exit 1; }
echo "ready"

[ -s mysql/instance/mysqld.pid ] || { echo "Failed to locate mysql/instance/mysqld.pid"; exit 1; }

[ -e mysql/root.pw ] || pwgen 32 1 > mysql/root.pw
chmod 600 mysql/root.pw
[ -e mysql/thallium.pw ] || pwgen 32 1 >mysql/thallium.pw
chmod 600 mysql/thallium.pw

cat - >mysql/root.conf <<EOF
[client]
user     = root
password = $(cat mysql/root.pw)
host     = localhost
socket   = mysql/instance/mysqld.sock
port     = 33306
EOF
chmod 600 mysql/root.conf

cat - >mysql/thallium.conf <<EOF
[client]
user     = thallium
password = $(cat mysql/thallium.pw)
host     = localhost
socket   = mysql/instance/mysqld.sock
port     = 33306
EOF
chmod 600 mysql/thallium.conf

echo "Setting password for root user."
echo "SET PASSWORD = PASSWORD('$(cat mysql/root.pw)');" | \
   mysql --socket mysql/instance/mysqld.sock --user root

echo "Testing DB connection."
mysqladmin --defaults-file=mysql/root.conf status >/dev/null 2>&1
RETVAL=$?
[ ${RETVAL} -eq 0 ] || { echo "Failed to connect to MySQL instance."; exit 1; }

echo "Creating database 'thallium'."
echo "CREATE DATABASE thallium;" | mysql --defaults-file=mysql/root.conf
RETVAL=$?
[ ${RETVAL} -eq 0 ] || { echo "Failed to create 'thallium' database."; exit 1; }

echo "Creating user 'thallium'."
echo "CREATE USER 'thallium'@'localhost' IDENTIFIED BY '$(cat mysql/thallium.pw)';" | \
   mysql --defaults-file=mysql/root.conf
RETVAL=$?
[ ${RETVAL} -eq 0 ] || { echo "Failed to create 'thallium' user"; exit 1; }

echo "Granting database privileges."
echo "GRANT ALL ON thallium.* to 'thallium'@'localhost';" | \
   mysql --defaults-file=mysql/root.conf

echo "Flushing privileges."
echo "FLUSH PRIVILEGES;" | mysql --defaults-file=mysql/root.conf
RETVAL=$?
[ ${RETVAL} -eq 0 ] || { echo "Failed to create 'thallium' user"; exit 1; }

echo "Testing DB connection (user = thallium)."
mysqladmin --defaults-file=mysql/thallium.conf status >/dev/null 2>&1
RETVAL=$?
[ ${RETVAL} -eq 0 ] || { echo "Failed to connect to MySQL instance."; exit 1; }

pushd thallium >/dev/null

[ -e config/config.ini.dist ] || { echo "Where is Thallium?"; exit 1; }
[ ! -e config/config.ini ] || rm config/config.ini
cat - >config/config.ini <<EOF
[app]
base_web_path = /thallium

[database]
type = mysql
socket = ${SCRIPT_DIR}/mysql/instance/mysqld.sock
db_name = thallium
db_user = thallium
db_pass = $(cat ../mysql/thallium.pw)
EOF

phpunit \
   -c ../phpunit.xml \
   --stderr \
   --verbose \
   --disallow-test-output \
   --report-useless-tests

popd >/dev/null
