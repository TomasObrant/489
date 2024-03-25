# 489

Запуск docker-compose up -d

Есть 2 закомментированных контейнера ad 
через образ 
#  ldap-ad-it:
#    image: dwimberger/ldap-ad-it
#    ports:
#      - "10389:10389"
#    networks:
#      app:
через докер файл с прокидыванием сервера
#  ldap-ad-it:
#    build:
#      context: .
#      dockerfile: docker/ldap/DockerFile
#    ports:
#      - "10389:10389"
#    networks:
#      app:

В тестовой команде есть заготовки для проверки подключения 
php bin/console test