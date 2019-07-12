from flask import current_app, g
import os
import tbk

CERTIFICATES_DIR = os.path.join(os.path.dirname(__file__), 'commerces')

#Codes are example!
NORMAL_COMMERCE_CODE = os.getenv('NormalCode',"597020000541")

def load_commerce_data(commerce_code):
    with open(os.path.join(CERTIFICATES_DIR, commerce_code, commerce_code + '.key'), 'r') as file:
        key_data = file.read()
    with open(os.path.join(CERTIFICATES_DIR, commerce_code, commerce_code + '.crt'), 'r') as file:
        cert_data = file.read()
    with open(os.path.join(CERTIFICATES_DIR, 'tbk.pem'), 'r') as file:
        tbk_cert_data = file.read()

    return {
        'key_data': key_data,
        'cert_data': cert_data,
        'tbk_cert_data': tbk_cert_data
    }

def initTbk():
    #Load Data (Certs)
    normal_commerce_data = load_commerce_data(NORMAL_COMMERCE_CODE)

    #Build main commerce Object (to transactions)
    normal_commerce = tbk.commerce.Commerce(
        commerce_code=NORMAL_COMMERCE_CODE,
        key_data=normal_commerce_data['key_data'],
        cert_data=normal_commerce_data['cert_data'],
        tbk_cert_data=normal_commerce_data['tbk_cert_data'],
        #environment MUST be changed!
        environment=tbk.environments.DEVELOPMENT)

    #Get webPay service access
    webpay_service = tbk.services.WebpayService(normal_commerce)

    return webpay_service
    
def getWebpay():
  if 'webpayService' not in g:
    webpaySvc = initTbk()
    g.webpayService = webpaySvc
  return g.webpayService


#Transaction (send to front to webpay!)
#if fails, goes to final_url
#If goes well, use Return
#transaction = webpay_service.init_transaction(
#        amount=flask.request.form['amount'],
#        buy_order=flask.request.form['buy_order'],
#        return_url=BASE_URL + '/normal/return',
#        final_url=BASE_URL + '/normal/final',
#        session_id=flask.request.form['session_id']
#    )

