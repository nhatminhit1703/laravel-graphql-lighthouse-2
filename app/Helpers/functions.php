<?php
if (!function_exists('toSlack')) {

        function toSlack($message,$channel,$url)
        {
            try {
                if((app()->environment() == "staging" || app()->environment() == "production")){
                    $payload = [
                        "channel"     => $channel,
                        "icon_emoji"  => ':warning:',
                        "username"    => "WID",
                        "text" => "`Shopping WID`"."\r\n".$message."\r\n"."IP: ".\Request::getClientIp()."\r\n"."Browser: ".$_SERVER['HTTP_USER_AGENT']."\r\n"."Customer ID: ".(\Auth::check() ? \Auth::user()->id.'-'.\Auth::user()->email : "No Login")
                    ];
                    $data = json_encode($payload);
                    $ch = curl_init($url);
                    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
                    curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                    $result = curl_exec($ch);
                    curl_close($ch);
                }
            } catch (\Throwable $th) {
                //throw $th;
            }
        }

}