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
