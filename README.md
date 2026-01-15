# 🚀 NetTrack - Troubleshooting Ticket System

NetTrack adalah aplikasi manajemen pelaporan gangguan (ticketing system) yang dirancang untuk membantu tim teknis mencatat, memantau, dan mengelola histori gangguan pelanggan secara efisien. 

Sistem ini dilengkapi dengan fitur audit log untuk keamanan data dan fitur ekspor laporan untuk kebutuhan manajerial.

## ✨ Fitur Utama

* **Manajemen Tiket**: Pembuatan tiket gangguan dengan nomor referensi unik otomatis.
* **Filter Canggih**: Pencarian berdasarkan status (Open, In Progress, Resolved), rentang tanggal, dan nama pelanggan.
* **Audit Logs**: Mencatat setiap aktivitas user (siapa, melakukan apa, kapan, dan dari IP mana) untuk keamanan sistem.
* **Dynamic Pagination**: Kontrol jumlah tampilan baris data (10, 20, 50, All) per halaman.
* **Export to Excel**: Mengunduh laporan yang sudah difilter langsung ke format .xlsx menggunakan *Laravel Excel*.
* **Zona Waktu Lokal**: Sudah dikonfigurasi menggunakan GMT+7 (WIB) untuk akurasi pelaporan di Indonesia.
* **UI Modern**: Antarmuka responsif menggunakan Tailwind CSS dengan desain kartu yang bersih.

## 🛠️ Tech Stack

- **Framework:** Laravel 11
- **Database:** MySQL
- **Frontend:** Tailwind CSS, Blade Templating, FontAwesome
- **Library:** `maatwebsite/excel` (Export Data)
- **Timezone:** Asia/Jakarta (WIB)

## 📸 Preview Antarmuka

<img width="1900" height="957" alt="image" src="https://github.com/user-attachments/assets/30e83e16-4871-42d4-8825-6f140b3af2a3" />
<img width="1898" height="961" alt="image" src="https://github.com/user-attachments/assets/3bf5cbe8-c0ba-4b64-9efa-7e5f2ce2b361" />


## ⚙️ Instalasi

1. **Clone repository**
   ```bash
   git clone [https://github.com/username-anda/net-track.git](https://github.com/username-anda/net-track.git)
   cd net-track

2. **Akun**
   email: admin@arindama.com
   pw: 12345678

3. File database dengan data lengkap terlampir pada folder database.
