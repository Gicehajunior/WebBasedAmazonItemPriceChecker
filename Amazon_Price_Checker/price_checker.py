import requests
from bs4 import BeautifulSoup
import smtplib
import time
from includes import gmail_credentials

# initialize link to request all your requests
URL='https://www.amazon.de/Sony-DigitalKamera-Touch-Display-Vollformatsensor-Kartenslots/dp/B07B4L1PQ8/ref=sr_1_3?keywords=sony+a7&qid=15661393494&s=gateway&sr=8-3'

# set your agent.
header={"User-Agent": 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/74.0.3729.169 Safari/537.36'}


def check_price(URL, headers):
    
    #make a call to request from the above url using your user agent. 
    # returns everything you want.
    page = requests.get(URL, headers=headers) 

    soup = BeautifulSoup(page.content, 'html.parser')

    # print (soup.prettify())


    title = soup.find(id = "productTitle").get_text()
    price = soup.find(id = "priceblock_ourprice").get_text()
    
    converted_price = float(price[0:3])

    if converted_price < 496.95:
        send_mail()
        
    print(converted_price)
    print(title.strip())
        
    if converted_price > 496.95:
        send_mail()
    
# define the function send_mail
def send_mail():
    # either use 2-step verification to generate passwords instead of your actual email account password.
    # set via app passwords in gmail settings.
    server = smtplib.SMTP('smtp.gmail.com', 587)
    server.ehlo()
    server.starttls() 
    server.ehlo()

    # login using your email and the app password
    server.login(gmail_credentials.username, gmail_credentials.password)
    # set subject
    # set body
    # set msg
    subject = 'The price for your Camera P200 fell down'
    body = 'Kindly Checkout this link, https://www.amazon.com/Nikon-DX-Format-3-5-5-6G-70-300mm-4-5-6-3G/dp/B07GW23M7T/ref=dp_ob_title_ce'

    msg = f"Subject: {subject}\n\n{body}"

    # now send the email
    # pass the above params on the send_mail function
    send_mail(
        'xtianwarrior76@gmail.com',
        'gicehajunior76@gmail.com',
        msg
    )
    # print the output - whether the above successfully executed
    print('Hello Junior, Your Camera P200 price fell down. Check your email to checkout the new price.')
    server.quit()

    while(True):
        check_price()
        #set time of seconds to stop execution for the check_price function.
        time.sleep(60)

check_price(URL, header)

        











