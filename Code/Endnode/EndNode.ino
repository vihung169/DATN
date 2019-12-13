#include "Adafruit_Sensor.h"
#include "DHT.h"
#include "DHT_U.h"
#include <Wire.h>
#include "BH1750.h"
#include <string.h>
#include "ArduinoJson.h"
#include <SPI.h>
#include <LoRa.h>
/*************************DEFINE PIN**********************************/
#define VREF 5.0
#define DHTTYPE DHT11 // DHT 11
#define DHT_PIN 32
#define TDS_PIN 33
#define PH_PIN 15
#define MAYBOM_PIN 13
#define DEN_PIN 12
//#define DEN_PIN 14

const int csPin = 5;          // LoRa radio chip select
const int resetPin = 4;       // LoRa radio reset
const int irqPin = 2  ;         // change for your board; must be a hardware interrupt pin


/*************************Value************************************/
int buf[10], tempofpH;
unsigned long int avgValue;
int analogBuffer[10], tempofTDS;
float trungbinhdienap = 0, tdsValue = 0, nhietdo = 25;
long lastSendTime = 0;        // last send time
int interval = 2000;          // interval between sends
/*************************SETTING************************************/
StaticJsonBuffer <200> jsonBuffer;
JsonObject& root = jsonBuffer.createObject();

DHT dht(DHT_PIN, DHTTYPE);

BH1750 lightMeter;
void setup()
{
  pinMode(12, OUTPUT);
  pinMode(13, OUTPUT);
//  pinMode(14, OUTPUT);
  digitalWrite(12, HIGH);
  digitalWrite(13, HIGH);
//  digitalWrite(14, LOW);
  Serial.begin(115200);
  Serial.println("------------------------------------------------------------------------------");
  Serial.println("--------------------TRUONG DAI HOC CONG NGHIEP TP HCM-------------------------");
  Serial.println("-------------------------KHOA CONG NGHE DIEN TU-------------------------------");
  Serial.println("---------------------------DIEN TU - MAY TINH---------------------------------");
  Serial.println("------------------------------VI THAI HUNG------------------------------------");
  Serial.println("--------------------------------15086471--------------------------------------");
  Serial.println("------------------------------------------------------------------------------");
  Serial.println("-----------------------------THIET BI ENDNODE---------------------------------");
  Serial.println("-----------------------------BAT DAU HE THONG---------------------------------");
  Serial.println("------------------------------------------------------------------------------");

  Wire.begin();
  LoRa.setPins(csPin, resetPin, irqPin);// set CS, reset, IRQ pin
  if (!LoRa.begin(434E6)) {
    Serial.println("NOT CONNECTED LORA!!!!");
    Serial.println("PLEASE CHECK CONNECT!!!!");
    while (1);
  }
  LoRa.onReceive(onReceive);
  LoRa.receive();
  DHT dht(DHT_PIN, DHTTYPE);
  lightMeter.begin();
}
void loop()
{
  if (millis() - lastSendTime > interval) {
    delay(2000);
    float TemperaturValue = dht.readTemperature();
    delay(1000);
    float HumidityValue = dht.readHumidity();
    delay(1000);
    int lux = lightMeter.readLightLevel();
    delay(1000);
    float ph = Readph(PH_PIN);
    delay(1000);
    float Tds = ReadTds(TDS_PIN);
    delay(1000);

    root["temp"] = TemperaturValue;
    root["humi"] = HumidityValue;
    root["lux"] = lux;
    root["ph"] = ph;
    root["tds"] = Tds ;
    //root["rssi"] = LoRa.packetRssi();
    size_t len = root.measureLength();
    size_t size = len + 1;
    char message[size];
    root.printTo(message, size);
    Serial.println(message);
    sendMessage(message);
    lastSendTime = millis();
    delay(2000);
    LoRa.receive();
  }
}
// ---------------------------------------------------------------------------------//
// funtion lay du lieu cam bien ph //
float Readph(int pHSensor)
{
  int phPin = pHSensor;
  for (int i = 0; i < 10; i++)
  {
    buf[i] = analogRead(phPin);
    delay(10);
  }
  for (int i = 0; i < 9; i++)
  {
    for (int j = i + 1; j < 10; j++)
    {
      if (buf[i] > buf[j])
      {
        tempofpH = buf[i];
        buf[i] = buf[j];
        buf[j] = tempofpH;
      }
    }
  }
  avgValue = 0;
  for (int i = 2; i < 8; i++)
    avgValue += buf[i];
  float phValue = (float)avgValue * 5.00 / 4095 / 6;
  phValue = 3.5 * phValue;
  delay(2000);
  return (phValue);
}
// ---------------------------------------------------------------------------------//
// funtion lay du lieu cam bien TDS //
float ReadTds(int TDSSensor)
{
  int TDSPin = TDSSensor;
  for (int i = 0; i < 10; i++)
  {
    analogBuffer[i] = analogRead(TDSPin);
    delay(10);
  }
  for (int i = 0; i < 9; i++)
  {
    for (int j = i + 1; j < 10; j++)
    {
      if (analogBuffer[i] > analogBuffer[j])
      {
        tempofTDS = analogBuffer[i];
        analogBuffer[i] = analogBuffer[j];
        analogBuffer[j] = tempofTDS;
      }
    }
  }
  for (int i = 2; i < 8; i++)
  {
    trungbinhdienap = analogBuffer[i] * (float)VREF / 4095.0;
    float hesobunhietdo = 1.0 + 0.02 * (nhietdo - 25.0);
    float hesobudienap = trungbinhdienap / hesobunhietdo;
    float tdsValue = ((133.42 * hesobudienap * hesobudienap * hesobudienap - 255.86 * hesobudienap * hesobudienap + 857.39 * hesobudienap) * 0.5) / 6;
    delay(1000);
    return (tdsValue);
  }
}
void sendMessage(String message) {
  LoRa.beginPacket();                   // start packet
  LoRa.print(message);                 // add payload
  LoRa.endPacket();                     // finish packet and send it
}


void onReceive(int packetSize)
{
  if (packetSize == 0) return;       // if there's no packet, return
  // read packet header bytes:
  String incoming = "";                 // payload of packet
  while (LoRa.available()) {            // can't use readString() in callback, so
    incoming += (char)LoRa.read();      // add bytes one by one
  }
  Serial.println(incoming);
  //Khai bao bien phuc vu Doc gia tri gui ve
  StaticJsonBuffer <200> Buffer;
  JsonObject& root2 = Buffer.parseObject(incoming);
  if (!root2.success()) {
    Serial.println("parseObject() failed");
    return;
  }
  int mayBom = root2["maybom"];
  int phunsuong = root2["phunsuong"];
  int den = root2["den"];
  int quat = root2["quat"];
  //  Serial.println(mayBom);
  if (mayBom == 1) {
    Serial.println("MAY BOM: ON");
    digitalWrite(MAYBOM_PIN, LOW);
  }
  else {
    Serial.println("MAY BOM: OFF");
    digitalWrite(MAYBOM_PIN, HIGH);
  }
  if (den == 1) {
    Serial.println("DEN QUANG HOP: ON");
    digitalWrite(DEN_PIN, LOW);
  }
  else {
    Serial.println("DEN QUANG HOP: OFF");
    digitalWrite(DEN_PIN, HIGH);
  }
}
