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

#### C.3. Coba login dengan SSH
```console
ssh username@remote_host
```

#### C.4. Login ke SSH tanpa ngetik IP berulang kali
Di local
```console
nano ~/.ssh/config
```
Trus buat config nya
```bash
Host remote_alias
    HostName remote_host
    Port port_num
```
