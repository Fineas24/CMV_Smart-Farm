from picamera2 import Picamera2
from datetime import datetime
import RPi.GPIO as GPIO
import time
import requests

import subprocess

def send_sms(phone_number, message):
    command = f'npx mudslide send {phone_number} "{message}"'
    subprocess.run(command, shell=True)

phone_number = '+40748942490'
message = 'Am gasit un intrus'

# Set up the GPIO mode
GPIO.setmode(GPIO.BCM)  # Use BCM numbering

# Set up GPIO17 as an input with a pull-up resistor
GPIO.setup(17, GPIO.IN, pull_up_down=GPIO.PUD_UP)

# Creează un obiect camera
picam2 = Picamera2()

# Configură camera
camera_config = picam2.create_still_configuration()
picam2.configure(camera_config)

# Funcție pentru a obține data și ora curente într-un format specificat
def get_timestamp():
    return datetime.now().strftime("%Y-%m-%d_%H-%M-%S")

# Capturează imaginea cu un nume de fișier bazat pe data și ora curente
def capture_image():
    timestamp = get_timestamp()
    file_path = f"/var/www/html/smartfarm/photos/poza_{timestamp}.jpg"
    picam2.start()
    time.sleep(2)  # Așteaptă 2 secunde pentru a stabiliza imaginea
    picam2.capture_file(file_path)
    picam2.stop()
    print(f"Fotografie salvată: {file_path}")
    file_link = f"http://127.0.0.1/smartfarm/send_photo.php?link=poza_{timestamp}.jpg"
    #print({file_link})

    response = requests.get(file_link)

    # Print the status code of the response
    print(f'Status Code: {response.status_code}')

    # Print the response content
    print(f'Response Content: {response.text}')

# Asigură-te că directorul de destinație există
import os
os.makedirs('/var/www/html/smartfarm/photos', exist_ok=True)

flag = 0
try:
    while True:
        # Read the input from GPIO17
        input_state = GPIO.input(17)
        
        # Print the input state
        if input_state == GPIO.HIGH:
            print("Asteapta intrusul")
            #print("GPIO17 is HIGH")

        if input_state == GPIO.LOW and flag == 0:
            print("face poza")
            #print("GPIO17 is LOW")
            # Capturează imaginea
            capture_image()
            flag = 1
            #trimite msg whatsapp
            send_sms(phone_number, message)
        if input_state == GPIO.HIGH and flag == 1:
            flag = 0
            #print("Asteapta intrusul")
            #print("GPIO17 is HIGH")
        
        # Sleep for a short time to debounce
        time.sleep(0.1)


except KeyboardInterrupt:
    # Clean up GPIO settings before exiting
    GPIO.cleanup()
    print("Program exited cleanly")