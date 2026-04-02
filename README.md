<p align="center">
  <img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="300">
</p>

# 📚 VocabBuilder

A modern **Vocabulary Learning Web Application** built using **Laravel, JavaScript, and CSS**.  
VocabBuilder helps users **learn, practice, and manage vocabulary** through interactive quizzes, flashcards, and personalized word lists.

---

## 🌟 Overview

VocabBuilder is designed to improve vocabulary learning through:
- Active recall (Quiz)
- Repetition (Flashcards)
- Organization (Word List)

It provides a clean and user-friendly interface for learners to track and enhance their language skills.

---

## 🚀 Features

### 📊 Dashboard
- View total words learned
- Track learning progress with charts
- Quick access to features

### ➕ Add New Word
- Add vocabulary words with meaning and examples
- Auto-fetch meaning and example support
- Audio pronunciation feature

### 📖 Word List
- View all saved vocabulary
- Search words and meanings
- Edit and delete entries

### 🧠 Quiz System
- Multiple choice questions
- Instant feedback
- Interactive learning experience

### 🃏 Flashcards
- Flip card learning method
- Navigate between words
- Improve memory retention

---

## 🖼️ Screenshots

### 🧠 Quiz Interface
![Quiz](./screenshots/quiz.png)

### ➕ Add New Word
![Add Word](./screenshots/add.png)

### 📊 Dashboard
![Dashboard](./screenshots/DB.png)

### 🃏 Flashcards
![Flashcards](./screenshots/flashcard.png)

### 📖 Word List
![Word List](./screenshots/list.png)

---

## 🛠️ Tech Stack

| Technology | Description |
|----------|-------------|
| Laravel | Backend framework (PHP) |
| JavaScript | Client-side interactivity |
| HTML & CSS | Frontend structure and styling |
| MySQL | Database |

---

## ⭐ Support

If you like this project, give it a ⭐ on GitHub!

[![GitHub stars](https://img.shields.io/github/stars/vjdmahi/vocabulary_builder?style=social)](https://github.com/vjdmahi/vocabulary_builder/stargazers)


## 📥 Installation

```bash
git clone https://github.com/vjdmahi/vocabulary_builder.git
cd vocabulary_builder
composer install
cp .env.example .env
php artisan key:generate
php artisan serve


