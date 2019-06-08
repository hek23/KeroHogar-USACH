from flask import Flask
import markdown
import os                     
import json
import datetime

#App initialization
app = Flask(__name__)
# MySQL configurations
app.config['MYSQL_DATABASE_USER'] = os.getenv('DB_USERNAME','user')
app.config['MYSQL_DATABASE_PASSWORD'] = os.getenv('DB_PASSWORD','pass')
app.config['MYSQL_DATABASE_DB'] = os.getenv('DB_DATABASE','db')
app.config['MYSQL_DATABASE_HOST'] = os.getenv('DB_HOST','localhost')
app.config['MYSQL_DATABASE_PORT'] = int(os.getenv('DB_PORT', '3306'))
#Init DB Connections
from helpers import mysqlConnector

#Register Database in app
mysqlConnector.init_app(app)
#Define appContext for import modules that require flask_app
with app.app_context():
  #Import Controllers, routes, etc
  from controllers import *

@app.route("/")
def index():
  return "It's DAMN TRUE"