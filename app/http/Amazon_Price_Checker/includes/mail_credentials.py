from pathlib import Path
import smtplib
from dotenv import load_dotenv
import os

dotenv_path = Path("./.env")
load_dotenv(dotenv_path=dotenv_path)

# For server functionality, required to fill the password and username of yor gmail account here below
def password():
    
    password = os.getenv("MAIL_NOTIFICATION_PASSWORD")
    
    return password

def username():
    username = os.getenv("MAIL_NOTIFICATION_EMAIL_ADDRESS")
    
    return username

