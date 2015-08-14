// (c)2012-2015 Flat File Database System by Muhammad Fauzan Sholihin	www.pricebill.com	Paypal donation: tecnixindo@gmail.com	Indonesian Bank : BCA 0372344006 SwiftCode=CENA IDJA
// Your donation will keep development process of this web apps. Thanks for your kindness
// You may use, modify, redistribute my apps for free as long as keep the origin copywrite

// db command list
------------------
// add_db ($filename,$ar_data)
// edit_db ($filename,$ar_data)
// del_db ($filename,$key)
// read_db($filename,$first_row,$last_row)
// search_db($filename,$pattern)
// key_db($filename,$key)
// get_key_db($filename,$pattern)
// replace_db($filename,$ar_data,$pattern)
// array_sort($array, $column_data, $order=SORT_ASC)
// recursive_data($pattern,$column_parent=1,$row_array_in)

function write_file($filename, $string) {	// file name, data
$db_size = @filesize($filename);
if ($db_size > 5242880 ) {$string = trim($string); $string = substr($string,0,5242880); } //5242880 / 10485760
$fixed = str_replace("\n\n\n","\n",$string);
$fixed = str_replace("\'","'",$string);
$fixed = str_replace("\\\"","\"",$string);
$fixed = trim($fixed);
$fp = @fopen( $filename,"w+"); 
$lock = @flock($fp, LOCK_EX); 
if ($lock) {
fseek($fp, 0, SEEK_END);
@fwrite( $fp, "\n".$fixed."\n"); 
}
@flock($fp, LOCK_UN); 
@fclose( $fp ); 
}

function read_file($filename) {		// file name
if (!file_exists($filename)) {return;}
$db_size = filesize($filename);
if ($db_size <=0 ) {return;}
$handle = fopen($filename, "r");
flock($handle, LOCK_SH); 
$contents = fread($handle, $db_size);
while (!feof($handle)) { 
$contents .= fread($handle, $db_size);
    }
flock($handle, LOCK_UN); 
fclose($handle);
sleep(0.1);
return $contents;
}

// format: file name , array data (your data = array[1] to array[unlimited]. array[0] = key)
function add_db ($filename,$ar_data) { // output as string (optional)
$data_storage = read_file($filename);
$data_storage = str_replace("\n\n","\n",$data_storage);
$countdata = count($ar_data);
if ($ar_data[0] != '') {$countdata = $countdata - 1; }
$key = 1 + in_string('{-}','{,}',$data_storage);
for ($i=1;$i<=$countdata;$i++) {
$data .= $ar_data[$i] ;
if ($i < $countdata) {$data .= '{,}';}
}
$data = "\n{-}".$key."{,}".$data.$data_storage;
write_file($filename,$data);
return $data;
}

// format: file name , array data
function edit_db ($filename,$ar_data) { // output as string (optional)
$data_storage = read_file($filename)."\n";
$data_storage = str_replace("\n\n","\n",$data_storage);
$key = $ar_data[0] ;
$key = preg_replace('/[^0-9]/', '',$ar_data[0]);
$find_key = substr($data_storage, strpos($data_storage, "{-}".$key."{,}"));
$find_key = substr($find_key,0, strpos($find_key, "\n{-}"));
if ($find_key == '') {$find_key = substr($data_storage, strpos($data_storage, "{-}".$key."{,}"));}
$countdata = count($ar_data);
$data = "\n{-}" ;
for ($i=0;$i<$countdata;$i++) {
$data .= $ar_data[$i] ;
if ($i+1 < $countdata) {$data .= '{,}';}
}
$data .= "\n";
$data_storage = str_replace($find_key,$data,$data_storage);
$data_storage = str_replace("\n\n","\n",$data_storage);
write_file($filename,$data_storage);
return $data;
}

// format: file name , database unique key
function del_db ($filename,$key){
$data = "{-}".$key."{,}";
$data_storage = read_file($filename);
$find_key = substr($data_storage, strpos($data_storage, $data));
$find_key = substr($find_key,0, strpos($find_key, "\n{-}"));
if ($find_key == '') {$find_key = substr($data_storage, strpos($data_storage, $data));}
$data_storage = str_replace($find_key,"",$data_storage);
$data_storage = str_replace("\n\n","\n",$data_storage);
write_file($filename,$data_storage);
//return $find_key;
}

// format: file name, first row, last row
function read_db($filename,$first_row,$last_row) { //output as array data
if (!stristr($filename,'http://')) {$data_storage = read_file($filename);}
if (stristr($filename,'http://')) {$data_storage = access_url($filename);}
$data_storage = str_replace("\n\n","\n",$data_storage);
$pieces = explode("{-}",$data_storage);
	for ($i=$first_row;$i<=$last_row;$i++) { 
	if (!$pieces[$i]) {break;}
	$out[] = explode ("{,}",$pieces[$i]);
	}
if (count($out) <= 0) {$out = array();}
return $out;
}

// format: file name , string pattern
function search_db($filename,$pattern) { // output array data
$data_storage = read_file($filename);
$data_storage = str_replace("\n\n","\n",$data_storage);
$pieces = explode("{-}",$data_storage);
$count_data = count($pieces);
if ($count_data <= 1) {return array();}
$j = 0;
	for ($i=0;$i<=$count_data;$i++) { 
	if (!$pieces[$i]) {break;}
	$out = explode ("{,}",$pieces[$i]);
	if (in_array($pattern, $out)) {
									$result[$j] = $out;
									$j = $j + 1 ;
								  }
	}

return $result;
}

// format: file name , database unique key
function key_db ($filename,$key){ // output: row data at specific key
if ($key == '') {$out = array(); return $out;}
$data = "{-}".$key."{,}";
$data_storage = read_file($filename);
if (!stristr($data_storage,$data)) {return;}
$find_key = substr($data_storage, strpos($data_storage, $data));
$find_key = substr($find_key,0, strpos($find_key, "\n{-}"));
if ($find_key == '') {$find_key = substr($data_storage, strpos($data_storage, $data));}
$data_storage = str_replace("\n\n","\n",$data_storage);
$out = explode ("{,}",$find_key);
return $out;
}

// format: file name , string pattern
function get_key_db($filename,$pattern) { // output string key
$data_storage = read_file($filename);
$available = @stristr($data_storage,$pattern); 
if ($available == '') {return; break;}
$data_storage = str_replace("\n\n","\n",$data_storage);
$pieces = explode("{-}",$data_storage);
	for ($i=1;$i<=count($pieces);$i++) { 
	if (!$pieces[$i]) {break;}
	$out = explode ("{,}",$pieces[$i]);
	if (in_array($pattern, $out)) {break ;}
	if (!in_array($pattern, $out)) {$out = array() ;}
	}
return $out[0];
}

function replace_db($filename,$ar_data,$pattern) {
$key = get_key_db($filename,$pattern);
if (strlen($key) >=1) {$ar_data[0] = preg_replace('/[^0-9]/', '',$key); edit_db ($filename,$ar_data);}
if (strlen($key) <1) {add_db ($filename,$ar_data);}
}

function array_sort($array, $column_data, $order=SORT_ASC)
{
    $new_array = array();
    $sortable_array = array();

    if (count($array) > 0) {
        foreach ($array as $k => $v) {
            if (is_array($v)) {
                foreach ($v as $k2 => $v2) {
                    if ($k2 == $column_data) {
                        $sortable_array[$k] = $v2;
                    }
                }
            } else {
                $sortable_array[$k] = $v;
            }
        }

        switch ($order) {
            case SORT_ASC:
                asort($sortable_array);
            break;
            case SORT_DESC:
                arsort($sortable_array);
            break;
        }

        foreach ($sortable_array as $k => $v) {
            $new_array[$k] = $array[$k];
        }
    }

    return $new_array;
}

function recursive_data($pattern,$column_parent=1,$row_array_in) { // result = row array out
$pola = '{,}'.$pattern.'{,}';
$i = 0;
	foreach ($row_array_in as $column_array_in) {
	if ($column_array_in[$column_parent] == $pattern) {$out[] = $column_array_in;}
	$i++;
	}
return $out;
}

