<pre>

textpress db
============
texTPress DB is a text-based database in PHP (flat file db). 
You can see demo in texTPress CMS (text-press.googlecode.com)

how to use
==========
insert file "functions.php" into your php file like this:
  include_once "functions.php";
    
db command list
===============
  add_db ($filename,$ar_data)
  edit_db ($filename,$ar_data)
  del_db ($filename,$key)
  read_db($filename,$first_row,$last_row)
  search_db($filename,$pattern)
  key_db($filename,$key)
  get_key_db($filename,$pattern)
  replace_db($filename,$ar_data,$pattern)
  array_sort($array, $column_data, $order=SORT_ASC)
  recursive_data($pattern,$column_parent=1,$row_array_in)

</pre>
