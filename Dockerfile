FROM php:8.2-cli-alpine

WORKDIR /app
COPY . .

# Jalankan server bawaan PHP mengarah ke folder public
EXPOSE 80
CMD ["php", "-S", "0.0.0.0:80", "-t", "public"]
