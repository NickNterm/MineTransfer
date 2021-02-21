import mysql.connector
from datetime import datetime

today = datetime.now()

# dd/mm/YY
dateNow = today.strftime("%d.%m.%Y.%H.%M")
dateNow = dateNow.split(".")
print("d1 =", dateNow)
mydb = mysql.connector.connect(
  host="localhost",
  user="admin",
  password="admin",
  database="MineTransfer"
)

mycursor = mydb.cursor()

sqlselect = "SELECT id, date, expire  FROM Data"

mycursor.execute(sqlselect)

myresult = mycursor.fetchall()

for x in myresult:
    id = x[0]
    datadate = x[1].split(".")
    expire = x[2]
    '''
    expire:
    1: mia wra
    2: dwdeka wres
    3: mia mera
    4: dyo meres
    5: tries meres
    6: mia bdomada
    '''
    final = [dateNow[0]-datadate[0],dateNow[1]-datadate[1],dateNow[2]-datadate[2],dateNow[3]-datadate[3],dateNow[4]-datadate[4]]
    '''
    here are just some crazy conditions in case year, month, day changes 
    '''
     if final[2] > 0:
            final[1] =+ 12
        if final[1] > 0:
            final[1] =+ 30   
        if final[0] > 0:
            final[4] =+ 24
    if expire == 1:
            sqldelete = "DELETE FROM Data WHERE id ='", id, "'"
            mycursor.execute(sqldelete)
    elif expire == 2:
        if final[4] >= 12:
            sqldelete = "DELETE FROM Data WHERE id ='", id, "'"
            mycursor.execute(sqldelete)
    elif expire == 3:
        if final[0] >= 1 and final[3] >= 0:
            sqldelete = "DELETE FROM Data WHERE id ='", id, "'"
            mycursor.execute(sqldelete)
    elif expire == 4:
        if final[0] >= 2 and final[3] >= 0:
            sqldelete = "DELETE FROM Data WHERE id ='", id, "'"
            mycursor.execute(sqldelete)
    elif expire == 5:
        if final[0] >= 3 and final[3] >= 0:
            sqldelete = "DELETE FROM Data WHERE id ='", id, "'"
            mycursor.execute(sqldelete)
    elif expire == 6:
        if final[0] >= 7 and final[3] >= 0:
            sqldelete = "DELETE FROM Data WHERE id ='", id, "'"
            mycursor.execute(sqldelete)
    

#mydb.commit()

#print(mycursor.rowcount, "record(s) deleted")