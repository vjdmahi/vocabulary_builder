<p align="center">
  <img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="300">
</p>

# 📚 Vocabulary Builder Web App

## 🚀 About the Project
This is a Laravel-based web application that helps users improve their vocabulary through visual learning.

Users can enter a word, and the system fetches relevant images from an external API to help understand the meaning more effectively.

---

## ✨ Features
- 🔍 Search for any word  
- 🖼️ Display related images using API  
- ⚡ Fast and user-friendly interface  
- 📖 Visual-based vocabulary learning  

---

## 🛠️ Technologies Used
- PHP (Laravel Framework)  
- REST API  
- HTML, CSS, JavaScript  
- MySQL  

---

## ⚙️ How It Works
1. User enters a word  
2. Application sends request to image API  
3. Images are fetched dynamically  
4. Results are displayed to the user  

---

## 📥 Installation

```bash
git clone https://github.com/vjdmahi/vocabulary_builder.git
cd vocabulary_builder
composer install
cp .env.example .env
php artisan key:generate
php artisan serve
