find . -type f -exec chmod 664 {} \;    
find . -type d -exec chmod 775 {} \;
chgrp -R www-data storage bootstrap/cache;
chmod -R ug+rwx storage bootstrap/cache;
