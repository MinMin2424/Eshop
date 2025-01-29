<?php

/**
 * Seznam měst pro různé země.
 */

$a = [];

// Argentina cities
array_push($a, "Buenos Aires", "Córdoba", "Rosario", "Mendoza", "La Plata");

// Australia cities
array_push($a, "Sydney", "Melbourne", "Brisbane", "Perth", "Canberra", "Adelaide", "Hobart");

// Belgium cities
array_push($a, "Bruges", "Ghent", "Brussels", "Durbuy", "Dinant", "Leuven");

// Brazil cities
array_push($a, "Rio de Janeiro", "Sao Paulo", "Salvador & Pelourinho", "Recife", "Natal");

// Canada cities
array_push($a, "Montreal", "Vancouver", "Halifax", "Quebec City", "Ottawa", "Victoria");

// Chile cities
array_push($a, "Santiago de Chile", "Valparaiso", "Vina del Mar", "Arica", "San Pedro de Atacama", "La Serena");


// China cities
array_push($a, "Shanghai", "Chengdu", "Beijing", "Guangzhou", "Guilin");

// Cuba cities
array_push($a, "Havana", "Trinidad", "Santa Clara", "Santiago de Cuba", "Baracoa", "Vinales", "Camaguey");

// Czech cities
array_push($a,"Benešov", "Beroun", "Brno");
array_push($a, "Česká Lípa", "Český Krumlov");
array_push($a, "Děčín", "Domažlice");
array_push($a, "DěčHolešovín");
array_push($a, "Cheb", "Chomutov", "Chýnov");
array_push($a, "Jáchymov", "Jesenice", "Jihlava");
array_push($a, "Karlovy Vary", "Kladno", "Kutná Hora");
array_push($a, "Liberec", "Litoměřice", "Litomyšl", "Loket");
array_push($a, "Mariánské Lázně", "Mladá Boleslav", "Litomyšl", "Most");
array_push($a, "Olomouc", "Ostrava");
array_push($a, "Pardubice", "Písek", "Plzeň", "Poděbrady", "Praha");
array_push($a, "Říčany");
array_push($a, "Sázava", "Strakonice");
array_push($a, "Tábor", "Tachov", "Telč", "Teplice", "Terezín", "Třebíč", "Třeboň");
array_push($a, "Ústí nad Labem", "Valtice");
array_push($a, "Zlín", "Znojmo");
array_push($a, "Žatec", "Ždánice", "Ždár nad Sázavou");

// Denmark cities
array_push($a, " Copenhagen", "Aarhus", "Aalborg", "Varde", "Frederikshavn");

// Egypt cities
array_push($a, "Cairo", "Giza", "Alenxandria", "Fairyum", "Port Said", "Suez", "Zagazig");

// Finland cities
array_push($a, "Helsinki", "Rovaniemi", "Historic Turku", "Vaasa", "Lappeenranta");

// France cities
array_push($a, "Bordeaux", "Strasbourg", "Toulouse", "Marseille", "Nantes");

// German cities
array_push($a, "Berlin", "Hamburg", "Nuremberg", "Munich", "Dresden", "Leipzig");

// Italy cities
array_push($a, "Florence", "Naples", "Palermo", "Milan", "Bologna", "Turin");

// Japan cities
array_push($a, "Sapporo", "Tokyo", "Yokohama", "Nagoya", "Kyoto", "Nara", "Osaka", "Hiroshima");

// Luxembourg cities
array_push($a, "Clervaux", "Larochette", "Luxembourg", "Diekirch", "Vianden", "Echternach");

// Mexico cities
array_push($a, "Mexico City", "Oaxaca", "Guadalajara", "Puebla", "Cancun", "Puerto Vallarta", "Merida", "San Miguel de Allende");

// New Zealand
array_push($a, "Auckland", "Wellington", "Christchurch", "Dunedin", "Napier-Hastings", "Tauranga", "Nelson", "Rotorua");

// Norway cities
array_push($a, "Oslo", "Bergen", "Trondheim", "Stavanger", "Tromso");

// Poland cities
array_push($a, "Poznan", "Krakow", "Warsaw", "Zakopane", "Torun", "Lublin", "Lodz");

// Russia cities
array_push($a, "Moscow", "St. Petersburg", "Kazan", "Sochi", "Veliky Novgorod", "Smolensk", "Krasnodar");

// Slowakia cities
array_push($a, "Bratislava", "High Tatras National Park", "Poprad", "Kosice", "Bojnice", "Levoca");

// South Korea cities
array_push($a, "Daegu", "Seogwipo", "Tongyeong", "Seoul", "Busan", "Jeju City", "Incheon");

// Sweden cities
array_push($a, "Stockholm", "Gothenburg", "Karlskrona", "Malmo");

// Switzerland cities
array_push($a, "Zurich", "Lucerne", "Bern", "Interlaken", "Zermatt", "Montreux and Geneva");

// The United State of America cities
array_push($a, "San Francisco", "Las Vegas", "Miami", "New York", "Los Angeles", "Honolulu");

// The U.K. cities
array_push($a, "London", "Edinburgh", "Manchester", "Birmingham", "Glasgow", "Liverpool", "Oxford", "Cambridge");

// Vietnam cities
array_push($a, "Hanoi", "Sapa", "Ninh Binh", "Ha Giang", "Da Nang", "Hoi An", "Hue", "Nha Trang", "Hai Phong", "Ho Chi Minh City");

// Získání parametr 'q' z URL.
$q = $_REQUEST["q"];

$hint = "";

// Prohledávání všechny návrhy v poli, pokud $q není prázdný
if ($q !== "") {
  $q = strtolower($q);
  $len=strlen($q);
  foreach($a as $name) {
    if (stristr($q, substr($name, 0, $len))) {
      if ($hint === "") {
        $hint = $name;
      } else {
        $hint .= "<p>$name</p>";
      }
    }
  }
}

// Vypíše "no suggestion", pokud nebyl nalezen žádný návrh, jinak vypíše správné hodnoty
echo $hint === "" ? "no suggestion" : $hint;

?>