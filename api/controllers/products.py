from helpers import mysqlConnector
from flask import current_app, g, Response
import json

@current_app.route('/v1/products', methods=['GET'])
def getAllProducts():
	sqlQuery= "SELECT id, name, price FROM kerhogar.products;"
	cursor = mysqlConnector.get_db().cursor()
	cursor.execute(sqlQuery)
	result = cursor.fetchall()
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
	return Response(json.dumps(products),  mimetype='application/json')

