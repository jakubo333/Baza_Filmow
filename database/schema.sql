
CREATE DATABASE IF NOT EXISTS movie_db CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE movie_db;

CREATE TABLE uzytkownicy (
    id INT AUTO_INCREMENT PRIMARY KEY,
    login VARCHAR(50) NOT NULL UNIQUE,
    haslo VARCHAR(255) NOT NULL,
    data_rejestracji TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE filmy (
    id INT AUTO_INCREMENT PRIMARY KEY,
    tytul VARCHAR(255) NOT NULL,
    rok INT NOT NULL,
    gatunek VARCHAR(100) NOT NULL,
    opis TEXT
);

CREATE TABLE aktorzy (
    id INT AUTO_INCREMENT PRIMARY KEY,
    imie VARCHAR(100) NOT NULL,
    nazwisko VARCHAR(100) NOT NULL,
    biografia TEXT
);

CREATE TABLE obsada (
    film_id INT,
    aktor_id INT,
    rola VARCHAR(255),
    PRIMARY KEY (film_id, aktor_id),
    FOREIGN KEY (film_id) REFERENCES filmy(id) ON DELETE CASCADE,
    FOREIGN KEY (aktor_id) REFERENCES aktorzy(id) ON DELETE CASCADE
);

CREATE TABLE recenzje (
    id INT AUTO_INCREMENT PRIMARY KEY,
    film_id INT,
    autor VARCHAR(100) NOT NULL,
    ocena INT CHECK (ocena >= 1 AND ocena <= 10),
    tresc TEXT,
    data_dodania TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (film_id) REFERENCES filmy(id) ON DELETE CASCADE
);

-- Przykładowy użytkownik admin / admin123 (hash wygenerowany przez password_hash w PHP)
INSERT INTO uzytkownicy (login, haslo) VALUES ('admin', '$2y$10$wT8vI8D2k2fW3oO/5L.B.eN4lY.uT8X.sF4/g3cR2vQ.E3X4b9d7K');

-- Przykładowe dane - Filmy
INSERT INTO filmy (id, tytul, rok, gatunek, opis) VALUES 
(1, 'Matrix', 1999, 'Sci-Fi / Akcja', 'Haker Neo odkrywa przerażającą prawdę o rzeczywistości i swojej roli w wojnie maszyn z ludźmi.'),
(2, 'Incepcja', 2010, 'Sci-Fi / Thriller', 'Złodziej, który wykrada sekrety z podświadomości podczas snu, otrzymuje zadanie zaszczepienia idei w umyśle dziedzica fortuny.'),
(3, 'Interstellar', 2014, 'Sci-Fi', 'Zespół badaczy podróżuje przez tunel czasoprzestrzenny w kosmosie, aby znaleźć nowy dom dla ludzkości.'),
(4, 'Mroczny Rycerz', 2008, 'Akcja / Kryminał', 'Batman, porucznik Gordon i prokurator Harvey Dent zmagają się z przerażającym psychopatą znanym jako Joker.'),
(5, 'Pulp Fiction', 1994, 'Kryminał', 'Przeplatające się historie dwóch płatnych morderców, boksera, żony gangstera i pary napadającej na restaurację.'),
(6, 'Skazani na Shawshank', 1994, 'Dramat', 'Bankier niesłusznie skazany na dożywocie zaprzyjaźnia się z więziennym przemytnikiem i powoli adaptuje się do brutalnego życia.'),
(7, 'Władca Pierścieni: Drużyna Pierścienia', 2001, 'Fantasy', 'Hobbit Frodo Baggins wyrusza w niebezpieczną podróż, by zniszczyć potężny pierścień, zanim wpadnie on w ręce Mrocznego Władcy.'),
(8, 'Forrest Gump', 1994, 'Dramat / Komedia', 'Historia życia mężczyzny o niskim ilorazie inteligencji, który mimo przeciwności losu bierze udział w najważniejszych wydarzeniach XX wieku.'),
(9, 'Gladiator', 2000, 'Dramat historyczny', 'Generał rzymski zostaje zdradzony i zredukowany do roli gladiatora, szukając zemsty na skorumpowanym cesarzu.'),
(10, 'Titanic', 1997, 'Melodramat', 'Arystokratka zakochuje się w biednym artyście na pokładzie niefortunnego statku R.M.S. Titanic.');

-- Przykładowe dane - Aktorzy
INSERT INTO aktorzy (id, imie, nazwisko, biografia) VALUES 
(1, 'Keanu', 'Reeves', 'Kanadyjski aktor, muzyk i reżyser, znany głównie z ról w filmach akcji i sci-fi.'),
(2, 'Leonardo', 'DiCaprio', 'Amerykański aktor i producent filmowy, laureat Oscara, znany z ról u najważniejszych reżyserów.'),
(3, 'Matthew', 'McConaughey', 'Amerykański aktor, który przeszedł drogę od komedii romantycznych do wybitnych ról dramatycznych.'),
(4, 'Christian', 'Bale', 'Walijski aktor znany z niesamowitych transformacji fizycznych do ról.'),
(5, 'John', 'Travolta', 'Amerykański aktor, tancerz i piosenkarz. Gwiazda lat 70. i 90.'),
(6, 'Morgan', 'Freeman', 'Amerykański aktor i reżyser, posiadacz jednego z najbardziej rozpoznawalnych głosów w kinie.'),
(7, 'Elijah', 'Wood', 'Amerykański aktor, niezapomniany odtwórca roli Froda.'),
(8, 'Ian', 'McKellen', 'Brytyjski aktor teatralny i filmowy, legenda sceny szekspirowskiej.'),
(9, 'Heath', 'Ledger', 'Australijski aktor, pośmiertny laureat Oscara za rolę Jokera.'),
(10, 'Tom', 'Hanks', 'Jeden z najbardziej lubianych i cenionych amerykańskich aktorów w historii kina.'),
(11, 'Russell', 'Crowe', 'Nowozelandzki aktor, laureat Oscara za rolę w Gladiatorze.'),
(12, 'Joaquin', 'Phoenix', 'Amerykański aktor znany z ról skomplikowanych psychologicznie postaci.'),
(13, 'Kate', 'Winslet', 'Brytyjska aktorka, siedmiokrotnie nominowana do Oscara.'),
(14, 'Samuel L.', 'Jackson', 'Amerykański aktor, współpracownik Quentina Tarantino.');

-- Przykładowe dane - Obsada
INSERT INTO obsada (film_id, aktor_id, rola) VALUES 
(1, 1, 'Thomas A. Anderson / Neo'),
(2, 2, 'Dom Cobb'),
(3, 3, 'Joseph Cooper'),
(4, 4, 'Bruce Wayne / Batman'),
(4, 9, 'Joker'),
(5, 5, 'Vincent Vega'),
(5, 14, 'Jules Winnfield'),
(6, 6, 'Ellis Boyd "Red" Redding'),
(7, 7, 'Frodo Baggins'),
(7, 8, 'Gandalf Szary'),
(8, 10, 'Forrest Gump'),
(9, 11, 'Maximus Decimus Meridius'),
(9, 12, 'Commodus'),
(10, 2, 'Jack Dawson'),
(10, 13, 'Rose DeWitt Bukater');

-- Przykładowe dane - Recenzje
INSERT INTO recenzje (film_id, autor, ocena, tresc) VALUES 
(1, 'Kinomaniak', 10, 'Absolutny klasyk gatunku, pozycja obowiązkowa, która zmieniła kino akcji na zawsze.'),
(4, 'Komiksiarz', 10, 'Najlepszy film o Batmanie. Rola Ledgera przejdzie do historii.'),
(2, 'Sennik', 9, 'Niesamowicie zawiły scenariusz i świetna muzyka Hansa Zimmera.');
