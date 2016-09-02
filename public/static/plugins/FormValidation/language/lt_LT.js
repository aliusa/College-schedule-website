(function ($) {
    /**
     * Default English package. It's included in the dist, so you do NOT need to include it to your head tag
     * The only reason I put it here is that you can clone it, and translate it into your language
     */
    FormValidation.I18n = $.extend(true, FormValidation.I18n, {
        'en_US': {
            base64: {
                'default': 'Please enter a valid base 64 encoded'
            },
            between: {
                'default': 'Please enter a value between %s and %s',
                notInclusive: 'Please enter a value between %s and %s strictly'
            },
            bic: {
                'default': 'Please enter a valid BIC number'
            },
            callback: {
                'default': 'Please enter a valid value'
            },
            choice: {
                'default': 'Please enter a valid value',
                less: 'Please choose %s options at minimum',
                more: 'Please choose %s options at maximum',
                between: 'Please choose %s - %s options'
            },
            color: {
                'default': 'Please enter a valid color'
            },
            creditCard: {
                'default': 'Please enter a valid credit card number'
            },
            cusip: {
                'default': 'Please enter a valid CUSIP number'
            },
            cvv: {
                'default': 'Please enter a valid CVV number'
            },
            date: {
                'default': 'Please enter a valid date',
                min: 'Please enter a date after %s',
                max: 'Please enter a date before %s',
                range: 'Please enter a date in the range %s - %s'
            },
            different: {
                'default': 'Please enter a different value'
            },
            digits: {
                'default': 'Please enter only digits'
            },
            ean: {
                'default': 'Please enter a valid EAN number'
            },
            ein: {
                'default': 'Please enter a valid EIN number'
            },
            emailAddress: {
                'default': 'Please enter a valid email address'
            },
            file: {
                'default': 'Please choose a valid file'
            },
            greaterThan: {
                'default': 'Please enter a value greater than or equal to %s',
                notInclusive: 'Please enter a value greater than %s'
            },
            grid: {
                'default': 'Please enter a valid GRId number'
            },
            hex: {
                'default': 'Please enter a valid hexadecimal number'
            },
            iban: {
                'default': 'Please enter a valid IBAN number',
                country: 'Please enter a valid IBAN number in %s',
                countries: {
                    AD: 'Andora',
                    AE: 'Jungtiniai Arabų Emyratai',
                    AL: 'Albanija',
                    AO: 'Angola',
                    AT: 'Austrija',
                    AZ: 'Azerbaidžanas',
                    BA: 'Bosnija ir Hercegovina',
                    BE: 'Belgija',
                    BF: 'Burkina Fasas',
                    BG: 'Bulgarija',
                    BH: 'Bahreinas',
                    BI: 'Burundis',
                    BJ: 'Beninas',
                    BR: 'Brazilija',
                    CH: 'Šveicarija',
                    CI: 'Dramblio kaulo krantas',
                    CM: 'Kamerūnas',
                    CR: 'Kosta Rika',
                    CV: 'Žaliasis Kyšulys',
                    CY: 'Kipras',
                    CZ: 'Čekijos Respublika',
                    DE: 'Vokietija',
                    DK: 'Dalika',
                    DO: 'Dominikos Respublika',
                    DZ: 'Alžyras',
                    EE: 'Estija',
                    ES: 'Ispanija',
                    FI: 'Suomija',
                    FO: 'Farerų salos',
                    FR: 'Prancūzija',
                    GB: 'Didžioji Britanija',
                    GE: 'Gruzija',
                    GI: 'Gibraltaras',
                    GL: 'Grenlandija',
                    GR: 'Graikija',
                    GT: 'Gvatemala',
                    HR: 'Kroatija',
                    HU: 'Vengrija',
                    IE: 'Airija',
                    IL: 'Izraelis',
                    IR: 'Iranas',
                    IS: 'Islandija',
                    IT: 'Italija',
                    JO: 'Jordanija',
                    KW: 'Kuveitas',
                    KZ: 'Kazachstanas',
                    LB: 'Libanas',
                    LI: 'Lichtenšteinas',
                    LT: 'Lietuva',
                    LU: 'Liuksemburgas',
                    LV: 'Latvija',
                    MC: 'Monakas',
                    MD: 'Moldova',
                    ME: 'Juodkalnija',
                    MG: 'Madagaskaras',
                    MK: 'Makedonija',
                    ML: 'Malis',
                    MR: 'Mauritanija',
                    MT: 'Malta',
                    MU: 'Mauricijus',
                    MZ: 'Mozambikas',
                    NL: 'Nyderlandai',
                    NO: 'Norvegija',
                    PK: 'Pakistanas',
                    PL: 'Lenkija',
                    PS: 'Palestina',
                    PT: 'Portugalija',
                    QA: 'Kataras',
                    RO: 'Rumunija',
                    RS: 'Serbija',
                    SA: 'Saudo Arabija',
                    SE: 'Švedija',
                    SI: 'Slovėnija',
                    SK: 'Slovakija',
                    SM: 'San Marinas',
                    SN: 'Senegalas',
                    TN: 'Tunisas',
                    TR: 'Turkija',
                    VG: 'Didžiosios Britanijos Mergelių salos'
                }
            },
            id: {
                'default': 'Please enter a valid identification number',
                country: 'Please enter a valid identification number in %s',
                countries: {
                    BA: 'Bosnia and Herzegovina',
                    BG: 'Bulgaria',
                    BR: 'Brazil',
                    CH: 'Switzerland',
                    CL: 'Chile',
                    CN: 'China',
                    CZ: 'Czech Republic',
                    DK: 'Denmark',
                    EE: 'Estonia',
                    ES: 'Spain',
                    FI: 'Finland',
                    HR: 'Croatia',
                    IE: 'Ireland',
                    IS: 'Iceland',
                    LT: 'Lithuania',
                    LV: 'Latvia',
                    ME: 'Montenegro',
                    MK: 'Macedonia',
                    NL: 'Netherlands',
                    PL: 'Poland',
                    RO: 'Romania',
                    RS: 'Serbia',
                    SE: 'Sweden',
                    SI: 'Slovenia',
                    SK: 'Slovakia',
                    SM: 'San Marino',
                    TH: 'Thailand',
                    ZA: 'South Africa'
                }
            },
            identical: {
                'default': 'Please enter the same value'
            },
            imei: {
                'default': 'Please enter a valid IMEI number'
            },
            imo: {
                'default': 'Please enter a valid IMO number'
            },
            integer: {
                'default': 'Please enter a valid number'
            },
            ip: {
                'default': 'Please enter a valid IP address',
                ipv4: 'Please enter a valid IPv4 address',
                ipv6: 'Please enter a valid IPv6 address'
            },
            isbn: {
                'default': 'Please enter a valid ISBN number'
            },
            isin: {
                'default': 'Please enter a valid ISIN number'
            },
            ismn: {
                'default': 'Please enter a valid ISMN number'
            },
            issn: {
                'default': 'Please enter a valid ISSN number'
            },
            lessThan: {
                'default': 'Please enter a value less than or equal to %s',
                notInclusive: 'Please enter a value less than %s'
            },
            mac: {
                'default': 'Please enter a valid MAC address'
            },
            meid: {
                'default': 'Please enter a valid MEID number'
            },
            notEmpty: {
                'default': 'Įveskite tinkamą tekstą'
            },
            numeric: {
                'default': 'Please enter a valid float number'
            },
            phone: {
                'default': 'Please enter a valid phone number',
                country: 'Please enter a valid phone number in %s',
                countries: {
                    AE: 'United Arab Emirates',
                    BG: 'Bulgaria',
                    BR: 'Brazil',
                    CN: 'China',
                    CZ: 'Czech Republic',
                    DE: 'Germany',
                    DK: 'Denmark',
                    ES: 'Spain',
                    FR: 'France',
                    GB: 'United Kingdom',
                    IN: 'India',
                    MA: 'Morocco',
                    NL: 'Netherlands',
                    PK: 'Pakistan',
                    RO: 'Romania',
                    RU: 'Russia',
                    SK: 'Slovakia',
                    TH: 'Thailand',
                    US: 'USA',
                    VE: 'Venezuela'
                }
            },
            regexp: {
                'default': 'Please enter a value matching the pattern'
            },
            remote: {
                'default': 'Please enter a valid value'
            },
            rtn: {
                'default': 'Please enter a valid RTN number'
            },
            sedol: {
                'default': 'Please enter a valid SEDOL number'
            },
            siren: {
                'default': 'Please enter a valid SIREN number'
            },
            siret: {
                'default': 'Please enter a valid SIRET number'
            },
            step: {
                'default': 'Please enter a valid step of %s'
            },
            stringCase: {
                'default': 'Please enter only lowercase characters',
                upper: 'Please enter only uppercase characters'
            },
            stringLength: {
                'default': 'Please enter a value with valid length',
                less: 'Please enter less than %s characters',
                more: 'Please enter more than %s characters',
                between: 'Please enter value between %s and %s characters long'
            },
            uri: {
                'default': 'Please enter a valid URI'
            },
            uuid: {
                'default': 'Please enter a valid UUID number',
                version: 'Please enter a valid UUID version %s number'
            },
            vat: {
                'default': 'Please enter a valid VAT number',
                country: 'Please enter a valid VAT number in %s',
                countries: {
                    AT: 'Austria',
                    BE: 'Belgium',
                    BG: 'Bulgaria',
                    BR: 'Brazil',
                    CH: 'Switzerland',
                    CY: 'Cyprus',
                    CZ: 'Czech Republic',
                    DE: 'Germany',
                    DK: 'Denmark',
                    EE: 'Estonia',
                    ES: 'Spain',
                    FI: 'Finland',
                    FR: 'France',
                    GB: 'United Kingdom',
                    GR: 'Greece',
                    EL: 'Greece',
                    HU: 'Hungary',
                    HR: 'Croatia',
                    IE: 'Ireland',
                    IS: 'Iceland',
                    IT: 'Italy',
                    LT: 'Lithuania',
                    LU: 'Luxembourg',
                    LV: 'Latvia',
                    MT: 'Malta',
                    NL: 'Netherlands',
                    NO: 'Norway',
                    PL: 'Poland',
                    PT: 'Portugal',
                    RO: 'Romania',
                    RU: 'Russia',
                    RS: 'Serbia',
                    SE: 'Sweden',
                    SI: 'Slovenia',
                    SK: 'Slovakia',
                    VE: 'Venezuela',
                    ZA: 'South Africa'
                }
            },
            vin: {
                'default': 'Please enter a valid VIN number'
            },
            zipCode: {
                'default': 'Please enter a valid postal code',
                country: 'Please enter a valid postal code in %s',
                countries: {
                    AT: 'Austria',
                    BG: 'Bulgaria',
                    BR: 'Brazil',
                    CA: 'Canada',
                    CH: 'Switzerland',
                    CZ: 'Czech Republic',
                    DE: 'Germany',
                    DK: 'Denmark',
                    ES: 'Spain',
                    FR: 'France',
                    GB: 'United Kingdom',
                    IE: 'Ireland',
                    IN: 'India',
                    IT: 'Italy',
                    MA: 'Morocco',
                    NL: 'Netherlands',
                    PL: 'Poland',
                    PT: 'Portugal',
                    RO: 'Romania',
                    RU: 'Russia',
                    SE: 'Sweden',
                    SG: 'Singapore',
                    SK: 'Slovakia',
                    US: 'USA'
                }
            }
        }
    });
}(jQuery));
