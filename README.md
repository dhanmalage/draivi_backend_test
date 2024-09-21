
# Draivi backend test

Greetings, I am Dhananjaya. Below are the detailed steps to properly set up the application. Read conclusion at end of the document for my comments.

## Installation

### 1. Project directory structure
```
index.php
/app
  /controllers
      DataController.php
      FileController.php
  /models
      ProductModel.php
  /views
      options_view.php
      products_view.php
  /helpers
      GuzzleHelper.php
/config
    database.php
/public
    /assets
      /images
        loading.gif
      scripts.js
      style.css
/vendor
    (Composer libraries go here)
```

### 2. Clone the code to your local environment

```
git clone https://github.com/dhanmalage/draivi_backend_test.git
```
### 3. Create environment variables

There is a `.env` file located in the root of the project. I know it is bad practice to push the `.env` file to the git repository but I did it here because this is a test. `.env` file should contain two variables.

```
IMPORT_FILE_URL='https://www.alko.fi/INTERSHOP/static/WFS/Alko-OnlineShop-Site/-/Alko-OnlineShop/fi_FI/Alkon%20Hinnasto%20Tekstitiedostona/alkon-hinnasto-tekstitiedostona.xlsx'

CURRENCYLAYER_API_KEY=7542f899ca1385870f0f3f4e380bd718
```
### 4. Import Database

Inside the database folder you will find 2 sql files. `draivi_backend_test_blank.sql` file is the blank database with table and `draivi_backend_test.sql` file contain the product data. You can import either into you environment. 

### 5. Run Composer Install

Navigate to the application directory and open a terminal and run the following composer command. 
```
composer install
```

### 6. Setup a virtual host

I'm using Apache server for this. My local domain for this project is `draivi.test` First Open the file `bin\apache\apache2.4.59\conf\extra\httpd-vhosts.conf` and add following v-host code to the file. Change `DocumentRoot` and `DocumentRoot` paths to match your environment. 

```
<VirtualHost *:80>
  ServerName draivi.test
  ServerAlias draivi.test
  DocumentRoot "${INSTALL_DIR}/www/draivi_backend_test/public"
  <Directory "${INSTALL_DIR}/www/draivi_backend_test/public/">
    Options +Indexes +Includes +FollowSymLinks +MultiViews
    AllowOverride All
    Require local
  </Directory>
</VirtualHost>
```

### 7. Update the OS host file

Open file `C:\Windows\System32\drivers\etc\hosts` and add the line

```
127.0.0.1 draivi.test
```
### 8. Open app on browser

Now you should be able to open the application on your browser. Open the browser and access `draivi.test`

## Conclusion

I only used basic `php` and some `jQuery`. If the requirement was to do the test using advanced design principles I could have used a framework like `Laravel` and `Node.js` for the advanced javascript work like `Fetch API` with `async` `promise`. However the application works well. I have tested many times. If you want more clarification or help installing the application feel free to contact me anytime. Thank you.