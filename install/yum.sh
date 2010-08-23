#!/bin/bash

ID=$(rpm --version)

if [ "x$?" == "x0" ]; then
	echo "You're running a dpkg system."
	echo "Defaulting to apt-get to"
	echo "install the stuff we need."
	echo "This needs sudo rights."

	yum  install httpd php mysql mysql-server php-mysql php-xml
fi
