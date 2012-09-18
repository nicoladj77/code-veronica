#!/bin/bash

PARENT="../../vortex/less"
LESSC="lessc --no-color --include-path=.:$PARENT"

if which -s lessc; then
	$LESSC $PARENT/style.less > temp.css
	cat theme-info.less temp.css > ../style.css
	rm temp.css
	$LESSC $PARENT/calendar.less > ../css/calendar.css
	$LESSC $PARENT/event.less > ../css/event.css
else
	echo 'Error: lessc not found. Install Node.js then: npm install -g less';
	exit 1;
fi
