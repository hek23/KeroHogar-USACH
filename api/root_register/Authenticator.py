#Test code for auth
from functools import wraps
from flask import request, Response
from helpers import mysqlConnector

def check_auth(username, password):
    """This function is called to check if a username /
    password combination is valid.
    """
    cursor = mysqlConnector.get_db().cursor()
    cursor.execute('SELECT count(*) FROM User where Email = \'{0}\' and Password = \'{1}\''.format(username,password))
    result = cursor.fetchone()
    cursor.close()
    return result[0]>0

def authenticate():
    """Sends a 401 response that enables basic auth"""
    return Response(
    'Could not verify your access level for that URL.\n'
    'You have to login with proper credentials', 401,
    {'WWW-Authenticate': 'Basic realm="Login Required"'})

def requires_auth(f):
    @wraps(f)
    def decorated(*args, **kwargs):
        if not('user' in request.headers and 'pass' in request.headers):
            return Response(status=405)
        if not check_auth(request.headers.get('user'), request.headers.get('pass')):
            return authenticate()
        return f(*args, **kwargs)
    return decorated