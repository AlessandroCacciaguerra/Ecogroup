#!/bin/bash

DB_NAME="eco_group"

wait_for_mysql() {
  echo "Waiting for MySQL to be ready..."
  until /opt/lampp/bin/mysqladmin ping -h 0.0.0.0; do
    echo "Waiting for MySQL..."
    sleep 2
  done
  echo "MySQL is up and running!"
}

create_database() {
  echo "Creating database $DB_NAME if it doesn't exist..."
  /opt/lampp/bin/mysql -e "CREATE DATABASE IF NOT EXISTS $DB_NAME;" || {
    echo "Error creating database $DB_NAME"
    exit 1
  }
}

populate_database() {
  echo "Populating database $DB_NAME..."

  if [ -f /opt/lampp/htdocs/EcogroupWeb-AlessandroCacciaguerra/db/Database.sql ]; then
    echo "Running Database.sql:"
    /opt/lampp/bin/mysql $DB_NAME < /opt/lampp/htdocs/EcogroupWeb-AlessandroCacciaguerra/db/Database.sql || {
      echo "Error executing Database.sql"
      exit 1
    }
    echo "Database structure created from Database.sql"
  else
    echo "Error: /opt/lampp/htdocs/EcogroupWeb-AlessandroCacciaguerra/db/Database.sql not found!"
    exit 1
  fi

  if [ -f /opt/lampp/htdocs/EcogroupWeb-AlessandroCacciaguerra/db/seed.sql ]; then
    echo "Running seed.sql:"
    /opt/lampp/bin/mysql $DB_NAME < /opt/lampp/htdocs/EcogroupWeb-AlessandroCacciaguerra/db/seed.sql || {
      echo "Error executing seed.sql"
      exit 1
    }
    echo "Database populated from seed.sql"
  else
    echo "Error: /opt/lampp/htdocs/EcogroupWeb-AlessandroCacciaguerra/db/seed.sql not found!"
    exit 1
  fi

}

wait_for_mysql
create_database
populate_database

echo "Database initialization complete!"
