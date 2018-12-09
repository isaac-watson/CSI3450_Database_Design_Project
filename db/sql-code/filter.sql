/*
filter.sql

Filtering query that is used to access the houses meeting the requirements of the user.

Filtering options are:
- Number of bathrooms (@bath_num)
- Number of bedrooms (@bed_num)
- Basement wished or not (@basement)
- Number of floors (@floor_num)
- Size of the dwelling area (@dwell_size)
- Building year of the house (@year_built)
- Type of the listed home (@htype_name)
- Style of the listed home (@hstyle_name)
- Sale, rental, foreclosure, etc. (@stype_name)
- Size of the lot (@lot_size)
- Name of the street (@street_name)
- Number of house on street (@street_num)
- Rank of the school (@school_rank)
- SAT scores of desired school (@school_sat_math, @school_sat_read)
- City population (@city_population)
- City crime rates, violent and property related (@city_crime_violent, @city_crime_property)
- Home pricing (@price)

The filters are applied by common sense. This means that the filter will return this 
particular, specified value, as well as all "better" values. For example, prices will
be shown in the range from 0 to @price, while other values like the number of bath, or
bedrooms will be applied from the specified value to infinity. This allows to find 
listings that are "better" or exactly like the user wishes them to be like.
*/

select a.street_num, a.street_name, c.city_name, a.zip, d.bed_num, d.bath_num,d.basement, d.dwell_size, st.stype_name, lis.price
FROM listing as lis
INNER JOIN (select * 
from dwelling 
-- applying filters for the dwelling area
where (bath_num >= @bath_num) 
	& (bed_num >= @bed_num)
    & (basement = @basement or @basement = 2)
    & (floor_num >= @floor_num)
    & (dwell_size >= @dwell_size)
	& (year_built >= @year_built)
    & (@htype_name = 'Any' or (htype_id = (select htype_id from home_type where htype_name = @htype_name)))
    & (@hstyle_name = 'Any' or (hstyle_id = (select hstyle_id from home_style where hstyle_name = @hstyle_name)))
	  )as d
    on lis.dwell_id = d.dwell_id
inner join (select * 
from sale_type
)as st
on lis.stype_id = st.stype_id
INNER JOIN (select * 
from lot 
-- applying lot size filters
where (lot_size >= @lot_size)
) as l
    on d.lot_id = l.lot_id
INNER JOIN ((select * 
from address
-- applying filters on address data (street name and number)
where (concat('%', street_name, '%') like concat('%', @street_name, '%'))
	& ((@street_num = '' or @street_num is null) or @street_num = street_num)) as a
    inner join
    (select * from school where 
		  (school_sat_math >= @school_sat_math)
        & (school_sat_read >= @school_sat_read)
        & (school_rank <= @school_rank or @school_rank = '')
	) as sc
    on sc.school_id = a.school_id
)
    on l.address_id = a.address_id
INNER JOIN (select * 
from city
-- applying city specific filters like crime rates and population
where ((city_name like concat('%', @city_name, '%')) 
	or (@city_name is null))
     & (city_population = -1 or @city_population >= city_population or @city_population = '')
     & (city_crime_violent = -1 or @city_crime_violent >= city_crime_violent or @city_crime_violent = '')
     & (city_crime_property = -1 or @city_crime_property >= city_crime_property or @city_crime_property = '')
) as c
on a.city_id = c.city_id
-- applying final filter for the price
where 
	  (price <= @price or @price = '' or @price = 0)
	& (lis.stype_id = (select stype_id from sale_type where stype_name = @stype_name) or @stype_name = 'Any')
limit 20;

select * from (address as a inner join city as c on a.city_id = c.city_id)
