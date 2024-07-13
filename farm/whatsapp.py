import pywhatkit as kit
import time

def send_whatsapp_message(phone_number, message):
    # Open WhatsApp Web and wait for QR code scanning
    kit.sendwhatmsg_instantly(phone_number, message, wait_time=20)
    time.sleep(5)  # Wait for a few seconds to ensure the message is sent

if __name__ == "__main__":
    # Replace with the target phone number and message
    phone_number = "+40748942490"  # Use the international format, e.g., "+1234567890"
    message = "Hello, this is a test message from Python!"

    send_whatsapp_message(phone_number, message)
