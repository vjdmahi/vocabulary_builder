# Vocabulary Builder Project Report

## 1. Project Overview
**Vocabulary Builder** is a web-based application designed to help users expand their vocabulary in an interactive and engaging way. The application allows learners to manage their own dictionary, track their learning progress, and reinforce their knowledge through flashcards and quizzes.

## 2. Key Features

### 2.1 Dashboard
The dashboard provides a quick overview of the user's learning journey.
- **Total Words Learned**: Displays the total count of words added to the vocabulary.
- **Learning Progress Chart**: A visual representation of learning activity over time.
- **Quick Actions**: Easy access to add new words.

![Dashboard Screenshot](docs/images/dashboard.png)
*Figure 1: User Dashboard with progress tracking.*

### 2.2 Vocabulary Management (Word List)
Users can view, search, and manage their collection of words.
- **Search**: Quickly find specific words or meanings.
- **List View**: Displays words with their meanings, examples, and detailed information.
- **Edit/Delete**: Options to update or remove words from the list.

![Word List Screenshot](docs/images/word_list.png)
*Figure 2: Vocabulary list with search and management options.*

### 2.3 Interactive Learning Tools

#### Flashcards
A digital flashcard system for active recall.
- **Front**: Shows an image (if available) to modify the visual memory context.
- **Back**: Reveals the meaning and example usage.
- **Navigation**: Easy flip animation and navigation between cards.

![Flashcards Screenshot](docs/images/flashcards.png)
*Figure 3: Interactive flashcards for vocabulary practice.*

#### Quiz Mode
A multiple-choice quiz to test vocabulary retention.
- **Question**: Prompts with a word or meaning.
- **Options**: Multiple possible answers to choose from.
- **Feedback**: Immediate feedback on correctness.

![Quiz Screenshot](docs/images/quiz.png)
*Figure 4: Quiz interface for testing knowledge.*

### 2.4 Add New Word
A streamlined interface for adding new vocabulary.
- **Auto-Fetch**: Automatically retrieves meanings and examples for entered words (if enabled).
- **Manual Entry**: Allows users to input custom definitions and examples.

![Add Word Screenshot](docs/images/add_word.png)
*Figure 5: Add New Word form.*

## 3. Technology Stack

### Backend
- **Framework**: Laravel 11 (PHP 8.2+)
- **Database**: MySQL / SQLite

### Frontend
- **Templating**: Blade
- **Styling**: Tailwind CSS / Custom CSS
- **Interactivity**: JavaScript (Alpine.js / Vanilla JS)
- **Bundling**: Vite

## 4. Installation & Setup

To run this project locally, follow these steps:

1.  **Clone the repository**:
    ```bash
    git clone https://github.com/your-username/vocabulary-builder.git
    cd vocabulary-builder
    ```

2.  **Install dependencies**:
    ```bash
    composer install
    npm install
    ```

3.  **Environment Setup**:
    ```bash
    cp .env.example .env
    php artisan key:generate
    ```

4.  **Database Migration**:
    ```bash
    php artisan migrate
    ```

5.  **Run the Application**:
    ```bash
    npm run dev
    php artisan serve
    ```

6.  Access the application at `http://localhost:8000`.

## 5. Conclusion
The Vocabulary Builder project successfully implements a full-stack web application that aids in language learning. It combines a robust backend with an intuitive frontend to provide a seamless user experience.
