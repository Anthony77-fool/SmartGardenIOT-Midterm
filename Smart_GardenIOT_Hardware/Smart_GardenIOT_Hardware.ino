#include "DHT.h"
#include <ESP8266WiFi.h>
#include <ESP8266HTTPClient.h>
#include <WiFiClient.h>

const int soilPin = A0;
const int relayPin = 5; // D1 on ESP8266 is GPIO 5
#define DHTPIN 4 
#define DHTTYPE DHT11

const char* ssid = "SSID-USERNAME";
const char* password = "PASSWORD";
const char* serverName = "http://IP_ADDRESS/PHP_Projects/SmartGardenIOT/insert_data.php"; // Change to your IP

DHT dht(DHTPIN, DHTTYPE);

// Calibration Constants
const int DRY_VAL = 800; 
const int WET_VAL = 300;
//temporarily set to 0
const int THIRSTY_THRESHOLD = 30; // Set to 35% for a reliable trigger

void setup() {
  Serial.begin(115200);
  
  // RELAY SETUP: Active Low modules turn ON when signal is LOW.
  // We set it HIGH first so the pump doesn't blast water the moment it turns on.
  digitalWrite(relayPin, HIGH); 
  pinMode(relayPin, OUTPUT);
  
  dht.begin();
  delay(1000);
  Serial.println("\n--- Smart Garden System Active with Auto-Watering ---");

  //NEW
  WiFi.begin(ssid, password);
  while (WiFi.status() != WL_CONNECTED) {
    delay(500);
    Serial.print(".");
  }
  Serial.println("\nWiFi Connected!");
}

//it takes around 13.4 seconds before sending new rows in the db
void loop() {
  // 1. Smooth Soil Reading
  long total = 0;
  for(int i=0; i<10; i++) {
    total += analogRead(soilPin);
    delay(10); 
  }
  int rawValue = total / 10;

  // 2. Calculate Percentage
  int moisturePercent = map(rawValue, DRY_VAL, WET_VAL, 0, 100);
  moisturePercent = constrain(moisturePercent, 0, 100);

  // 3. Read DHT
  float h = dht.readHumidity();
  float t = dht.readTemperature();

  // 4. AUTO-WATERING LOGIC
  // If moisture is low, turn on the pump
  if (moisturePercent < THIRSTY_THRESHOLD) {
    Serial.println("{\"status\": \"Watering Started\"}");
    digitalWrite(relayPin, LOW);  // Turn Relay ON
    delay(3000);                  // Run pump for 3 seconds
    digitalWrite(relayPin, HIGH); // Turn Relay OFF
    Serial.println("{\"status\": \"Watering Finished\"}");
    
    // Crucial: Wait 10 seconds for water to soak into the soil 
    // so the sensor can "see" the change before the next loop.
    delay(10000); 
  }

  // 5. Web-Ready Output (JSON Format)
  if (!isnan(h) && !isnan(t)) {
    Serial.print("{");
    Serial.print("\"temp\": " + String(t) + ", ");
    Serial.print("\"humid\": " + String(h) + ", ");
    Serial.print("\"soil_raw\": " + String(rawValue) + ", ");
    Serial.print("\"soil_percent\": " + String(moisturePercent) + ", ");
    Serial.print("\"pump_status\": " + String(digitalRead(relayPin) == LOW ? "\"ON\"" : "\"OFF\""));
    Serial.println("}");
  } else {
    Serial.println("{\"error\": \"DHT_fail\"}");
  }

  delay(3000); 

  // NEW: Send to Database
  if (WiFi.status() == WL_CONNECTED) {
    WiFiClient client;
    HTTPClient http;
    http.begin(client, serverName);
    http.addHeader("Content-Type", "application/json");

    // Prepare the JSON string
    String httpRequestData = "{\"temp\":" + String(t) + ",\"humid\":" + String(h) + ",\"soil_raw\":" + String(rawValue) + ",\"soil_percent\":" + String(moisturePercent) + "}";
    
    int httpResponseCode = http.POST(httpRequestData);
    Serial.print("HTTP Response code: ");
    Serial.println(httpResponseCode);
    
    http.end();
  }
  
  delay(10000); // Send data every 10 seconds
}
