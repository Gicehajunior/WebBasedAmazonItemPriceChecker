import requests
from bs4 import BeautifulSoup
import smtplib, ssl
import time
from includes import mail_credentials
import os
from dotenv import load_dotenv
from pathlib import Path
# from selenium import webdriver
# from selenium.webdriver.chrome.options import Options

dotenv_path = Path("./.env")
load_dotenv(dotenv_path=dotenv_path)

# set your agent.
header={"User-Agent": 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/74.0.3729.169 Safari/537.36'}

def amazon_item_url():
    # initialize link to request all your requests
    URL = os.getenv('ITEM_URL') #This has to be from database, This was for test purposes.

    print(URL)

    return URL


def find_item_info(headers):
    #make a call to request from the above url using your user agent. 
    # returns everything you want.
    # options = Options() 
    # options.add_argument('--headless')
    # options.add_argument('--disable-gpu')
    # driver = webdriver.Chrome(options=options)
    page = requests.get(amazon_item_url(), timeout=2.50, headers=headers)
    print(page)
    soup = BeautifulSoup(page.content, 'html.parser')

    # print (soup.prettify())
    # time.sleep(3)

    title = soup.find_all("span", class_="product-title-word-break")[0].get_text() 
    price = soup.find_all("span", class_="a-offscreen")[0].get_text()
    price = price.replace("€", '')
    
    print(title)
    print(price)

    return title, price


def check_price(headers):
    title, price = find_item_info(headers)

    converted_price = float(price[0:4])

    print("\n")
    print(converted_price)

    if converted_price < 496.95:
        print("Lower Price change")
        send_mail(title, converted_price, "down")
        
    if converted_price > 496.95:
        print("Higher price Change")
        send_mail(title, converted_price, "up")


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
def send_mail(title, price, status): 
    if status == "down":
        string_paragraph_email_text = "The price for your item with the name "+title.strip()+" fell down."
    else:
        string_paragraph_email_text = "The price for your item with the name "+title.strip()+" gone up."

    body = string_paragraph_email_text + '\n\n' + " The Current price reads as: " + str(price) + '\n\n' + 'Kindly Checkout this link to confirm, ' + amazon_item_url() 
    
    msg = body

    if send_email(msg) == "Email sending success!":
        print("Email sending success!")
    else:
        print("Email sending Failed!")

check_price(header)

        











