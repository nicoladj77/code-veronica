#!/bin/bash

LESSC="lessc --no-color --include-path=."

if which -s lessc; then
	$LESSC style.less > temp.css
	cat theme-info.less temp.css > ../style.css
	rm temp.css
	$LESSC calendar.less > ../css/calendar.css
	$LESSC event.less > ../css/event.css
	$LESSC print.less > ../css/print.css
else
  echo 'Error: lessc not found. Install Node.js then: npm install -g less';
	exit 1;
fi
