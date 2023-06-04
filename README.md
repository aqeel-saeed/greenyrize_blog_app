# How To Install ?

## Run Those Commands:

```
git clone https://github.com/aqeel-saeed/greenyrize_blog_app.git
cd greenyrize_blog app
composer i
cp .env.example .env
php artisan key:generate
```

and then write the db name in the env file, run the xampp and run those commands:

```
php artisan migrate
php artisan db:seed
php artisan passport:install
php artisan serve
```
