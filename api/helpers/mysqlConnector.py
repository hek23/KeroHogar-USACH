#!/usr/bin/python3
# -*- coding: utf-8 -*-
from flask import current_app, g
from flaskext.mysql import MySQL

def get_db():
  if 'sqldb' not in g:
    mysql = MySQL()
    mysql.init_app(current_app)
    g.sqldb = mysql.connect()
  return g.sqldb

def close_db(e=None):
  db = g.pop('sqldb', None)
  if db is not None:
    db.close()

#Register methods for close
def init_app(app):
  app.teardown_appcontext(close_db)
  #Define appContext for import modules that require flask_app
  with app.app_context():
    g.sqldb = get_db()

#Not used now
'''def init_db():
  db = get_db()
  with current_app.open_resource('schema.sql') as f:
    db.executescript(f.read().decode('utf8'))'''