<?php

class scoutDB {
    function scoutDB () {

    }
    
    function login ($user, $password) {
        global $urlBase;
        //Get token
        //API Url
        $url = $urlBase . "/users/sign_in.json?person[email]=". $user ."&person[password]=". $password;
        //Initiate cURL.    
        $ch = curl_init();
        //The JSON data.
        $jsonData = array(
            "person[email]" => $user,
            "person[password]" => $password
        );
        //Encode the array into JSON.
        $jsonDataEncoded = json_encode($jsonData);
        //set cURL options
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonDataEncoded);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
        //Execute the request
        $result = curl_exec($ch);
        //Close cURL
        curl_close($ch);
        //Decode JSON response
        $decoded = json_decode($result, TRUE);
        $authToken = $decoded["people"][0]["authentication_token"];
        return $authToken;
    }

    function qry($qry) {
        global $urlBase;
        global $user, $password, $authToken;
        $authToken = $this->login($user, $password);
        //API Url
        $url = $urlBase . "/groups" . $qry . ".json";
        //Initiate cURL.
        $ch = curl_init();
        //Set cURL options
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json', 'X-User-Email: ' . $user, 'X-User-Token: '.$authToken, 'Accept: application/json'));
        //Execute the request
        $result = curl_exec($ch);
        //Close cURL
        curl_close($ch);
        //Decode JSON response
        $decoded = json_decode($result, TRUE);
        return $decoded;
    }

    function getGroups($groupIds) {
        global $arrLabels;
        $groupId = array();
        $groupId = explode(",", $groupIds);
        //Get data
        $data = array();
        foreach ($groupId as $id) {
            $qry = "/".$id."/people";
            $data = $this->qry($qry);
        }
        //loop phone numbers into new array
        $numbers = array();
        foreach ($data["linked"]["phone_numbers"] as $number) {
            $numbers[$number["id"]] = $number["number"];
        }
        //loop roles into new array
        $roles = array();
        foreach ($data["linked"]["roles"] as $role) {
            if (in_array($role["role_type"], $arrLabels)) { //Replace role_type with label
                $roles[$role["id"]] = $role["label"];
            }
            else {
                $roles[$role["id"]] = $role["role_type"];
            }
        }
        //loop persons into new array
        for ( $i = 0; $i < count($data["people"]); $i++) {
            //$id = $decoded["people"][$i]["id"]; //Could be used as array key..
            $people[$i] = array(
            "id" =>
            $data["people"][$i]["id"],
            "nickname" => $data["people"][$i]["nickname"],
            "email" =>
            $data["people"][$i]["email"],
            "first_name" => $data["people"][$i]["first_name"],
            "last_name" => $data["people"][$i]["last_name"],
            "address" => $data["people"][$i]["address"],
            "zip_code" => $data["people"][$i]["zip_code"],
            "town" =>
            $data["people"][$i]["town"],
            "href" =>
            $data["people"][$i]["href"],
        );
        //append roles to $people
        $roleids = $data["people"][$i]["links"]["roles"];
        $j = 0;
        foreach ($roleids as $id) {
        if (array_key_exists($id, $roles)) {
            $roleindex = "role" . $j;
            $people[$i][$roleindex] = $roles[$id];
        }
        $j++;
        }
        //append phone numbers to $people
        if (array_key_exists("phone_numbers", $data["people"][$i]["links"])) {
            $numids = $data["people"][$i]["links"]["phone_numbers"];
            $j = 0;
            foreach ($numids as $id) {
                if (array_key_exists($id, $numbers)) {
                    $numindex = "phone" . $j;
                    $people[$i][$numindex] = $numbers[$id];
                }
                $j++;
            }
        }
    }
    return $people;
    }
}

?>