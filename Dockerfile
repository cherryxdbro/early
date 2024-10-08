FROM php:apache AS runtime
RUN apt-get update
RUN apt-get install -y gnupg unixodbc-dev
RUN apt-get clean
RUN curl -fsSL https://packages.microsoft.com/keys/microsoft.asc | gpg --dearmor -o /usr/share/keyrings/microsoft-prod.gpg
RUN curl https://packages.microsoft.com/config/debian/12/prod.list | tee /etc/apt/sources.list.d/mssql-release.list
RUN apt-get update
RUN ACCEPT_EULA=Y apt-get install -y msodbcsql18
RUN pecl install sqlsrv pdo_sqlsrv
RUN docker-php-ext-enable sqlsrv pdo_sqlsrv
COPY src/apache2 /etc/apache2
RUN a2enmod rewrite
WORKDIR /var/www/html
COPY src/html .