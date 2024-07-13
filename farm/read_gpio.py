import RPi.GPIO as GPIO
import time

# Set up the GPIO mode
GPIO.setmode(GPIO.BCM)  # Use BCM numbering

# Set up GPIO17 as an input with a pull-up resistor
GPIO.setup(17, GPIO.IN, pull_up_down=GPIO.PUD_UP)

try:
    while True:
        # Read the input from GPIO17
        input_state = GPIO.input(17)
        
        # Print the input state
        if input_state == GPIO.HIGH:
            print("GPIO17 is HIGH")
        else:
            print("GPIO17 is LOW")
        
        # Sleep for a short time to debounce
        time.sleep(0.1)

except KeyboardInterrupt:
    # Clean up GPIO settings before exiting
    GPIO.cleanup()
    print("Program exited cleanly")
