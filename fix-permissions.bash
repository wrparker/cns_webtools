find . -type f -exec chmod 664 {} \;    
find . -type d -exec chmod 775 {} \;
chmod -R ug+rwx storage bootstrap/cache;
