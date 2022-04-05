# WARP2 Charger

The Module supports Tinkerforge WARP2 Charger Smart and Professional.

## Inhaltsverzeichnis

1. [Funktionaloverview](#1-funktionaloverview)
2. [Requirements](#2-requirements)
3. [Software-Installation](#3-software-installation)
4. [Setup of the instance in IP-Symcon](#4-setup-of-the-instance-in-ip-symcon)
5. [Versionsinformation](#5-versionsinformation)

## 1. Funktionaloverview

* Support for WARP2 Charger Smart and Professional
* Integration of various Datapoints
* Ability to start/stop charging
* Ability to set the maximum charge current
* Ability to turn archiving on

## 2. Requirements

- IP-Symcon > Version 5.5
- WARP2 Firmware >2.x

## 3. Software-Installation

* Via Module store via 'WARP2 Charger'-Module installation.
* Alternatively via Module Control adding the following URL: https://github.com/elueckel/Warp-Charger 

## 4. Setup of the instance in IP-Symcon

 Via 'Add Instance' the module can be found using the term "WARP2 Charger".

__Configurationspage__:

**Wallbox IP Address**

IP Address of the Wallbox

**Username and Password**

Account used to log into the wallbox

**Update Frequency**

Frequency how often data will be retrieved from the Wallbox (status and meter reading). 

**Button: Update Status**

Gets the current status from the wallbox (Lockstate, Errormessages or Current State)

**BUTTON: Read Meters**

Gets the current meter readings from the wallbox (since reset, production and current charging)

**TASTE: Turn on Archiving**

Turns on archiving for meters and current charging (this will consume harddisk space!).

**Debugging**

The module provide debugging information in the module debug section.  

**Controllable variables in the object tree**

The following variables can be controlled in the object tree: 
* _Maximum charge current
* _Start Charging (Push button ... resets itself)
* _Stop Charging (Push button ... resets itself)


## 5. Versionsinformation

Version 1.0 05-04-2022
* Support for WARP2 Charger Smart and Professional with Firmware 2.0 and above
* Integration of various Datapoints
* Ability to start/stop charging
* Ability to set the maximum charge current
* Ability to turn archiving on
