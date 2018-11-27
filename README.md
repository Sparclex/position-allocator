# Position allocator

Scans a code 39 barcode and allocates the value to the next available position on the plate.

## Requirements

The project is written using the php framework [laravel v5.7](https://laravel.com/docs/5.7/). Therefore the requirements are equal to the framework requirements:

- PHP >= 7.1.3
- OpenSSL PHP Extension
- PDO PHP Extension
- Mbstring PHP Extension
- Tokenizer PHP Extension
- XML PHP Extension
- Ctype PHP Extension
- JSON PHP Extension
- BCMath PHP Extension

## Installation

- Copy all the files to the webserver
- Use the public directory as the webroot
- Rename `.env.example` to `.env`
- Update the Database credentials in the `.env` file
- Update the `APP_PASSWORD` variable in the `.env` (this is the password used to log in)
- Use [Composer](https://getcomposer.org/) to install all dependencies `composer install`
- In you project home on the server run `php artisan migrate --seed`


Optional

If you want to have regularly backups of your database to your google drive update the `.env` variables as described in [this blogpost](https://medium.com/@dennissmink/laravel-backup-database-to-your-google-drive-f4728a2b74bd). For other backup destinations please check out the [laravel-backup](https://docs.spatie.be/laravel-backup) documentation. After setting these variables add the following cron job:
```
* * * * * cd /path-to-your-project && php artisan schedule:run >> /dev/null 2>&1
```

## Customization

You can change the number of rows and columns per plate by updating the according values in the `.env` file.

## Development

Follow the installation steps and additionally run the following steps

- `yarn` or `npm install`
- `yarn watch` or `npm run watch`

