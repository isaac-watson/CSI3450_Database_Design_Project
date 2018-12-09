/*
newListing.sql

This concatenation of queries creates a new listing, by adding multiple elements to different
tables. Most notably, this query will automatically increase the primary keys in each table 
once they have been seeded with an entry with PK = 0. This is advantageous considering that
the auto_increment feature of a table will stick to a value even though the corresponding 
entries have been deleted. This is something we do not want since we would like to not have
lose values.

The code can be adapted to work in PHP by changing all variables except the newly generated 
ones to look like the following @var_name -> '$var_name'.

During the insertion the first query checks, whether or not the address is a voter registered
address in Metro Detroit. If it is not the query will not generate a new entry, thus when the
following queries try to access their key by using @lot_next_id, the query fails and no new 
data is put into the database. This way we verify the integrity of the data. Furthermore, we 
also make a check for the duplicity of a realtor before adding them to the table. If a realtor
with the same first and last name, as well as the same email address is already contained in the
database, we use that PK to link to the listing since the combination of name and email address 
can be considered unique.
*/
-- increment the lot_id PK
set @lot_next_id :=(select max(lot_id) + 1 from lot);

-- insert the new lot information
insert into lot (lot_id, address_id, lot_size) values(@lot_next_id, (select address_id from address where (street_num = @street_num) & (street_name like concat('%',@street_name,'%')) & (zip = @zip) limit 1), @lot_size );

-- increment the dwell_id PK
set @dwell_next_id := (select max(dwell_id) + 1 from dwelling);

-- insert the new dwelling information
insert into dwelling values(@dwell_next_id, @lot_next_id, @unit, (select htype_id from home_type where htype_name like @htype_name), (select hstyle_id from home_style where hstyle_name like @hstyle_name), @dwell_size, @floor_num, @basement, @bath_num, @bed_num, @year_built);
 
-- increment the realtor_id PK
set @real_next_id := (select max(realtor_id) + 1 from realtor);

-- insert the new realtor information if and only if no too similar realtor has been added before, check against first name, last name, and email address
insert into realtor select @real_next_id, @realtor_lname, @realtor_init, @realtor_fname, @realtor_phone, @realtor_email from dual where 
not exists (select * from realtor where (realtor_lname like @realtor_lname) & (realtor_fname like @realtor_fname) & (realtor_email like @realtor_email));
 
-- increment the list_id PK
set @list_next_id := (select max(list_id) + 1 from listing);

-- inserting a new listing with the date added and last modified set to the current day and date sold to 99 years in the future
insert into listing values(@list_next_id, @dwell_next_id, (select stype_id from sale_type where stype_name = @stype_name), @price, @real_next_id, curdate(), curdate(), date_add(curdate(), interval 99 year));