from helpers import mysqlConnector

class Product:
    
    def getAll():
        productQuery = "SELECT p.id, p.name, p.price FROM products p;"
        cursor = mysqlConnector.get_db().cursor()
        cursor.execute(productQuery)
        result = cursor.fetchAll()
        cursor.close()


    def getProductByID():
        pass
