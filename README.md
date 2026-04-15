# affiliate-hub
Affiliate Hub adalah web application untuk memajang dan mengelola link affiliate dalam bentuk product showcase yang simple, clean, dan modern.

Aplikasi ini berfungsi sebagai wadah display produk affiliate agar lebih mudah dipromosikan, dilacak click-nya, dan diorganisir berdasarkan kategori.

# Tech Stack
- Laravel 13 (Backend API + MVC)
- Vue 3 (Frontend)
- Inertia.js
- TailwindCSS
- Vite

# Features
- Product listing affiliate
- Category filtering
- Click tracking per product
- Redirect tracking system
- Search product realtime
- Admin dashboard (optional)
- Responsive UI

# Installation Guide 
1. git clone https://github.com/username/affiliate-hub.git
2. cd affiliate-hub
3. composer install
4. npm install
5. cp .env.example .env
6. php artisan key:generate
7. php artisan migrate
8. composer run dev

# Notes
- Click tracking berdasarkan IP + timestamp
- Produk di-load via Inertia (Laravel → Vue)
- UI fully responsive & modern
- Designed untuk affiliate marketing scalable system

