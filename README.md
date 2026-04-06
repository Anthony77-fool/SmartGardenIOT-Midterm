# Smart Garden IoT System 🌿

An automated IoT solution designed to bridge the geographical gap between plant owners and their plants' biological needs. [cite_start]This project addresses the "absentee caretaker" dilemma for students and professionals who are frequently away from their residences[cite: 20, 23].

## 📌 Project Overview
The Smart Garden IoT System provides real-time monitoring and automated irrigation. [cite_start]It prevents plants from suffering due to overwatering or dehydration by allowing for remote intervention and data-driven care[cite: 21, 22].

---

## 🏗️ System Architecture
[cite_start]The project is built on a three-tier IoT architecture to ensure seamless data flow from the soil to the web dashboard[cite: 41]:

### 1. Perception Layer (Hardware)
Responsible for physical data acquisition and environmental interaction.
**Microcontroller:** ESP8266 (NodeMCU) with integrated Wi-Fi.
**Sensors:** DHT11 (Ambient Temperature & Humidity) and Soil Moisture Sensor V1.2.
**Actuators:** 5V Water Pump for automated irrigation.

### 2. Network Layer (Backend & Database)
[cite_start]Acts as the communication bridge and central storage hub.
**Framework:** Laravel (PHP) MVC Framework providing a robust API.
**Communication:** Data is transmitted from the hardware via HTTP POST requests.
**Database:** MySQL for logging sensor readings with unique IDs and automated timestamps.

### 3. Application Layer (User Interface)
[cite_start]Provides a responsive dashboard for real-time oversight and data analysis.
**Dashboard:** Built with Laravel Blade templates and Tailwind CSS.
**Visualization:** Chart.js for rendering historical data trends and agricultural patterns.
**Management:** `history.blade.php` view includes a searchable table for all logged data.

---

## 🛠️ Tech Stack
| Component | Technology |
| :--- | :--- |
| **Hardware** | ESP8266, DHT11, Soil Moisture V1.2 |
| **Backend** | Laravel 10.x / 11.x, PHP |
| **Database** | MySQL |
| **Frontend** | Tailwind CSS, Blade, Chart.js |
