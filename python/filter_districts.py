import mysql.connector
# filter()
# 
# used to extract school district data
#
def filter():
    mydb = mysql.connector.connect(
      host="localhost",
      user="root",
      passwd="root",
      database="mydb"
    )

    cursor = mydb.cursor()

    f = open("school_districts.txt", 'r')
    for line in f:
        strings = line.split("(")
        name = strings[0].strip()
        sid = strings[1].replace(")", "").strip()
        
        sql = "insert into school_districts values(%s,%s)"
        vals = (sid, name)

        cursor.execute(sql, vals)

    mydb.commit()
    cursor.close()
    mydb.close()
        
