<?php
    $label = 'Add';
    $percentage = $shipping_charges = '';
    if (!empty($edit))
    {
        $percentage = $edit['percentage'];
        $shipping_charges = $edit['shipping_charges'];
        $timezone_added = $edit['timezone'];
        $start_time = $edit['start_time'];
        $end_time = $edit['end_time'];
        $label = 'Update';
    }
?>
<?php
// Function to get the list of time zones with countries
function getTimezonesWithCountries() {
    $timezones = DateTimeZone::listIdentifiers();
    $timezoneCountries = [];
    
    foreach ($timezones as $timezone) {
        $dateTimeZone = new DateTimeZone($timezone);
        $location = $dateTimeZone->getLocation();
        if ($location && isset($location['country_code'])) {
            $timezoneCountries[$timezone] = $location['country_code'];
        }
    }
    
    return $timezoneCountries;
}

// Country codes to country names mapping (partial list, can be extended)
$countryNames = [
    'AD' => 'Andorra',
    'AE' => 'United Arab Emirates',
    'AF' => 'Afghanistan',
    'AG' => 'Antigua and Barbuda',
    'AI' => 'Anguilla',
    'AL' => 'Albania',
    'AM' => 'Armenia',
    'AO' => 'Angola',
    'AQ' => 'Antarctica',
    'AR' => 'Argentina',
    'AS' => 'American Samoa',
    'AT' => 'Austria',
    'AU' => 'Australia',
    'AW' => 'Aruba',
    'AX' => 'Åland Islands',
    'AZ' => 'Azerbaijan',
    'BA' => 'Bosnia and Herzegovina',
    'BB' => 'Barbados',
    'BD' => 'Bangladesh',
    'BE' => 'Belgium',
    'BF' => 'Burkina Faso',
    'BG' => 'Bulgaria',
    'BH' => 'Bahrain',
    'BI' => 'Burundi',
    'BJ' => 'Benin',
    'BL' => 'Saint Barthélemy',
    'BM' => 'Bermuda',
    'BN' => 'Brunei',
    'BO' => 'Bolivia',
    'BQ' => 'Bonaire',
    'BR' => 'Brazil',
    'BS' => 'Bahamas',
    'BT' => 'Bhutan',
    'BV' => 'Bouvet Island',
    'BW' => 'Botswana',
    'BY' => 'Belarus',
    'BZ' => 'Belize',
    'CA' => 'Canada',
    'CC' => 'Cocos (Keeling) Islands',
    'CD' => 'Democratic Republic of the Congo',
    'CF' => 'Central African Republic',
    'CG' => 'Republic of the Congo',
    'CH' => 'Switzerland',
    'CI' => 'Côte d\'Ivoire',
    'CK' => 'Cook Islands',
    'CL' => 'Chile',
    'CM' => 'Cameroon',
    'CN' => 'China',
    'CO' => 'Colombia',
    'CR' => 'Costa Rica',
    'CU' => 'Cuba',
    'CV' => 'Cape Verde',
    'CW' => 'Curaçao',
    'CX' => 'Christmas Island',
    'CY' => 'Cyprus',
    'CZ' => 'Czech Republic',
    'DE' => 'Germany',
    'DJ' => 'Djibouti',
    'DK' => 'Denmark',
    'DM' => 'Dominica',
    'DO' => 'Dominican Republic',
    'DZ' => 'Algeria',
    'EC' => 'Ecuador',
    'EE' => 'Estonia',
    'EG' => 'Egypt',
    'EH' => 'Western Sahara',
    'ER' => 'Eritrea',
    'ES' => 'Spain',
    'ET' => 'Ethiopia',
    'FI' => 'Finland',
    'FJ' => 'Fiji',
    'FM' => 'Micronesia',
    'FO' => 'Faroe Islands',
    'FR' => 'France',
    'GA' => 'Gabon',
    'GB' => 'United Kingdom',
    'GD' => 'Grenada',
    'GE' => 'Georgia',
    'GF' => 'French Guiana',
    'GG' => 'Guernsey',
    'GH' => 'Ghana',
    'GI' => 'Gibraltar',
    'GL' => 'Greenland',
    'GM' => 'Gambia',
    'GN' => 'Guinea',
    'GP' => 'Guadeloupe',
    'GQ' => 'Equatorial Guinea',
    'GR' => 'Greece',
    'GT' => 'Guatemala',
    'GU' => 'Guam',
    'GW' => 'Guinea-Bissau',
    'GY' => 'Guyana',
    'HK' => 'Hong Kong',
    'HM' => 'Heard Island and McDonald Islands',
    'HN' => 'Honduras',
    'HR' => 'Croatia',
    'HT' => 'Haiti',
    'HU' => 'Hungary',
    'ID' => 'Indonesia',
    'IE' => 'Ireland',
    'IL' => 'Israel',
    'IM' => 'Isle of Man',
    'IN' => 'India',
    'IO' => 'British Indian Ocean Territory',
    'IQ' => 'Iraq',
    'IR' => 'Iran',
    'IS' => 'Iceland',
    'IT' => 'Italy',
    'JE' => 'Jersey',
    'JM' => 'Jamaica',
    'JO' => 'Jordan',
    'JP' => 'Japan',
    'KE' => 'Kenya',
    'KG' => 'Kyrgyzstan',
    'KH' => 'Cambodia',
    'KI' => 'Kiribati',
    'KM' => 'Comoros',
    'KN' => 'Saint Kitts and Nevis',
    'KP' => 'North Korea',
    'KR' => 'South Korea',
    'KW' => 'Kuwait',
    'KY' => 'Cayman Islands',
    'KZ' => 'Kazakhstan',
    'LA' => 'Laos',
    'LB' => 'Lebanon',
    'LC' => 'Saint Lucia',
    'LI' => 'Liechtenstein',
    'LK' => 'Sri Lanka',
    'LR' => 'Liberia',
    'LS' => 'Lesotho',
    'LT' => 'Lithuania',
    'LU' => 'Luxembourg',
    'LV' => 'Latvia',
    'LY' => 'Libya',
    'MA' => 'Morocco',
    'MC' => 'Monaco',
    'MD' => 'Moldova',
    'ME' => 'Montenegro',
    'MF' => 'Saint Martin',
    'MG' => 'Madagascar',
    'MH' => 'Marshall Islands',
    'MK' => 'North Macedonia',
    'ML' => 'Mali',
    'MM' => 'Myanmar',
    'MN' => 'Mongolia',
    'MO' => 'Macao',
    'MP' => 'Northern Mariana Islands',
    'MQ' => 'Martinique',
    'MR' => 'Mauritania',
    'MS' => 'Montserrat',
    'MT' => 'Malta',
    'MU' => 'Mauritius',
    'MV' => 'Maldives',
    'MW' => 'Malawi',
    'MX' => 'Mexico',
    'MY' => 'Malaysia',
    'MZ' => 'Mozambique',
    'NA' => 'Namibia',
    'NC' => 'New Caledonia',
    'NE' => 'Niger',
    'NF' => 'Norfolk Island',
    'NG' => 'Nigeria',
    'NI' => 'Nicaragua',
    'NL' => 'Netherlands',
    'NO' => 'Norway',
    'NP' => 'Nepal',
    'NR' => 'Nauru',
    'NU' => 'Niue',
    'NZ' => 'New Zealand',
    'OM' => 'Oman',
    'PA' => 'Panama',
    'PE' => 'Peru',
    'PF' => 'French Polynesia',
    'PG' => 'Papua New Guinea',
    'PH' => 'Philippines',
    'PK' => 'Pakistan',
    'PL' => 'Poland',
    'PM' => 'Saint Pierre and Miquelon',
    'PN' => 'Pitcairn Islands',
    'PR' => 'Puerto Rico',
    'PT' => 'Portugal',
    'PW' => 'Palau',
    'PY' => 'Paraguay',
    'QA' => 'Qatar',
    'RE' => 'Réunion',
    'RO' => 'Romania',
    'RS' => 'Serbia',
    'RU' => 'Russia',
    'RW' => 'Rwanda',
    'SA' => 'Saudi Arabia',
    'SB' => 'Solomon Islands',
    'SC' => 'Seychelles',
    'SD' => 'Sudan',
    'SE' => 'Sweden',
    'SG' => 'Singapore',
    'SH' => 'Saint Helena',
    'SI' => 'Slovenia',
    'SJ' => 'Svalbard and Jan Mayen',
    'SK' => 'Slovakia',
    'SL' => 'Sierra Leone',
    'SM' => 'San Marino',
    'SN' => 'Senegal',
    'SO' => 'Somalia',
    'SR' => 'Suriname',
    'SS' => 'South Sudan',
    'ST' => 'São Tomé and Príncipe',
    'SV' => 'El Salvador',
    'SX' => 'Sint Maarten',
    'SY' => 'Syria',
    'SZ' => 'Eswatini',
    'TC' => 'Turks and Caicos Islands',
    'TD' => 'Chad',
    'TF' => 'French Southern Territories',
    'TG' => 'Togo',
    'TH' => 'Thailand',
    'TJ' => 'Tajikistan',
    'TK' => 'Tokelau',
    'TL' => 'Timor-Leste',
    'TM' => 'Turkmenistan',
    'TN' => 'Tunisia',
    'TO' => 'Tonga',
    'TR' => 'Turkey',
    'TT' => 'Trinidad and Tobago',
    'TV' => 'Tuvalu',
    'TZ' => 'Tanzania',
    'UA' => 'Ukraine',
    'UG' => 'Uganda',
    'UM' => 'United States Minor Outlying Islands',
    'US' => 'United States',
    'UY' => 'Uruguay',
    'UZ' => 'Uzbekistan',
    'VA' => 'Vatican City',
    'VC' => 'Saint Vincent and the Grenadines',
    'VE' => 'Venezuela',
    'VG' => 'British Virgin Islands',
    'VI' => 'United States Virgin Islands',
    'VN' => 'Vietnam',
    'VU' => 'Vanuatu',
    'WF' => 'Wallis and Futuna',
    'WS' => 'Samoa',
    'YE' => 'Yemen',
    'YT' => 'Mayotte',
    'ZA' => 'South Africa',
    'ZM' => 'Zambia',
    'ZW' => 'Zimbabwe',
];

// Get time zones with their country codes
$timezoneCountries = getTimezonesWithCountries();

$asd = '';
// Generate options for the select element
foreach ($timezoneCountries as $timezone => $countryCode) {

    $css = '';
    if ($timezone_added == $timezone) {
        $css = 'selected';
    }
    $countryName = isset($countryNames[$countryCode]) ? $countryNames[$countryCode] : $countryCode;
    $asd.= "<option value=\"$timezone\" $css >$countryName - $timezone</option>";
}
?>

<div class="vertical-overlay"></div>
<div class="main-content">
    <div class="page-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h4 class="mb-sm-0">Tax & Shipping Amount</h4>
                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="<?php echo base_url('admin') ?>">Dashboards</a></li>
                                <li class="breadcrumb-item active"><?php echo $label; ?></li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="card">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <form class="update_tax_shipping" method="post">
                                                <div class="row">
                                                    
                                                    <div class="col-sm-4">
                                                        <label for="category">Tax (%)</label>
                                                        <input type="text" name="percentage" class="form-control" value="<?php echo $percentage; ?>" placeholder="Enter Tax in percentage">
                                                    </div>
                                                    <div class="col-sm-4" >
                                                        <label for="category">Shipping Amount</label>
                                                        <input type="text" name="shipping_charges" class="form-control" value="<?php echo $shipping_charges; ?>" placeholder="Enter shipping charges">
                                                    </div>
                                                    <div class="col-sm-4" >
                                                        <label for="category">Select Timezone</label>
                                                        <select name="timezone" class="select2_single form-control" >
                                                            <?php echo $asd; ?>
                                                        </select>
                                                    </div>
                                                    <div class="col-sm-4" >
                                                        <label for="category">Order Start time</label>
                                                        <input type="time" name="start_time" class="form-control" value="<?php echo $start_time; ?>" >
                                                    </div>
                                                    <div class="col-sm-4" >
                                                        <label for="category">Order End time</label>
                                                        <input type="time" name="end_time" class="form-control" value="<?php echo $end_time; ?>" >
                                                    </div>
                                                    <div class="clear"></div>
                                                    <div class="col-sm-6">
                                                        <p class="error_show"></p>
                                                        <button class="btn btn-primary" type="submit"><?php echo $label; ?></button>
                                                    </div>
                                                </div>
                                            </form>
                                            <br>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script src='<?php echo base_url(); ?>/public/admin/main_js/tax_update.js'></script>
<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/css/select2.min.css" rel="stylesheet" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/js/select2.min.js"></script>
<script>
    $(".select2_single").select2({
        placeholder: "Select a timezone",
        allowClear: true
    });
    $("#multiple").select2({
        placeholder: "Select a programming language",
        allowClear: true
    });
</script>