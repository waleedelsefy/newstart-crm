<?php

namespace Database\Seeders;

use App\Models\Country;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CountrySeeder extends Seeder
{
    public $countries = [
        [
            "id" => "1",
            "iso" => "AF",
            "name_ar" => "أفغانستان",
            "name_en" => "Afghanistan",
            "iso3" => "AFG",
            "phone_code" => "93"
        ],
        [
            "id" => "2",
            "iso" => "AL",
            "name_ar" => "ألبانيا",
            "name_en" => "Albania",
            "iso3" => "ALB",
            "phone_code" => "355"
        ],
        [
            "id" => "3",
            "iso" => "DZ",
            "name_ar" => "الجزائر",
            "name_en" => "Algeria",
            "iso3" => "DZA",
            "phone_code" => "213"
        ],
        [
            "id" => "4",
            "iso" => "AS",
            "name_ar" => "AMERICAN SAMOA",
            "name_en" => "American Samoa",
            "iso3" => "ASM",
            "phone_code" => "1684"
        ],
        [
            "id" => "5",
            "iso" => "AD",
            "name_ar" => "أندورا",
            "name_en" => "Andorra",
            "iso3" => "AND",
            "phone_code" => "376"
        ],
        [
            "id" => "6",
            "iso" => "AO",
            "name_ar" => "أنغولا",
            "name_en" => "Angola",
            "iso3" => "AGO",
            "phone_code" => "244"
        ],
        [
            "id" => "7",
            "iso" => "AI",
            "name_ar" => "أنغيلا",
            "name_en" => "Anguilla",
            "iso3" => "AIA",
            "phone_code" => "1264"
        ],
        [
            "id" => "8",
            "iso" => "AQ",
            "name_ar" => "ANTARCTICA",
            "name_en" => "Antarctica",
            "iso3" => "ATA",
            "phone_code" => "0"
        ],
        [
            "id" => "9",
            "iso" => "AG",
            "name_ar" => "أنتيغوا وبربودا",
            "name_en" => "Antigua and Barbuda",
            "iso3" => "ATG",
            "phone_code" => "1268"
        ],
        [
            "id" => "10",
            "iso" => "AR",
            "name_ar" => "الأرجنتين",
            "name_en" => "Argentina",
            "iso3" => "ARG",
            "phone_code" => "54"
        ],
        [
            "id" => "11",
            "iso" => "AM",
            "name_ar" => "أرمينيا",
            "name_en" => "Armenia",
            "iso3" => "ARM",
            "phone_code" => "374"
        ],
        [
            "id" => "12",
            "iso" => "AW",
            "name_ar" => "أروبا",
            "name_en" => "Aruba",
            "iso3" => "ABW",
            "phone_code" => "297"
        ],
        [
            "id" => "13",
            "iso" => "AU",
            "name_ar" => "أستراليا",
            "name_en" => "Australia",
            "iso3" => "AUS",
            "phone_code" => "61"
        ],
        [
            "id" => "14",
            "iso" => "AT",
            "name_ar" => "النمسا",
            "name_en" => "Austria",
            "iso3" => "AUT",
            "phone_code" => "43"
        ],
        [
            "id" => "15",
            "iso" => "AZ",
            "name_ar" => "أذربيجان",
            "name_en" => "Azerbaijan",
            "iso3" => "AZE",
            "phone_code" => "994"
        ],
        [
            "id" => "16",
            "iso" => "BS",
            "name_ar" => "الباهاما",
            "name_en" => "Bahamas",
            "iso3" => "BHS",
            "phone_code" => "1242"
        ],
        [
            "id" => "17",
            "iso" => "BH",
            "name_ar" => "البحرين",
            "name_en" => "Bahrain",
            "iso3" => "BHR",
            "phone_code" => "973"
        ],
        [
            "id" => "18",
            "iso" => "BD",
            "name_ar" => "بنغلاديش",
            "name_en" => "Bangladesh",
            "iso3" => "BGD",
            "phone_code" => "880"
        ],
        [
            "id" => "19",
            "iso" => "BB",
            "name_ar" => "بربادوس",
            "name_en" => "Barbados",
            "iso3" => "BRB",
            "phone_code" => "1246"
        ],
        [
            "id" => "20",
            "iso" => "BY",
            "name_ar" => "روسيا البيضاء",
            "name_en" => "Belarus",
            "iso3" => "BLR",
            "phone_code" => "375"
        ],
        [
            "id" => "21",
            "iso" => "BE",
            "name_ar" => "بلجيكا",
            "name_en" => "Belgium",
            "iso3" => "BEL",
            "phone_code" => "32"
        ],
        [
            "id" => "22",
            "iso" => "BZ",
            "name_ar" => "بليز",
            "name_en" => "Belize",
            "iso3" => "BLZ",
            "phone_code" => "501"
        ],
        [
            "id" => "23",
            "iso" => "BJ",
            "name_ar" => "بنين",
            "name_en" => "Benin",
            "iso3" => "BEN",
            "phone_code" => "229"
        ],
        [
            "id" => "24",
            "iso" => "BM",
            "name_ar" => "برمودا",
            "name_en" => "Bermuda",
            "iso3" => "BMU",
            "phone_code" => "1441"
        ],
        [
            "id" => "25",
            "iso" => "BT",
            "name_ar" => "بوتان",
            "name_en" => "Bhutan",
            "iso3" => "BTN",
            "phone_code" => "975"
        ],
        [
            "id" => "26",
            "iso" => "BO",
            "name_ar" => "بوليفيا",
            "name_en" => "Bolivia",
            "iso3" => "BOL",
            "phone_code" => "591"
        ],
        [
            "id" => "27",
            "iso" => "BA",
            "name_ar" => "البوسنة والهرسك",
            "name_en" => "Bosnia and Herzegovina",
            "iso3" => "BIH",
            "phone_code" => "387"
        ],
        [
            "id" => "28",
            "iso" => "BW",
            "name_ar" => "بوتسوانا",
            "name_en" => "Botswana",
            "iso3" => "BWA",
            "phone_code" => "267"
        ],
        [
            "id" => "29",
            "iso" => "BV",
            "name_ar" => "BOUVET ISLAND",
            "name_en" => "Bouvet Island",
            "iso3" => "BVT",
            "phone_code" => "0"
        ],
        [
            "id" => "30",
            "iso" => "BR",
            "name_ar" => "البرازيل",
            "name_en" => "Brazil",
            "iso3" => "BRA",
            "phone_code" => "55"
        ],
        [
            "id" => "31",
            "iso" => "IO",
            "name_ar" => "BRITISH INDIAN OCEAN TERRITORY",
            "name_en" => "British Indian Ocean Territory",
            "iso3" => "IOT",
            "phone_code" => "246"
        ],
        [
            "id" => "32",
            "iso" => "BN",
            "name_ar" => "بروناي دار السلام",
            "name_en" => "Brunei Darussalam",
            "iso3" => "BRN",
            "phone_code" => "673"
        ],
        [
            "id" => "33",
            "iso" => "BG",
            "name_ar" => "بلغاريا",
            "name_en" => "Bulgaria",
            "iso3" => "BGR",
            "phone_code" => "359"
        ],
        [
            "id" => "34",
            "iso" => "BF",
            "name_ar" => "بوركينا فاسو",
            "name_en" => "Burkina Faso",
            "iso3" => "BFA",
            "phone_code" => "226"
        ],
        [
            "id" => "35",
            "iso" => "BI",
            "name_ar" => "بوروندي",
            "name_en" => "Burundi",
            "iso3" => "BDI",
            "phone_code" => "257"
        ],
        [
            "id" => "36",
            "iso" => "KH",
            "name_ar" => "كمبوديا",
            "name_en" => "Cambodia",
            "iso3" => "KHM",
            "phone_code" => "855"
        ],
        [
            "id" => "37",
            "iso" => "CM",
            "name_ar" => "الكاميرون",
            "name_en" => "Cameroon",
            "iso3" => "CMR",
            "phone_code" => "237"
        ],
        [
            "id" => "38",
            "iso" => "CA",
            "name_ar" => "كندا",
            "name_en" => "Canada",
            "iso3" => "CAN",
            "phone_code" => "1"
        ],
        [
            "id" => "39",
            "iso" => "CV",
            "name_ar" => "الرأس الأخضر",
            "name_en" => "Cape Verde",
            "iso3" => "CPV",
            "phone_code" => "238"
        ],
        [
            "id" => "40",
            "iso" => "KY",
            "name_ar" => "جزر كايمان",
            "name_en" => "Cayman Islands",
            "iso3" => "CYM",
            "phone_code" => "1345"
        ],
        [
            "id" => "41",
            "iso" => "CF",
            "name_ar" => "جمهورية افريقيا الوسطى",
            "name_en" => "Central African Republic",
            "iso3" => "CAF",
            "phone_code" => "236"
        ],
        [
            "id" => "42",
            "iso" => "TD",
            "name_ar" => "تشاد",
            "name_en" => "Chad",
            "iso3" => "TCD",
            "phone_code" => "235"
        ],
        [
            "id" => "43",
            "iso" => "CL",
            "name_ar" => "تشيلي",
            "name_en" => "Chile",
            "iso3" => "CHL",
            "phone_code" => "56"
        ],
        [
            "id" => "44",
            "iso" => "CN",
            "name_ar" => "الصين",
            "name_en" => "China",
            "iso3" => "CHN",
            "phone_code" => "86"
        ],
        [
            "id" => "45",
            "iso" => "CX",
            "name_ar" => "جزيرة الكريسماس",
            "name_en" => "Christmas Island",
            "iso3" => "CXR",
            "phone_code" => "61"
        ],
        [
            "id" => "46",
            "iso" => "CC",
            "name_ar" => "جزر كوكوس (كيلينغ)",
            "name_en" => "Cocos (Keeling) Islands",
            "iso3" => "CCK",
            "phone_code" => "672"
        ],
        [
            "id" => "47",
            "iso" => "CO",
            "name_ar" => "كولومبيا",
            "name_en" => "Colombia",
            "iso3" => "COL",
            "phone_code" => "57"
        ],
        [
            "id" => "48",
            "iso" => "KM",
            "name_ar" => "جزر القمر",
            "name_en" => "Comoros",
            "iso3" => "COM",
            "phone_code" => "269"
        ],
        [
            "id" => "49",
            "iso" => "CG",
            "name_ar" => "الكونغو",
            "name_en" => "Congo",
            "iso3" => "COG",
            "phone_code" => "242"
        ],
        [
            "id" => "50",
            "iso" => "CD",
            "name_ar" => "CONGO, THE DEMOCRATIC REPUBLIC OF THE",
            "name_en" => "Congo, the Democratic Republic of the",
            "iso3" => "COD",
            "phone_code" => "242"
        ],
        [
            "id" => "51",
            "iso" => "CK",
            "name_ar" => "جزر كوك",
            "name_en" => "Cook Islands",
            "iso3" => "COK",
            "phone_code" => "682"
        ],
        [
            "id" => "52",
            "iso" => "CR",
            "name_ar" => "كوستا ريكا",
            "name_en" => "Costa Rica",
            "iso3" => "CRI",
            "phone_code" => "506"
        ],
        [
            "id" => "53",
            "iso" => "CI",
            "name_ar" => "COTE D'IVOIRE",
            "name_en" => "Cote D'Ivoire",
            "iso3" => "CIV",
            "phone_code" => "225"
        ],
        [
            "id" => "54",
            "iso" => "HR",
            "name_ar" => "CROATIA",
            "name_en" => "Croatia",
            "iso3" => "HRV",
            "phone_code" => "385"
        ],
        [
            "id" => "55",
            "iso" => "CU",
            "name_ar" => "كوبا",
            "name_en" => "Cuba",
            "iso3" => "CUB",
            "phone_code" => "53"
        ],
        [
            "id" => "56",
            "iso" => "CY",
            "name_ar" => "قبرص",
            "name_en" => "Cyprus",
            "iso3" => "CYP",
            "phone_code" => "357"
        ],
        [
            "id" => "57",
            "iso" => "CZ",
            "name_ar" => "جمهورية التشيك",
            "name_en" => "Czech Republic",
            "iso3" => "CZE",
            "phone_code" => "420"
        ],
        [
            "id" => "58",
            "iso" => "DK",
            "name_ar" => "الدنمارك",
            "name_en" => "Denmark",
            "iso3" => "DNK",
            "phone_code" => "45"
        ],
        [
            "id" => "59",
            "iso" => "DJ",
            "name_ar" => "جيبوتي",
            "name_en" => "Djibouti",
            "iso3" => "DJI",
            "phone_code" => "253"
        ],
        [
            "id" => "60",
            "iso" => "DM",
            "name_ar" => "دومينيكا",
            "name_en" => "Dominica",
            "iso3" => "DMA",
            "phone_code" => "1767"
        ],
        [
            "id" => "61",
            "iso" => "DO",
            "name_ar" => "جمهورية الدومنيكان",
            "name_en" => "Dominican Republic",
            "iso3" => "DOM",
            "phone_code" => "1809"
        ],
        [
            "id" => "62",
            "iso" => "EC",
            "name_ar" => "الإكوادور",
            "name_en" => "Ecuador",
            "iso3" => "ECU",
            "phone_code" => "593"
        ],
        [
            "id" => "63",
            "iso" => "EG",
            "name_ar" => "مصر",
            "name_en" => "Egypt",
            "iso3" => "EGY",
            "phone_code" => "20"
        ],
        [
            "id" => "64",
            "iso" => "SV",
            "name_ar" => "السلفادور",
            "name_en" => "El Salvador",
            "iso3" => "SLV",
            "phone_code" => "503"
        ],
        [
            "id" => "65",
            "iso" => "GQ",
            "name_ar" => "غينيا الإستوائية",
            "name_en" => "Equatorial Guinea",
            "iso3" => "GNQ",
            "phone_code" => "240"
        ],
        [
            "id" => "66",
            "iso" => "ER",
            "name_ar" => "إريتريا",
            "name_en" => "Eritrea",
            "iso3" => "ERI",
            "phone_code" => "291"
        ],
        [
            "id" => "67",
            "iso" => "EE",
            "name_ar" => "استونيا",
            "name_en" => "Estonia",
            "iso3" => "EST",
            "phone_code" => "372"
        ],
        [
            "id" => "68",
            "iso" => "ET",
            "name_ar" => "أثيوبيا",
            "name_en" => "Ethiopia",
            "iso3" => "ETH",
            "phone_code" => "251"
        ],
        [
            "id" => "69",
            "iso" => "FK",
            "name_ar" => "جزر فوكلاند (مالفيناس)",
            "name_en" => "Falkland Islands (Malvinas)",
            "iso3" => "FLK",
            "phone_code" => "500"
        ],
        [
            "id" => "70",
            "iso" => "FO",
            "name_ar" => "جزر صناعية",
            "name_en" => "Faroe Islands",
            "iso3" => "FRO",
            "phone_code" => "298"
        ],
        [
            "id" => "71",
            "iso" => "FJ",
            "name_ar" => "فيجي",
            "name_en" => "Fiji",
            "iso3" => "FJI",
            "phone_code" => "679"
        ],
        [
            "id" => "72",
            "iso" => "FI",
            "name_ar" => "فنلندا",
            "name_en" => "Finland",
            "iso3" => "FIN",
            "phone_code" => "358"
        ],
        [
            "id" => "73",
            "iso" => "FR",
            "name_ar" => "فرنسا",
            "name_en" => "France",
            "iso3" => "FRA",
            "phone_code" => "33"
        ],
        [
            "id" => "74",
            "iso" => "GF",
            "name_ar" => "غيانا الفرنسية",
            "name_en" => "French Guiana",
            "iso3" => "GUF",
            "phone_code" => "594"
        ],
        [
            "id" => "75",
            "iso" => "PF",
            "name_ar" => "بولينيزيا الفرنسية",
            "name_en" => "French Polynesia",
            "iso3" => "PYF",
            "phone_code" => "689"
        ],
        [
            "id" => "76",
            "iso" => "TF",
            "name_ar" => "المناطق الجنوبية لفرنسا",
            "name_en" => "French Southern Territories",
            "iso3" => "ATF",
            "phone_code" => "0"
        ],
        [
            "id" => "77",
            "iso" => "GA",
            "name_ar" => "الغابون",
            "name_en" => "Gabon",
            "iso3" => "GAB",
            "phone_code" => "241"
        ],
        [
            "id" => "78",
            "iso" => "GM",
            "name_ar" => "غامبيا",
            "name_en" => "Gambia",
            "iso3" => "GMB",
            "phone_code" => "220"
        ],
        [
            "id" => "79",
            "iso" => "GE",
            "name_ar" => "جورجيا",
            "name_en" => "Georgia",
            "iso3" => "GEO",
            "phone_code" => "995"
        ],
        [
            "id" => "80",
            "iso" => "DE",
            "name_ar" => "ألمانيا",
            "name_en" => "Germany",
            "iso3" => "DEU",
            "phone_code" => "49"
        ],
        [
            "id" => "81",
            "iso" => "GH",
            "name_ar" => "غانا",
            "name_en" => "Ghana",
            "iso3" => "GHA",
            "phone_code" => "233"
        ],
        [
            "id" => "82",
            "iso" => "GI",
            "name_ar" => "جبل طارق",
            "name_en" => "Gibraltar",
            "iso3" => "GIB",
            "phone_code" => "350"
        ],
        [
            "id" => "83",
            "iso" => "GR",
            "name_ar" => "اليونان",
            "name_en" => "Greece",
            "iso3" => "GRC",
            "phone_code" => "30"
        ],
        [
            "id" => "84",
            "iso" => "GL",
            "name_ar" => "الأرض الخضراء",
            "name_en" => "Greenland",
            "iso3" => "GRL",
            "phone_code" => "299"
        ],
        [
            "id" => "85",
            "iso" => "GD",
            "name_ar" => "غرينادا",
            "name_en" => "Grenada",
            "iso3" => "GRD",
            "phone_code" => "1473"
        ],
        [
            "id" => "86",
            "iso" => "GP",
            "name_ar" => "جوادلوب",
            "name_en" => "Guadeloupe",
            "iso3" => "GLP",
            "phone_code" => "590"
        ],
        [
            "id" => "87",
            "iso" => "GU",
            "name_ar" => "GUAM",
            "name_en" => "Guam",
            "iso3" => "GUM",
            "phone_code" => "1671"
        ],
        [
            "id" => "88",
            "iso" => "GT",
            "name_ar" => "غواتيمالا",
            "name_en" => "Guatemala",
            "iso3" => "GTM",
            "phone_code" => "502"
        ],
        [
            "id" => "89",
            "iso" => "GN",
            "name_ar" => "غينيا",
            "name_en" => "Guinea",
            "iso3" => "GIN",
            "phone_code" => "224"
        ],
        [
            "id" => "90",
            "iso" => "GW",
            "name_ar" => "غينيا بيساو",
            "name_en" => "Guinea-Bissau",
            "iso3" => "GNB",
            "phone_code" => "245"
        ],
        [
            "id" => "91",
            "iso" => "GY",
            "name_ar" => "غيانا",
            "name_en" => "Guyana",
            "iso3" => "GUY",
            "phone_code" => "592"
        ],
        [
            "id" => "92",
            "iso" => "HT",
            "name_ar" => "هايتي",
            "name_en" => "Haiti",
            "iso3" => "HTI",
            "phone_code" => "509"
        ],
        [
            "id" => "93",
            "iso" => "HM",
            "name_ar" => "HEARD ISLAND AND MCDONALD ISLANDS",
            "name_en" => "Heard Island and Mcdonald Islands",
            "iso3" => "HMD",
            "phone_code" => "0"
        ],
        [
            "id" => "94",
            "iso" => "VA",
            "name_ar" => "HOLY SEE (VATICAN CITY STATE)",
            "name_en" => "Holy See (Vatican City State)",
            "iso3" => "VAT",
            "phone_code" => "39"
        ],
        [
            "id" => "95",
            "iso" => "HN",
            "name_ar" => "هندوراس",
            "name_en" => "Honduras",
            "iso3" => "HND",
            "phone_code" => "504"
        ],
        [
            "id" => "96",
            "iso" => "HK",
            "name_ar" => "هونغ كونغ",
            "name_en" => "Hong Kong",
            "iso3" => "HKG",
            "phone_code" => "852"
        ],
        [
            "id" => "97",
            "iso" => "HU",
            "name_ar" => "اليونان",
            "name_en" => "Hungary",
            "iso3" => "HUN",
            "phone_code" => "36"
        ],
        [
            "id" => "98",
            "iso" => "IS",
            "name_ar" => "أيسلندا",
            "name_en" => "Iceland",
            "iso3" => "ISL",
            "phone_code" => "354"
        ],
        [
            "id" => "99",
            "iso" => "IN",
            "name_ar" => "الهند",
            "name_en" => "India",
            "iso3" => "IND",
            "phone_code" => "91"
        ],
        [
            "id" => "100",
            "iso" => "ID",
            "name_ar" => "أندونيسيا",
            "name_en" => "Indonesia",
            "iso3" => "IDN",
            "phone_code" => "62"
        ],
        [
            "id" => "101",
            "iso" => "IR",
            "name_ar" => "IRAN, ISLAMIC REPUBLIC OF",
            "name_en" => "Iran, Islamic Republic of",
            "iso3" => "IRN",
            "phone_code" => "98"
        ],
        [
            "id" => "102",
            "iso" => "IQ",
            "name_ar" => "العراق",
            "name_en" => "Iraq",
            "iso3" => "IRQ",
            "phone_code" => "964"
        ],
        [
            "id" => "103",
            "iso" => "IE",
            "name_ar" => "أيرلندا",
            "name_en" => "Ireland",
            "iso3" => "IRL",
            "phone_code" => "353"
        ],
        [
            "id" => "104",
            "iso" => "IL",
            "name_ar" => "ISRAEL",
            "name_en" => "Israel",
            "iso3" => "ISR",
            "phone_code" => "972"
        ],
        [
            "id" => "105",
            "iso" => "IT",
            "name_ar" => "إيطاليا",
            "name_en" => "Italy",
            "iso3" => "ITA",
            "phone_code" => "39"
        ],
        [
            "id" => "106",
            "iso" => "JM",
            "name_ar" => "جامايكا",
            "name_en" => "Jamaica",
            "iso3" => "JAM",
            "phone_code" => "1876"
        ],
        [
            "id" => "107",
            "iso" => "JP",
            "name_ar" => "اليابان",
            "name_en" => "Japan",
            "iso3" => "JPN",
            "phone_code" => "81"
        ],
        [
            "id" => "108",
            "iso" => "JO",
            "name_ar" => "الأردن",
            "name_en" => "Jordan",
            "iso3" => "JOR",
            "phone_code" => "962"
        ],
        [
            "id" => "109",
            "iso" => "KZ",
            "name_ar" => "كازاخستان",
            "name_en" => "Kazakhstan",
            "iso3" => "KAZ",
            "phone_code" => "7"
        ],
        [
            "id" => "110",
            "iso" => "KE",
            "name_ar" => "كينيا",
            "name_en" => "Kenya",
            "iso3" => "KEN",
            "phone_code" => "254"
        ],
        [
            "id" => "111",
            "iso" => "KI",
            "name_ar" => "كيريباس",
            "name_en" => "Kiribati",
            "iso3" => "KIR",
            "phone_code" => "686"
        ],
        [
            "id" => "112",
            "iso" => "KP",
            "name_ar" => "KOREA, DEMOCRATIC PEOPLE'S REPUBLIC OF",
            "name_en" => "Korea, Democratic People's Republic of",
            "iso3" => "PRK",
            "phone_code" => "850"
        ],
        [
            "id" => "113",
            "iso" => "KR",
            "name_ar" => "KOREA, REPUBLIC OF",
            "name_en" => "Korea, Republic of",
            "iso3" => "KOR",
            "phone_code" => "82"
        ],
        [
            "id" => "114",
            "iso" => "KW",
            "name_ar" => "الكويت",
            "name_en" => "Kuwait",
            "iso3" => "KWT",
            "phone_code" => "965"
        ],
        [
            "id" => "115",
            "iso" => "KG",
            "name_ar" => "قرغيزستان",
            "name_en" => "Kyrgyzstan",
            "iso3" => "KGZ",
            "phone_code" => "996"
        ],
        [
            "id" => "116",
            "iso" => "LA",
            "name_ar" => "LAO PEOPLE'S DEMOCRATIC REPUBLIC",
            "name_en" => "Lao People's Democratic Republic",
            "iso3" => "LAO",
            "phone_code" => "856"
        ],
        [
            "id" => "117",
            "iso" => "LV",
            "name_ar" => "لاتفيا",
            "name_en" => "Latvia",
            "iso3" => "LVA",
            "phone_code" => "371"
        ],
        [
            "id" => "118",
            "iso" => "LB",
            "name_ar" => "لبنان",
            "name_en" => "Lebanon",
            "iso3" => "LBN",
            "phone_code" => "961"
        ],
        [
            "id" => "119",
            "iso" => "LS",
            "name_ar" => "ليسوتو",
            "name_en" => "Lesotho",
            "iso3" => "LSO",
            "phone_code" => "266"
        ],
        [
            "id" => "120",
            "iso" => "LR",
            "name_ar" => "ليبيريا",
            "name_en" => "Liberia",
            "iso3" => "LBR",
            "phone_code" => "231"
        ],
        [
            "id" => "121",
            "iso" => "LY",
            "name_ar" => "LIBYAN ARAB JAMAHIRIYA",
            "name_en" => "Libyan Arab Jamahiriya",
            "iso3" => "LBY",
            "phone_code" => "218"
        ],
        [
            "id" => "122",
            "iso" => "LI",
            "name_ar" => "ليختنشتاين",
            "name_en" => "Liechtenstein",
            "iso3" => "LIE",
            "phone_code" => "423"
        ],
        [
            "id" => "123",
            "iso" => "LT",
            "name_ar" => "ليتوانيا",
            "name_en" => "Lithuania",
            "iso3" => "LTU",
            "phone_code" => "370"
        ],
        [
            "id" => "124",
            "iso" => "LU",
            "name_ar" => "لوكسمبورغ",
            "name_en" => "Luxembourg",
            "iso3" => "LUX",
            "phone_code" => "352"
        ],
        [
            "id" => "125",
            "iso" => "MO",
            "name_ar" => "ماكاو",
            "name_en" => "Macao",
            "iso3" => "MAC",
            "phone_code" => "853"
        ],
        [
            "id" => "126",
            "iso" => "MK",
            "name_ar" => "MACEDONIA, THE FORMER YUGOSLAV REPUBLIC OF",
            "name_en" => "Macedonia, the Former Yugoslav Republic of",
            "iso3" => "MKD",
            "phone_code" => "389"
        ],
        [
            "id" => "127",
            "iso" => "MG",
            "name_ar" => "مدغشقر",
            "name_en" => "Madagascar",
            "iso3" => "MDG",
            "phone_code" => "261"
        ],
        [
            "id" => "128",
            "iso" => "MW",
            "name_ar" => "مالاوي",
            "name_en" => "Malawi",
            "iso3" => "MWI",
            "phone_code" => "265"
        ],
        [
            "id" => "129",
            "iso" => "MY",
            "name_ar" => "ماليزيا",
            "name_en" => "Malaysia",
            "iso3" => "MYS",
            "phone_code" => "60"
        ],
        [
            "id" => "130",
            "iso" => "MV",
            "name_ar" => "جزر المالديف",
            "name_en" => "Maldives",
            "iso3" => "MDV",
            "phone_code" => "960"
        ],
        [
            "id" => "131",
            "iso" => "ML",
            "name_ar" => "مالي",
            "name_en" => "Mali",
            "iso3" => "MLI",
            "phone_code" => "223"
        ],
        [
            "id" => "132",
            "iso" => "MT",
            "name_ar" => "مالطا",
            "name_en" => "Malta",
            "iso3" => "MLT",
            "phone_code" => "356"
        ],
        [
            "id" => "133",
            "iso" => "MH",
            "name_ar" => "جزر مارشال",
            "name_en" => "Marshall Islands",
            "iso3" => "MHL",
            "phone_code" => "692"
        ],
        [
            "id" => "134",
            "iso" => "MQ",
            "name_ar" => "مارتينيك",
            "name_en" => "Martinique",
            "iso3" => "MTQ",
            "phone_code" => "596"
        ],
        [
            "id" => "135",
            "iso" => "MR",
            "name_ar" => "موريتانيا",
            "name_en" => "Mauritania",
            "iso3" => "MRT",
            "phone_code" => "222"
        ],
        [
            "id" => "136",
            "iso" => "MU",
            "name_ar" => "موريشيوس",
            "name_en" => "Mauritius",
            "iso3" => "MUS",
            "phone_code" => "230"
        ],
        [
            "id" => "137",
            "iso" => "YT",
            "name_ar" => "مايوت",
            "name_en" => "Mayotte",
            "iso3" => "MYT",
            "phone_code" => "269"
        ],
        [
            "id" => "138",
            "iso" => "MX",
            "name_ar" => "المكسيك",
            "name_en" => "Mexico",
            "iso3" => "MEX",
            "phone_code" => "52"
        ],
        [
            "id" => "139",
            "iso" => "FM",
            "name_ar" => "MICRONESIA, FEDERATED STATES OF",
            "name_en" => "Micronesia, Federated States of",
            "iso3" => "FSM",
            "phone_code" => "691"
        ],
        [
            "id" => "140",
            "iso" => "MD",
            "name_ar" => "MOLDOVA, REPUBLIC OF",
            "name_en" => "Moldova, Republic of",
            "iso3" => "MDA",
            "phone_code" => "373"
        ],
        [
            "id" => "141",
            "iso" => "MC",
            "name_ar" => "موناكو",
            "name_en" => "Monaco",
            "iso3" => "MCO",
            "phone_code" => "377"
        ],
        [
            "id" => "142",
            "iso" => "MN",
            "name_ar" => "منغوليا",
            "name_en" => "Mongolia",
            "iso3" => "MNG",
            "phone_code" => "976"
        ],
        [
            "id" => "143",
            "iso" => "MS",
            "name_ar" => "مونتسيرات",
            "name_en" => "Montserrat",
            "iso3" => "MSR",
            "phone_code" => "1664"
        ],
        [
            "id" => "144",
            "iso" => "MA",
            "name_ar" => "المغرب",
            "name_en" => "Morocco",
            "iso3" => "MAR",
            "phone_code" => "212"
        ],
        [
            "id" => "145",
            "iso" => "MZ",
            "name_ar" => "موزمبيق",
            "name_en" => "Mozambique",
            "iso3" => "MOZ",
            "phone_code" => "258"
        ],
        [
            "id" => "146",
            "iso" => "MM",
            "name_ar" => "ميانمار",
            "name_en" => "Myanmar",
            "iso3" => "MMR",
            "phone_code" => "95"
        ],
        [
            "id" => "147",
            "iso" => "NA",
            "name_ar" => "ناميبيا",
            "name_en" => "Namibia",
            "iso3" => "NAM",
            "phone_code" => "264"
        ],
        [
            "id" => "148",
            "iso" => "NR",
            "name_ar" => "ناورو",
            "name_en" => "Nauru",
            "iso3" => "NRU",
            "phone_code" => "674"
        ],
        [
            "id" => "149",
            "iso" => "NP",
            "name_ar" => "نيبال",
            "name_en" => "Nepal",
            "iso3" => "NPL",
            "phone_code" => "977"
        ],
        [
            "id" => "150",
            "iso" => "NL",
            "name_ar" => "هولندا",
            "name_en" => "Netherlands",
            "iso3" => "NLD",
            "phone_code" => "31"
        ],
        [
            "id" => "151",
            "iso" => "AN",
            "name_ar" => "جزر الأنتيل الهولندية",
            "name_en" => "Netherlands Antilles",
            "iso3" => "ANT",
            "phone_code" => "599"
        ],
        [
            "id" => "152",
            "iso" => "NC",
            "name_ar" => "كاليدونيا الجديدة",
            "name_en" => "New Caledonia",
            "iso3" => "NCL",
            "phone_code" => "687"
        ],
        [
            "id" => "153",
            "iso" => "NZ",
            "name_ar" => "NEW ZEALAND",
            "name_en" => "New Zealand",
            "iso3" => "NZL",
            "phone_code" => "64"
        ],
        [
            "id" => "154",
            "iso" => "NI",
            "name_ar" => "نيكاراغوا",
            "name_en" => "Nicaragua",
            "iso3" => "NIC",
            "phone_code" => "505"
        ],
        [
            "id" => "155",
            "iso" => "NE",
            "name_ar" => "النيجر",
            "name_en" => "Niger",
            "iso3" => "NER",
            "phone_code" => "227"
        ],
        [
            "id" => "156",
            "iso" => "NG",
            "name_ar" => "نيجيريا",
            "name_en" => "Nigeria",
            "iso3" => "NGA",
            "phone_code" => "234"
        ],
        [
            "id" => "157",
            "iso" => "NU",
            "name_ar" => "نيوي",
            "name_en" => "Niue",
            "iso3" => "NIU",
            "phone_code" => "683"
        ],
        [
            "id" => "158",
            "iso" => "NF",
            "name_ar" => "جزيرة نورفولك",
            "name_en" => "Norfolk Island",
            "iso3" => "NFK",
            "phone_code" => "672"
        ],
        [
            "id" => "159",
            "iso" => "MP",
            "name_ar" => "جزر مريانا الشمالية",
            "name_en" => "Northern Mariana Islands",
            "iso3" => "MNP",
            "phone_code" => "1670"
        ],
        [
            "id" => "160",
            "iso" => "NO",
            "name_ar" => "النرويج",
            "name_en" => "Norway",
            "iso3" => "NOR",
            "phone_code" => "47"
        ],
        [
            "id" => "161",
            "iso" => "OM",
            "name_ar" => "سلطنة عمان",
            "name_en" => "Oman",
            "iso3" => "OMN",
            "phone_code" => "968"
        ],
        [
            "id" => "162",
            "iso" => "PK",
            "name_ar" => "باكستان",
            "name_en" => "Pakistan",
            "iso3" => "PAK",
            "phone_code" => "92"
        ],
        [
            "id" => "163",
            "iso" => "PW",
            "name_ar" => "بالاو",
            "name_en" => "Palau",
            "iso3" => "PLW",
            "phone_code" => "680"
        ],
        [
            "id" => "164",
            "iso" => "PS",
            "name_ar" => "PALESTINIAN TERRITORY, OCCUPIED",
            "name_en" => "Palestinian Territory, Occupied",
            "iso3" => "PSE",
            "phone_code" => "970"
        ],
        [
            "id" => "165",
            "iso" => "PA",
            "name_ar" => "بناما",
            "name_en" => "Panama",
            "iso3" => "PAN",
            "phone_code" => "507"
        ],
        [
            "id" => "166",
            "iso" => "PG",
            "name_ar" => "بابوا غينيا الجديدة",
            "name_en" => "Papua New Guinea",
            "iso3" => "PNG",
            "phone_code" => "675"
        ],
        [
            "id" => "167",
            "iso" => "PY",
            "name_ar" => "باراغواي",
            "name_en" => "Paraguay",
            "iso3" => "PRY",
            "phone_code" => "595"
        ],
        [
            "id" => "168",
            "iso" => "PE",
            "name_ar" => "بيرو",
            "name_en" => "Peru",
            "iso3" => "PER",
            "phone_code" => "51"
        ],
        [
            "id" => "169",
            "iso" => "PH",
            "name_ar" => "الفلبين",
            "name_en" => "Philippines",
            "iso3" => "PHL",
            "phone_code" => "63"
        ],
        [
            "id" => "170",
            "iso" => "PN",
            "name_ar" => "بيتكيرن",
            "name_en" => "Pitcairn",
            "iso3" => "PCN",
            "phone_code" => "0"
        ],
        [
            "id" => "171",
            "iso" => "PL",
            "name_ar" => "بولندا",
            "name_en" => "Poland",
            "iso3" => "POL",
            "phone_code" => "48"
        ],
        [
            "id" => "172",
            "iso" => "PT",
            "name_ar" => "البرتغال",
            "name_en" => "Portugal",
            "iso3" => "PRT",
            "phone_code" => "351"
        ],
        [
            "id" => "173",
            "iso" => "PR",
            "name_ar" => "PUERTO RICO",
            "name_en" => "Puerto Rico",
            "iso3" => "PRI",
            "phone_code" => "1787"
        ],
        [
            "id" => "174",
            "iso" => "QA",
            "name_ar" => "دولة قطر",
            "name_en" => "Qatar",
            "iso3" => "QAT",
            "phone_code" => "974"
        ],
        [
            "id" => "175",
            "iso" => "RE",
            "name_ar" => "جمع شمل",
            "name_en" => "Reunion",
            "iso3" => "REU",
            "phone_code" => "262"
        ],
        [
            "id" => "176",
            "iso" => "RO",
            "name_ar" => "رومانيا",
            "name_en" => "Romania",
            "iso3" => "ROM",
            "phone_code" => "40"
        ],
        [
            "id" => "177",
            "iso" => "RU",
            "name_ar" => "الاتحاد الروسي",
            "name_en" => "Russian Federation",
            "iso3" => "RUS",
            "phone_code" => "70"
        ],
        [
            "id" => "178",
            "iso" => "RW",
            "name_ar" => "رواندا",
            "name_en" => "Rwanda",
            "iso3" => "RWA",
            "phone_code" => "250"
        ],
        [
            "id" => "179",
            "iso" => "SH",
            "name_ar" => "سانت هيلانة",
            "name_en" => "Saint Helena",
            "iso3" => "SHN",
            "phone_code" => "290"
        ],
        [
            "id" => "180",
            "iso" => "KN",
            "name_ar" => "سانت كيتس ونيفيس",
            "name_en" => "Saint Kitts and Nevis",
            "iso3" => "KNA",
            "phone_code" => "1869"
        ],
        [
            "id" => "181",
            "iso" => "LC",
            "name_ar" => "القديسة لوسيا",
            "name_en" => "Saint Lucia",
            "iso3" => "LCA",
            "phone_code" => "1758"
        ],
        [
            "id" => "182",
            "iso" => "PM",
            "name_ar" => "سانت بيير وميكلون",
            "name_en" => "Saint Pierre and Miquelon",
            "iso3" => "SPM",
            "phone_code" => "508"
        ],
        [
            "id" => "183",
            "iso" => "VC",
            "name_ar" => "سانت فنسنت وجزر غرينادين",
            "name_en" => "Saint Vincent and the Grenadines",
            "iso3" => "VCT",
            "phone_code" => "1784"
        ],
        [
            "id" => "184",
            "iso" => "WS",
            "name_ar" => "ساموا",
            "name_en" => "Samoa",
            "iso3" => "WSM",
            "phone_code" => "684"
        ],
        [
            "id" => "185",
            "iso" => "SM",
            "name_ar" => "سان مارينو",
            "name_en" => "San Marino",
            "iso3" => "SMR",
            "phone_code" => "378"
        ],
        [
            "id" => "186",
            "iso" => "ST",
            "name_ar" => "ساو تومي وبرنسيبي",
            "name_en" => "Sao Tome and Principe",
            "iso3" => "STP",
            "phone_code" => "239"
        ],
        [
            "id" => "187",
            "iso" => "SA",
            "name_ar" => "المملكة العربية السعودية",
            "name_en" => "Saudi Arabia",
            "iso3" => "SAU",
            "phone_code" => "966"
        ],
        [
            "id" => "188",
            "iso" => "SN",
            "name_ar" => "السنغال",
            "name_en" => "Senegal",
            "iso3" => "SEN",
            "phone_code" => "221"
        ],
        [
            "id" => "189",
            "iso" => "CS",
            "name_ar" => "SERBIA AND MONTENEGRO",
            "name_en" => "Serbia and Montenegro",
            "iso3" => "SCG",
            "phone_code" => "381"
        ],
        [
            "id" => "190",
            "iso" => "SC",
            "name_ar" => "سيشيل",
            "name_en" => "Seychelles",
            "iso3" => "SYC",
            "phone_code" => "248"
        ],
        [
            "id" => "191",
            "iso" => "SL",
            "name_ar" => "سيرا ليون",
            "name_en" => "Sierra Leone",
            "iso3" => "SLE",
            "phone_code" => "232"
        ],
        [
            "id" => "192",
            "iso" => "SG",
            "name_ar" => "سنغافورة",
            "name_en" => "Singapore",
            "iso3" => "SGP",
            "phone_code" => "65"
        ],
        [
            "id" => "193",
            "iso" => "SK",
            "name_ar" => "سلوفاكيا",
            "name_en" => "Slovakia",
            "iso3" => "SVK",
            "phone_code" => "421"
        ],
        [
            "id" => "194",
            "iso" => "SI",
            "name_ar" => "سلوفينيا",
            "name_en" => "Slovenia",
            "iso3" => "SVN",
            "phone_code" => "386"
        ],
        [
            "id" => "195",
            "iso" => "SB",
            "name_ar" => "جزر سليمان",
            "name_en" => "Solomon Islands",
            "iso3" => "SLB",
            "phone_code" => "677"
        ],
        [
            "id" => "196",
            "iso" => "SO",
            "name_ar" => "الصومال",
            "name_en" => "Somalia",
            "iso3" => "SOM",
            "phone_code" => "252"
        ],
        [
            "id" => "197",
            "iso" => "ZA",
            "name_ar" => "جنوب أفريقيا",
            "name_en" => "South Africa",
            "iso3" => "ZAF",
            "phone_code" => "27"
        ],
        [
            "id" => "198",
            "iso" => "GS",
            "name_ar" => "SOUTH GEORGIA AND THE SOUTH SANDWICH ISLANDS",
            "name_en" => "South Georgia and the South Sandwich Islands",
            "iso3" => "SGS",
            "phone_code" => "0"
        ],
        [
            "id" => "199",
            "iso" => "ES",
            "name_ar" => "إسبانيا",
            "name_en" => "Spain",
            "iso3" => "ESP",
            "phone_code" => "34"
        ],
        [
            "id" => "200",
            "iso" => "LK",
            "name_ar" => "سيريلانكا",
            "name_en" => "Sri Lanka",
            "iso3" => "LKA",
            "phone_code" => "94"
        ],
        [
            "id" => "201",
            "iso" => "SD",
            "name_ar" => "سودان",
            "name_en" => "Sudan",
            "iso3" => "SDN",
            "phone_code" => "249"
        ],
        [
            "id" => "202",
            "iso" => "SR",
            "name_ar" => "سورينام",
            "name_en" => "Suriname",
            "iso3" => "SUR",
            "phone_code" => "597"
        ],
        [
            "id" => "203",
            "iso" => "SJ",
            "name_ar" => "سفالبارد وجان مايان",
            "name_en" => "Svalbard and Jan Mayen",
            "iso3" => "SJM",
            "phone_code" => "47"
        ],
        [
            "id" => "204",
            "iso" => "SZ",
            "name_ar" => "سوازيلاند",
            "name_en" => "Swaziland",
            "iso3" => "SWZ",
            "phone_code" => "268"
        ],
        [
            "id" => "205",
            "iso" => "SE",
            "name_ar" => "السويد",
            "name_en" => "Sweden",
            "iso3" => "SWE",
            "phone_code" => "46"
        ],
        [
            "id" => "206",
            "iso" => "CH",
            "name_ar" => "سويسرا",
            "name_en" => "Switzerland",
            "iso3" => "CHE",
            "phone_code" => "41"
        ],
        [
            "id" => "207",
            "iso" => "SY",
            "name_ar" => "SYRIAN ARAB REPUBLIC",
            "name_en" => "Syrian Arab Republic",
            "iso3" => "SYR",
            "phone_code" => "963"
        ],
        [
            "id" => "208",
            "iso" => "TW",
            "name_ar" => "TAIWAN, PROVINCE OF CHINA",
            "name_en" => "Taiwan, Province of China",
            "iso3" => "TWN",
            "phone_code" => "886"
        ],
        [
            "id" => "209",
            "iso" => "TJ",
            "name_ar" => "طاجيكستان",
            "name_en" => "Tajikistan",
            "iso3" => "TJK",
            "phone_code" => "992"
        ],
        [
            "id" => "210",
            "iso" => "TZ",
            "name_ar" => "TANZANIA, UNITED REPUBLIC OF",
            "name_en" => "Tanzania, United Republic of",
            "iso3" => "TZA",
            "phone_code" => "255"
        ],
        [
            "id" => "211",
            "iso" => "TH",
            "name_ar" => "تايلاند",
            "name_en" => "Thailand",
            "iso3" => "THA",
            "phone_code" => "66"
        ],
        [
            "id" => "212",
            "iso" => "TL",
            "name_ar" => "TIMOR-LESTE",
            "name_en" => "Timor-Leste",
            "iso3" => "TLS",
            "phone_code" => "670"
        ],
        [
            "id" => "213",
            "iso" => "TG",
            "name_ar" => "ليذهب",
            "name_en" => "Togo",
            "iso3" => "TGO",
            "phone_code" => "228"
        ],
        [
            "id" => "214",
            "iso" => "TK",
            "name_ar" => "توكيلاو",
            "name_en" => "Tokelau",
            "iso3" => "TKL",
            "phone_code" => "690"
        ],
        [
            "id" => "215",
            "iso" => "TO",
            "name_ar" => "تونغا",
            "name_en" => "Tonga",
            "iso3" => "TON",
            "phone_code" => "676"
        ],
        [
            "id" => "216",
            "iso" => "TT",
            "name_ar" => "ترينداد وتوباغو",
            "name_en" => "Trinidad and Tobago",
            "iso3" => "TTO",
            "phone_code" => "1868"
        ],
        [
            "id" => "217",
            "iso" => "TN",
            "name_ar" => "تونس",
            "name_en" => "Tunisia",
            "iso3" => "TUN",
            "phone_code" => "216"
        ],
        [
            "id" => "218",
            "iso" => "TR",
            "name_ar" => "ديك رومي",
            "name_en" => "Turkey",
            "iso3" => "TUR",
            "phone_code" => "90"
        ],
        [
            "id" => "219",
            "iso" => "TM",
            "name_ar" => "تركمانستان",
            "name_en" => "Turkmenistan",
            "iso3" => "TKM",
            "phone_code" => "7370"
        ],
        [
            "id" => "220",
            "iso" => "TC",
            "name_ar" => "جزر تركس وكايكوس",
            "name_en" => "Turks and Caicos Islands",
            "iso3" => "TCA",
            "phone_code" => "1649"
        ],
        [
            "id" => "221",
            "iso" => "TV",
            "name_ar" => "توفالو",
            "name_en" => "Tuvalu",
            "iso3" => "TUV",
            "phone_code" => "688"
        ],
        [
            "id" => "222",
            "iso" => "UG",
            "name_ar" => "أوغندا",
            "name_en" => "Uganda",
            "iso3" => "UGA",
            "phone_code" => "256"
        ],
        [
            "id" => "223",
            "iso" => "UA",
            "name_ar" => "أوكرانيا",
            "name_en" => "Ukraine",
            "iso3" => "UKR",
            "phone_code" => "380"
        ],
        [
            "id" => "224",
            "iso" => "AE",
            "name_ar" => "الإمارات العربية المتحدة",
            "name_en" => "United Arab Emirates",
            "iso3" => "ARE",
            "phone_code" => "971"
        ],
        [
            "id" => "225",
            "iso" => "GB",
            "name_ar" => "UNITED KINGDOM",
            "name_en" => "United Kingdom",
            "iso3" => "GBR",
            "phone_code" => "44"
        ],
        [
            "id" => "226",
            "iso" => "US",
            "name_ar" => "UNITED STATES",
            "name_en" => "United States",
            "iso3" => "USA",
            "phone_code" => "1"
        ],
        [
            "id" => "227",
            "iso" => "UM",
            "name_ar" => "UNITED STATES MINOR OUTLYING ISLANDS",
            "name_en" => "United States Minor Outlying Islands",
            "iso3" => "UMI",
            "phone_code" => "1"
        ],
        [
            "id" => "228",
            "iso" => "UY",
            "name_ar" => "أوروغواي",
            "name_en" => "Uruguay",
            "iso3" => "URY",
            "phone_code" => "598"
        ],
        [
            "id" => "229",
            "iso" => "UZ",
            "name_ar" => "أوزبكستان",
            "name_en" => "Uzbekistan",
            "iso3" => "UZB",
            "phone_code" => "998"
        ],
        [
            "id" => "230",
            "iso" => "VU",
            "name_ar" => "فانواتو",
            "name_en" => "Vanuatu",
            "iso3" => "VUT",
            "phone_code" => "678"
        ],
        [
            "id" => "231",
            "iso" => "VE",
            "name_ar" => "فنزويلا",
            "name_en" => "Venezuela",
            "iso3" => "VEN",
            "phone_code" => "58"
        ],
        [
            "id" => "232",
            "iso" => "VN",
            "name_ar" => "فيتنام",
            "name_en" => "Viet Nam",
            "iso3" => "VNM",
            "phone_code" => "84"
        ],
        [
            "id" => "233",
            "iso" => "VG",
            "name_ar" => "VIRGIN ISLANDS, BRITISH",
            "name_en" => "Virgin Islands, British",
            "iso3" => "VGB",
            "phone_code" => "1284"
        ],
        [
            "id" => "234",
            "iso" => "VI",
            "name_ar" => "VIRGIN ISLANDS, U.S.",
            "name_en" => "Virgin Islands, U.s.",
            "iso3" => "VIR",
            "phone_code" => "1340"
        ],
        [
            "id" => "235",
            "iso" => "WF",
            "name_ar" => "واليس وفوتونا",
            "name_en" => "Wallis and Futuna",
            "iso3" => "WLF",
            "phone_code" => "681"
        ],
        [
            "id" => "236",
            "iso" => "EH",
            "name_ar" => "الصحراء الغربية",
            "name_en" => "Western Sahara",
            "iso3" => "ESH",
            "phone_code" => "212"
        ],
        [
            "id" => "237",
            "iso" => "YE",
            "name_ar" => "اليمن",
            "name_en" => "Yemen",
            "iso3" => "YEM",
            "phone_code" => "967"
        ],
        [
            "id" => "238",
            "iso" => "ZM",
            "name_ar" => "زامبيا",
            "name_en" => "Zambia",
            "iso3" => "ZMB",
            "phone_code" => "260"
        ],
        [
            "id" => "239",
            "iso" => "ZW",
            "name_ar" => "زيمبابوي",
            "name_en" => "Zimbabwe",
            "iso3" => "ZWE",
            "phone_code" => "263"
        ]
    ];

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('countries')->insert($this->countries);
    }
}
