from flask import Flask
from flask_cors import CORS
import markdown
import os                     
import json
import datetime
from flask_jwt_extended import JWTManager


#App initialization
app = Flask(__name__)
cors = CORS(app, resources={r"/v1/*": {"origins": "*"}})
# MySQL configurations
app.config['MYSQL_DATABASE_USER'] = os.getenv('DB_USERNAME','user')
app.config['MYSQL_DATABASE_PASSWORD'] = os.getenv('DB_PASSWORD','pass')
app.config['MYSQL_DATABASE_DB'] = os.getenv('DB_DATABASE','db')
app.config['MYSQL_DATABASE_HOST'] = os.getenv('DB_HOST','localhost')
app.config['MYSQL_DATABASE_PORT'] = int(os.getenv('DB_PORT', '3306'))
app.config['JWT_SECRET_KEY'] = 'super-secret'  # Change this!
jwt = JWTManager(app)
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