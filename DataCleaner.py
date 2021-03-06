import mysql.connector
from datetime import datetime
import os


mydb = mysql.connector.connect(
    host="localhost",
    user="admin",
    password="admin",
    database="MineTransfer"
)
while True:
    mycursor = mydb.cursor()
    today = datetime.now()
    dateNow = today.strftime("%d.%m.%Y.%H.%M")
    dateNow = dateNow.split(".")
    sqlselect = "SELECT id, date, expire, code  FROM Data"

    mycursor.execute(sqlselect)

    myresult = mycursor.fetchall()

    for x in myresult:
        id = x[0]
        datadate = x[1].split(".")
        expire = x[2]
        code = x[3]
        '''
        expire:
        1: mia wra
        2: dwdeka wres
        3: mia mera
        4: dyo meres
        5: tries meres
        6: mia bdomada
        '''
        final = [int(dateNow[0])-int(datadate[0]), int(dateNow[1])-int(datadate[1]), int(dateNow[2]) -
                 int(datadate[2]), int(dateNow[3])-int(datadate[3]), int(dateNow[4])-int(datadate[4])]
        '''
        here are just some crazy conditions in case year, month, day changes 
        '''
        if final[2] > 0:
            final[1] += 12
        if final[1] > 0:
            final[0] += 30
        if final[0] > 0:
            final[3] += 23
        if expire == 1:
            if final[3] >= 1 and final[4] >= 0:
                sqldelete = "DELETE FROM Data WHERE id ='" + str(id) + "'"
                mycursor.execute(sqldelete)
                os.remove("transfers/" + code)
                print("delete " + code + " " + ' '.join(map(str, final)))
        elif expire == 2:
            if final[3] >= 12 and final[4] >= 0:
                sqldelete = "DELETE FROM Data WHERE id ='" + str(id) + "'"
                mycursor.execute(sqldelete)
                os.remove("transfers/" + code)
                print("delete " + code + " " + ' '.join(map(str, final)))

        elif expire == 3:
            if final[0] >= 1 and final[3] >= 0:
                sqldelete = "DELETE FROM Data WHERE id ='" + str(id) + "'"
                mycursor.execute(sqldelete)
                os.remove("transfers/" + code)
                print("delete " + code + " " + ' '.join(map(str, final)))

        elif expire == 4:
            if final[0] >= 2 and final[3] >= 0:
                sqldelete = "DELETE FROM Data WHERE id ='" + str(id) + "'"
                mycursor.execute(sqldelete)
                os.remove("transfers/" + code)
                print("delete " + code + " " + ' '.join(map(str, final)))

        elif expire == 5:
            if final[0] >= 3 and final[3] >= 0:
                sqldelete = "DELETE FROM Data WHERE id ='" + str(id) + "'"
                mycursor.execute(sqldelete)
                os.remove("transfers/" + code)
                print("delete " + code + " " + ' '.join(map(str, final)))

        elif expire == 6:
            if final[0] >= 7 and final[3] >= 0:
                sqldelete = "DELETE FROM Data WHERE id ='" + str(id) + "'"
                mycursor.execute(sqldelete)
                os.remove("transfers/" + code)
                print("delete " + code + " " + ' '.join(map(str, final)))

        mydb.commit()
