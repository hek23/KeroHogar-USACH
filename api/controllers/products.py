from helpers import mysqlConnector
from flask import current_app, g, Response
import json
from helpers.Authenticator import requires_auth

@current_app.route('/v1/products', methods=['GET'])
@requires_auth
def getAllProducts():
	sqlQuery= "SELECT id, name, price FROM kerhogar.products;"
	cursor = mysqlConnector.get_db().cursor()
	cursor.execute(sqlQuery)
	result = cursor.fetchall()
	if(result is None):
		cursor.close()
		return Response(json.dumps({}), mimetype='application/json')
	products = []
	for product in result:
		cursor.execute("SELECT COUNT(*) FROM kerhogar.product_formats where product_id={};".format(product[0]))
		newResult = cursor.fetchone()
		products.append({
						"id": product[0],
						"name": product[1],
						"price": product[2],
						"has_formats": newResult[0]>0
		})
	cursor.close()
	return Response(json.dumps(products),  mimetype='application/json')

@current_app.route('/v1/products/<Id>', methods=['GET'])
@requires_auth
def getProductByID(Id):
	sqlQuery= "SELECT name, price FROM kerhogar.products where id={};"
	cursor = mysqlConnector.get_db().cursor()
	cursor.execute(sqlQuery.format(Id))
	result = cursor.fetchone()
	if(result is None):
		product={}
	else:
		cursor.execute("SELECT COUNT(*) FROM kerhogar.product_formats where product_id={};".format(Id))
		product = {
			"name": result[0],
			"price": result[1],
			"has_formats": cursor.fetchone()[0] > 0
		}	
	cursor.close()
	return Response(json.dumps(product),  mimetype='application/json')