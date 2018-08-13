<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

if (!function_exists('pre'))
{

    function pre($data)
    {
        echo "<pre>";
        print_r($data);
        echo "</pre>";
        exit;
    }

}

if (!function_exists('pr'))
{

    function pr($data)
    {
        echo "<pre>";
        print_r($data);
        echo "</pre>";
    }

}

if (!function_exists('_j'))
{

    function _j($data)
    {
        if (is_array($data))
            echo json_encode($data);
        else
            echo json_encode(array($data));
    }

}

if (!function_exists('je'))
{

    function je($data)
    {
        if (is_array($data))
            echo json_encode($data);
        else
            echo json_encode(array($data));

        exit;
    }

}

if (!function_exists('json_response'))
{

    function json_response($message = null, $type = null, $code = 200)
    {
        // clear the old headers
        header_remove();
        // set the actual code
        http_response_code($code);
        // set the header to make sure cache is forced
        header("Cache-Control: no-transform,public,max-age=300,s-maxage=900");
        // treat this as json
        header('Content-Type: application/json');
        $status = array(
            200 => '200 OK',
            400 => '400 Bad Request',
            422 => 'Unprocessable Entity',
            500 => '500 Internal Server Error'
        );
        // ok, validation error, or failure
        header('Status: ' . $status[$code]);
        // return the encoded json
        if ($type == "Android" || $type == "ios")
        {
            if ($code < 300)
            {
                return json_encode(array(
                    'code' => $code, // success or not?
                    'result' => $message
                ));
            } else
            {
                 return json_encode(array(
                    'code' => $code, // success or not?
                    'error' => $message
                ));
            }
        } else
        {
            return json_encode($message);
        }
    }

}


if (!function_exists('getOS'))
{

    function getOS($user_agent)
    {

        global $user_agent;

        $os_platform = "Unknown OS Platform";

        $os_array = array(
            '/windows nt 6.3/i' => 'Windows 8.1',
            '/windows nt 6.2/i' => 'Windows 8',
            '/windows nt 6.1/i' => 'Windows 7',
            '/windows nt 6.0/i' => 'Windows Vista',
            '/windows nt 5.2/i' => 'Windows Server 2003/XP x64',
            '/windows nt 5.1/i' => 'Windows XP',
            '/windows xp/i' => 'Windows XP',
            '/windows nt 5.0/i' => 'Windows 2000',
            '/windows me/i' => 'Windows ME',
            '/win98/i' => 'Windows 98',
            '/win95/i' => 'Windows 95',
            '/win16/i' => 'Windows 3.11',
            '/macintosh|mac os x/i' => 'Mac OS X',
            '/mac_powerpc/i' => 'Mac OS 9',
            '/linux/i' => 'Linux',
            '/ubuntu/i' => 'Ubuntu',
            '/iphone/i' => 'iPhone',
            '/ipod/i' => 'iPod',
            '/ipad/i' => 'iPad',
            '/android/i' => 'Android',
            '/blackberry/i' => 'BlackBerry',
            '/webos/i' => 'Mobile'
        );

        foreach ($os_array as $regex => $value)
        {

            if (preg_match($regex, $user_agent))
            {
                $os_platform = $value;
            }
        }

        return $os_platform;
    }

}


if (!function_exists('getBrowser'))
{

    function getBrowser($user_agent)
    {

        global $user_agent;

        $browser = "Unknown Browser";

        $browser_array = array(
            '/msie/i' => 'Internet Explorer',
            '/firefox/i' => 'Firefox',
            '/safari/i' => 'Safari',
            '/chrome/i' => 'Chrome',
            '/opera/i' => 'Opera',
            '/netscape/i' => 'Netscape',
            '/maxthon/i' => 'Maxthon',
            '/konqueror/i' => 'Konqueror',
            '/mobile/i' => 'Handheld Browser'
        );

        foreach ($browser_array as $regex => $value)
        {

            if (preg_match($regex, $user_agent))
            {
                $browser = $value;
            }
        }

        return $browser;
    }

}


if (!function_exists('getIP'))
{

    function getIP()
    {

        if (!empty($_SERVER['HTTP_CLIENT_IP']))
        {
            $ip = $_SERVER['HTTP_CLIENT_IP'];
        } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR']))
        {
            $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
        } else
        {
            $ip = $_SERVER['REMOTE_ADDR'];
        }
        return $ip;
    }

}

/**
 * Returns base64 encoded string prepended by "data:image/"
 *
 * @param $filename string
 * @param $filetype string 
 * @return string
 */
if (!function_exists('base64_encode_image'))
{

    function base64_encode_image($filename, $filetype = "jpg")
    {
        if ($filename)
        {
            $imgbinary = fread(fopen($filename, "r"), filesize($filename));
            return 'data:image/' . $filetype
                    . ';base64,' . base64_encode($imgbinary);
        }
    }

}

if (!function_exists('removeElementWithValue'))
{

    function removeElementWithValue($array, $key, $value)
    {
        foreach ($array as $subKey => $subArray)
        {
            if ($subArray[$key] == $value)
            {
                unset($array[$subKey]);
            }
        }
        return $array;
    }

}
if (!function_exists('removeObjectElementWithValue'))
{

    function removeObjectElementWithValue($array, $key, $value)
    {
        foreach ($array as $subKey => $subArray)
        {
            if ($subArray->$key == $value)
            {
                unset($array[$subKey]);
            }
        }
        return $array;
    }

}
if (!function_exists('extract_email_address'))
{

    function extract_email_address($string)
    {
        preg_match('/\<(.*)\>/', $string, $matches);
        if (!empty($matches) && isset($matches[1]))
            return $matches[1];
        else
            return $string;
    }

}


if (!function_exists('array_column'))
{

    /**
     * Returns the values from a single column of the input array, identified by
     * the $columnKey.
     *
     * Optionally, you may provide an $indexKey to index the values in the returned
     * array by the values from the $indexKey column in the input array.
     *
     * @param array $input A multi-dimensional array (record set) from which to pull
     * a column of values.
     * @param mixed $columnKey The column of values to return. This value may be the
     * integer key of the column you wish to retrieve, or it
     * may be the string key name for an associative array.
     * @param mixed $indexKey (Optional.) The column to use as the index/keys for
     * the returned array. This value may be the integer key
     * of the column, or it may be the string key name.
     * @return array
     */
    function array_column($input = null, $columnKey = null, $indexKey = null)
    {

// Using func_get_args() in order to check for proper number of
// parameters and trigger errors exactly as the built-in array_column()
// does in PHP 5.5.
        $argc = func_num_args();
        $params = func_get_args();
        if ($argc < 2)
        {
            trigger_error("array_column() expects at least 2 parameters, {$argc} given", E_USER_WARNING);
            return null;
        }
        if (!is_array($params[0]))
        {
            trigger_error('array_column() expects parameter 1 to be array, ' . gettype($params[0]) . ' given', E_USER_WARNING);
            return null;
        }
        if (!is_int($params[1]) && !is_float($params[1]) && !is_string($params[1]) && $params[1] !== null && !(is_object($params[1]) && method_exists($params[1], '__toString'))
        )
        {
            trigger_error('array_column(): The column key should be either a string or an integer', E_USER_WARNING);
            return false;
        }
        if (isset($params[2]) && !is_int($params[2]) && !is_float($params[2]) && !is_string($params[2]) && !(is_object($params[2]) && method_exists($params[2], '__toString'))
        )
        {
            trigger_error('array_column(): The index key should be either a string or an integer', E_USER_WARNING);
            return false;
        }
        $paramsInput = $params[0];
        $paramsColumnKey = ($params[1] !== null) ? (string) $params[1] : null;
        $paramsIndexKey = null;
        if (isset($params[2]))
        {
            if (is_float($params[2]) || is_int($params[2]))
            {
                $paramsIndexKey = (int) $params[2];
            } else
            {
                $paramsIndexKey = (string) $params[2];
            }
        }
        $resultArray = array();
        foreach ($paramsInput as $row)
        {
            $key = $value = null;
            $keySet = $valueSet = false;
            if ($paramsIndexKey !== null && array_key_exists($paramsIndexKey, $row))
            {
                $keySet = true;
                $key = (string) $row[$paramsIndexKey];
            }
            if ($paramsColumnKey === null)
            {
                $valueSet = true;
                $value = $row;
            } elseif (is_array($row) && array_key_exists($paramsColumnKey, $row))
            {
                $valueSet = true;
                $value = $row[$paramsColumnKey];
            }
            if ($valueSet)
            {
                if ($keySet)
                {
                    $resultArray[$key] = $value;
                } else
                {
                    $resultArray[] = $value;
                }
            }
        }
        return $resultArray;
    }

}

if (!function_exists('get_lat_long'))
{

    function get_lat_long($Address)
    {

        $geocode = file_get_contents('http://maps.google.com/maps/api/geocode/json?address=' . str_replace(' ', '+', $Address) . '&sensor=false');

        $output = json_decode($geocode);

        if (strtolower($output->status) == strtolower("OK"))
            return $output;
        else
            return FALSE;
    }

}
if (!function_exists('quote_escape'))
{

    function quote_escape($str)
    {
        return '"' . chop($str) . '"';
    }

}
if (!function_exists('time_format'))
{

    function time_format($time_ago)
    {
        $time_ago = strtotime($time_ago);
        $cur_time = time();
        $time_elapsed = $cur_time - $time_ago;
        $seconds = $time_elapsed;
        $minutes = round($time_elapsed / 60);
        $hours = round($time_elapsed / 3600);
        $days = round($time_elapsed / 86400);
        $weeks = round($time_elapsed / 604800);
        $months = round($time_elapsed / 2600640);
        $years = round($time_elapsed / 31207680);
        // Seconds
        if ($seconds <= 60)
        {
            return $seconds . "s";
        }
        //Minutes
        else if ($minutes <= 60)
        {
            return $minutes . "m";
        }
        //Hours
        else if ($hours <= 24)
        {
            return $hours . "h";
        }
        //Days
        else if ($days <= 7)
        {
            return $days . "d";
        }
        //Weeks
        else
        {
            return $weeks . "w";
        }
    }

}
if (!function_exists('hashtag'))
{

    function hashtag($string)
    {
        $word = preg_split('/[;,\n]+/', str_replace(" ", "", $string));
        $arr = array_map('ucfirst', $word);
        if (!empty($arr))
            return "#" . implode(" #", $arr);
        else
            return '';
    }

}

if (!function_exists('format_size'))
{

    function format_size($size)
    {
        $sizes = array(" Bytes", " KB", " MB", " GB", " TB", " PB", " EB", " ZB", " YB");
        if ($size == 0)
        {
            return('n/a');
        } else
        {
            return (round($size / pow(1024, ($i = floor(log($size, 1024)))), 2) . $sizes[$i]);
        }
    }

}
if (!function_exists('time_ago'))
{

    function time_ago($time_ago)
    {
        $time_ago = strtotime($time_ago);
        $cur_time = time();
        $time_elapsed = $cur_time - $time_ago;
        $seconds = $time_elapsed;
        $minutes = round($time_elapsed / 60);
        $hours = round($time_elapsed / 3600);
        $days = round($time_elapsed / 86400);
        $weeks = round($time_elapsed / 604800);
        $months = round($time_elapsed / 2600640);
        $years = round($time_elapsed / 31207680);
        // Seconds
        if ($seconds <= 60)
        {
            return "just now";
        }
        //Minutes
        else if ($minutes <= 60)
        {
            if ($minutes == 1)
            {
                return "one minute ago";
            } else
            {
                return "$minutes minutes ago";
            }
        }
        //Hours
        else if ($hours <= 24)
        {
            if ($hours == 1)
            {
                return "an hour ago";
            } else
            {
                return "$hours hrs ago";
            }
        }
        //Days
        else if ($days <= 7)
        {
            if ($days == 1)
            {
                return "yesterday";
            } else
            {
                return "$days days ago";
            }
        }
        //Weeks
        else if ($weeks <= 4.3)
        {
            if ($weeks == 1)
            {
                return "a week ago";
            } else
            {
                return "$weeks weeks ago";
            }
        }
        //Months
        else if ($months <= 12)
        {
            if ($months == 1)
            {
                return "a month ago";
            } else
            {
                return "$months months ago";
            }
        }
        //Years
        else
        {
            if ($years == 1)
            {
                return "one year ago";
            } else
            {
                return "$years years ago";
            }
        }
    }

}
if (!function_exists('addhttp'))
{

    function addhttp($url)
    {
        if (!preg_match("~^(?:f|ht)tps?://~i", $url))
        {
            $url = "http://" . $url;
        }
        return $url;
    }

}

/* End of file programmer_helper.php */
/* Location: ./system/helpers/programmer_helper.php */
