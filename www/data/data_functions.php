<?php
// Tento soubor obsahuje veškeré funkce, které budou manipulovat s daty.

// Název souboru obsahujícího uživatelská jména.
const USERS_FILE_NAME = "../../data-users-products/users.json";


/**
 * Funkce pro získání všech uživatelů z datového soubru.
 * @return array Pole uživatelů.
 */
function getAllUsers() {
    // Načtení obsahu souboru users.json.
    $users = file_get_contents(USERS_FILE_NAME);
    return json_decode($users, true) ?: [];
}

/**
 * Funkce pro získání uživatele podle ID.
 * @param int $id ID uživatele.
 * @return array|null Pole s informacemi o uživateli nebo null, pokud uživatel nebyl nalezen.
 */
function getUsersById($id) {
    $user = getUsersByAttribute("id", $id);
    if (sizeof($user) == 0) {
        return null;
    } else {
        $x = $user[0];
        return $user[0];
    }
}

/**
 * Funkce pro získání uživatelů podle konkrétního attributu a jeho hodnoty.
 * @param string $attributeName Název attributu.
 * @param mixed $attributeValue Hodnota attributu.
 * @return array Pole uživatelů splňujících podmínku.
 */
function getUsersByAttribute($attributeName, $attributeValue){
    $users = getAllUsers();
    $to_return = array();
    foreach ($users as $index => $user_data) {
        if (isset($user_data[$attributeName]) && $user_data[$attributeName] == $attributeValue) {
            $to_return[] = $user_data;
        }
    }
    return $to_return;
}

/**
 * Funkce pro vložení nebo aktualizaci uživatele v datech.
 * @param string $id ID uživatele.
 * @param string $username Uživatelské jméno.
 * @param string $email E-mail uživatele.
 * @param string $phone_number Telefonní číslo uživatele.
 * @param string $gender Pohlaví uživatele.
 * @param string $address Adresa uživatele.
 * @param string $country Země uživatele.
 * @param string $city Město uživatele.
 * @param string $region Kraj uživatele.
 * @param string $postal_code Poštovní směrovací číslo uživatele.
 * @param string $password1 Heslo uživatele.
 * @param string $password2 Heslo uživatele (potvrzení).
 * @return void
 */
function insertOrUpdateUser($id, $username, $email, $phone_number, $birth_date, $gender, $address, $country, $city, $region, $postal_code, $password1, $password2) {
    $users = getAllUsers();

    if ($id == "") {
        $max_id = -1;
        foreach ($users as $user) {
            print_r ($user);
            if ($user["id"] > $max_id) {
                $max_id = $user["id"];
            }
        }
        if ($max_id == -1) {
            $max_id = 0;
        }
        $new_id = $max_id + 1;
        echo "new max id = $max_id";

        $hashed_password = password_hash($password1, PASSWORD_DEFAULT);

        $array_to_insert = array (
            "id" => $new_id,
            "username" => $username,
            "email" => $email,
            "phone-number" => $phone_number,
            "birth-date" => $birth_date,
            "gender" => $gender,
            "address" => $address,
            "country" => $country,
            "city" => $city,
            "region" => $region,
            "postal-code" => $postal_code,
            "password" => $hashed_password,
        );
        $users[] = $array_to_insert;
    } else {
        $users = getAllUsers();
        foreach ($users as $key => $user) {
            if ($user["id"] == $id) {
                $user["username"] = $username;
                $user["email"] = $email;
                $user["phone-number"] = $phone_number;
                $user["birth-date"] = $birth_date;
                $user["gender"] = $gender;
                $user["address"] = $address;
                $user["country"] = $country;
                $user["city"] = $city;
                $user["region"] = $region;
                $user["postal-code"] = $postal_code;
                $user["pass1"] = $password1;
                $user["pass2"] = $password2;
                $user["$key"] = $user;
                break;
            }
        }
    }
    // Uložení dat do souboru.
    save_data($users);
}

/**
 * Funkce pro uložení dat uživatelů do souboru.
 * @param array $users Pole uživatelů ke zpracování.
 * @return void
 */
function save_data($users) {
    $json = json_encode($users);
    file_put_contents(USERS_FILE_NAME, $json);
}

?>