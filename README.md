# Setup VPS

## Langkah 1 - Login sebagai root
```console
ssh root@your_server_ip
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
### Jika punya password
```console
ssh fadli@your_server_ip
```

### Jika root sudah menggunakan SSH
```console
rsync --archive --chown=fadli:fadli ~/.ssh /home/fadli
```

### Jika belum setup SSH
#### Generate SSH di lokal
```console
ssh-keygen
```
Akan ada 2 file yang jadi:
- ~/.ssh/id_rsa: Private key. Jangan share ini.
- ~/.ssh/id_rsa.pub: Public key. Bisa di share.
