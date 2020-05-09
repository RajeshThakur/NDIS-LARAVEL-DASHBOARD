# Admin Dashborad built with Laravel
#Intial Setup

1. Extract the archive and put it in the folder you want

2. Prepare your .env file there with database connection and other settings

3. Run `composer install` command

4. Run `php artisan migrate --seed` command. Notice: seed is important, because it will create the first admin user for you.

5. Run `php artisan key:generate` command.

6. Run `php artisan migrate:fresh --seed` command to re-run the migration after making changes

And that's it, go to your domain and login:

Email: deepak@superappbros.com.au
Password: Scorp5683

P.S. If you want to use this admin panel for existing project, here's an article with instructions

Notice: if you use CKEditor fields, there are a few more commands to launch for Laravel Filemanager package:
php artisan vendor:publish --tag=lfm_config
php artisan vendor:publish --tag=lfm_public

### Media Library

You need to publish and run the migration:
php artisan vendor:publish --provider="Spatie\MediaLibrary\MediaLibraryServiceProvider" --tag="migrations"
php artisan migrate

### Publish the Email Templates for Customizations ( June 28, 2019 )

`php artisan vendor:publish --tag=laravel-notifications`
After running this command, the mail notification templates will be located in the `resources/views/vendor/notifications` directory.

### DB Backup

[How to create DB Backups](https://github.com/wpconsulate/ndis/wiki/How-to-create-DB-Backups)

### Sentry Setup

You need to publish the provider:
php artisan vendor:publish --provider="Sentry\Laravel\ServiceProvider"

### OneSignal Setup

[ One Signal setup https://github.com/berkayk/laravel-onesignal ]
php artisan vendor:publish --tag=config

### dmark/bookings

1. Install the package via composer:

    ```shell
    composer require dmark/laravel-bookings
    ```

2. Publish resources (migrations and config files):

    ```shell
    php artisan dmark:publish:bookings
    ```

3. Execute migrations via the following command:
    ```shell
    php artisan dmark:migrate:bookings
    ```

### API Authentication via laravel/passport

php artisan passport:install

### Cron Jobs Schedule

### Notifications Migration

php artisan notifications:table
php artisan migrate

### After Running Migrations or making changes to Config make sure to run these

Check APP_ENV in your .env file. If it's on production then yes, laravel caching it. You should run these commands before changing configs:

    php artisan cache:clear
    php artisan config:clear
    php artisan route:clear

And then after changes run these:

    php artisan config:cache
    php artisan route:cache
    php artisan optimize

### disabled Mysql Full Group By

SET GLOBAL sql_mode=(SELECT REPLACE(@@sql_mode,'ONLY_FULL_GROUP_BY',''));

### To Customize the Mail Message Please run these commands once for setup

php artisan vendor:publish --tag=laravel-notifications
php artisan vendor:publish --tag=laravel-mail
