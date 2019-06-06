from flask import Flask
import markdown
import os                     
import json
import datetime

#App initialization
app = Flask(__name__)
# MySQL configurations
app.config['MYSQL_DATABASE_USER'] = os.getenv('USERDB','user')
app.config['MYSQL_DATABASE_PASSWORD'] = os.getenv('PASSWORDDB','pass')
app.config['MYSQL_DATABASE_DB'] = os.getenv('DBNAME','db')
app.config['MYSQL_DATABASE_HOST'] = os.getenv('HOSTDB','localhost')
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
  #Dummy Insert
  cursor = mysqlConnector.get_db().cursor()
  query = "INSERT INTO Clients (rut, name, password, email,phone, wholesaler) values \'{}\',\'{}\',\'{}\',\'{}\',\'{}\',\'{}\';"
  cursor.execute(query.format(self.asList()))
  mysqlConnector.get_db().commit()
  cursor.close()
  #Test Select
  cursor = mysqlConnector.get_db().cursor()
  query = "SELECT * FROM Clients"
  cursor.execute(query.format(rut))
  mysqlConnector.get_db().commit()
  result = cursor.fetchone()
  cursor.close()
  print(result)
  return true