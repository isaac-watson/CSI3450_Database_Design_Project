import mysql.connector
import random

# make_db(user_name, sw, db_name)
# params:
# user_name: the user name used to query the DB
# pw: the password to be used to connect to the DB
# db_name: the name of the schema/db to be accessed
#
# This very simple script will manipulate and transfer data from the entire_state_v_lst file,
# which contains the data from the Michigan voter registry, into the specified database.
# The code uses the specified format for the file, that can be found on 
# www.michiganvoters.info in the download section.
#
# Data generated is the address data as well as some mock data for realtors. It will be stored
# in the tables `realtor` and `home`.
#
def make_db(user_name, pw, db_name):
    file = open("entire_state_v.lst","r")

    index = 0
    i = 0
    rid = 0

    companyPieces = ["real","realtor","home","house","buy","best","estate","property","rent","lease","life","american","cheap","worst","z","agent"]

	#Create the SQL connection
    mydb = mysql.connector.connect(
      host="localhost",
      user=user_name,
      passwd=pw,
      database=db_name
    )

    cursor = mydb.cursor()

	#Selects only the 6 counties in Metro Detroit.
    counties = [82,63,50,44,74,47]
	
    try:
        for line in file:
            
			#Grab every address in the registry as long as it's in Metro Detroit
            if int(line[461:463].strip()) in counties:
                sql_1 = "INSERT INTO home (home_id, home_numb, home_numb_char, home_pre_str_dir, home_str_name, home_post_str_dir, home_ext, home_city, home_state, home_zip, home_county_code, home_school_district, home_school_precinct) VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s)"
                vals_1 = (i, line[92:99].strip(), line[91].strip(), line[103:105].strip(), line[105:135].strip(), line[141:143].strip(), line[143:156].strip(), line[156:191].strip(), line[191:193].strip(), line[193:198].strip(), line[461:463].strip(), line[474:479].strip(), line[510:516].strip())
                cursor.execute(sql_1, vals_1)
                
			#Grab the name of 1 in every 30 registered voters for realtor data
            if index % 30 == 0:
                fname = line[0:35].strip()
                lname = line[55:75].strip()
                a = random.randint(0,len(fname))
                b = random.randint(1,len(companyPieces)-1)
                c = random.randint(1,len(companyPieces)-1)
                
				#Randomly generate email and phone number
                email = fname + lname + "@" + companyPieces[b] + companyPieces[c] + ".com"
                phone = random.randint(245,249)*10000000 + random.randint(111,999)*10000 + random.randint(1111,9999)

				#Add a hyphen if the voter has no middle name
                init = "-"
                if not line[35:55].strip():
                    init = person.mname[0]
                
				#Insert into database
                sql_2 = "INSERT INTO realtor (realtor_id, realtor_fname, realtor_init, realtor_lname, realtor_email, realtor_phone) VALUES (%s, %s, %s, %s, %s, %s)"
                vals_2 = (rid, fname, init, lname, email, phone)
                cursor.execute(sql_2, vals_2)

                rid = rid +1

            index = index + 1
            i += 1
            
        mydb.commit()    
        cursor.close()
        mydb.close()
    except:
        cursor.close()
        mydb.close()
        print("error loading db")

    
        
