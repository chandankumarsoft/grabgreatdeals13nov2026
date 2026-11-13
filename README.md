# CodeIgniter 4 Application Starter

## What is CodeIgniter?

CodeIgniter is a PHP full-stack web framework that is light, fast, flexible and secure.
More information can be found at the [official site](https://codeigniter.com).

This repository holds a composer-installable app starter.
It has been built from the
[development repository](https://github.com/codeigniter4/CodeIgniter4).

More information about the plans for version 4 can be found in [CodeIgniter 4](https://forum.codeigniter.com/forumdisplay.php?fid=28) on the forums.

You can read the [user guide](https://codeigniter.com/user_guide/)
corresponding to the latest version of the framework.

## Installation & updates

`composer create-project codeigniter4/appstarter` then `composer update` whenever
there is a new release of the framework.

When updating, check the release notes to see if there are any changes you might need to apply
to your `app` folder. The affected files can be copied or merged from
`vendor/codeigniter4/framework/app`.

## Setup

Copy `env` to `.env` and tailor for your app, specifically the baseURL
and any database settings.

## Production deployment (cPanel)

The configured production domain is `https://grabgreatdeals.soflytech.com/`.
The development `.env` is local-only and must not be copied to the server.
Use the private, ignored `.env.production` file prepared locally for this
domain. Enter only the cPanel database values and SMTP settings in that file,
then upload it outside the web root as `.env` (do not upload it as a publicly
accessible file). It contains unique production encryption, recovery-signing,
and cron secrets; keep a secure backup and do not regenerate them after launch.
The equivalent required settings are:

```ini
CI_ENVIRONMENT = production
app.baseURL = 'https://grabgreatdeals.soflytech.com/'
app.indexPage = ''
app.forceGlobalSecureRequests = true
cookie.secure = true

database.default.hostname = localhost
database.default.database = CPANEL_DATABASE_NAME
database.default.username = CPANEL_DATABASE_USER
database.default.password = SET_THIS_IN_CPANEL
database.default.DBDriver = MySQLi
database.default.port = 3306

email.protocol = smtp
email.fromEmail = STORE_EMAIL_ADDRESS
email.fromName = 'GrabGreatDeals'
email.SMTPHost = SMTP_HOST
email.SMTPUser = SMTP_USERNAME
email.SMTPPass = SET_THIS_IN_CPANEL
email.SMTPPort = 587
email.SMTPCrypto = tls

encryption.key = hex2bin:GENERATE_64_RANDOM_HEX_CHARACTERS
legacy.recoverySigningKey = SET_A_UNIQUE_RANDOM_SECRET_AT_LEAST_32_CHARACTERS
jobs.cronToken = SET_A_DIFFERENT_RANDOM_SECRET
```

Set all database and SMTP fields before deployment. Keep both `.env` and
`.env.production` outside the public web root, and never commit either file.
The site is configured for Cash on Delivery:
Stripe is hidden unless valid live `pk_live_` and `sk_live_` keys are configured.
Do not use Stripe test keys in production.

In cPanel, point the domain's document root to the project's `public` directory.
Keep `app`, `writable`, `vendor`, and `.env` outside the document root. If the
hosting plan cannot set that document root, stop before upload and arrange a
secure layout rather than exposing the project root. Install dependencies with
`composer install --no-dev --optimize-autoloader` when SSH/Composer is available,
or upload a locally built `vendor` directory. Use PHP 8.2+ with `intl`,
`mbstring`, `mysqli`, `gd` (WebP enabled), `fileinfo`, and `openssl`.

Create a dedicated cPanel database and database user with only the permissions
the application needs. Take and verify a database backup before importing or
migrating data. Upload the complete `public/uploads` and `public/assets`
directories; product and blog content includes inline image references and
depends on these files. Make `writable` and its required subdirectories writable
by PHP without making them publicly accessible. Install the GeoLite database as
described below. Confirm AutoSSL/HTTPS is active before enabling production
traffic.

After deployment, verify the home, product, blog, search/filter, registration,
password-recovery, SMTP email, and Cash-on-Delivery order flows on the live
domain. Place a controlled test order and confirm stock/payment/order records
before accepting customer traffic. Keep a rollback copy of the previous code
and database backup, and monitor `writable/logs` during launch.

### Application secrets

Set `legacy.recoverySigningKey` in `.env` to a randomly generated secret with at least 32 characters. This key signs account password-setting and cart-recovery links. Set `jobs.cronToken` to a separate random secret; scheduled jobs must send it in the `X-Cron-Token` header. Keep both values private and consistent across application instances. Do not commit them to source control.

### Checkout database engine migration

The checkout relies on transactions across order, payment, address, order-detail, and product-stock writes. Before deploying, take and verify a database backup, then run `php spark migrate` against the intended MySQL/MariaDB database. Migration `2026-11-07-000001` converts `tbl_order`, `tbl_order_details`, `tbl_payment`, `tbl_billing`, `tbl_shipping`, and `tbl_product` to InnoDB. Migration `2026-11-07-000002` expands `tbl_customer.cus_password` to 255 characters for future password hash compatibility. Run migrations during a maintenance window: MySQL may lock or rebuild tables, and schema changes are not part of the checkout transaction. Do not re-import the phpMyAdmin SQL export to apply these changes.

For a new live database, export the already-migrated local database from phpMyAdmin as SQL with both structure and data, then import it into the intended empty live database. The SQL export does not deploy application code or `.env`; deploy the updated application separately and configure its live database credentials and unique secrets. Never import over an existing live database without a verified backup and an explicit data-replacement plan. Treat SQL exports as sensitive because they may contain customer data.

### Upload image WebP conversion

The `media:convert-uploads-to-webp` command creates WebP copies of JPEG and PNG files throughout `public/uploads`, then updates matching image references in text columns in the configured database. It preserves original files, leaves animated GIFs unchanged, and writes a JSON mapping under `writable/backups` for reference rollback. When JPEG/PNG files share a basename, the command preserves their source extensions in the WebP filenames to avoid collisions. Run `php spark media:convert-uploads-to-webp` first to inspect the scope. Before executing, make and verify a full database backup; then run `php spark media:convert-uploads-to-webp --execute`. Large image collections can be divided across separate worker commands, using each index from 0 to worker-count minus one (for example `php spark media:convert-uploads-to-webp --execute --worker 0 --workers 4`). After every worker finishes, run the standard `--execute` command once to update database references. If the workers have already verified every existing WebP file, add `--trust-existing` to that final command to avoid re-decoding all outputs. To change the default quality, pass a separate option value, for example `--quality 85`. The command requires PHP GD with WebP support. Keep the originals until the WebP site has been verified in every environment.

## GeoLite country database

First-visit currency localization uses the MaxMind GeoLite2 Country database locally.
Place the extracted `GeoLite2-Country.mmdb` file at
`writable/geoip/GeoLite2-Country.mmdb` on each deployment. Keep the database and
MaxMind license credentials out of source control; the database directory is ignored.
Replace the database regularly with an updated download from MaxMind. If the file
is missing or unreadable, visitors use the configured default country and currency.

Retain the `COPYRIGHT.txt` and `LICENSE.txt` files supplied with the database and
follow MaxMind's GeoLite EULA and GeoNames attribution requirements.

## Important Change with index.php

`index.php` is no longer in the root of the project! It has been moved inside the *public* folder,
for better security and separation of components.

This means that you should configure your web server to "point" to your project's *public* folder, and
not to the project root. A better practice would be to configure a virtual host to point there. A poor practice would be to point your web server to the project root and expect to enter *public/...*, as the rest of your logic and the
framework are exposed.

**Please** read the user guide for a better explanation of how CI4 works!

## Repository Management

We use GitHub issues, in our main repository, to track **BUGS** and to track approved **DEVELOPMENT** work packages.
We use our [forum](http://forum.codeigniter.com) to provide SUPPORT and to discuss
FEATURE REQUESTS.

This repository is a "distribution" one, built by our release preparation script.
Problems with it can be raised on our forum, or as issues in the main repository.

## Server Requirements

PHP version 8.2 or higher is required, with the following extensions installed:

- [intl](http://php.net/manual/en/intl.requirements.php)
- [mbstring](http://php.net/manual/en/mbstring.installation.php)

> [!WARNING]
> - The end of life date for PHP 7.4 was November 28, 2022.
> - The end of life date for PHP 8.0 was November 26, 2023.
> - The end of life date for PHP 8.1 was December 31, 2025.
> - If you are still using below PHP 8.2, you should upgrade immediately.
> - The end of life date for PHP 8.2 will be December 31, 2026.

Additionally, make sure that the following extensions are enabled in your PHP:

- json (enabled by default - don't turn it off)
- [mysqlnd](http://php.net/manual/en/mysqlnd.install.php) if you plan to use MySQL
- [libcurl](http://php.net/manual/en/curl.requirements.php) if you plan to use the HTTP\CURLRequest library
