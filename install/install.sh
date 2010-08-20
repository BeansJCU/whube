#!/bin/bash

ID=$(dpkg --version)

if [ "x$?" == "x0" ]; then
	echo "You're running a dpkg system."
	echo "Defaulting to apt-get to"
	echo "install the stuff we need."
	echo "This needs sudo rights."

	sudo apt-get install apache2 php5 php5-mysql mysql-server 
fi

echo "OK, let's setup the site stuff. Please hit enter and"
echo "modify the file to taste."
read FOO

vim ../conf/site.php

echo "OK, I'm going to try and enable rewrite"
echo "This will need sudo rights."

sudo a2enmod rewrite

echo "OK, this is going to run the MySQL Query."
echo "This is using the user \`root'"

mysql -u root -p < install.sql

rm install.php

echo -e "\n\n"
echo "OK. It's \"installed\"."
echo "You [1mneed[0m to modify your apache config ( the <Directory> )"
echo "to allow us to use .htaccess files."
echo "One sample looks like:"
echo ""
echo "This is in \"/etc/apache/sites-enabled/000-default\" "
echo "by default"
echo ""
echo "        <Directory /var/www/>"
echo "                Options Indexes FollowSymLinks MultiViews"
echo "                AllowOverride All"
echo "                Order allow,deny"
echo "                allow from all"
echo "        </Directory>"
echo ""
echo "Thanks a bunch for using Whube!"
echo "  -- Paul Tagliamonte & The Whube Team"
echo ""
