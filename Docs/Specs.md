# Specyfikacja Wymagań (Specs.md)

## 1. Cel Projektu
Stworzenie prostej, ale funkcjonalnej aplikacji internetowej "Baza filmów" umożliwiającej użytkownikom przeglądanie filmów, sprawdzanie informacji o aktorach i dodawanie/czytanie recenzji. Wersja z rozszerzoną początkową bazą klasyków filmowych.

## 2. Funkcjonalności Główne (Zgodne z PDF)
1.  **Katalog filmów (`index.php`)**: Prezentacja filmów w czytelnej siatce z wyszukiwarką.
2.  **Szczegóły filmu i recenzje (`film.php`)**: Wyświetlanie opisu, średniej oceny oraz obsady.

## 3. Funkcjonalności Dodatkowe (Wersja V5)
*   **System Użytkowników i Logowanie (`login.php`, `rejestracja.php`)**: Zgodnie z wytycznymi wprowadzono opcjonalny system kont. Użytkownicy mogą rejestrować konta, a ich hasła są bezpiecznie **haszowane za pomocą wbudowanych funkcji PHP (`password_hash()`)**.
*   **Restrykcje dostępowe**: Dodawanie nowych filmów (`dodaj_film.php`) oraz pisanie recenzji pod filmami wymaga wcześniejszego zalogowania się do systemu. Niezweryfikowani użytkownicy są odsyłani do formularza logowania.
