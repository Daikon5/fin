Дипломная работа по курсу «PHP/SQL: back-end разработка и базы данных», сервис вопросов и ответов.

Для запуска проекта нужно: 
- скорпировать файлы из этого репозитория
- установить Composer и в каталоге с файлами выполнить команду 'composer install' 
- импортировать БД из faq.sql
- в dbcnofig.php изменить название БД, логин и пароль для доступа к ней на ваши

Каталоги:
- controllers - два контроллера для обработки действий юзера и администратора
- models - модели взаимодействия с БД и подготовки к ним, используемые контроллерами
- templates - шаблоны интерфейсов юзера и администратора и стили для них

Файлы:
- index.php - центр управления контроллерами
- faq.sql - дамп базы данных (UML-схема БД https://drive.google.com/open?id=1-wD0STMaZlP0zsgLE_2v8u4Xf1DYyskd)
- dbconfig.php - настройки доступа к БД
- logout.php - удаление сессии и логаут
- composer.lock, composer.json - установление зависимостей Composer
