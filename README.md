<pre>

textpress db
============
texTPress DB is a text-based database in PHP (flat file db). 
You can see demo in texTPress CMS (text-press.googlecode.com)

how to use
==========
insert file "functions.inc.php" into your php file like this:
  include_once "functions.inc.php";
    
db command list
===============
  add_db ($filename,$array_data)
  edit_db ($filename,$array_data)
  del_db ($filename,$key)
  read_db($filename,$first_row,$last_row)
  search_db($filename,$pattern)
  key_db($filename,$key)
  get_key_db($filename,$pattern)
  replace_db($filename,$array_data,$pattern)
  array_sort($array, $column_data, $order=SORT_ASC)
  recursive_data($pattern,$column_parent=1,$row_array_in)

example add_db guest book
=========================
	$data[1] = date('Y-m-d H:i:s');     // submitted date
	$data[2] = 'John Doe';              // person name
	$data[3] = 'Message from John Doe'; // guest book message
	add_db('guestbook.txt',$data);		// save database
	
file name can be: guestbook.txt or guestbook.db, or guestbook or whatever

Donation for development:
=========================
BTC	1AEdAhje16RSeUMvYLQ4rzu9i5ZcHP9uDn
BCHABC	bitcoincash:qzpn7gr23awme4vawq7pjg8fc2najp736g0yr4eg0q
BCHSV	bitcoincash:qrxwsduzu43gx83rqmqmnwwhq98qnmtyccfl89lr2p
BTG	GfzmgESHyogYGt3UMc8Zp6wyB4wovpeuJn
DASH	XwYEp7DbaPechDyEvcdfkNt99htVK3vmC5
DOGE	DHKufkhPXbmgbCTpMGYNeGCQD4Zb6uAMsg
ETC	0x310ac05f20b75f175711a9e20d778ff3fa4a4221
ETH	0x3483a47d0962853a292f88cc008635be15630095
LTC	LXaz5trQTZ6YMTfvPEi9EhsMb3KLAyCsKo
XZC	Zzv5V8o5jiygAu85jYihsBNwLykT71isbd
</pre>
