# Troubleshoot: MySQL Connection via Coolify + WireGuard + HAProxy

## Arsitektur

```
PC Lokal (Laragon)
    → Cloudflare DNS (mysql.fgdev.tech - DNS Only / grey cloud)
        → Oracle Server (HAProxy port 5432)
            → WireGuard tunnel (10.50.0.4)
                → Server Coolify (Docker MySQL container 3306 → public 5432)
```

## Gejala

- `SQLSTATE[HY000] [2002] A connection attempt failed...` (timeout)
- `SQLSTATE[HY000] [2006] MySQL server has gone away`
- HAProxy log: `backend 'mysql_coolify' has no server available!`

## Langkah Diagnosa

### 1. Cek dari Oracle Server (SSH)

```bash
# Cek HAProxy status
systemctl status haproxy

# Cek apakah port 5432 listening
ss -tlnp | grep 5432

# Test koneksi ke Coolify via WireGuard
nc -zv 10.50.0.4 5432 -w 5

# Cek WireGuard status
sudo wg show
```

### 2. Cek dari Server Coolify (SSH)

```bash
# Cek apakah MySQL container running
docker ps | grep mysql

# Cek port mapping
docker ps --format "table {{.Names}}\t{{.Ports}}" | grep mysql

# Cek apakah port 5432 listen di host
ss -tlnp | grep 5432
```

## Penyebab Umum & Solusi

### A. Cloudflare Proxy aktif (orange cloud)

**Gejala:** Timeout total, ping resolve ke IP Cloudflare (104.x.x.x)

**Solusi:** Di Cloudflare Dashboard → DNS → record `mysql.fgdev.tech` → ubah ke **DNS Only** (grey cloud). Cloudflare hanya proxy HTTP/HTTPS, bukan TCP/MySQL.

### B. MySQL container tidak expose port 5432

**Gejala:** `nc -zv 10.50.0.4 5432` timeout dari Oracle, `ss -tlnp | grep 5432` kosong di Coolify server. Docker `ps` menunjukkan `3306/tcp` tanpa mapping.

**Solusi:**
1. Coolify Dashboard → MySQL service → Configuration
2. Cek "Make it publicly available" ✓
3. Public Port: `5432`
4. Kalau error `nginx.conf: Is a directory`:
   ```bash
   rm -rf /data/coolify/databases/<container-id>/proxy/nginx.conf
   mkdir -p /data/coolify/databases/<container-id>/proxy
   ```
5. Klik "Make it publicly available" lagi
6. Restart service

### C. HAProxy backend DOWN (flapping)

**Gejala:** HAProxy log menunjukkan server UP lalu DOWN berulang.

**Solusi:**
```bash
# Setelah fix di Coolify, restart HAProxy
systemctl restart haproxy

# Verifikasi
journalctl -u haproxy --since "1 min ago" --no-pager
```

### D. Container name conflict saat restart

**Gejala:** `Error response from daemon: Conflict. The container name is already in use`

**Solusi:**
```bash
docker rm -f <container_name>
# Lalu restart dari Coolify dashboard
```

## Verifikasi Koneksi Berhasil

Dari terminal Laragon:
```bash
php artisan db:show
php artisan migrate
```

## Konfigurasi .env

```env
DB_CONNECTION=mysql
DB_HOST=mysql.fgdev.tech
DB_PORT=5432
DB_DATABASE=plasmo
DB_USERNAME=mysql
DB_PASSWORD=<password>
```

## Catatan

- Port 5432 digunakan sebagai public port mapping (bukan port default MySQL 3306) untuk menghindari scanning bot
- WireGuard peer `10.50.0.4` = server Coolify
- HAProxy config: `/etc/haproxy/haproxy.cfg`
- Coolify proxy data: `/data/coolify/databases/<container-id>/proxy/`
