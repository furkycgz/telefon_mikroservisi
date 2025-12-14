📱 Phone Validation Microservice (Docker + Laravel)

Bu proje, Web Teknolojileri dersi kapsamında geliştirilmiş bir telefon doğrulama mikroservisi uygulamasıdır.
Uygulama Docker ortamında tek komutla çalıştırılabilmekte ve frontend – API – veritabanı olmak üzere 3 servisli bir mimari sunmaktadır.

🧩 Proje Mimarisi
phone-microservice/
│
├── api/ → Laravel tabanlı REST API
├── frontend/ → Nginx + HTML (Reverse Proxy)
├── docker-compose.yml
└── README.md

Kullanılan Teknolojiler

Backend: Laravel (PHP)

Frontend: HTML + JavaScript

Web Server: Nginx (Reverse Proxy)

Database: MySQL 8

Containerization: Docker & Docker Compose

DB Yönetimi: phpMyAdmin

⚙️ Telefon Numarası Doğrulama Kuralları

Kurgusal bir kasabada tüm telefon numaraları 6 basamaklıdır ve aşağıdaki kurallara uymak zorundadır:

Telefon numarasında en az bir tane 0’dan farklı rakam bulunmalıdır

İlk üç basamağın toplamı, son üç basamağın toplamına eşit olmalıdır
(a1 + a2 + a3 = a4 + a5 + a6)

Tek sıradaki basamakların toplamı, çift sıradaki basamakların toplamına eşit olmalıdır
(a1 + a3 + a5 = a2 + a4 + a6)

📌 Örnek geçerli numara:

054153

🌐 Servisler ve Portlar
Servis Açıklama Adres
Frontend Kullanıcı arayüzü http://localhost:8080

API Laravel REST API http://localhost:8000

phpMyAdmin Veritabanı yönetimi http://localhost:8081

MySQL Veritabanı servisi Docker içi
▶️ Kurulum ve Çalıştırma
Gereksinimler

Docker

Docker Compose

Tek Komutla Çalıştırma
docker-compose up --build

📌 Bu komut:

MySQL veritabanını başlatır

Laravel API’yi ayağa kaldırır

Nginx frontend servisini çalıştırır

phpMyAdmin’i erişilebilir hale getirir

🖥️ Frontend – API İletişimi

Frontend, API’ye doğrudan erişmez.
Tüm istekler Nginx Reverse Proxy üzerinden iletilir:

Browser → http://localhost:8080/api/...
Nginx → http://api:8000/api/...

Bu yapı sayesinde:

API adresi gizlenir

Mikroservis mimarisi sağlanır

Ödev şartları birebir karşılanır ✅

🗄️ Veritabanı Yapısı
registrations Tablosu
Alan Tip
id bigint
name string
email string
phone string(6)
created_at timestamp
updated_at timestamp

📌 Aynı telefon numarasının tekrar kaydedilmesi engellenmiştir.

🔍 Veritabanını Görüntüleme

phpMyAdmin üzerinden erişim:

http://localhost:8081

Giriş bilgileri:

Server: db

Username: phone_user



Database: phone_db

📸 Rapor İçin Önerilen Screenshotlar

docker-compose up çıktısı

phpMyAdmin tablo görünümü

Frontend formu

Geçerli / geçersiz telefon sonucu

🎯 Proje Özeti

✅ Docker Compose

✅ 3 servisli mimari

✅ Reverse Proxy

✅ Telefon doğrulama algoritması

✅ MySQL + phpMyAdmin

✅ Tek komutla çalıştırma
