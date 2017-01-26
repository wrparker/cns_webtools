CNS Webtools Laravel application
======
This is meant to be a set of tools for users at the University of Texas at Austin, College of Natural sciences to use to handle and manipulate data.

Some portions of this application that include proprietary code will be removed in the public rendition of this software.  


Installation Procedure:
------
1. Install Vagrant/Virutal Box
2. vagrant box add laravel/homestead
3. cd ~
4. git clone https://github.com/laravel/homestead.git Homestead
5. cd Homestead
6. OS....
  *UNIX
    *bash init.sh
  *WINDOWS
    *init.bat
7. Configure Homestead.yaml
7. Configure Homestead.yaml
8. Make sure that you set SSH keys or else vagrant up will error
9. vagrant up
10. set hosts file homestead.app to 192.168.10.10
11. git clone github.com/wrparker/cns_webtools
12. run init.bash (basically a few seutp commands.)