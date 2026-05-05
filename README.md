# 🚗 Autorendi Haldussüsteem (PHP & MySQL)

See on praktiline veebirakendus autorendi teenuse haldamiseks. Rakendus sisaldab avalikku vaadet klientidele ja turvatud kontrollpaneeli administraatorile.

## 🌟 Peamised funktsioonid

### Kliendivaade
* **Autopargi sirvimine:** Dünaamiline ülevaade kõikidest autodest koos tehniliste andmetega.
* **Otsingufunktsioon:** Võimalus filtreerida autosid margi või mudeli järgi.
* **Kasutajasüsteem:** Turvaline registreerimine ja sisselogimine (paroolid on räsitud).

### Administraatori vaade (CRUD)
* **Turvatud ligipääs:** Admin-liides on kaitstud serveripoolse sessioonikontrolliga.
* **Autode lisamine:** Uute sõidukite sisestamine süsteemi.
* **Andmete muutmine:** Olemasolevate autode info ja saadavuse staatuse uuendamine.
* **Kustutamine:** Sõidukite eemaldamine andmebaasist.

## 🛠 Tehniline ülesehitus

* **Backend:** PHP 8 (protseduuriline)
* **Andmebaas:** MySQL
* **Frontend:** HTML5, CSS3, Bootstrap 5.3
* **Konteinerid:** Docker (Apache, PHP, MySQL)

## 📁 Kaustastruktuur

- **admin/** - Administraatori paneeli failid (lisa, muuda, kustuta)
- **db/** - Andmebaasi SQL skriptid (tabelite struktuur)
- **img/** - Autode pildid
- **config.php** - Andmebaasi ühenduse seaded
- **header.php** - Universaalne navigatsioonimenüü ja sessioonihaldus
- **index.php** - Rakenduse avalik avaleht
- **login.php / register.php** - Kasutajate autentimine

## 🚀 Paigaldamine

1. Klooni repositoorium: `git clone https://github.com/remitre-remi/car_rent.git`
2. Käivita Docker: `docker-compose up -d`
3. Impordi andmebaas failist `db/database_05052026.sql`
4. Ava brauseris: `http://localhost:8080`

## 🛡 Turvalisus
Rakenduses on kasutatud `mysqli_real_escape_string` meetodit SQL-süstimise vältimiseks ning `password_hash` funktsiooni kasutajate paroolide turvaliseks salvestamiseks.
