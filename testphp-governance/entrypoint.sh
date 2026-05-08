#!/bin/sh

set -e

echo "Starting environment configuration..."

echo "Waiting for PostgreSQL to be ready..."
sleep 10

if [ ! -d "vendor" ]; then
    echo "Installing Composer dependencies..."
    composer install --no-interaction --prefer-dist --optimize-autoloader
fi

echo "Generating application key..."
php artisan key:generate --force || true

echo "Running database migrations..."
php artisan migrate --force

echo "Creating storage symbolic link..."
php artisan storage:link --force

echo "System is up and running!"

exec php artisan serve --host=0.0.0.0 --port=80
