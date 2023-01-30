# Instrukcja instalacji oraz obsługi wtyczki „BluePayment” dla platformy OpenCart 2.3

**Moduł przeznaczony jest tylko dla OpenCart w wersji 2.3. W celu pobrania modułu dla wersji 3.x, przejdź [tutaj.](https://github.com/bluepayment-plugin/opencart-plugin)** 

## Podstawowe informacje
BluePayment to moduł płatności umożliwiający realizację transakcji bezgotówkowych w sklepie opartym na platformie OpenCart. Jeżeli jeszcze nie masz wtyczki, możesz ją pobrać [tutaj.](https://github.com/bluepayment-plugin/opencart-plugin/raw/master/bm.ocmod.zip)

### Główne funkcje

Do najważniejszych funkcji modułu zalicza się:
- realizację płatności online poprzez odpowiednie zbudowanie startu transakcji
- obsługę powiadomień o statusie transakcji (notyfikacje XML)
- obsługę zakupów bez rejestracji w serwisie
- obsługę dwóch trybów działania – testowego i produkcyjnego (dla każdego z nich wymagane są osobne dane kont, po które zwróć się do nas)
- przekierowanie na paywall/bramkę Blue media, gdzie są dostępne wszystkie formy płatności 

### Wymagania systemowe
- OpenCart 2.3
- Wersja PHP 5.4 lub wyższa

### Opis zmian

Wersja 1.0.5
- Dodaliśmy obsługę Visa Mobile.
- Ustandaryzowaliśmy tekst **Klucz konfiguracyjny (hash)** (wcześniej _Klucz współdzielony_) w konfiguracji modułu.
- Dodaliśmy informację o aktualnej wersji platformy oraz moduły podczas rozpoczęcia transakcji.

Wersja 1.0.1
- Dodaliśmy komunikat pomocniczy dot. środowiska testowego w panelu administracyjnym.

Wersja 1.0.0
- Pierwsza wersja dokumentu

## Instalacja modułu
Możesz zainstalować moduł płatności jedną z dwóch metod – automatycznie lub manualnie.

### Instalacja manualna

1. Przejdź do zakładki **Extensions ➝ Installer**
2. Za pomocą formularza **załaduj plik z modułem**, a następnie wyślij formularz.
3. Przejdź do punktu Aktywacja modułu

## Aktywacja

1. Przejdź do zakładki **Extensions > Extensions** 
2. Z listy rozwijanej wybierz **Payments**
3. Wyszukaj moduł **BM płatności online**, zainstaluj ją, a następnie przejdź do konfiguracji modułu.

<img width="611" alt="Widok modułu w zakładce Rozszerzenia" src="https://user-images.githubusercontent.com/87177993/126613447-92c964e1-4f31-4ac3-91e4-663f47380f9a.png">

*Widok modułu w zakładce "Rozszerzenia"*

## Konfiguracja modułu

### Konfiguracja podstawowych pól wtyczki

1. W sekcji **Włącz/Wyłącz** decydujesz czy kanał płatności będzie widoczny podczas składania zamówienia.

2. **Użyj środowiska testowego** – wybierając opcję **TAK**, sprawisz, że wszystkie płatności będą przekierowywane na testową bramkę płatniczą, która znajduje się pod adresem https://oplacasie-accept.bm.pl. Jeżeli tego nie zrobisz, automatycznie zostanie ustawiona produkcyjna wersja bramki płatniczej, a wszystkie płatności zostaną przekierowane na adres https://oplacasie.bm.pl.

Jeżeli wybierzesz środowisko testowe, moduł nie będzie przetwarzał żadnych faktycznych płatności.

3. **Status oczekiwania na płatność** – wybrany status zostanie ustawiony dla nowego zamówienia.

4. **Status prawidłowej płatności** – wybrany status zostanie ustawiony dla zamówienia, które zostało prawidłowo opłacone.

5. **Status nieprawidłowej płatności** – wybrany status zostanie ustawiony dla zamówienia, które nie zostało prawidłowo opłacone.

6. Po uzupełnieniu wszystkich pól – wciśnij: **Zapisz zmiany** i gotowe.

<img width="514" alt="Widok konfiguracji modułu" src="https://user-images.githubusercontent.com/87177993/126634649-d01a3169-ecc0-423d-8e14-9a3af7746c22.png">

*Widok konfiguracji modułu*

### Konfiguracja sekcji Ustawienia walut

Żeby wyświetlić waluty – zdefiniuj je w zakładce **System ➝ Localisation ➝ Currencies**

**Pola wspólne dla wszystkich walut:**

1. **Identyfikator serwisu partnera** – ma wartość liczbową i jest unikalny dla każdego sklepu (otrzymasz go od Blue Media).

2. **Klucz konfiguracyjny (hash)** – unikalny klucz przypisany do danego sklepu (otrzymasz go od Blue Media).

<img width="514" alt="Przykładowy wygląd ustawień  poszczególnych walut" src="https://user-images.githubusercontent.com/87177993/126635294-083fb905-8700-4ee0-b171-9c5b7bb3ffe7.png">

*Przykładowy wygląd ustawień poszczególnych walut*

### Konfiguracja adresów URL

Upewnij się, że w panelach administracyjnych BlueMedia https://oplacasie.bm.pl oraz https://oplacasie-accept.bm.pl poniższe pola zawierają poprawne adresy sklepu.

- Konfiguracja adresu powrotu po płatności

https://domena-sklepu.pl/index.php?route=extension/payment/ bluepayment/paymentReturn

- Konfiguracja adresu, na który jest wysyłany ITN 

https://domena-sklepu.pl/index.php?route=extension/payment/ bluepayment/processItn
![](Aspose.Words.1383d066-ff99-4ba8-8972-f38f314d96d2.006.jpeg)Strona  PAGE   \\* MERGEFORMAT 1 z  NUMPAGES   \\* MERGEFORMAT 6


## Logi

1. Przejdź do zakładki **Konfiguracja modułu > Logi**.

2. Użyj rozwijanej listy, a znajdziesz tam pliki z podziałem na dni, tworzone według wzoru **bluepayment-YYYY-MM-DD.log** 

Pliki te zawierają logi błędów, które mogą wystąpić podczas procesu płatności. W plikach dostępne są również informacje dotyczące każdej wykonanej płatności za pomocą wtyczki BlueMedia. 

Dane te mogą się okazać przydatne przy zgłaszaniu problemów z działaniem wtyczki. 

<img width="557" alt="Zakładka z logami - przykładowy widok" src="https://user-images.githubusercontent.com/87177993/126635650-fc7a781a-b239-49f0-a629-3d3f4cd7de6e.png">

*Zakładka z logami - przykładowy widok*

