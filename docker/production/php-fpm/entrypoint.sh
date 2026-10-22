#!/bin/sh
set -e

# Initialize storage directory if empty
# -----------------------------------------------------------
# If the storage directory is empty, copy the initial contents
# and set the correct permissions.
# -----------------------------------------------------------
if [ ! "$(ls -A /var/www/api/storage)" ]; then
  echo "Initializing storage directory..."
  cp -R /var/www/api/storage-init/. /var/www/api/storage
  chown -R www-data:www-data /var/www/api/storage
fi

# Remove storage-init directory
rm -rf /var/www/api/storage-init

# Run Laravel migrations
# -----------------------------------------------------------
# Ensure the database schema is up to date.
# -----------------------------------------------------------
php artisan migrate --force

# Clear and cache configurations
# -----------------------------------------------------------
# Improves performance by caching config and routes.
# -----------------------------------------------------------
php artisan config:cache
php artisan route:cache

# Run the default command
exec "$@"