#!/usr/bin/env bash

# Edit the following to change the name of the database user that will be created:
APP_DB_USER=yii2_db
APP_DB_PASS=yii2_db

# Edit the following to change the name of the database that is created (defaults to the user name)
APP_DB_NAME=$APP_DB_USER
APP_DB_NAME_TEST=yii2_db_test

service postgresql restart

cat << EOF | su - postgres -c psql
-- Remove databse:

DROP DATABASE "$APP_DB_NAME";

DROP DATABASE "$APP_DB_NAME_TEST";

-- Create the database:
CREATE DATABASE "$APP_DB_NAME" WITH OWNER="$APP_DB_USER"
                                  LC_COLLATE='en_US.utf8'
                                  LC_CTYPE='en_US.utf8'
                                  ENCODING='UTF8'
                                  TEMPLATE=template0;
-- Create the test database:
CREATE DATABASE "$APP_DB_NAME_TEST" WITH OWNER="$APP_DB_USER"
                                  LC_COLLATE='en_US.utf8'
                                  LC_CTYPE='en_US.utf8'
                                  ENCODING='UTF8'
                                  TEMPLATE=template0;
EOF