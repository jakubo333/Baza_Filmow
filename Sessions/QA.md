# Zapis z Sesji: QA Agent (Sessions/QA.md)
**Agent: Llama (Agent QA / QA Agent)**

Moim zadaniem było "zepsucie" aplikacji, aby upewnić się, że jest stabilna. Przeprowadziłem serię testów zintegrowanych. Sprawdzałem, czy wyszukiwarka reaguje na niepełne tytuły, próbowałem dodawać puste recenzje oraz opinie z ocenami wychodzącymi poza skalę 1-10. 

**Aktualizacja V5 (Logowanie i Haszowanie):** Przetestowałem nowy moduł rejestracji. Baza danych nie przechowuje czystych tekstowo haseł, ale wygenerowane bezpowrotnie hash-e bcrypt. Użytkownik anonimowy próbujący wbić na URL `dodaj_film.php` zostaje poprawnie zrzucony (Redirect 302) do strony logowania. Autoryzacja działa perfekcyjnie.
