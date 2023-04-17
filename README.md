Для клонирования проекта необходимо
1.git clone git@github.com:Oleg1979k/test_task.git
2.composer install
3.php artisan migrate
Для первого выполнения тестов необходимо выполнить 
php artisan test
Для повторного выполнения тестов необходимо:
1.php artisan migrate:rollback --step=3
2.php artisan migrate
3.php artisan test

