from helpers import mysqlConnector


class Client:
    def __init__(self,rut,name,password,email,phone,wholesaler):
        self.rut = rut
        self.name = name
        self.password = password
        self.email = email
        self.phone = phone
        self.wholesaler = wholesaler
    
    def save(self):
        #Insert new client. on Clients table or updates it
        #First, check if exist!
        cursor = mysqlConnector.get_db().cursor()
        if(getByRut(self.rut) is None):
            #Doesn't exist!, Insert!
            query = "INSERT INTO Clients (rut, name, password, email,phone, wholesaler) values \'{}\',\'{}\',\'{}\',\'{}\',\'{}\',\'{}\';"
        else:
            query = "UPDATE Clients SET rut=\'{}\', name=\'{}\', password=\'{}\', email=\'{}\', phone=\'{}\', wholesaler=\'{}\';"
        #Execute Query
        cursor.execute(query.format(self.asList()))
        mysqlConnector.get_db().commit()
        cursor.close()
        return true

    def getByRut(rut):
        cursor = mysqlConnector.get_db().cursor()
        query = "SELECT * FROM Clients where rut =\'{}\'"
        cursor.execute(query.format(rut))
        mysqlConnector.get_db().commit()
        result = cursor.fetchone()
        cursor.close()
        #return Client()

    






#cursor.execute('SELECT count(*) FROM Clients where Email = \'\'{0}\'\' and Password = \'\'{1}\'\''.format(username,password))
#result = cursor.fetchone()
#cursor.close()