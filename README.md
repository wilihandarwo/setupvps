# Initial Setup VPS

## Langkah 1 - Login sebagai root

```console
ssh root@your_server_ip
```

Update

```console
sudo apt-get update
sudo apt-get upgrade -y
```

## Langkah 2 - Buat user baru

Kedepannya kita ga akan pernah login lagi sebagai root, tapi dengan user baru ini

```console
adduser fadli
```

## Langkah 3 - Pemberian akses admin / root ke user baru tadi

```console
usermod -aG sudo fadli
```

## Langkah 4 - Setting Firewall

Cek dulu setting yang ada:

```console
ufw app list
```

```console
ufw allow OpenSSH
```

```console
ufw enable
```

```console
ufw status
```

## Langkah 5 - Aktifkan Akses Eksternal untuk Reguler User

### A. Jika punya password

```console
ssh fadli@your_server_ip
```

### B. Jika root sudah menggunakan SSH

```console
rsync --archive --chown=fadli:fadli ~/.ssh /home/fadli
```

### C. Jika belum setup SSH

#### C.1. Generate SSH di lokal

```console
ssh-keygen
```

Akan ada 2 file yang jadi:

- ~/.ssh/id_rsa: Private key. Jangan share ini.
- ~/.ssh/id_rsa.pub: Public key. Bisa di share.

#### C.2. Transfer public key dari local

**C.2.1. Dengan SSH Copy ID**

```console
ssh-copy-id username@remote_host
```

**C.2.2. Dengan Manual**

```console
cat ~/.ssh/id_rsa.pub
```

Copy value nya.
Masuk ke server lagi.
Buat folder SSH

```console
mkdir -p ~/.ssh
```

Terus masukkan public key yang dicopy tadi

```console
echo isi_public_key >> ~/.ssh/authorized_keys
```

#### C.3. Secure folder SSH

```console
sudo chmod 700 ~/.ssh
sudo chmod 600 ~/.ssh/authorized_keys
```

#### C.3. Coba login dengan SSH

```console
ssh fadli@remote_host
```

## Langkah 6 - Non-aktifkan Password

```console
sudo nano /etc/ssh/sshd_config
```

Cari baris PasswordAuthentication, comment nya dihapus, biar aktif

```bash
PasswordAuthentication no
```

Restart

```console
sudo service ssh restart
```

atau

```console
sudo systemctl restart ssh
```

#### Langkah 8 - Login ke SSH tanpa ngetik IP berulang kali

Di local

```console
nano ~/.ssh/config
```

Trus buat config nya

```bash
Host testhost
    HostName your_domain
    User demo
```

## Langkah 9 - Limit user yang bisa connect ke SSH

```console
sudo nano /etc/ssh/sshd_config
```

Cari dan edit

```bash
AllowUsers user1 user2
```

Restart

```console
sudo service ssh restart
```

## Langkah 10 - Nonaktifkan login dengan root

```console
sudo nano /etc/ssh/sshd_config
```

Cari dan edit

```bash
PermitRootLogin no
```

Restart

```console
sudo service ssh restart
```

## Langkah 11 - Jaga koneksi terus hidup

```console
nano ~/.ssh/config
```

cari dan edit

```bash
Host *
    ServerAliveInterval 120
```

# Install Nginx Ubuntu 22.04

## Langkah 1 - Install Nginx

```console
sudo apt update
sudo apt install nginx
```

Enable Nginx

```console
sudo systemctl start nginx
sudo systemctl enable nginx
```

## Langkah 2 - Atur ulang firewall

```console
sudo ufw app list
```

```console
sudo ufw allow 'Nginx HTTP'
```

verifiy

```console
sudo ufw status
```

## Langkah 3 - Cek web server

```console
systemctl status nginx
```

Buka ip address nya, kalau ga tau silahkan ketik di server:

```console
curl -4 icanhazip.com
```

## Langkah 4 - Command untuk Nginx

Stop web server:

```console
sudo systemctl stop nginx
```

Start web server:

```console
sudo systemctl start nginx
```

Stop and start web server:

```console
sudo systemctl restart nginx
```

Configuration changes and reload web server:

```console
sudo systemctl reload nginx
```

Disable startu automaticaly the server:

```console
sudo systemctl disable nginx
```

Start at boot server:

```console
sudo systemctl enable nginx
```

## Langkah 5 - Install PHP

```console
sudo apt install php8.2-fpm php8.2-sqlite3
```

verify

```console
php -v
```

Cek Sqlite

```console
sqlite3 --version
```

## Langkah 5 - Setup server block

Multiple domain di /var/www/

Buat directory

```console
sudo mkdir -p /var/www/your_domain
```

Kasih ownership access ke
$USER environtment variable

```console
sudo chown -R $USER:$USER /var/www/your_domain
```

permission

```console
sudo chmod -R 755 /var/www/your_domain
```

setup configuration block

```console
sudo nano /etc/nginx/sites-available/your_domain
```

configuration

```bash
server {
    listen 80;
    server_name your_domain www.your_domain;
    root /var/www/your_domain;

    index index.html index.htm index.php;

    location / {
        try_files $uri $uri/ =404;
    }

    location ~ \.php$ {
        include snippets/fastcgi-php.conf;
        fastcgi_pass unix:/var/run/php/php8.1-fpm.sock;
     }

    location ~ /\.ht {
        deny all;
    }

}
```

site enable

```console
sudo ln -s /etc/nginx/sites-available/your_domain /etc/nginx/sites-enabled/
```

unlink

```console
sudo unlink /etc/nginx/sites-enabled/default
```

prevent memory bucket problem

```console
sudo nano /etc/nginx/nginx.conf
```

cari server_names_hash_bucket_size, uncomment

```bash
...
http {
    ...
    server_names_hash_bucket_size 64;
    ...
}
...
```

Cek syntax error di config nginx

```console
sudo nginx -t
```

kalau aman restart

```console
sudo systemctl restart nginx
```

# Securing Nginx

## Langkah 1 - Install Certbot

```console
sudo snap install core; sudo snap refresh core
```

link certbot command

```console
sudo ln -s /snap/bin/certbot /usr/bin/certbot
```

## Langkah 2 - Setting Firewall

Cek firewall

```console
sudo ufw status
```

Tambah

```console
sudo ufw allow 'Nginx Full'
sudo ufw delete allow 'Nginx HTTP'
```

Cek statusnya

```console
sudo ufw status
```

## Langkah 3 - Keluarin Sertifikat SSL

```console
sudo certbot --nginx -d example.com -d www.example.com
```

## Langkah 4 - Verifikasi

```console
sudo systemctl status snap.certbot.renew.service
```

dryrun

```console
sudo certbot renew --dry-run
```

# Add New Website

## Persiapan di Server

Buat folder di /var/www/

```console
sudo mkdir -p /var/www/your_domain
```

Kasih ownership access ke
$USER environtment variable

```console
sudo chown -R $USER:$USER /var/www/your_domain
```

permission

```console
sudo chmod -R 755 /var/www/your_domain
```

setup configuration block

```console
sudo nano /etc/nginx/sites-available/your_domain
```

configuration

```bash
server {
    listen 80;
    server_name your_domain www.your_domain;
    root /var/www/your_domain;

    index index.html index.htm index.php;

    location / {
        try_files $uri $uri/ =404;
    }

    location ~ \.php$ {
        include snippets/fastcgi-php.conf;
        fastcgi_pass unix:/var/run/php/php8.1-fpm.sock;
     }

    location ~ /\.ht {
        deny all;
    }

}
```

site enable

```console
sudo ln -s /etc/nginx/sites-available/your_domain /etc/nginx/sites-enabled/
```

Cek syntax error di config nginx

```console
sudo nginx -t
```

kalau aman restart

```console
sudo systemctl restart nginx
```

## Arahkan domain ke IP

## Install Certbot

```console
sudo certbot --nginx -d example.com -d www.example.com
```

```console
sudo systemctl status snap.certbot.renew.service
```

dryrun

```console
sudo certbot renew --dry-run
```
