## Post Management Application Built with Laravel

### Setup Steps
1. Run the `composer install`command to install all of the framework's dependencies
2. Update your database connection information in the `.env` file
3. Resets your database to its original state and populates it with the seed data via the `php artisan migrate:refresh --seed` command
4. To display an image in the storage folder in Laravel, you need to first create a symbolic link from the `public/storage` directory to the `storage/app/public` directory. This will ensure that the image can be accessed through a publicly accessible URL.
To create the symbolic link, run the following command: `php artisan storage:link`
5. Run the following command: `php artisan serve` to run the application

### Default admin and normal user account
- Admin: admin@admin.com/password
- User: user@user.com/password

### API endpoints can be found in `API.postman_collection.json` Postman collection 
