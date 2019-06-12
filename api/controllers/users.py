from helpers import mysqlConnector
from flask import current_app, g, Response, request
import json
import bcrypt
from flask_jwt_extended import jwt_required, create_access_token, verify_jwt_in_request, get_jwt_identity
import pymysql
from functools import wraps

def user_required(fn):
    @wraps(fn)
    def wrapper(*args, **kwargs):
        verify_jwt_in_request()
        identity = get_jwt_identity()
        splited = identity.split("::")
        cursor = mysqlConnector.get_db().cursor()
        cursor.execute("SELECT password FROM clients WHERE rut=\'{}\'".format(splited[0]))
        pwd = cursor.fetchone()
        if (pwd is None):
            return Response(mimetype='application/json', status = 400, response=json.dumps({"msg":"No user/pass found"}))
        elif (pwd[0] != splited[1]):
            return Response(mimetype='application/json', status = 400, response=json.dumps({"msg":"pass missed"}))
        else:    
            return fn(*args, **kwargs)
    return wrapper

@current_app.route('/v1/users', methods=['POST'])
def createUser():
    userData = request.get_json()
    query = "INSERT INTO clients (rut, name, password, email, phone, wholesaler) VALUES (\'{}\',\'{}\',\'{}\',\'{}\',\'{}\',{}) "
    wholesaler = (userData['wholesaler'] == 1) 
    cursor = mysqlConnector.get_db().cursor()
    try:
        cursor.execute(query.format(userData['rut'], userData['name'], bcrypt.hashpw(userData['pass'].encode('utf-8'), bcrypt.gensalt(12)).decode('utf-8'), userData['email'], userData['phone'], wholesaler))
        mysqlConnector.get_db().commit()
        cursor.execute("SELECT id FROM clients where rut=\'{}\';".format(userData['rut']))
        id = cursor.fetchone()[0]
        cursor.close()
        return Response(json.dumps({"id":id}), mimetype= 'application/json',status=201)
    except pymysql.err.IntegrityError:
        return Response(json.dumps({"error": "Rut ya existente"}), mimetype='application/json', status=400)

@current_app.route('/v1/users/<UserID>', methods=['PUT'])
@user_required
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
    if not userData['name']:
        return Response(mimetype='application/json', status = 400, response=json.dumps({"msg": "Username missing"}))
    if not userData['pass']:
        return Response(mimetype='application/json', status = 400, response=json.dumps({"msg": "Password missing"}))
    query = "SELECT password, id FROM clients where rut=\'{}\'"
    cursor = mysqlConnector.get_db().cursor()
    cursor.execute(query.format(userData['name']))
    pwd = cursor.fetchone()
    cursor.close()
    if pwd is None:
        return Response(status = 400)
    if not(bcrypt.checkpw(userData['pass'].encode('utf-8'), pwd[0].encode('utf-8'))):
        return Response (mimetype='application/json', status = 401)
    else:
        return Response(mimetype='application/json', status = 200, response=json.dumps({"id":pwd[1] ,"token": create_access_token(identity=(userData['name'] +"::" +pwd[0]))}))


