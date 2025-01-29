# Usar uma imagem base do PHP com Composer
FROM php:8.1-cli

# Instalar extensões necessárias
RUN apt-get update && apt-get install -y \
    unzip \
    libpq-dev \
    libonig-dev \
    && docker-php-ext-install pdo pdo_mysql pdo_pgsql

# Definir o diretório de trabalho no container
WORKDIR /app

# Copiar os arquivos do projeto
COPY ./backend /app

# Expor a porta que o servidor PHP usará
EXPOSE 8000

# Comando para iniciar o servidor PHP
CMD ["php", "-S", "0.0.0.0:8000", "-t", "/app/routes"]
