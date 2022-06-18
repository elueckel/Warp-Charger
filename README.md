# WARP2 Charger

Das Modul unterstützt die Tinkerforge WARP2 Charger Smart und Professional.

## Inhaltsverzeichnis

1. [Funktionsumfang](#1-funktionsumfang)
2. [Voraussetzungen](#2-voraussetzungen)
3. [Software-Installation](#3-software-installation)
4. [Einrichten der Instanzen in IP-Symcon](#4-einrichten-der-instanzen-in-ip-symcon)
5. [Versionsinformation](#5-versionsinformation)

## 1. Funktionsumfang

* Unterstützung für WARP2 Charger Smart und Professional
* Darstellen von diversen Datenpunkten
* Möglichkeit den Ladevorgang zu Starten/Stoppen
* Möglichkeit die Ladestrom zu steuern in mA 
* Möglichkeit die Archivierung zu aktivieren

## 2. Voraussetzungen

- IP-Symcon ab Version 5.5
- WARP2 Firmware >2.x

## 3. Software-Installation

* Über den Module Store das 'WARP2 Charger'-Modul installieren.
* Alternativ über das Module Control folgende URL hinzufügen: https://github.com/elueckel/Warp-Charger 

## 4. Einrichten der Instanzen in IP-Symcon

 Unter 'Instanz hinzufügen' kann das 'WARP2 Charger'-Modul mithilfe des Schnellfilters gefunden werden.  
	- Weitere Informationen zum Hinzufügen von Instanzen in der [Dokumentation der Instanzen](https://www.symcon.de/service/dokumentation/konzepte/instanzen/#Instanz_hinzufügen)

__Konfigurationsseite__:

**Wallbox IP Adresse**

IP Adresse der Wallbox

**Benutzername & Kennwort**

Account mit dem sich das Modul mit der Wallbox. verbindet

**Aktualisierungsfrequenz**

Häufigkeit wie oft die Wallbox aktualisiert wird (Status und Zählerstände). 

**TASTE: Status Abfragen**

Holt die aktuellen Basisdaten (Fehlermeldungen, Verrieglung, Status) von der Wallbox.

**TASTE: Zählerstände Abfragen**

Holt die aktuellen Zählerstände (Aktuelle Leistung, Verbrauch seit Produktion und Verbraucht seit Reset).

**TASTE: Einschalten der Archivierung für die Variablen**

Aktiviert die Archivierung für die Zählervariablen (durch das Sammeln der Daten wird Festplattenplatz verbraucht)

**Debugging**

Das Modul gibt diverse Informationen im Debug Bereich aus. 

**Steuerbare Variablen im Objektbaum**

Im Objektbaum können die folgenden Variablen gesteuert werden:
* _Maximaler Ladestrom (nutzbar für Überschussladen)
* _Start Ladevorgang (Taster ... setzt sich automatisch zurück)
* _Stop Ladevorgang (Taster ... setzt sich automatisch zurück)


## 5. Versionsinformation

Version 1.0 05-04-2022
* Unterstützung für WARP2 Charger Smart und Professional mit Firmware 2
* Auslesen Fehlerstände
* Auslesen Verbrauchsdaten und Ladeverlauf
* Start/Stop Ladevorgang
* Setzen des Ladestroms

Version 1.01 06-06-2022
* Fix Fehler beim Auslesen der Zähler wegen API Update

Version 1.02 18-06-2022
* Fix Automatischer Abruf von Daten