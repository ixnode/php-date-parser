<?php

/*
 * This file is part of the ixnode/php-date-parser project.
 *
 * (c) Björn Hempel <https://www.hempel.li/>
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Ixnode\PhpDateParser\Constants;

use DateTimeZone;
use Ixnode\PhpNamingConventions\Exception\FunctionReplaceException;
use Ixnode\PhpNamingConventions\NamingConventions;

/**
 * Class Timezones
 *
 * @author Björn Hempel <bjoern@hempel.li>
 * @version 0.1.0 (2023-07-16)
 * @since 0.1.0 (2023-07-16) First version.
 */
class Timezones
{
    final public const AFRICA_ABIDJAN = 'Africa/Abidjan';

    final public const AFRICA_ACCRA = 'Africa/Accra';

    final public const AFRICA_ADDIS_ABABA = 'Africa/Addis_Ababa';

    final public const AFRICA_ALGIERS = 'Africa/Algiers';

    final public const AFRICA_ASMARA = 'Africa/Asmara';

    final public const AFRICA_BAMAKO = 'Africa/Bamako';

    final public const AFRICA_BANGUI = 'Africa/Bangui';

    final public const AFRICA_BANJUL = 'Africa/Banjul';

    final public const AFRICA_BISSAU = 'Africa/Bissau';

    final public const AFRICA_BLANTYRE = 'Africa/Blantyre';

    final public const AFRICA_BRAZZAVILLE = 'Africa/Brazzaville';

    final public const AFRICA_BUJUMBURA = 'Africa/Bujumbura';

    final public const AFRICA_CAIRO = 'Africa/Cairo';

    final public const AFRICA_CASABLANCA = 'Africa/Casablanca';

    final public const AFRICA_CEUTA = 'Africa/Ceuta';

    final public const AFRICA_CONAKRY = 'Africa/Conakry';

    final public const AFRICA_DAKAR = 'Africa/Dakar';

    final public const AFRICA_DAR_ES_SALAAM = 'Africa/Dar_es_Salaam';

    final public const AFRICA_DJIBOUTI = 'Africa/Djibouti';

    final public const AFRICA_DOUALA = 'Africa/Douala';

    final public const AFRICA_EL_AAIUN = 'Africa/El_Aaiun';

    final public const AFRICA_FREETOWN = 'Africa/Freetown';

    final public const AFRICA_GABORONE = 'Africa/Gaborone';

    final public const AFRICA_HARARE = 'Africa/Harare';

    final public const AFRICA_JOHANNESBURG = 'Africa/Johannesburg';

    final public const AFRICA_JUBA = 'Africa/Juba';

    final public const AFRICA_KAMPALA = 'Africa/Kampala';

    final public const AFRICA_KHARTOUM = 'Africa/Khartoum';

    final public const AFRICA_KIGALI = 'Africa/Kigali';

    final public const AFRICA_KINSHASA = 'Africa/Kinshasa';

    final public const AFRICA_LAGOS = 'Africa/Lagos';

    final public const AFRICA_LIBREVILLE = 'Africa/Libreville';

    final public const AFRICA_LOME = 'Africa/Lome';

    final public const AFRICA_LUANDA = 'Africa/Luanda';

    final public const AFRICA_LUBUMBASHI = 'Africa/Lubumbashi';

    final public const AFRICA_LUSAKA = 'Africa/Lusaka';

    final public const AFRICA_MALABO = 'Africa/Malabo';

    final public const AFRICA_MAPUTO = 'Africa/Maputo';

    final public const AFRICA_MASERU = 'Africa/Maseru';

    final public const AFRICA_MBABANE = 'Africa/Mbabane';

    final public const AFRICA_MOGADISHU = 'Africa/Mogadishu';

    final public const AFRICA_MONROVIA = 'Africa/Monrovia';

    final public const AFRICA_NAIROBI = 'Africa/Nairobi';

    final public const AFRICA_NDJAMENA = 'Africa/Ndjamena';

    final public const AFRICA_NIAMEY = 'Africa/Niamey';

    final public const AFRICA_NOUAKCHOTT = 'Africa/Nouakchott';

    final public const AFRICA_OUAGADOUGOU = 'Africa/Ouagadougou';

    final public const AFRICA_PORTO_NOVO = 'Africa/Porto-Novo';

    final public const AFRICA_SAO_TOME = 'Africa/Sao_Tome';

    final public const AFRICA_TRIPOLI = 'Africa/Tripoli';

    final public const AFRICA_TUNIS = 'Africa/Tunis';

    final public const AFRICA_WINDHOEK = 'Africa/Windhoek';

    final public const AMERICA_ADAK = 'America/Adak';

    final public const AMERICA_ANCHORAGE = 'America/Anchorage';

    final public const AMERICA_ANGUILLA = 'America/Anguilla';

    final public const AMERICA_ANTIGUA = 'America/Antigua';

    final public const AMERICA_ARAGUAINA = 'America/Araguaina';

    final public const AMERICA_ARGENTINA_BUENOS_AIRES = 'America/Argentina/Buenos_Aires';

    final public const AMERICA_ARGENTINA_CATAMARCA = 'America/Argentina/Catamarca';

    final public const AMERICA_ARGENTINA_CORDOBA = 'America/Argentina/Cordoba';

    final public const AMERICA_ARGENTINA_JUJUY = 'America/Argentina/Jujuy';

    final public const AMERICA_ARGENTINA_LA_RIOJA = 'America/Argentina/La_Rioja';

    final public const AMERICA_ARGENTINA_MENDOZA = 'America/Argentina/Mendoza';

    final public const AMERICA_ARGENTINA_RIO_GALLEGOS = 'America/Argentina/Rio_Gallegos';

    final public const AMERICA_ARGENTINA_SALTA = 'America/Argentina/Salta';

    final public const AMERICA_ARGENTINA_SAN_JUAN = 'America/Argentina/San_Juan';

    final public const AMERICA_ARGENTINA_SAN_LUIS = 'America/Argentina/San_Luis';

    final public const AMERICA_ARGENTINA_TUCUMAN = 'America/Argentina/Tucuman';

    final public const AMERICA_ARGENTINA_USHUAIA = 'America/Argentina/Ushuaia';

    final public const AMERICA_ARUBA = 'America/Aruba';

    final public const AMERICA_ASUNCION = 'America/Asuncion';

    final public const AMERICA_ATIKOKAN = 'America/Atikokan';

    final public const AMERICA_BAHIA = 'America/Bahia';

    final public const AMERICA_BAHIA_BANDERAS = 'America/Bahia_Banderas';

    final public const AMERICA_BARBADOS = 'America/Barbados';

    final public const AMERICA_BELEM = 'America/Belem';

    final public const AMERICA_BELIZE = 'America/Belize';

    final public const AMERICA_BLANC_SABLON = 'America/Blanc-Sablon';

    final public const AMERICA_BOA_VISTA = 'America/Boa_Vista';

    final public const AMERICA_BOGOTA = 'America/Bogota';

    final public const AMERICA_BOISE = 'America/Boise';

    final public const AMERICA_CAMBRIDGE_BAY = 'America/Cambridge_Bay';

    final public const AMERICA_CAMPO_GRANDE = 'America/Campo_Grande';

    final public const AMERICA_CANCUN = 'America/Cancun';

    final public const AMERICA_CARACAS = 'America/Caracas';

    final public const AMERICA_CAYENNE = 'America/Cayenne';

    final public const AMERICA_CAYMAN = 'America/Cayman';

    final public const AMERICA_CHICAGO = 'America/Chicago';

    final public const AMERICA_CHIHUAHUA = 'America/Chihuahua';

    final public const AMERICA_CIUDAD_JUAREZ = 'America/Ciudad_Juarez';

    final public const AMERICA_COSTA_RICA = 'America/Costa_Rica';

    final public const AMERICA_CRESTON = 'America/Creston';

    final public const AMERICA_CUIABA = 'America/Cuiaba';

    final public const AMERICA_CURACAO = 'America/Curacao';

    final public const AMERICA_DANMARKSHAVN = 'America/Danmarkshavn';

    final public const AMERICA_DAWSON = 'America/Dawson';

    final public const AMERICA_DAWSON_CREEK = 'America/Dawson_Creek';

    final public const AMERICA_DENVER = 'America/Denver';

    final public const AMERICA_DETROIT = 'America/Detroit';

    final public const AMERICA_DOMINICA = 'America/Dominica';

    final public const AMERICA_EDMONTON = 'America/Edmonton';

    final public const AMERICA_EIRUNEPE = 'America/Eirunepe';

    final public const AMERICA_EL_SALVADOR = 'America/El_Salvador';

    final public const AMERICA_FORT_NELSON = 'America/Fort_Nelson';

    final public const AMERICA_FORTALEZA = 'America/Fortaleza';

    final public const AMERICA_GLACE_BAY = 'America/Glace_Bay';

    final public const AMERICA_GOOSE_BAY = 'America/Goose_Bay';

    final public const AMERICA_GRAND_TURK = 'America/Grand_Turk';

    final public const AMERICA_GRENADA = 'America/Grenada';

    final public const AMERICA_GUADELOUPE = 'America/Guadeloupe';

    final public const AMERICA_GUATEMALA = 'America/Guatemala';

    final public const AMERICA_GUAYAQUIL = 'America/Guayaquil';

    final public const AMERICA_GUYANA = 'America/Guyana';

    final public const AMERICA_HALIFAX = 'America/Halifax';

    final public const AMERICA_HAVANA = 'America/Havana';

    final public const AMERICA_HERMOSILLO = 'America/Hermosillo';

    final public const AMERICA_INDIANA_INDIANAPOLIS = 'America/Indiana/Indianapolis';

    final public const AMERICA_INDIANA_KNOX = 'America/Indiana/Knox';

    final public const AMERICA_INDIANA_MARENGO = 'America/Indiana/Marengo';

    final public const AMERICA_INDIANA_PETERSBURG = 'America/Indiana/Petersburg';

    final public const AMERICA_INDIANA_TELL_CITY = 'America/Indiana/Tell_City';

    final public const AMERICA_INDIANA_VEVAY = 'America/Indiana/Vevay';

    final public const AMERICA_INDIANA_VINCENNES = 'America/Indiana/Vincennes';

    final public const AMERICA_INDIANA_WINAMAC = 'America/Indiana/Winamac';

    final public const AMERICA_INUVIK = 'America/Inuvik';

    final public const AMERICA_IQALUIT = 'America/Iqaluit';

    final public const AMERICA_JAMAICA = 'America/Jamaica';

    final public const AMERICA_JUNEAU = 'America/Juneau';

    final public const AMERICA_KENTUCKY_LOUISVILLE = 'America/Kentucky/Louisville';

    final public const AMERICA_KENTUCKY_MONTICELLO = 'America/Kentucky/Monticello';

    final public const AMERICA_KRALENDIJK = 'America/Kralendijk';

    final public const AMERICA_LA_PAZ = 'America/La_Paz';

    final public const AMERICA_LIMA = 'America/Lima';

    final public const AMERICA_LOS_ANGELES = 'America/Los_Angeles';

    final public const AMERICA_LOWER_PRINCES = 'America/Lower_Princes';

    final public const AMERICA_MACEIO = 'America/Maceio';

    final public const AMERICA_MANAGUA = 'America/Managua';

    final public const AMERICA_MANAUS = 'America/Manaus';

    final public const AMERICA_MARIGOT = 'America/Marigot';

    final public const AMERICA_MARTINIQUE = 'America/Martinique';

    final public const AMERICA_MATAMOROS = 'America/Matamoros';

    final public const AMERICA_MAZATLAN = 'America/Mazatlan';

    final public const AMERICA_MENOMINEE = 'America/Menominee';

    final public const AMERICA_MERIDA = 'America/Merida';

    final public const AMERICA_METLAKATLA = 'America/Metlakatla';

    final public const AMERICA_MEXICO_CITY = 'America/Mexico_City';

    final public const AMERICA_MIQUELON = 'America/Miquelon';

    final public const AMERICA_MONCTON = 'America/Moncton';

    final public const AMERICA_MONTERREY = 'America/Monterrey';

    final public const AMERICA_MONTEVIDEO = 'America/Montevideo';

    final public const AMERICA_MONTSERRAT = 'America/Montserrat';

    final public const AMERICA_NASSAU = 'America/Nassau';

    final public const AMERICA_NEW_YORK = 'America/New_York';

    final public const AMERICA_NIPIGON = 'America/Nipigon';

    final public const AMERICA_NOME = 'America/Nome';

    final public const AMERICA_NORONHA = 'America/Noronha';

    final public const AMERICA_NORTH_DAKOTA_BEULAH = 'America/North_Dakota/Beulah';

    final public const AMERICA_NORTH_DAKOTA_CENTER = 'America/North_Dakota/Center';

    final public const AMERICA_NORTH_DAKOTA_NEW_SALEM = 'America/North_Dakota/New_Salem';

    final public const AMERICA_NUUK = 'America/Nuuk';

    final public const AMERICA_OJINAGA = 'America/Ojinaga';

    final public const AMERICA_PANAMA = 'America/Panama';

    final public const AMERICA_PANGNIRTUNG = 'America/Pangnirtung';

    final public const AMERICA_PARAMARIBO = 'America/Paramaribo';

    final public const AMERICA_PHOENIX = 'America/Phoenix';

    final public const AMERICA_PORT_AU_PRINCE = 'America/Port-au-Prince';

    final public const AMERICA_PORT_OF_SPAIN = 'America/Port_of_Spain';

    final public const AMERICA_PORTO_VELHO = 'America/Porto_Velho';

    final public const AMERICA_PUERTO_RICO = 'America/Puerto_Rico';

    final public const AMERICA_PUNTA_ARENAS = 'America/Punta_Arenas';

    final public const AMERICA_RAINY_RIVER = 'America/Rainy_River';

    final public const AMERICA_RANKIN_INLET = 'America/Rankin_Inlet';

    final public const AMERICA_RECIFE = 'America/Recife';

    final public const AMERICA_REGINA = 'America/Regina';

    final public const AMERICA_RESOLUTE = 'America/Resolute';

    final public const AMERICA_RIO_BRANCO = 'America/Rio_Branco';

    final public const AMERICA_SANTAREM = 'America/Santarem';

    final public const AMERICA_SANTIAGO = 'America/Santiago';

    final public const AMERICA_SANTO_DOMINGO = 'America/Santo_Domingo';

    final public const AMERICA_SAO_PAULO = 'America/Sao_Paulo';

    final public const AMERICA_SCORESBYSUND = 'America/Scoresbysund';

    final public const AMERICA_SITKA = 'America/Sitka';

    final public const AMERICA_ST_BARTHELEMY = 'America/St_Barthelemy';

    final public const AMERICA_ST_JOHNS = 'America/St_Johns';

    final public const AMERICA_ST_KITTS = 'America/St_Kitts';

    final public const AMERICA_ST_LUCIA = 'America/St_Lucia';

    final public const AMERICA_ST_THOMAS = 'America/St_Thomas';

    final public const AMERICA_ST_VINCENT = 'America/St_Vincent';

    final public const AMERICA_SWIFT_CURRENT = 'America/Swift_Current';

    final public const AMERICA_TEGUCIGALPA = 'America/Tegucigalpa';

    final public const AMERICA_THULE = 'America/Thule';

    final public const AMERICA_THUNDER_BAY = 'America/Thunder_Bay';

    final public const AMERICA_TIJUANA = 'America/Tijuana';

    final public const AMERICA_TORONTO = 'America/Toronto';

    final public const AMERICA_TORTOLA = 'America/Tortola';

    final public const AMERICA_VANCOUVER = 'America/Vancouver';

    final public const AMERICA_WHITEHORSE = 'America/Whitehorse';

    final public const AMERICA_WINNIPEG = 'America/Winnipeg';

    final public const AMERICA_YAKUTAT = 'America/Yakutat';

    final public const AMERICA_YELLOWKNIFE = 'America/Yellowknife';

    final public const ANTARCTICA_CASEY = 'Antarctica/Casey';

    final public const ANTARCTICA_DAVIS = 'Antarctica/Davis';

    final public const ANTARCTICA_DUMONT_DURVILLE = 'Antarctica/DumontDUrville';

    final public const ANTARCTICA_MACQUARIE = 'Antarctica/Macquarie';

    final public const ANTARCTICA_MAWSON = 'Antarctica/Mawson';

    final public const ANTARCTICA_MC_MURDO = 'Antarctica/McMurdo';

    final public const ANTARCTICA_PALMER = 'Antarctica/Palmer';

    final public const ANTARCTICA_ROTHERA = 'Antarctica/Rothera';

    final public const ANTARCTICA_SYOWA = 'Antarctica/Syowa';

    final public const ANTARCTICA_TROLL = 'Antarctica/Troll';

    final public const ANTARCTICA_VOSTOK = 'Antarctica/Vostok';

    final public const ARCTIC_LONGYEARBYEN = 'Arctic/Longyearbyen';

    final public const ASIA_ADEN = 'Asia/Aden';

    final public const ASIA_ALMATY = 'Asia/Almaty';

    final public const ASIA_AMMAN = 'Asia/Amman';

    final public const ASIA_ANADYR = 'Asia/Anadyr';

    final public const ASIA_AQTAU = 'Asia/Aqtau';

    final public const ASIA_AQTOBE = 'Asia/Aqtobe';

    final public const ASIA_ASHGABAT = 'Asia/Ashgabat';

    final public const ASIA_ATYRAU = 'Asia/Atyrau';

    final public const ASIA_BAGHDAD = 'Asia/Baghdad';

    final public const ASIA_BAHRAIN = 'Asia/Bahrain';

    final public const ASIA_BAKU = 'Asia/Baku';

    final public const ASIA_BANGKOK = 'Asia/Bangkok';

    final public const ASIA_BARNAUL = 'Asia/Barnaul';

    final public const ASIA_BEIRUT = 'Asia/Beirut';

    final public const ASIA_BISHKEK = 'Asia/Bishkek';

    final public const ASIA_BRUNEI = 'Asia/Brunei';

    final public const ASIA_CHITA = 'Asia/Chita';

    final public const ASIA_CHOIBALSAN = 'Asia/Choibalsan';

    final public const ASIA_COLOMBO = 'Asia/Colombo';

    final public const ASIA_DAMASCUS = 'Asia/Damascus';

    final public const ASIA_DHAKA = 'Asia/Dhaka';

    final public const ASIA_DILI = 'Asia/Dili';

    final public const ASIA_DUBAI = 'Asia/Dubai';

    final public const ASIA_DUSHANBE = 'Asia/Dushanbe';

    final public const ASIA_FAMAGUSTA = 'Asia/Famagusta';

    final public const ASIA_GAZA = 'Asia/Gaza';

    final public const ASIA_HEBRON = 'Asia/Hebron';

    final public const ASIA_HO_CHI_MINH = 'Asia/Ho_Chi_Minh';

    final public const ASIA_HONG_KONG = 'Asia/Hong_Kong';

    final public const ASIA_HOVD = 'Asia/Hovd';

    final public const ASIA_IRKUTSK = 'Asia/Irkutsk';

    final public const ASIA_JAKARTA = 'Asia/Jakarta';

    final public const ASIA_JAYAPURA = 'Asia/Jayapura';

    final public const ASIA_JERUSALEM = 'Asia/Jerusalem';

    final public const ASIA_KABUL = 'Asia/Kabul';

    final public const ASIA_KAMCHATKA = 'Asia/Kamchatka';

    final public const ASIA_KARACHI = 'Asia/Karachi';

    final public const ASIA_KATHMANDU = 'Asia/Kathmandu';

    final public const ASIA_KHANDYGA = 'Asia/Khandyga';

    final public const ASIA_KOLKATA = 'Asia/Kolkata';

    final public const ASIA_KRASNOYARSK = 'Asia/Krasnoyarsk';

    final public const ASIA_KUALA_LUMPUR = 'Asia/Kuala_Lumpur';

    final public const ASIA_KUCHING = 'Asia/Kuching';

    final public const ASIA_KUWAIT = 'Asia/Kuwait';

    final public const ASIA_MACAU = 'Asia/Macau';

    final public const ASIA_MAGADAN = 'Asia/Magadan';

    final public const ASIA_MAKASSAR = 'Asia/Makassar';

    final public const ASIA_MANILA = 'Asia/Manila';

    final public const ASIA_MUSCAT = 'Asia/Muscat';

    final public const ASIA_NICOSIA = 'Asia/Nicosia';

    final public const ASIA_NOVOKUZNETSK = 'Asia/Novokuznetsk';

    final public const ASIA_NOVOSIBIRSK = 'Asia/Novosibirsk';

    final public const ASIA_OMSK = 'Asia/Omsk';

    final public const ASIA_ORAL = 'Asia/Oral';

    final public const ASIA_PHNOM_PENH = 'Asia/Phnom_Penh';

    final public const ASIA_PONTIANAK = 'Asia/Pontianak';

    final public const ASIA_PYONGYANG = 'Asia/Pyongyang';

    final public const ASIA_QATAR = 'Asia/Qatar';

    final public const ASIA_QOSTANAY = 'Asia/Qostanay';

    final public const ASIA_QYZYLORDA = 'Asia/Qyzylorda';

    final public const ASIA_RIYADH = 'Asia/Riyadh';

    final public const ASIA_SAKHALIN = 'Asia/Sakhalin';

    final public const ASIA_SAMARKAND = 'Asia/Samarkand';

    final public const ASIA_SEOUL = 'Asia/Seoul';

    final public const ASIA_SHANGHAI = 'Asia/Shanghai';

    final public const ASIA_SINGAPORE = 'Asia/Singapore';

    final public const ASIA_SREDNEKOLYMSK = 'Asia/Srednekolymsk';

    final public const ASIA_TAIPEI = 'Asia/Taipei';

    final public const ASIA_TASHKENT = 'Asia/Tashkent';

    final public const ASIA_TBILISI = 'Asia/Tbilisi';

    final public const ASIA_TEHRAN = 'Asia/Tehran';

    final public const ASIA_THIMPHU = 'Asia/Thimphu';

    final public const ASIA_TOKYO = 'Asia/Tokyo';

    final public const ASIA_TOMSK = 'Asia/Tomsk';

    final public const ASIA_ULAANBAATAR = 'Asia/Ulaanbaatar';

    final public const ASIA_URUMQI = 'Asia/Urumqi';

    final public const ASIA_UST_NERA = 'Asia/Ust-Nera';

    final public const ASIA_VIENTIANE = 'Asia/Vientiane';

    final public const ASIA_VLADIVOSTOK = 'Asia/Vladivostok';

    final public const ASIA_YAKUTSK = 'Asia/Yakutsk';

    final public const ASIA_YANGON = 'Asia/Yangon';

    final public const ASIA_YEKATERINBURG = 'Asia/Yekaterinburg';

    final public const ASIA_YEREVAN = 'Asia/Yerevan';

    final public const ATLANTIC_AZORES = 'Atlantic/Azores';

    final public const ATLANTIC_BERMUDA = 'Atlantic/Bermuda';

    final public const ATLANTIC_CANARY = 'Atlantic/Canary';

    final public const ATLANTIC_CAPE_VERDE = 'Atlantic/Cape_Verde';

    final public const ATLANTIC_FAROE = 'Atlantic/Faroe';

    final public const ATLANTIC_MADEIRA = 'Atlantic/Madeira';

    final public const ATLANTIC_REYKJAVIK = 'Atlantic/Reykjavik';

    final public const ATLANTIC_SOUTH_GEORGIA = 'Atlantic/South_Georgia';

    final public const ATLANTIC_ST_HELENA = 'Atlantic/St_Helena';

    final public const ATLANTIC_STANLEY = 'Atlantic/Stanley';

    final public const AUSTRALIA_ADELAIDE = 'Australia/Adelaide';

    final public const AUSTRALIA_BRISBANE = 'Australia/Brisbane';

    final public const AUSTRALIA_BROKEN_HILL = 'Australia/Broken_Hill';

    final public const AUSTRALIA_DARWIN = 'Australia/Darwin';

    final public const AUSTRALIA_EUCLA = 'Australia/Eucla';

    final public const AUSTRALIA_HOBART = 'Australia/Hobart';

    final public const AUSTRALIA_LINDEMAN = 'Australia/Lindeman';

    final public const AUSTRALIA_LORD_HOWE = 'Australia/Lord_Howe';

    final public const AUSTRALIA_MELBOURNE = 'Australia/Melbourne';

    final public const AUSTRALIA_PERTH = 'Australia/Perth';

    final public const AUSTRALIA_SYDNEY = 'Australia/Sydney';

    final public const EUROPE_AMSTERDAM = 'Europe/Amsterdam';

    final public const EUROPE_ANDORRA = 'Europe/Andorra';

    final public const EUROPE_ASTRAKHAN = 'Europe/Astrakhan';

    final public const EUROPE_ATHENS = 'Europe/Athens';

    final public const EUROPE_BELGRADE = 'Europe/Belgrade';

    final public const EUROPE_BERLIN = 'Europe/Berlin';

    final public const EUROPE_BRATISLAVA = 'Europe/Bratislava';

    final public const EUROPE_BRUSSELS = 'Europe/Brussels';

    final public const EUROPE_BUCHAREST = 'Europe/Bucharest';

    final public const EUROPE_BUDAPEST = 'Europe/Budapest';

    final public const EUROPE_BUSINGEN = 'Europe/Busingen';

    final public const EUROPE_CHISINAU = 'Europe/Chisinau';

    final public const EUROPE_COPENHAGEN = 'Europe/Copenhagen';

    final public const EUROPE_DUBLIN = 'Europe/Dublin';

    final public const EUROPE_GIBRALTAR = 'Europe/Gibraltar';

    final public const EUROPE_GUERNSEY = 'Europe/Guernsey';

    final public const EUROPE_HELSINKI = 'Europe/Helsinki';

    final public const EUROPE_ISLE_OF_MAN = 'Europe/Isle_of_Man';

    final public const EUROPE_ISTANBUL = 'Europe/Istanbul';

    final public const EUROPE_JERSEY = 'Europe/Jersey';

    final public const EUROPE_KALININGRAD = 'Europe/Kaliningrad';

    final public const EUROPE_KIEV = 'Europe/Kiev';

    final public const EUROPE_KIROV = 'Europe/Kirov';

    final public const EUROPE_LISBON = 'Europe/Lisbon';

    final public const EUROPE_LJUBLJANA = 'Europe/Ljubljana';

    final public const EUROPE_LONDON = 'Europe/London';

    final public const EUROPE_LUXEMBOURG = 'Europe/Luxembourg';

    final public const EUROPE_MADRID = 'Europe/Madrid';

    final public const EUROPE_MALTA = 'Europe/Malta';

    final public const EUROPE_MARIEHAMN = 'Europe/Mariehamn';

    final public const EUROPE_MINSK = 'Europe/Minsk';

    final public const EUROPE_MONACO = 'Europe/Monaco';

    final public const EUROPE_MOSCOW = 'Europe/Moscow';

    final public const EUROPE_OSLO = 'Europe/Oslo';

    final public const EUROPE_PARIS = 'Europe/Paris';

    final public const EUROPE_PODGORICA = 'Europe/Podgorica';

    final public const EUROPE_PRAGUE = 'Europe/Prague';

    final public const EUROPE_RIGA = 'Europe/Riga';

    final public const EUROPE_ROME = 'Europe/Rome';

    final public const EUROPE_SAMARA = 'Europe/Samara';

    final public const EUROPE_SAN_MARINO = 'Europe/San_Marino';

    final public const EUROPE_SARAJEVO = 'Europe/Sarajevo';

    final public const EUROPE_SARATOV = 'Europe/Saratov';

    final public const EUROPE_SIMFEROPOL = 'Europe/Simferopol';

    final public const EUROPE_SKOPJE = 'Europe/Skopje';

    final public const EUROPE_SOFIA = 'Europe/Sofia';

    final public const EUROPE_STOCKHOLM = 'Europe/Stockholm';

    final public const EUROPE_TALLINN = 'Europe/Tallinn';

    final public const EUROPE_TIRANE = 'Europe/Tirane';

    final public const EUROPE_ULYANOVSK = 'Europe/Ulyanovsk';

    final public const EUROPE_UZHGOROD = 'Europe/Uzhgorod';

    final public const EUROPE_VADUZ = 'Europe/Vaduz';

    final public const EUROPE_VATICAN = 'Europe/Vatican';

    final public const EUROPE_VIENNA = 'Europe/Vienna';

    final public const EUROPE_VILNIUS = 'Europe/Vilnius';

    final public const EUROPE_VOLGOGRAD = 'Europe/Volgograd';

    final public const EUROPE_WARSAW = 'Europe/Warsaw';

    final public const EUROPE_ZAGREB = 'Europe/Zagreb';

    final public const EUROPE_ZAPOROZHYE = 'Europe/Zaporozhye';

    final public const EUROPE_ZURICH = 'Europe/Zurich';

    final public const INDIAN_ANTANANARIVO = 'Indian/Antananarivo';

    final public const INDIAN_CHAGOS = 'Indian/Chagos';

    final public const INDIAN_CHRISTMAS = 'Indian/Christmas';

    final public const INDIAN_COCOS = 'Indian/Cocos';

    final public const INDIAN_COMORO = 'Indian/Comoro';

    final public const INDIAN_KERGUELEN = 'Indian/Kerguelen';

    final public const INDIAN_MAHE = 'Indian/Mahe';

    final public const INDIAN_MALDIVES = 'Indian/Maldives';

    final public const INDIAN_MAURITIUS = 'Indian/Mauritius';

    final public const INDIAN_MAYOTTE = 'Indian/Mayotte';

    final public const INDIAN_REUNION = 'Indian/Reunion';

    final public const PACIFIC_APIA = 'Pacific/Apia';

    final public const PACIFIC_AUCKLAND = 'Pacific/Auckland';

    final public const PACIFIC_BOUGAINVILLE = 'Pacific/Bougainville';

    final public const PACIFIC_CHATHAM = 'Pacific/Chatham';

    final public const PACIFIC_CHUUK = 'Pacific/Chuuk';

    final public const PACIFIC_EASTER = 'Pacific/Easter';

    final public const PACIFIC_EFATE = 'Pacific/Efate';

    final public const PACIFIC_ENDERBURY = 'Pacific/Enderbury';

    final public const PACIFIC_FAKAOFO = 'Pacific/Fakaofo';

    final public const PACIFIC_FIJI = 'Pacific/Fiji';

    final public const PACIFIC_FUNAFUTI = 'Pacific/Funafuti';

    final public const PACIFIC_GALAPAGOS = 'Pacific/Galapagos';

    final public const PACIFIC_GAMBIER = 'Pacific/Gambier';

    final public const PACIFIC_GUADALCANAL = 'Pacific/Guadalcanal';

    final public const PACIFIC_GUAM = 'Pacific/Guam';

    final public const PACIFIC_HONOLULU = 'Pacific/Honolulu';

    final public const PACIFIC_KIRITIMATI = 'Pacific/Kiritimati';

    final public const PACIFIC_KOSRAE = 'Pacific/Kosrae';

    final public const PACIFIC_KWAJALEIN = 'Pacific/Kwajalein';

    final public const PACIFIC_MAJURO = 'Pacific/Majuro';

    final public const PACIFIC_MARQUESAS = 'Pacific/Marquesas';

    final public const PACIFIC_MIDWAY = 'Pacific/Midway';

    final public const PACIFIC_NAURU = 'Pacific/Nauru';

    final public const PACIFIC_NIUE = 'Pacific/Niue';

    final public const PACIFIC_NORFOLK = 'Pacific/Norfolk';

    final public const PACIFIC_NOUMEA = 'Pacific/Noumea';

    final public const PACIFIC_PAGO_PAGO = 'Pacific/Pago_Pago';

    final public const PACIFIC_PALAU = 'Pacific/Palau';

    final public const PACIFIC_PITCAIRN = 'Pacific/Pitcairn';

    final public const PACIFIC_POHNPEI = 'Pacific/Pohnpei';

    final public const PACIFIC_PORT_MORESBY = 'Pacific/Port_Moresby';

    final public const PACIFIC_RAROTONGA = 'Pacific/Rarotonga';

    final public const PACIFIC_SAIPAN = 'Pacific/Saipan';

    final public const PACIFIC_TAHITI = 'Pacific/Tahiti';

    final public const PACIFIC_TARAWA = 'Pacific/Tarawa';

    final public const PACIFIC_TONGATAPU = 'Pacific/Tongatapu';

    final public const PACIFIC_WAKE = 'Pacific/Wake';

    final public const PACIFIC_WALLIS = 'Pacific/Wallis';

    final public const UTC = 'UTC';

    /**
     * Prints all DateTimeZone identifiers from PHP library.
     *
     * @return void
     * @throws FunctionReplaceException
     * @SuppressWarnings(PHPMD.StaticAccess)
     */
    static public function printAll(): void
    {
        foreach (DateTimeZone::listIdentifiers() as $identifier) {
            $namingConventions = new NamingConventions(str_replace('/', '_', $identifier));

            print sprintf(
                'final public const %s = \'%s\';'.PHP_EOL.PHP_EOL,
                $namingConventions->getConstant(),
                $identifier
            );
        }
    }
}
