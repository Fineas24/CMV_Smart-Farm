import smtplib
from email.mime.text import MIMEText
from email.mime.multipart import MIMEMultipart

def send_email(subject, message, from_email, to_email, smtp_server, smtp_port, smtp_username, smtp_password):
    # Create a multipart message
    msg = MIMEMultipart()
    msg['From'] = from_email
    msg['To'] = to_email
    msg['Subject'] = subject

    # Attach the message to the email
    msg.attach(MIMEText(message, 'plain'))

    # Setup the SMTP server
    server = smtplib.SMTP_SSL(smtp_server, smtp_port)
    server.login(smtp_username, smtp_password)

    # Send the email
    server.sendmail(from_email, to_email, msg.as_string())
    server.quit()

# Replace these with your actual email credentials and SMTP server details
from_email = 'test.pass@lmvineu.ro'
to_email = 'marius.crainic@lmvineu.ro'
smtp_server = 'smtp.gmail.com'
smtp_port = 465  # For SSL
smtp_username = 'test.pass@lmvineu.ro'  # your full email address
smtp_password = ''

subject = 'Test Email'
message = 'This is a test email sent from Python.'

send_email(subject, message, from_email, to_email, smtp_server, smtp_port, smtp_username, smtp_password)
