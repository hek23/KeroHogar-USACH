from helpers import mysqlConnector
from flask import current_app, g, Response, request
import json
from helpers.Authenticator import requires_auth
import bcrypt

@current_app.route('/v1/users', methods=['POST'])
def createUser():
    userData = request.get_json()
    query = "INSERT INTO clients (rut, name, password, email, phone, wholesaler) VALUES (\'{}\',\'{}\',\'{}\',\'{}\',\'{}\',{}) "
    wholesaler = (userData['wholesaler'] == 1) 
    cursor = mysqlConnector.get_db().cursor()
    cursor.execute(query.format(userData['rut'], userData['name'], bcrypt.hashpw(userData['pass'].encode('utf-8'), bcrypt.gensalt(12)).decode('utf-8'), userData['email'], userData['phone'], wholesaler))
    mysqlConnector.get_db().commit()
    cursor.execute("SELECT id FROM clients where rut=\'{}\';".format(userData['rut']))
    id = cursor.fetchone()[0]
    cursor.close()
    return Response(json.dumps({"id":id}), mimetype= 'application/json',status=201)

@current_app.route('/v1/users/<UserID>', methods=['PUT'])
@requires_auth
def editUser():
    userData = request.get_json()
    query = "UPDATE clients SET rut=\'{}\', name = \'{}\', password=\'{}\', email=\'{}\', phone=\'{}\', wholesaler={}"
    wholesaler = (userData['wholesaler'] == 1)
    cursor = mysqlConnector.get_db().cursor()
    cursor.execute(query.format(userData['rut'], userData['name'], bcrypt.hashpw(userData['pass'].encode('utf-8'), bcrypt.gensalt(12)).decode('utf-8'), userData['email'], userData['phone'], wholesaler))
    mysqlConnector.get_db().commit()
    return Response(mimetype='application/json', status =200)

@current_app.route('/v1/users/login', methods=['POST'])
def login():
    userData = request.get_json()
    query = "SELECT password FROM clients where rut=\'{}\'"
    cursor = mysqlConnector.get_db().cursor()
    cursor.execute(query.format(userData['name']))
    pwd = cursor.fetchone()
    if pwd is None:
        return Response(status = 402)
    if not(bcrypt.checkpw(userData['password'].encode('utf-8'), pwd[0].encode('utf-8'))):
        return Response (mimetype='application/json', status = 401)
    else:
        token = bcrypt.hashpw((userData['name']+pwd[0]).encode('utf-8') , bcrypt.gensalt(12))
        return Response(mimetype='application/json', status = 200, response=json.dumps({"token":token.decode('utf-8')}))