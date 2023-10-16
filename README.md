# Manager kart do gry Magic the Gathering 
## Opis projektu
MTG to kolekcjonerska gra kaciana, w której gracze mają możliwość fizycznie wymieniać się kartami, sprzedawać je oraz kupować. Do gry konieczne jest utworzenie przynajmniej jedenj talii z posiadanych kart. Niniejszy projekt powstał w celu ułatwienia zarządzania taliami oraz kartami.
## Źródła modelu danych
Jako bazę istniejących kart wykorzystany został open-sourcowy projekt **MTG JSON** (https://mtgjson.com), który udostępnia różne bazy kart do gry MTG. Podczas tworzenia projektu posłużono się modelem *AllPrintings*, ponieważ zawiera on szeroką bazę informacji o wszystkich dotychczas wydrukowanych kartach - https://mtgjson.com/downloads/all-files/

## Wykorzystane technologie
W celu stworzenia pełnej aplikacji niezbędne było wykorzystanie kilku technologii.

Najważniejszym elementem było stworzenie odpowiedniej bazy danych do przechowywania informacji o kartach, użytkownikach, ich kolekcjach i taliach oraz ustalenie relacji zachodzących między nimi. W tym celu wykorzystany został **MySQL**, ponieważ jest to open-source’owy system umożliwiający zarządzanie relacyjnymi bazami danych w prosty sposób.

Interfejs aplikacji został stworzony za pomocą technologii **HTML&CSS**, a połącznie go z bazą danych zostało wykonane za pomocą **PHP**, gdyż dzięki wielu wbudowanym funkcjom, umożliwia on proste powiązanie bazy danych z front-endem.


## Dokumentacja bazy danych
Aplikacja opiera się głównie na odpowiednio stworzonej bazie danych. Aby była ona jednak w pełni użyteczna, baza powinna oferować następujące funkcjonalności:
-	Rejestrację oraz logowanie do systemu
-	Stworzenie kolekcji kart – możliwość dodawania oraz usuwania kart
-	Przeglądanie zawartości swojej kolekcji
-	Stworzenie wielu talii – możliwość dodawania oraz usuwania kart
-	Przeglądanie zawartości swoich talii 
-	Wyznaczenie kart z kolekcji przeznaczonych na sprzedaż
-	Przeglądanie bazy wszystkich dostępnych kart
-	Wyznaczanie kart, które użytkownik chciałby nabyć
-	Wyświetlanie ofert sprzedaży innych użytkowników
-	Przesyłanie kart z kolekcji między użytkownikami

### Struktura bazy
Aby zawrzeć wszystkie założone funkcjonalności aplikacji, w bazie danych zostały stworzone następujące tabele:
-	Użytkownicy (users)
-	Baza kart globalnych (global_card)
-	Kolekcja (collection)
-	Talia (deck)
-	Karty do kupienia (want_to_buy)
-	Karty do sprzedaży (want_to_sell)

Wszystkie kolumny, które są zawarte w tabelach znajdują się na schemacie bazy:

![image](https://user-images.githubusercontent.com/72393493/214519995-19aa2c90-716e-403c-80a1-d0b39553ca95.png)

Aby baza działała zgodnie z przeznaczeniem, zastosowane zostały odpowiednie relacje między tabelami. Każdy użytkownik może posiadać swoją kolekcję, zawierającą jedynie takie karty, które znajdują się w bazie wszystkich kart *(global_cards)*. Co więcej powinien mieć on możliwość stworzenia wielu talii o różnych nazwach, składających się jedynie z kart, które znajdują się w jego kolekcji. Karty, które użytkownik chciałby sprzedać również mogą pochodzić jedynie z jego kolekcji – nie może sprzedać karty, której nie posiada. Dodatkowo możliwe powinno być wyznaczenie kart do kupienia, które znajdują się w bazie wszystkich kart. Wszystkie wyżej opisane relacje zawarte są na schemacie bazy (rysunek wyżej). Warto również dodać, że wszystkie wartości *foreign keys* mają zastosowaną opcję **ON DELETE CASCADE**, aby zapewnić, że za każdym razem gdy z tablicy “rodzica” zostanie usunięty element, to z tablicy “dziecka” również zostanie usunięty jego odpowiednik.

### Widoki
Ze względu na to, że większość tabel składa się głównie z indeksów wskazujących na wartości w innych tabelach, po wyświetleniu są one mało czytelne. Aby rozwiązać ten problem wykorzystane zostały widoki, które łączą ze sobą odpowiednie tabele i wyświetlają tylko pożądane, czytelne wartości. W tym celu wykorzystane zostały funkcje: **SELECT** wybierająca kolumny do wyświetlenia oraz **JOIN** przyłączająca odpowiednie wiersze z innych tabel. 

Przykładowo, wyświetlenie wszystkich rekordów z tabeli *collection*, da nasępujacy wynik:

![image](https://user-images.githubusercontent.com/72393493/214522177-6ae215d9-879e-47b2-9a4b-0a632ca9f15c.png)
 
Aby wynik ten stał się czytelny utworzono widok *show_collection* w następujący sposób:
 
 ![show_collection](https://user-images.githubusercontent.com/72393493/214522740-222d4e89-101a-40aa-91a1-111ab673f8bd.png)

Wyświetlanie kolekcji może być teraz dokonane poprzez wykorzystanie powyższego widoku *(show_collection)*. Dzięki temu zostaną wyświetlone najpotrzebniejsze dane, które powinny charakteryzować kolekcję. Takie działanie da następujący wynik:

![image](https://user-images.githubusercontent.com/72393493/214523552-70259aa1-e150-4d3e-bffa-51838e18b42c.png)

Wszystkie widoki zostały stworzone na takiej samej podstawie - powinny wyświetlać jedynie najpotrzebniejsze dane i/lub łączyć ze sobą odpowiednie table. Stworzone zostały następujące widoki:
- show_collection - wyświetla wszystkie rekordy z tabeli *collection* odpowiednio dołączając tabele: *users* oraz *global_cards*
- show_deck - wyświetla wszystkie rekordy z tabeli *deck* odpowiednio dołączając tabele: *users, global_cards* oraz *collection*
- show_global_cards- wyświetla tylko najpotrzebniejsze wartości z tabeli *global_cards*
- show_want_to_sell - wyświetla wszystkie rekordy z tabeli *want_to_sell* odpowiednio dołączając tabele: *users, global_cards* oraz *collection*
- show_want_to_buy - wyświetla wszystkie rekordy z tabeli *collection* odpowiednio dołączając tabele: *users* oraz *global_cards*

### Procedury
Aplikacja powinna odpowiednio filtrować dane w zależności od użytkownika. Dodatkowo każdy użytkownik powinien mieć możliwość usuwania oraz dodawania kart do jego kolekcji oraz talii. Powienien on również móc zarządzać kartami na sprzedaż oraz kartami do kupna. Co więcej, aplikacja powinna zapewniać funkcję transferu karty oraz mozliwośc wyszukiwania karty w bazie. Dodatkowo, użytkownik powinien mieć możliwość założenia nowego konta. W celu zagwarantowania wymienionych funkcjonalności w bazie danych zostały zaimplementowane odpowiednie procedury.

#### Filtrowanie danych
Każdy użytkownik powienien móc wyświetlać tylko te dane, które są dla niego przeznaczone. Dlatego zastosowano procedury, które na bazie wcześniej stworzonych widoków oraz nazwy użytkownika, ukazują odpowiednie dane. Przykładowo, aby wyświelić kolekcję danego użytkownika, zastosowano następującą procedurę *user_collection*:

![coll_proc](https://user-images.githubusercontent.com/72393493/214863216-b76c85b1-e6f0-4262-b398-747b61fb819f.png)

Procedura jako argument przyjmuje nazwę użytkownika, a następnie wyświetla wszystkie rekordy z widoku *show_collection* (czytelna forma tabeli *collection*), gdzie nazwa użytkownika zgadza się z tą podaną w argumencie. Na tej samej podstawie stworzone zostały inne procedury filtrujące:
- user_deck - wyświetla dane filtrując na podstawie nazwy użytkownika oraz nazwy talii
- user_decknames - wyświetla wszytskie nazwy talii dla danego użytkownika
- user_want_to_sell - wyświetla karty, które dany użytkownik chce sprzedać
- user_want_to_buy - wyświetla karty, które dany użytkownik chce kupić
- show_all_sell - wyświetla karty, które inni użytkownicy chcą sprzedać, wykluczając karty na sprzedaż danego użytkownika - wyświetlanie ofert sprzedaży innych użytkowników

#### Usuwanie kart
Każdy użytkownik powinien mieć możliwość usuwania kart z kolekcji, talii, tabel: 'do sprzedaży' oraz 'do kupna'. Przykładowo, procedura usuwająca kartę z kolekcji *delete_from_collection*, wygląda następująco:

![del](https://user-images.githubusercontent.com/72393493/214870578-583516b2-acf5-45bb-89c5-44c54b444ddf.png)

Procedura jako argumenty przyjmuje nazwę użytkownika oraz CID karty (ID karty w kolekcji). Jako, że karta jest usuwana z tabeli *collection*, w której nie ma wartości "username* tylko *UID* (user ID), najpierw należy odnaleźć UID należące do danego użytkownika. W tym celu należy przefiltrować tabelę *users*, która posiada obydwie te wartości i przypisać odpowiadające UID do zmiennej. Dzięki temu możliwe jest usunięcie z tabeli *collection* karty o odpowiednim CID, należącej użytkownika o odpoowiednim UID. Tym samym sposobem zostały napisane pozostałe procedury usuwające:
- delete_from_deck - usuwa odpowiednią kartę z podanej talii dla danego użytkownika
- delete_from_buy - usuwa odpowiednią kartę z tabeli *want_to_buy* dla danego użytkownika
- delete_from_sell - usuwa odpowiednią kartę z tabeli *want_to_sell* dla danego użytkownika

#### Dodawanie kart
Użytkownicy powinni równiez mieć możliwość dodawania kart do ich kolekcji, talii, zbioru kart do kupienia oraz sprzedania. Przykładowo procedura dodająca karty do kolekcji *add_to_collection* wyglądałaby następująco:

![add](https://user-images.githubusercontent.com/72393493/215357440-5c7ab978-80ac-491f-8631-12cf4c2f69fa.png)

Procedura przyjmuje jako argumenty nazwę użytkownika oraz numer identyfikacyjny karty z bazy wszystkich kart (GCID). Tak samo jak podczas usuwania kart, nazwa użytkownika musi zostać zastąpiona odpowiadającym numerem ID (UID). Dzięki odpowiednim argumentom możliwe jest dodanie karty do kolekcji. Na podobnej zasadzie powstały pozostałe procedury dodające karty:
- add_to_deck - dodaje wskazaną kartę z kolecji do odpowiedniej talii
- add_to_sell - dodaje kartę z kolekcji do zbioru kart na sprzedaż
- add_to_buy - dodaje kartę z bazy kart do zbioru kart, które użytkownik chciałby kupić

Procedura *add_to_deck* jest jednak przypadkiem szczególnym. Mimo, że jej działanie bazuje na tej samej podstawie co reszta procedur z tej grupy - użytkownik podaje konkretne dane (nazwe tali oraz kartę z kolecji) co umożliwia mu dodadnie karty do odpowiedniej tabeli. Jednak, należy w tym przypadku uwzględnić również ilość posiadanych przez użytkownika egzemplarzy danej karty. Jedna karta z kolekcji użytkownika może znajdować się w wielu taliach, gdyż użytkownik może ją dowolnie przekładać z jednej talii do drugiej. Jednak, w jednej talii użytkownik nie może posiadać większej ilości danej karty niż ma ich w kolekcji. Na przykład, posiadając w kolekcji dwie karty "Angel of Mercy", nie możliwe powinno być dodanie do talii trzech lub więcej egzemplarzy tej karty, gdyż taka ilość nie jest posiadana - można dodać maksymalnie 2. Należoło, więc wprowadzić ograniczenie, aby takie sytuacje nie występowały. Implementacja procedury *add_to_deck* prezentuje się następująco:

![add_to_deck](https://user-images.githubusercontent.com/72393493/215358349-a729d7b2-c877-437f-80f4-abee0f3d80c2.png)

Poza deklaracją zmiennej *id*, która pojawiała się we wczesniejszych przypadkach, aby z nazwy użytkownika otrzymać jego ID, pojawiają się kolejne zmienne:
- cname - do zmiennej zostaje przypisana nazwa karty odpowiadająca podanemu numerowi identyfikacyjnemu 
- cnum - do zmiennej przypisana zostaje ilość egzemplarzy danej karty w kolekcji
- dnum - do zmiennej przypisana zostaje ilość egzemplarzy danej karty w podanej talii
Jeśli w talii ilość egzemplarzy danej karty nie przekracza ilości posiadanych kart, karta zostaje dodana do talii. W przeciwnym wypadku generowany jest błąd, a dodanie karty uniemozliwione.

#### Transfer kart
Aplikacja powinna umożliwiać użytkownikom przesyłanie kart do innych użytkowników. W tym celu utworzona została procedura *send_card*:

![transfer](https://user-images.githubusercontent.com/72393493/215358794-41455b2f-173b-42f3-a90c-bcef7fcac4ce.png)

Użytkownik definiuje jaką kartę ze swojej kolekcji chce wysłać oraz do kogo ma ona zostać wysłana. Dwóm zmiennym *id* oraz *idd* zostają przypisane numery identyfikacyjne odpowiadające nazwom użytkowników, odpowiednio: nadawcy i odbiory. Do zmiennej glob zostaje przypisany numer ID karty globalnej na podstawie podanego numeru identyfikacyjnego karty z kolekcji. Dzięki powyższym przypisaniom mozliwe jest usunięcie karty z kolekcji nadawcy oraz dodanie jej odpowiednika do kolekcji odbiorcy.
#### Wyszukiwanie kart
Aby ułatwić użytkownikom wyszukiwanie kart oraz ich numerów identyfikacyjnych, utworzona zosatała procedura *find_global_card*, która na podstawie podanej nazwy karty wyszukuje wszystkie dopasowania z bazy wszystkich kart. 

![find](https://user-images.githubusercontent.com/72393493/215359178-d298978e-3e49-48c4-b151-ccd510e9709a.png)

#### Zakładanie konta
Aplikacja powinna dawać również możliwość założenia konta. W tym celu powstała odpowiednia procedura dodająca użytkownika do bazy użytkowników na podstawie zadeklarownych przez niego: nazwy użytkownika oraz hasła. 

![register](https://user-images.githubusercontent.com/72393493/215359360-681c2f64-f301-4445-87bd-7f2e16ae9adc.png)

Warto dodać, że hasło jest odpowiednio zaszyfrowane za pomocą funkcji skrótu SHA256. Nie jest to jednak wykonywane na poziomie bazy danych - do bazy wszelkie hasła trafiają w zaszyfrowanej formie. 

## Uruchomienie aplikacji webowej

W celu uruchomienia aplikacji niezbędne będzie zainstalowanie dwóch środowisk:
- XAMPP - pakiet usług, który umożliwia postawienie lokalnego serwera www, dzięki, któremu możliwe będzie uruchomienie aplikacji
- MySQL Workbench - oprogramowanie służące do zarządzanie bazami danych, potrzebne do zaimportowania lokalnej bazy danych

Kolejne kroki potrzebne do uruchomienia aplikacji:
1. Należy pobrać wszytskie pliki znajdujące się w folderze "Kod źródłowy" oraz plik "Baza.sql" (plik .sql dostepny do pobrania pod adresem: https://drive.google.com/drive/folders/12CExyVnowMZsh42q7w6ioZHd6QyK-fZd?usp=share_link)
2. Należy uruchomić MySQL Workbench oraz zalogować się na lokalną instancję, jak  pokazano na rysunku poniżej:

![mysql](https://user-images.githubusercontent.com/72393493/214127590-86dd7a89-be29-410b-a104-5e7ba9da988a.png)

3. W okienku "Navigator", znajdującym się po lewej stronie ekranu, należy przejść do zakładki "Administration", a następnie wybrać opcję "Data Import/Restore":

![import](https://user-images.githubusercontent.com/72393493/214128236-cdcef63f-d2f0-4ebd-b8a5-af0e116014a9.png)

4. W okienku, które wyskoczy należy wybrać opcję "Import from Self-Contained File" oraz wybrać lokalizację pliku z bazą danych "Baza.sql" (Pkt.1 na rysunku). Następnie należy przejść do zakładki "Import Progress" (Pkt.2 na rysunku) oraz rozpocząć import ("Start Import" w prawym dolnym rogu)

![import2](https://user-images.githubusercontent.com/72393493/214129214-d24a9338-045b-4a5d-9c57-84b204cbce5a.png)

5. Baza danych powinna zostać poprawnie zaimportowana. W okienku "Navigator" w zakładce "Schemas" powinna być widoczna baza danych o nazwie "mtg":

![schema](https://user-images.githubusercontent.com/72393493/214129907-cecb6c81-91d6-4476-a72b-d5a6628b4963.png)

6. Należy otworzyć folder 'xampp' (domyślna lokalizacja "C:\xampp"), przejść do folderu 'htdocs', utworzyć folder o nazwie "mtg" i wkleić do niego wszytskie wcześniej pobrane pliki źródłowe.

7. Należy otworzyć plik 'db.php' korzystając z dowolnego edytora tekstowego i uzupełnić dane logowania do bazy danych na własne. W komendzie "$con = mysqli_connect("localhost", "user", "password", "mtg");" należy zmienić pola "user" oraz "password" na odpowiednio nawę użytkownika oraz hasło, które są wykorzstywane do logowania do lokalnej instancji MySQL.

8. Należy uruchomić wcześniej pobrany program "XAMPP Control Panel" oraz uruchomić usługi "Apache" oraz "MySQL":

![xampp](https://user-images.githubusercontent.com/72393493/214131137-41f3265f-e55d-4f04-bae1-f9ade47bf1ba.png)

W razie wystąpienia problemów z uruchomieniem usługi "MySQL" należy zmienić domyślny port usługi na np. 3307 (dla usługi MySQL -> 'Config' -> 'my.ini' -> zmienić wartości 'port' i zapisać, w konfiguracji globalnej 'Config' -> "Service and Port Settings" -> zmienić port dla MySQL)

9. Aby uruchomić aplikację w przeglądarce należy podać adres "localhost/mtg". Aplikacja jest gotowa do użytku:

![loginpage](https://user-images.githubusercontent.com/72393493/214133931-3a90f761-0ac2-400b-84cc-c77f7c84a524.png)

## Dokumentacja aplikacji web.

Interfejs web. aplikacji powstał zgodnie z założonymi w projekcie wymaganymi funkcjonalnościami.

### Rejestracja oraz logowanie do systemu

Strona główna pozwala użytkownikowi na przeprowadzenie procesu logowania oraz rejestracji. W przypadku logowania wymagane jest podanie loginu oraz hasła. Interfejs służący rejestracji natomiast wymaga kolejnego powtórzenia wpisanego hasła, by wyeleminować ewentualne pomyłki.

![1  Strona logowania](https://user-images.githubusercontent.com/100868161/215371031-f8a0661c-fb2f-41cd-b21d-7aae839c2074.png)
![2  Logowanie](https://user-images.githubusercontent.com/100868161/215371061-93074cb6-7be4-465a-b73d-282c2c72d6c3.png)
![3  Rejestracja](https://user-images.githubusercontent.com/100868161/215371081-3965b6af-6138-4b3e-af88-e0a61a764440.png)

### Stworzenie kolekcji kart – możliwość dodawania oraz usuwania kart, przeglądanie zawartości swojej kolekcji

Za pomocą interfejsu możliwe jest również stworzenie kolekcji kart oraz zarządzanie nią tj. dodawanie do kolekcji poszczególnych kart oraz ich usuwanie.


![4  Kolekcja user1](https://user-images.githubusercontent.com/100868161/215371235-64720f48-c31a-49bc-b840-fefc5c1420a2.png)
![5  Dodaj do kolekcji](https://user-images.githubusercontent.com/100868161/215371242-569d919e-b5ee-4efc-8147-7ebc57d6170b.png)
![6  usuń z kolekcji](https://user-images.githubusercontent.com/100868161/215371248-433b7955-b36f-4594-b6f7-d50ec5f2e4c7.png)

### Przesyłanie kart z kolekcji między użytkownikami

Funkcjonalność związana z przesyłaniem kart między kolekcjami poszczególnych użytkowników również została zapewniona z poziomu interfejsu web.

![7  Wyslij karte](https://user-images.githubusercontent.com/100868161/215371324-eb99a169-eaaf-43eb-a6b9-4a49dc3b5b31.png)

### Stworzenie wielu talii – możliwość dodawania oraz usuwania kart, przeglądanie zawartości swoich talii

Analogicznie do możliwości Web GUI związanych z kolekcją, w pełni funkcjonalne jest także zarządzanie taliami kart.

![8  Deck user1](https://user-images.githubusercontent.com/100868161/215371447-fef880a7-9e68-4948-911c-ff8ee98fd7b5.png)
![9  Deck po wyszukaniu 'deck1'](https://user-images.githubusercontent.com/100868161/215371455-446f6011-da6d-408d-a83e-ee2b04d1e12e.png)
![10  Dodaj do talii](https://user-images.githubusercontent.com/100868161/215371463-0a0a94b2-47eb-4647-897b-f3d51fb3ce53.png)
![11  Usuń z talii](https://user-images.githubusercontent.com/100868161/215371480-1137a372-8698-408e-b6ce-cf37728e6be9.png)

### Wyznaczanie kart, które użytkownik chciałby nabyć
Dzięki interfejsowi web, użytkownicy są w stanie w przystępny sposób deklarować chęć kupna konkretnych kart oraz zarządzać ich listą.

![12  Do kupienia user1](https://user-images.githubusercontent.com/100868161/215371578-bb4c8e3d-b287-45ca-993c-0349ca7985d9.png)
![13  Dodaj do kuupienia](https://user-images.githubusercontent.com/100868161/215371608-d3c30fb6-6d7a-440a-a9e7-453b91569f2e.png)
![14  Usun z do kupienia](https://user-images.githubusercontent.com/72393493/215413226-f9aad06f-7391-4288-bbed-328d1f9060eb.png)

### Wyznaczenie kart z kolekcji przeznaczonych na sprzedaż

Analogicznie do wyżej wymienionej funkcjonalności, możliwa jest również deklaracja chęci sprzedaży karty należącej do danego użytkownika.

![15  Do sprzedaży user1](https://user-images.githubusercontent.com/100868161/215371740-40d00bd5-fa62-46f7-8658-c4cf290460c8.png)
![16  Dodaj do sprzedazy](https://user-images.githubusercontent.com/100868161/215371763-fa949068-6a3e-40c2-9fcc-de8fe1afe4c2.png)
![17  Usun ze sprzedazy](https://user-images.githubusercontent.com/100868161/215371774-9ca14268-83e5-48d4-9909-c825cd7fafad.png)

### Wyświetlanie ofert sprzedaży innych użytkowników

W celu umożliwienia potencjalnych wymian, zapewniona została możliwość przeglądania ofert sprzedaży innych użytkowników.

![20  Oferty sprzedaży dla user1](https://user-images.githubusercontent.com/100868161/215371842-a89524b1-53c4-46a0-a389-0b8368332fde.png)
![21  Oferty sprzeadży dla user2](https://user-images.githubusercontent.com/100868161/215371851-08e5479b-f986-4eec-8a6b-be69bf8b2854.png)

### Przeglądanie bazy wszystkich dostępnych kart
Użytkownicy z poziomu web GUI mają również możliwość przeglądania wszystkich istniejących w grze kart, filtrując wyniki po nazwie karty.

![18  Baza kart](https://user-images.githubusercontent.com/100868161/215371889-06e62812-4427-43d7-bb42-ce8a640d2a07.png)
![19  Baza po wyszukaniu 'Field Marshal'](https://user-images.githubusercontent.com/100868161/215371961-c4fad7e9-4180-483d-85c4-94c282c78c60.png)
