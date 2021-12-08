import requests
from bs4 import BeautifulSoup
import smtplib, ssl
import time
from includes import mail_credentials
import os
from dotenv import load_dotenv
from pathlib import Path

dotenv_path = Path("./.env")
load_dotenv(dotenv_path=dotenv_path)

# set your agent.
header={"User-Agent": 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/74.0.3729.169 Safari/537.36'}

def amazon_item_url():
    # initialize link to request all your requests
    URL = os.getenv('ITEM_URL') #This has to be from database, This was for test purposes.

    print(URL)

    return URL

def check_price(headers):
    
    #make a call to request from the above url using your user agent. 
    # returns everything you want.
    page = requests.get(amazon_item_url(), headers=headers)

    soup = BeautifulSoup(page.content, 'html.parser')

    # print (soup.prettify())

    title = soup.find_all("span", class_="product-title-word-break")[0].get_text()
    price = soup.find_all("span", class_="a-offscreen")[0].get_text()

    print(title)
    print(price)
    
    converted_price = float(price[0:4])

    print("\n")
    print(converted_price)

    if converted_price < 496.95:
        print("Lower Price change")
        send_mail()
        
    if converted_price > 496.95:
        print("Higher price Change")
        send_mail()


def send_email(msg):
    try:
        recipients = ['gicehajunior76@gmail.com']
        emaillist = [elem.strip().split(',') for elem in recipients]

        sender = mail_credentials.username() 

        headers = f"""From: {sender}
        The price for your item fell down"""

        msg = headers + '\n\n' + msg

        print(msg)

        # Create secure connection with server and send email
        context = ssl.create_default_context()
        with smtplib.SMTP_SSL("mail.urbanviewhotel.co.ke", 465) as server:
            server.login(sender, mail_credentials.password())
            server.sendmail(
                sender, emaillist, msg
            )

        return "Email sending success!"
    except:
        return "Email sending Failed!"

# define the function send_mail
def send_mail(): 
    body = 'The price for your item with the following link fell down.' + '\n\n' + 'Kindly Checkout this link to confirm, ' + amazon_item_url() 
    
    msg = body 

    if send_email(msg) == "Email sending success!":
        print("Email sending success!")
    else:
        print("Email sending Failed!")
  

check_price(header)

        











