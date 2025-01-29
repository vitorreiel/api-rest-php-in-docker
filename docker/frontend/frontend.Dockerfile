# Usar a imagem do Nginx
FROM nginx:alpine

# Copiar os arquivos estáticos para o diretório padrão do Nginx
COPY ./frontend /usr/share/nginx/html

# Expor a porta padrão do Nginx
EXPOSE 80