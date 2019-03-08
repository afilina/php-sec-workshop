# Web Application Security

```
composer install 
bin/console server:run
```

The last command will display a URL that you'll need need to open in your browser. If you see a page with a title "PHP Application Security", then you're good to go.

## Composer

If you don't have composer on your computer:
* Install composer: https://getcomposer.org/download/ (run the commands at the top) This will install composer.phar into the current directory.
* Move it to a more sensible location and rename it: `mv composer.phar /usr/local/bin/composer`

## Troubleshooting

If `composer install` doesn't work, execute `composer update ` instead.

If anything still doesn't work, open an issue in this project with steps that you did and some details about your environment (OS, PHP version).
