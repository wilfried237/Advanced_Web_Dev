# Use the official PHP image
FROM php:7.4-cli

# Install system dependencies
RUN apt-get update && apt-get install -y \
    libsqlite3-dev \
    && docker-php-ext-install pdo pdo_sqlite

# Set the working directory
WORKDIR /var/www/html

# Copy application files
COPY . .

# Expose port (if needed)
EXPOSE 9000

# Start the application (Modify this as per your requirements)
CMD ["php", "-S", "0.0.0.0:9000"]
