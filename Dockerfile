FROM php:8.2-cli-alpine

# Install SQLite, MySQL extensions & Python for TTS
RUN apk add --no-cache \
    sqlite \
    sqlite-dev \
    python3 \
    py3-pip \
    && docker-php-ext-install pdo_mysql || true

# Optional edge-tts for dynamic AI Miko voice synthesis
RUN pip3 install --no-cache-dir edge-tts --break-system-packages 2>/dev/null || true

WORKDIR /app
COPY . .

# Ensure storage directories exist and are writable
RUN mkdir -p database public/audio/miko/cache && chmod -R 777 database public/audio/miko/cache

# Copy entrypoint script and ensure execution permissions
COPY docker/entrypoint.sh /usr/local/bin/entrypoint.sh
RUN chmod +x /usr/local/bin/entrypoint.sh

ENV PHP_CLI_SERVER_WORKERS=4
EXPOSE 80

ENTRYPOINT ["/usr/local/bin/entrypoint.sh"]
CMD ["php", "-S", "0.0.0.0:80", "-t", "public"]
