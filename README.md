

<h1 align="center">Selamat datang di Website CSV! 👋</h1>

 ### Halaman Admin
![Admin Panel](https://github.com/machfudin37/website-csv/blob/main/tampilan/ui-admin.png?raw=true)


 ### Halaman User
![User Panel](https://github.com/machfudin37/website-csv/blob/main/tampilan/ui-user.png?raw=true)

------------

## Website CSV
Website CSV merupakan aplikasi yang dibuat untuk mengkonversi staff yang biasanya mencatat data dari excel yang berbentuk .csv ke website agar dapat memudahkan dalam menampilkan data yang bisa ubah menjadi .pdf dan dapat memvisualisasikan data yang dimasukan staff menjadi grafik. aplikasi ini dibangun menggunakan Framework Laravel versi 10.

------------

## Demo
Demo website dapat dilihat disini. [Lihat Demo](https://youtu.be/AvtI2iBWaos)

------------
 ### 👤 Default Account for testing
	
**Admin Default Account**
- Email: admin@gmail.com
- Password: 123
- ```http://127.0.0.1:8000/```

**User Default Account**
- Email: user@gmail.com
- Password: 123
- ```http://127.0.0.1:8000/```

------------
## 💻 Install

1. **Clone Repository**
```bash
git clone https://github.com/machfudin37/website-csv.git
```

2. **Buka source code dengan text editor**

3. **ketikan perintah berikut di terminal untuk menginstall Dependencies dari Laravel:**
```bash
composer install
```

4. **ubah/copy .env.example menjadi .env dan sesuaikan isi dari .env:**

5. **ketikan perintah berikut di terminal untuk memasukan database pada mysql:**
```bash
php artisan migrate
```

6. **ketikan perintah berikut di terminal untuk memasukan isi database pada mysql:**
```bash
php artisan db:seed
```

7. **ketikan perintah berikut di terminal untuk membuat app key .env**
```bash
php artisan key:generate
```

8. **Buka ```localhost:8000/``` untuk menjalankan website**
