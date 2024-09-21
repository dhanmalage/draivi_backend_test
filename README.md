
# Draivi backend test

Greetings, I am Dhananjaya. Below are the detailed steps to properly set up the application. Read conclusion at end of the document for my comments.

## Installation

### 1. Clone the code to your local environment

```
git clone https://github.com/dhanmalage/draivi_backend_test.git
```
### 2. Create environment variables

There is a `.env` file located in the root of the project. I know it is bad practice to push the `.env` file to the git repository but I did it here because this is a test. `.env` file should contain two variables.

```
IMPORT_FILE_URL='https://www.alko.fi/INTERSHOP/static/WFS/Alko-OnlineShop-Site/-/Alko-OnlineShop/fi_FI/Alkon%20Hinnasto%20Tekstitiedostona/alkon-hinnasto-tekstitiedostona.xlsx'

CURRENCYLAYER_API_KEY=7542f899ca1385870f0f3f4e380bd718
```

### 3. Run Composer Install

Navigate to the application directory and open a terminal and run the following composer command. 
```
composer install
```

### 4. Setup a virtual host

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

### 5. Update the OS host file

Open file `C:\Windows\System32\drivers\etc\hosts` and add the line

```
127.0.0.1 draivi.test
```
### 6. Open app on browser

Now you should be able to open the application on your browser. Open the browser and access `draivi.test`

## Conclusion

I only used basic `php` and some `jQuery`. If the requirement was to do the test using advanced design principles I could have used a framework like `Laravel` and `Node.js` for the advanced javascript work like `Fetch API` with `async` `promise`. However the application works well. I have tested many times. If you want more clarification or help installing the application feel free to contact me anytime. Thank you.